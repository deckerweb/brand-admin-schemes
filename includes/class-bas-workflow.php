<?php
/**
 * Bounded branding history, portable templates and explicit network provisioning.
 *
 * @package BrandAdminSchemes
 * Copyright © 2022–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
namespace Deckerweb\BrandAdminSchemes;
defined( 'ABSPATH' ) || exit;

/** Keep website drafts isolated and prevent concurrent editor overwrites. */
final class Workflow {
	/** Per-request lock ownership; never exposed to clients. */
	private static string $lock = '';

	/** Register explicit workflows and one-time new-site provisioning. @return void */
	public static function register(): void {
		add_action( 'wp_ajax_bas_workflow', [ __CLASS__, 'ajax' ] );
		add_action( 'admin_enqueue_scripts', [ __CLASS__, 'assets' ] );
		add_action( 'network_admin_menu', [ __CLASS__, 'menu' ] );
		add_action( 'admin_post_bas_network_template', [ __CLASS__, 'network_save' ] );
		add_action( 'wp_initialize_site', [ __CLASS__, 'initialize_site' ], 200, 2 );
		add_action( 'shutdown', [ __CLASS__, 'unlock' ] );
		/**
		 * Add BAS through the verified Leitstand module extension point.
		 * @since 1.0.0
		 * @param array $modules Existing independent Leitstand modules.
		 * @return array Modules with optional BAS branding integration.
		 */
		add_filter( 'leitstand_modules', static function( array $modules ): array {
			if ( interface_exists( '\\Deckerweb\\Leitstand\\Module' ) ) {
				require_once BAS_PLUGIN_DIR . 'includes/class-bas-leitstand-module.php';
				$modules['bas-branding'] = new LeitstandModule();
			}
			return $modules;
		} );
		/**
		 * Place the BAS module in Leitstand's existing settings navigation group.
		 * @since 1.0.0
		 * @param array $groups Current navigation groups.
		 * @return array Navigation metadata extended only when the settings group exists.
		 */
		add_filter( 'leitstand_navigation_groups', static function( array $groups ): array {
			if ( isset( $groups['settings']['modules'] ) && is_array( $groups['settings']['modules'] ) ) { $groups['settings']['modules'][] = 'bas-branding'; }
			return $groups;
		} );
	}

	/**
	 * Read branding and templates in one statement for a consistent editor baseline.
	 * @return array{settings:mixed,revision:string} Stored settings and their revision.
	 */
	public static function snapshot(): array {
		global $wpdb;
		$rows = $wpdb->get_results( $wpdb->prepare( "SELECT option_name, option_value FROM {$wpdb->options} WHERE option_name IN (%s, %s)", \BAS_Plugin::OPTION, 'bas_templates' ), OBJECT_K );
		$settings = isset( $rows[\BAS_Plugin::OPTION] ) ? maybe_unserialize( $rows[\BAS_Plugin::OPTION]->option_value ) : null;
		$templates = isset( $rows['bas_templates'] ) ? maybe_unserialize( $rows['bas_templates']->option_value ) : [];
		return [ 'settings' => $settings, 'revision' => hash( 'sha256', wp_json_encode( [ get_current_blog_id(), $settings, $templates ] ) ) ];
	}

	/** Read a revision from fresh storage rather than a request-local cache. @return string */
	public static function revision(): string { return self::snapshot()['revision']; }

	/**
	 * Acquire a website mutex and compare the editor's revision before writing.
	 * @return void Sends a 409 response when stale or another writer owns the lock.
	 */
	public static function begin(): void {
		global $wpdb;
		$existing = $wpdb->get_var( $wpdb->prepare( "SELECT option_value FROM {$wpdb->options} WHERE option_name = %s", 'bas_write_lock' ) );
		if ( is_string( $existing ) && '' !== $existing && (float) $existing < microtime( true ) - 120 ) {
			$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->options} WHERE option_name = %s AND option_value = %s", 'bas_write_lock', $existing ) );
			wp_cache_delete( 'bas_write_lock', 'options' );
		wp_cache_delete( 'alloptions', 'options' );
		wp_cache_delete( 'notoptions', 'options' );
		}
		self::$lock = time() . ':' . wp_generate_uuid4();
		// INSERT IGNORE is atomic; add_option's duplicate-key update may replace a lock after a race.
		$claimed = $wpdb->query( $wpdb->prepare( "INSERT IGNORE INTO {$wpdb->options} (option_name, option_value, autoload) VALUES (%s, %s, %s)", 'bas_write_lock', self::$lock, 'no' ) );
		if ( 1 !== $claimed ) {
			self::$lock = '';
			wp_send_json_error( __( 'Another save is in progress. Try again shortly.', 'brand-admin-schemes' ), 409 );
		}
		wp_cache_delete( \BAS_Plugin::OPTION, 'options' );
		wp_cache_delete( 'bas_templates', 'options' );
		wp_cache_delete( 'alloptions', 'options' );
		$revision = $_POST['revision'] ?? '';
		if ( ! is_string( $revision ) || ! hash_equals( self::revision(), $revision ) ) {
			self::unlock();
			wp_send_json_error( __( 'Settings changed in another editor. Export your draft before reloading.', 'brand-admin-schemes' ), 409 );
		}
	}

	/** Release only this request's lock, including after failed writes. @return void */
	public static function unlock(): void {
		if ( '' === self::$lock ) { return; }
		global $wpdb;
		$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->options} WHERE option_name = %s AND option_value = %s", 'bas_write_lock', self::$lock ) );
		wp_cache_delete( 'bas_write_lock', 'options' );
		wp_cache_delete( 'alloptions', 'options' );
		wp_cache_delete( 'notoptions', 'options' );
		self::$lock = '';
	}

	/**
	 * Preserve at most ten validated snapshots for bounded local history.
	 * @param mixed $before Previous website settings, or null before the first save.
	 * @param string $color Previous personal color in this website's storage scope.
	 * @return void
	 */
	public static function remember( $before, string $color ): void {
		$history = get_option( 'bas_history', [] );
		$history = is_array( $history ) ? $history : [];
		array_unshift( $history, [ 'id' => wp_generate_uuid4(), 'date' => time(), 'user' => get_current_user_id(), 'scope' => Multisite::color_key(), 'before' => $before, 'color' => $color ] );
		update_option( 'bas_history', array_slice( $history, 0, 10 ), false );
	}

	/**
	 * Remove attachment IDs and site-specific identity from a portable template.
	 * @param array $settings Validated branding settings.
	 * @return array Portable settings requiring local media selection.
	 */
	public static function portable( array $settings ): array {
		foreach ( [ 'login_logo_id', 'login_banner_id', 'login_background_id' ] as $key ) { $settings[$key] = 0; }
		$settings['login_heading'] = '';
		$settings['login_message'] = '';
		$settings['login_quote'] = '';
		$settings['login_quote_author'] = '';
		$settings['login_svg_confirmed'] = false;
		$settings['delete_workflows'] = false;
		$settings['source'] = 'manual';
		$settings['palette'] = '';
		foreach ( $settings['manual'] as $role => $color ) { $settings['manual'][$role] = $settings['scheme']['brand_' . $role] ?? $color; $settings['mapping'][$role] = ''; }
		$settings['environment_mode'] = 'auto';
		$settings['default_mode'] = 'off';
		$settings['icons']['audience'] = 'capability';
		foreach ( [ 'frontend', 'admin', 'builder' ] as $context ) { $settings['icons'][$context]['label'] = ''; }
		return $settings;
	}

	/**
	 * Expose revision, bounded metadata and explicit template/history actions.
	 * @return void Emits a nonce- and capability-protected JSON response.
	 */
	public static function ajax(): void {
		check_ajax_referer( 'bas_nonce' );
		if ( ! current_user_can( 'manage_options' ) || is_network_admin() ) { wp_send_json_error( __( 'Forbidden', 'brand-admin-schemes' ), 403 ); }
		$operation = sanitize_key( is_string( $_POST['operation'] ?? null ) ? $_POST['operation'] : '' );
		$payload = $_POST['settings'] ?? '';
		$raw = is_string( $payload ) && strlen( $payload ) <= 300000 ? json_decode( wp_unslash( $payload ), true ) : null;
		$history = get_option( 'bas_history', [] );
		$history = is_array( $history ) ? $history : [];
		$templates = get_option( 'bas_templates', [] );
		$templates = is_array( $templates ) ? $templates : [];
		if ( 'template_save' === $operation ) {
			$name = is_array( $raw ) && is_string( $raw['name'] ?? null ) ? substr( sanitize_text_field( $raw['name'] ), 0, 80 ) : '';
			$settings = \BAS_Plugin::bundle_validate( is_array( $raw ) ? ( $raw['settings'] ?? null ) : null );
			if ( '' === $name || count( $templates ) >= 10 || empty( $settings['scheme'] ) ) { wp_send_json_error( __( 'Enter a template name. Up to ten templates can be stored.', 'brand-admin-schemes' ), 400 ); }
			self::begin();
			$templates[wp_generate_uuid4()] = [ 'name' => $name, 'settings' => self::portable( $settings ) ];
			update_option( 'bas_templates', $templates, false );
			self::unlock();
		} elseif ( 'template_delete' === $operation ) {
			$id = is_array( $raw ) && is_string( $raw['id'] ?? null ) ? $raw['id'] : '';
			if ( 'network-starter' === $id ) { wp_send_json_error( __( 'Manage this template in network settings.', 'brand-admin-schemes' ), 403 ); }
			self::begin(); unset( $templates[$id] ); update_option( 'bas_templates', $templates, false ); self::unlock();
		} elseif ( 'restore' === $operation ) {
			$id = is_array( $raw ) && is_string( $raw['id'] ?? null ) ? $raw['id'] : '';
			$entry = null;
			foreach ( $history as $item ) { if ( ( $item['id'] ?? '' ) === $id ) { $entry = $item; break; } }
			if ( ! is_array( $entry ) || $entry['user'] !== get_current_user_id() || $entry['scope'] !== Multisite::color_key() ) { wp_send_json_error( __( 'This history entry cannot be restored in your current context.', 'brand-admin-schemes' ), 409 ); }
			self::begin();
			$previous = get_option( \BAS_Plugin::OPTION, null );
			$color = get_user_meta( get_current_user_id(), Multisite::color_key(), true );
			self::remember( $previous, (string) $color );
			if ( null === $entry['before'] ) { delete_option( \BAS_Plugin::OPTION ); } else { update_option( \BAS_Plugin::OPTION, \BAS_Plugin::bundle_validate( $entry['before'] ), false ); }
			if ( '' === $entry['color'] ) { delete_user_meta( get_current_user_id(), Multisite::color_key() ); } else { Multisite::set_color( get_current_user_id(), $entry['color'] ); }
			delete_option( \BAS_Plugin::UNDO );
			self::unlock();
			/**
			 * Announce an explicit history restoration after the website write.
			 * @since 1.0.0
			 * @param int $site_id Website whose branding changed.
			 * @param string $reason Change reason: restore.
			 */
			do_action( 'bas_site_settings_changed', get_current_blog_id(), 'restore' );
			wp_send_json_success( [ 'revision' => self::revision(), 'settings' => \BAS_Plugin::editor_settings(), 'loginMedia' => \BAS_Plugin::editor_media( \BAS_Plugin::editor_settings() ) ] );
		} elseif ( 'state' !== $operation ) { wp_send_json_error( __( 'Unknown action.', 'brand-admin-schemes' ), 400 ); }
		$entries = [];
		foreach ( $history as $item ) {
			if ( $item['user'] === get_current_user_id() && $item['scope'] === Multisite::color_key() ) { $entries[] = [ 'id' => $item['id'], 'date' => wp_date( 'Y-m-d H:i', $item['date'] ), 'name' => $item['before']['name'] ?? __( 'Initial settings', 'brand-admin-schemes' ) ]; }
		}
		if ( is_multisite() ) {
			$network_template = get_network_option( get_current_network_id(), 'bas_network_template', [] );
			$network_settings = \BAS_Plugin::template_settings( $network_template['settings'] ?? null );
			if ( null !== $network_settings ) {
				$templates['network-starter'] = [ 'name' => $network_template['name'] ?? $network_settings['name'], 'settings' => self::portable( $network_settings ), 'origin' => 'network', 'readonly' => true ];
			}
		}
		wp_send_json_success( [ 'revision' => self::revision(), 'history' => $entries, 'templates' => $templates ] );
	}

	/**
	 * Load common footer styles and dialog behavior only on the network page.
	 * @param string $hook Current WordPress admin page hook.
	 * @return void
	 */
	public static function assets( string $hook ): void {
		if ( false === strpos( $hook, 'bas-network-template' ) || ! is_network_admin() ) { return; }
		wp_enqueue_style( 'bas-editor', plugins_url( 'assets/editor.css', BAS_PLUGIN_FILE ), [], \BAS_Plugin::VERSION );
		wp_enqueue_script( 'bas-documentation', plugins_url( 'assets/documentation.js', BAS_PLUGIN_FILE ), [], \BAS_Plugin::VERSION, true );
	}

	/** Register one functional network template page. @return void */
	public static function menu(): void {
		add_submenu_page( 'settings.php', __( 'Branding starter template', 'brand-admin-schemes' ), __( 'Branding starter template', 'brand-admin-schemes' ), 'manage_network_options', 'bas-network-template', [ __CLASS__, 'page' ] );
	}

	/** Render explicit network controls without enumerating every website. @return void */
	public static function page(): void {
		if ( ! current_user_can( 'manage_network_options' ) ) { return; }
		$value = get_network_option( get_current_network_id(), 'bas_network_template', [] );
		echo '<div class="wrap bas-root"><div class="bas-page-heading"><img src="' . esc_url( plugins_url( 'assets-github/icon.svg', BAS_PLUGIN_FILE ) ) . '" alt="" width="56" height="56"><h1>' . esc_html__( 'Brand Admin Schemes', 'brand-admin-schemes' ) . '</h1></div><h2>' . esc_html__( 'Branding starter template', 'brand-admin-schemes' ) . '</h2><p>' . esc_html__( 'Import a portable branding JSON. Apply it once to new websites or an explicitly selected empty website. Existing branding and personal colors are retained.', 'brand-admin-schemes' ) . '</p>';

		if ( ! empty( $value['settings'] ) ) {
			echo '<section class="bas-panel" aria-labelledby="bas-stored-template"><h3 id="bas-stored-template">' . esc_html__( 'Saved starter template', 'brand-admin-schemes' ) . '</h3><dl><dt>' . esc_html__( 'Name', 'brand-admin-schemes' ) . '</dt><dd>' . esc_html( $value['name'] ?? $value['settings']['name'] ?? __( 'Branding starter template', 'brand-admin-schemes' ) ) . '</dd><dt>' . esc_html__( 'Status', 'brand-admin-schemes' ) . '</dt><dd>' . esc_html( ! empty( $value['enabled'] ) ? __( 'Enabled for new websites', 'brand-admin-schemes' ) : __( 'Saved; automatic use is disabled', 'brand-admin-schemes' ) ) . '</dd>';
			if ( ! empty( $value['uploaded_at'] ) ) { echo '<dt>' . esc_html__( 'Last uploaded', 'brand-admin-schemes' ) . '</dt><dd>' . esc_html( wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), (int) $value['uploaded_at'] ) ) . '</dd>'; }
			if ( ! empty( $value['filename'] ) ) { echo '<dt>' . esc_html__( 'Source file', 'brand-admin-schemes' ) . '</dt><dd>' . esc_html( $value['filename'] ) . '</dd>'; }
			echo '</dl><p>' . esc_html__( 'Uploading another JSON replaces this starter template. Existing website branding stays unchanged.', 'brand-admin-schemes' ) . '</p></section>';
		} else { echo '<p>' . esc_html__( 'No starter template saved yet.', 'brand-admin-schemes' ) . '</p>'; }
		$notice = sanitize_key( wp_unslash( $_GET['bas_template_notice'] ?? '' ) );
		if ( in_array( $notice, [ 'saved', 'deleted' ], true ) ) { echo '<div class="notice notice-success"><p>' . esc_html( 'deleted' === $notice ? __( 'Starter template removed. Existing website branding stays unchanged.', 'brand-admin-schemes' ) : __( 'Starter template saved.', 'brand-admin-schemes' ) ) . '</p></div>'; }

		echo '<form method="post" enctype="multipart/form-data" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
		wp_nonce_field( 'bas_network_template' );
		echo '<input type="hidden" name="action" value="bas_network_template"><p><label>' . esc_html__( 'Branding JSON file', 'brand-admin-schemes' ) . ' <input type="file" name="template" accept=".json,application/json"></label></p><p><label><input type="checkbox" name="enabled" value="1" ' . checked( ! empty( $value['enabled'] ), true, false ) . '> ' . esc_html__( 'Use this starter template for new websites', 'brand-admin-schemes' ) . '</label></p><p><label>' . esc_html__( 'Optional destination website ID', 'brand-admin-schemes' ) . ' <input type="number" name="destination" min="1"></label></p><p>' . esc_html__( 'Images and website-specific text are excluded. Select images separately on each destination website.', 'brand-admin-schemes' ) . '</p>';
		submit_button(); echo '</form>';
		if ( ! empty( $value['settings'] ) ) {
			echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
			wp_nonce_field( 'bas_network_template' );
			echo '<input type="hidden" name="action" value="bas_network_template"><input type="hidden" name="operation" value="delete"><p><label><input type="checkbox" name="confirm_delete" value="1" required> ' . esc_html__( 'Remove the saved starter template and disable automatic use. Existing website branding stays unchanged.', 'brand-admin-schemes' ) . '</label></p>';
			submit_button( __( 'Delete starter template', 'brand-admin-schemes' ), 'delete' ); echo '</form>';
		}
		\BAS_Plugin::editor_footer(); echo '</div>';
	}

	/** Validate explicit network provisioning and retain existing branding. @return void */
	public static function network_save(): void {
		if ( ! is_multisite() || ! current_user_can( 'manage_network_options' ) ) { wp_die( esc_html__( 'Forbidden', 'brand-admin-schemes' ) ); }
		check_admin_referer( 'bas_network_template' );
		$network = get_current_network_id(); $value = get_network_option( $network, 'bas_network_template', [] );
		if ( 'delete' === ( $_POST['operation'] ?? '' ) ) {
			if ( empty( $_POST['confirm_delete'] ) ) { wp_die( esc_html__( 'Confirm deletion of the starter template.', 'brand-admin-schemes' ) ); }
			delete_network_option( $network, 'bas_network_template' );
			wp_safe_redirect( network_admin_url( 'settings.php?page=bas-network-template&bas_template_notice=deleted' ) ); exit;
		}
		$file = $_FILES['template'] ?? null;
		if ( is_array( $file ) && UPLOAD_ERR_NO_FILE !== $file['error'] ) {
			if ( UPLOAD_ERR_OK !== $file['error'] || $file['size'] > 300000 || ! is_uploaded_file( $file['tmp_name'] ) ) { wp_die( esc_html__( 'Invalid template file.', 'brand-admin-schemes' ) ); }
			$raw = json_decode( file_get_contents( $file['tmp_name'] ), true );
			if ( ! is_array( $raw ) || 'bas/v1' !== ( $raw['format'] ?? '' ) ) { wp_die( esc_html__( 'Unknown file format', 'brand-admin-schemes' ) ); }
			$settings = \BAS_Plugin::template_settings( $raw['settings'] ?? null );
			if ( null === $settings ) { wp_die( esc_html__( 'Invalid scheme colors', 'brand-admin-schemes' ) ); }
			$value['settings'] = self::portable( $settings );
			$name = $raw['template_name'] ?? $raw['name'] ?? $settings['name'];
			$value['name'] = is_string( $name ) && '' !== trim( $name ) ? substr( sanitize_text_field( $name ), 0, 80 ) : $settings['name'];
			$value['uploaded_at'] = time();
			$value['filename'] = sanitize_file_name( $file['name'] ?? '' );
		}
		$value['enabled'] = ! empty( $_POST['enabled'] );
		if ( $value['enabled'] && empty( $value['settings'] ) ) { wp_die( esc_html__( 'Choose a branding JSON before enabling the starter template.', 'brand-admin-schemes' ) ); }
		update_network_option( $network, 'bas_network_template', $value );
		$id = absint( $_POST['destination'] ?? 0 );
		if ( $id && ! self::apply( $id, $network, $value ) ) { wp_die( esc_html__( 'The destination has existing branding or belongs to another network. Nothing was overwritten.', 'brand-admin-schemes' ) ); }
		wp_safe_redirect( network_admin_url( 'settings.php?page=bas-network-template&bas_template_notice=saved' ) ); exit;
	}

	/**
	 * Seed only a new site where BAS is network-active; never synchronize later.
	 * @param \WP_Site $site Newly initialized website.
	 * @param array $args Core initialization arguments, unused.
	 * @return void
	 */
	public static function initialize_site( \WP_Site $site, array $args ): void {
		$active = get_network_option( (int) $site->network_id, 'active_sitewide_plugins', [] );
		$value = get_network_option( (int) $site->network_id, 'bas_network_template', [] );
		if ( isset( $active[plugin_basename( BAS_PLUGIN_FILE )] ) && ! empty( $value['enabled'] ) ) { self::apply( (int) $site->blog_id, (int) $site->network_id, $value ); }
	}

	/**
	 * Copy portable branding once without media, personal colors or replacement.
	 * @param int $site_id Destination website ID.
	 * @param int $network_id Owning network ID.
	 * @param array $template Validated network template envelope.
	 * @return bool Whether the empty destination received branding.
	 */
	public static function apply( int $site_id, int $network_id, array $template ): bool {
		$site = get_site( $site_id );
		if ( ! $site || (int) $site->network_id !== $network_id || empty( $template['settings']['scheme'] ) ) { return false; }
		switch_to_blog( $site_id );
		try {
			$validated = \BAS_Plugin::template_settings( $template['settings'] );
			if ( null === $validated ) { return false; }
			$o = self::portable( $validated );
			$id = 'bas-' . substr( md5( wp_generate_uuid4() ), 0, 12 );
			$o['active'] = $id; $o['schemes'][$id] = [ 'name' => $o['name'] ?: 'CI', 'colors' => $o['scheme'] ];
			return add_option( \BAS_Plugin::OPTION, $o, '', false );
		} finally { restore_current_blog(); }
	}
}
