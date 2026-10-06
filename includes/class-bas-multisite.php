<?php
/**
 * Site-specific user color preferences for WordPress Multisite.
 *
 * @package BrandAdminSchemes
 * @since 0.18.0
 */

namespace Deckerweb\BrandAdminSchemes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Multisite {
	/** Register adapters; no network-wide settings or site iteration required.
	 * @return void
	 */
		public static function register(): void {
		add_filter( 'update_user_metadata', [ __CLASS__, 'profile_color' ], 10, 4 );
		add_action( 'wp_ajax_save-user-color-scheme', [ __CLASS__, 'save_profile_color' ], 1 );
		add_action( 'admin_enqueue_scripts', [ __CLASS__, 'profile_assets' ] );
	}

	/** Resolve the actual storage key without applying default/forced colors.
	 * @return string
	 */
		public static function color_key(): string {
		global $wpdb;
		return self::site_scope() ? $wpdb->get_blog_prefix() . 'admin_color' : 'admin_color';
	}

	/** Network admin retains WordPress's global preference.
	 * @return bool
	 */
		public static function site_scope(): bool {
		return is_multisite() && ! is_network_admin();
	}

	/** Save in the same scope used by WordPress's user-option reader.
	 * @param int $user_id Affected WordPress user ID.
	 * @param string $color Color.
	 * @return void
	 */
		public static function set_color( int $user_id, string $color ): void {
		update_user_option( $user_id, 'admin_color', $color, ! self::site_scope() );
	}

	/**
	 * Scope a validated WordPress profile submission to its current website.
	 *
	 * This filter runs within Core's metadata update, after profile validation.
	 * Other metadata and programmatic global preferences remain untouched.
	 *
	 * @param mixed  $check      Existing short-circuit value.
	 * @param int    $user_id    Edited user ID.
	 * @param string $meta_key   Metadata key.
	 * @param mixed  $meta_value Submitted value.
	 * @return mixed Original short-circuit value or successful local write.
	 */
	public static function profile_color( $check, $user_id, $meta_key, $meta_value ) {
		global $pagenow, $_wp_admin_css_colors;
		if ( null !== $check || ! self::site_scope() || 'admin_color' !== $meta_key
			|| ! in_array( $pagenow, [ 'profile.php', 'user-edit.php' ], true ) ) {
			return $check;
		}
		$nonce = $_POST['_wpnonce'] ?? '';
		if ( ! is_string( $nonce ) || ! wp_verify_nonce( wp_unslash( $nonce ), 'update-user_' . $user_id )
			|| ! current_user_can( 'edit_user', $user_id ) || ! is_string( $meta_value )
			|| ! isset( $_wp_admin_css_colors[ $meta_value ] ) ) {
			return $check;
		}
		self::set_color( (int) $user_id, $meta_value );
		return true;
	}

	/** Carry the network-profile context across Core's site-admin AJAX endpoint.
	 * @param string $hook Current WordPress admin page hook.
	 */
		public static function profile_assets( string $hook ): void {
		if ( ! is_multisite() || ! is_network_admin() || ! in_array( $hook, [ 'profile.php', 'user-edit.php' ], true ) ) {
			return;
		}
		wp_enqueue_script( 'bas-profile-scope', plugins_url( 'assets/profile.js', BAS_PLUGIN_FILE ), [ 'jquery', 'user-profile' ], \BAS_Plugin::VERSION, true );
		wp_add_inline_script( 'bas-profile-scope', 'window.BAS_PROFILE_SCOPE=' . wp_json_encode( [
			'nonce' => wp_create_nonce( 'bas_network_color_' . get_current_blog_id() ),
		] ) . ';', 'before' );
	}

	/** Keep Core's profile-picker AJAX contract while storing a local choice. */
	public static function save_profile_color(): void {
		global $_wp_admin_css_colors;
		// Core does not set WP_NETWORK_ADMIN in admin-ajax.php. A user-bound
		// nonce from the network profile supplies the missing context explicitly.
		if ( is_multisite() && 'network' === ( $_POST['bas_color_scope'] ?? '' ) ) {
			$nonce = $_POST['bas_color_scope_nonce'] ?? '';
			if ( ! is_string( $nonce ) || ! wp_verify_nonce( wp_unslash( $nonce ), 'bas_network_color_' . get_current_blog_id() ) ) {
				wp_send_json_error( null, 403 );
			}
			// Core verifies its own nonce and stores the global preference.
			return;
		}
		if ( ! self::site_scope() ) {
			return;
		}
		check_ajax_referer( 'save-color-scheme', 'nonce' );
		$raw = $_POST['color_scheme'] ?? '';
		$color = is_string( $raw ) ? sanitize_key( wp_unslash( $raw ) ) : '';
		$user_id = get_current_user_id();
		if ( ! $user_id || ! isset( $_wp_admin_css_colors[ $color ] ) ) {
			wp_send_json_error();
		}
		$previous = get_user_option( 'admin_color', $user_id );
		self::set_color( $user_id, $color );
		wp_send_json_success( [
			'previousScheme' => 'admin-color-' . $previous,
			'currentScheme'  => 'admin-color-' . $color,
		] );
	}
}
