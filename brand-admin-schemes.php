<?php
/**
 * Plugin Name: Brand Admin Schemes
 * Plugin URI: https://github.com/deckerweb/brand-admin-schemes
 * Description: Brand colors for your WordPress admin, login, toolbar and browser tabs. Use Core Framework, Bricks, ACSS or your own palette.
 * Version: 0.18.0
 * Requires at least: 6.4
 * Requires PHP: 8.0
 * Author: David Decker – DECKERWEB
 * Author URI: https://github.com/deckerweb
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: brand-admin-schemes
 * Domain Path: /languages/
 * Update URI: https://github.com/deckerweb/brand-admin-schemes
 * GitHub Plugin URI: https://github.com/deckerweb/brand-admin-schemes
 *
 * Copyright © 2022–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
define( 'BAS_PLUGIN_FILE', __FILE__ );
define( 'BAS_PLUGIN_DIR', __DIR__ . '/' );
/**
 * Manages source palettes, saved admin schemes, the settings editor and toolbar colors.
 *
 * Saved settings are site-wide; the selected admin color is a WordPress user option.
 * @internal
 */
final class BAS_Plugin {
	/** Current package version, shared by assets and the settings footer. */
	const VERSION = '0.18.0';
	/**
	 * Site option containing the editor state and saved schemes.
	 * @var string
	 */
	const OPTION = 'bas_settings';
	/**
	 * Single-use snapshot of the last save for its author.
	 * @var string
	 */
	const UNDO = 'bas_last_undo';
	/**
	 * Register WordPress hooks for settings, colors, localization and AJAX.
	 */
	public static function boot(): void {
		BAS_Context_Icons::boot();
		BAS_Bundle::boot();
		BAS_Gutenberg_Palette::boot();
		add_action( 'init', static function() {
			load_plugin_textdomain( 'brand-admin-schemes', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		} );
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), [__CLASS__, 'action_links'] );
		add_filter( 'network_admin_plugin_action_links_' . plugin_basename( __FILE__ ), [__CLASS__, 'action_links'] );
		add_action( 'admin_menu', [__CLASS__, 'menu'] );
		add_action( 'admin_enqueue_scripts', [__CLASS__, 'assets'] );
		add_action( 'admin_enqueue_scripts', [__CLASS__, 'environment_style'] );
		add_action( 'admin_init', [__CLASS__, 'register_scheme'], 20 );
		add_action( 'wp_enqueue_scripts', [__CLASS__, 'frontend_bar'], 100 );
		add_action( 'wp_enqueue_scripts', [__CLASS__, 'environment_style'] );
		add_action( 'admin_bar_menu', [__CLASS__, 'environment_badge'], 210 );
		add_filter( 'get_user_option_admin_color', [__CLASS__, 'admin_color_option'], 10, 3 );
		add_action( 'admin_head-profile.php', [__CLASS__, 'hide_picker'] );
		add_action( 'admin_head-user-edit.php', [__CLASS__, 'hide_picker'] );
		add_action( 'wp_ajax_bas_save', [__CLASS__, 'save'] );
		add_action( 'wp_ajax_bas_undo', [__CLASS__, 'undo'] );
		add_action( 'wp_ajax_bas_import', [__CLASS__, 'import'] );
		add_action( 'wp_ajax_bas_sources', [__CLASS__, 'sources_ajax'] );
		add_action( 'login_enqueue_scripts', [__CLASS__, 'login_assets'] );
		add_action( 'login_header', [__CLASS__, 'login_visual'] );
		add_filter( 'login_message', [__CLASS__, 'login_welcome'] );
		add_filter( 'login_headerurl', [__CLASS__, 'login_logo_url'] );
		add_filter( 'login_headertext', [__CLASS__, 'login_logo_text'] );
	}

	/**
	 * Place the settings link immediately before Deactivate.
	 * @param array<string,string> $links Plugin action links.
	 * @return array<string,string>
	 */
	public static function action_links( array $links ): array {
		if ( !current_user_can( 'manage_options' ) ) {
			return $links;
		}
		$link = '<a href="' . esc_url( admin_url( 'options-general.php?page=brand-admin-schemes' ) ) . '">' . esc_html__( 'Color scheme', 'brand-admin-schemes' ) . '</a>';
		$out = [];
		$inserted = false;
		foreach ( $links as $key => $value ) {
			if ( $key === 'deactivate' ) {
				$out['bas_settings'] = $link;
				$inserted = true;
			}
			$out[$key] = $value;
		}
		if ( !$inserted ) {
			$out['bas_settings'] = $link;
		}
		return $out;
	}

	/**
	 * Return strings consumed by the JavaScript editor in the current locale.
	 * @return array<string,string> Original English message to translation.
	 */
	private static function translations(): array {
		$strings = [
			'Who can see contextual tab icons?',
			'Administrators and users with permission',
			'Everyone, including visitors',
			'Restricted by default using bas_view_context_icons. Everyone also makes generated frontend icons and their optional environment marker public. Save all changes to apply this choice.',
			'Contextual tab icons are currently available to everyone, including visitors.',
			'Use & export',
			'Download SVG',
			'Download PNG',
			'Save to Media Library',
			'Use as official Site Icon',
			'Exports use the generated design. PNGs are 512 × 512 pixels. Media and Site Icon actions take effect immediately; the official Site Icon omits the environment marker.',
			'The icon could not be rendered. Please try again.',
			'PNG export is not supported by this browser.',
			'Use this design as the official WordPress Site Icon? This immediately adds a PNG to the Media Library, replaces the Site Icon and switches the frontend to the WordPress Site Icon. Other draft settings are not saved.',
			'Preparing icon…',
			'Icon downloaded.',
			'The icon could not be saved to the Media Library.',
			'Official Site Icon updated. Other draft settings have not been saved.',
			'Icon saved to the Media Library.',
			'Open in Media Library',
			'A valid 512 × 512 PNG icon is required.',
			'Invalid icon action.',
			'PNG uploads are not available on this site.',
			'The upload quota is exhausted.',
			'WordPress could not process the PNG icon.',

			'Contextual tab icons are visible only to signed-in users with the bas_view_context_icons capability. Administrators receive it by default; a role editor can grant it to other roles or users. Visitors keep the WordPress Site Icon.',
			'Contextual tab icons are available to administrators by default. Other users and visitors keep the WordPress Site Icon.',

			'Guided setup',
			'Four simple steps. Your existing settings stay available.',
			'Choose your colors',
			'Find your atmosphere',
			'Optional finishing touches',
			'Review and save',
			'Your brand at a glance',
			'Review the scheme name and user default below, then save in the fixed bar above.',
			'Your Site Icon and site title are used when no custom logo or title is selected. Existing images and settings are retained.',
			'Existing icon settings are retained. Colors and initials provide automatic fallbacks.',
			'Previews show the optional designs, even when they are disabled.',
			'Continue in full settings',
			'Changes remain a draft until you save. You can leave setup at any time and continue in the full settings.',
			'Back',
			'Next',
			'Use Save all changes in the fixed bar above to apply your design.',
			'Enabled',
			'Disabled',
			'Browser tab icons',

			'Symbol',
			'Environment display',
			'Displayed environment',
			'Preview',
			'Balanced',
			'Calm',
			'Bold',
			'Dark',
			'Save scheme',
			'Reload page',
			'Unsaved changes',
			'All changes saved',
			'Discard unsaved changes and reload the page?',
			'Color contrast check',
			'Estimated text contrast for this scheme and login palette. Other plugins can change the final appearance.',
			'Admin menu',
			'Admin submenu',
			'Admin toolbar',
			'Admin buttons',
			'Login background',
			'Login button',
			'Readable',
			'Check contrast',
			'Try text',
			'Try background',
			'Mark the installation environment on generated favicons',
			'A small letter and color distinguish Local, Development, Staging and Live tabs. A retained WordPress Site Icon stays unchanged.',
			'Export agency package (.zip)',
			'Import agency package (.zip)',
			'An agency package includes settings and local PNG, JPEG, WebP or GIF images (up to 4 MB each). SVG files are excluded. On import, images are added to the Media Library immediately; review and save the settings afterward. ZIP support is required on the server.',
			'Export failed',
			'Import failed',
			'Agency package is too large.',
			'Agency package imported for review. Images were added to the Media Library; save all changes to apply settings.',
			'Offer brand colors in the Gutenberg palette',
			'Adds Primary, Secondary, Tertiary and Accent as extra editor colors. Existing theme colors stay available; the saved active scheme provides the values.',
			'Save all changes',
			'Jump to a section',
			'Jump to:',
			'Brand colors',
			'Scheme & toolbar',
			'Browser favicons',
			'Import & export',
			'Export settings as JSON',
			'Import settings from JSON',
			'Export your color schemes and plugin settings as JSON, or import a file to review it before saving. Images stay in the WordPress media library and are not included in the JSON file.',
			'Use “Save all changes” in the fixed bar above to activate the selected scheme and apply settings across this page.',
			'All settings saved. The selected admin scheme is active for your account. Reload the page to see every change.',
			'Settings imported for review. Check the previews, then save all changes to apply them.',
			'Browser tab icons (favicons)',
			'These small icons appear in browser tabs, helping you tell the public website, WordPress admin and builder editor apart.',
			'Use different icons in browser tabs',
			'Website browser tab',
			'WordPress admin browser tab',
			'Builder editor browser tab',
			'Generate a website favicon',
			'Keep the WordPress Site Icon as favicon',
			'In a detected builder editor tab, the favicon uses the builder color preset. Ordinary website tabs keep their website icon.',
			'Color source',
			'Source',
			'Manual colors',
			'Bricks palette',
			'Core Framework, ACSS and Bricks are shown only when readable colors are available. Saved color values remain available without the source.',
			'optional',
			'Derive automatically',
			'Atmosphere',
			'Brand strength',
			'Higher brand strength makes the brand colors more prominent. Text and button colors are adjusted for readability.',
			'Save and assign',
			'Scheme name',
			'Saved schemes',
			'New scheme',
			'Default for users',
			'No default',
			'Default; allow personal selection',
			'Force for all users',
			'Color frontend admin bar',
			'Frontend admin bar color',
			'The default applies to users on the WordPress default scheme; forcing also overrides personal selections.',
			'Preview and apply',
			'Hover over a card or focus it with the keyboard. Escape ends the temporary preview.',
			'Save and activate selected scheme',
			'Export JSON',
			'Import JSON',
			'Save failed',
			'Scheme saved and activated for your account. Reload the page to see the full result.',
			'File too large.',
			'Scheme imported. Check the preview and save to activate it.',
			'Color sources could not be loaded. Manual colors remain available.',
			'Primary',
			'Secondary',
			'Tertiary',
			'Accent',
			'Generate a WordPress admin color scheme from Core Framework, Bricks, or four manual brand colors.',
			'Color scheme',
			'Brand Admin',
			'Brand Admin Schemes',
			'Invalid scheme colors',
			'Unknown file format',
			'Forbidden',
			'Brand colors create readable WordPress admin schemes.',
			'Loading editor…',
			'CI · ',
			'Undo last save',
			'No saved change to undo.',
			'Last save undone. Reload the page to see the full result.',
			'Undo is no longer available because settings changed.',
			'Contrast',
			'Menu',
			'Button',
			'Review source color changes',
			'The source palette has changed since this scheme was saved. Review the old and new colors before updating it.',
			'Confirm source changes before saving.',
			'I reviewed the source color changes',
			'Saved',
			'Current',
			'Installation environment',
			'Automatic detection',
			'Local',
			'Development',
			'Staging',
			'Live',
			'Detected environment',
			'WordPress setting',
			'Site address hint',
			'WordPress default',
			'Manual selection',
			'PHP version',
			'Enabled',
			'Disabled',
			'The badge appears in the admin bar on both the frontend and backend. Automatic detection uses the WordPress environment first and cautious site address hints only when no environment is configured.',
			'Status colors',
			'Custom color',
			'Automatic color',
			'Colors adapt to the visible toolbar. Custom colors keep their hue and change brightness only when needed for contrast.',
			'Welcome back',
			'Login design',
			'Style the WordPress login',
			'Layout',
			'Image on the left',
			'Image on the right',
			'Centered',
			'Content alignment',
			'Align left',
			'Align center',
			'Customer logo',
			'Tab icons',
			'Distinguish frontend, admin and builder tabs at a glance.',
			'Enable contextual tab icons',
			'Generate frontend icon',
			'Keep WordPress Site Icon',
			'Frontend tab',
			'Admin tab',
			'Builder tab',
			'Letters',
			'Circle outline',
			'Spark outline',
			'Leaf outline',
			'Shield outline',
			'Diamond outline',
			'Grid outline',
			'Bricks outline',
			'Oxygen outline',
			'Automatic builder symbol',
			'Builder color preset',
			'Automatically detected',
			'Leave colors empty to follow the active scheme or builder preset.',
			'Abbreviation (up to 3 characters)',
			'Background color',
			'Foreground color',
			'Automatic from scheme',
			'Automatic contrast',
			'Builder colors follow Bricks, Elementor or Oxygen when detected.',
			'A short quote appears only on the image or gradient panel.',
			'A banner replaces the logo and stays within the form width.',
			'Gradient style',
			'Attribution (optional)',
			'Quote on image panel',
			'Use banner',
			'Use logo or Site Icon',
			'Customer banner',
			'Logo display',
			'A wide image works best; its full shape remains visible.',
			'Gradients use the current scheme colors. A selected background image takes priority.',
			'Optional short quote',
			'Dusk',
			'Mist',
			'Bloom',
			'Horizon',
			'Satin',
			'Background image',
			'Choose image',
			'Remove image',
			'Welcome heading',
			'Welcome message',
			'Image position',
			'Overlay strength',
			'Login colors',
			'Use scheme colors',
			'Customize login colors',
			'Background',
			'Surface',
			'Button color',
			'Desktop',
			'Tablet',
			'Mobile',
			'Login preview',
			'Username or email address',
			'Password',
			'Remember Me',
			'Log In',
			'Lost your password?',
			'Preview login in a new tab',
			'Logo and background image are optional. The standard WordPress forms remain available.',
			'Media library unavailable.',
			'Show site title',
			'Show site tagline',
			'Uses the WordPress site title when empty; falls back to Welcome back.',
			'Uses the WordPress tagline when empty.',
			'Site Icon is used automatically. Choose an image to override it.',
			'Gradient style',
			'Diagonal',
			'Aurora',
			'Radial',
			'Surprise me (stable per site)',
			'Page background',
			'SVG logo (requires Safe SVG)',
			'I understand: SVG files must be sanitized. Only administrators can choose one here.',
			'Install and activate Safe SVG to use sanitized SVG logos.',
			'Confirm sanitized SVG logos first.',
		];
		$out = [];
		foreach ( $strings as $message ) {
			$out[$message] = __( $message, 'brand-admin-schemes' );
		}
		return $out;
	}

	/**
	 * Define the initial editor state, scheme collection and site-wide options.
	 * @return array<string,mixed>
	 */
	private static function defaults(): array {
		return [
			'source' => 'manual',
			'palette' => '',
			'mapping' => ['primary' => '', 'secondary' => '', 'tertiary' => '', 'accent' => ''],
			'manual' => ['primary' => '#3858e9', 'secondary' => '#23282d', 'tertiary' => '#64748b', 'accent' => '#d54e21'],
			'mood' => 'balanced',
			'strength' => 50,
			'scheme' => [],
			'name' => '',
			'schemes' => [],
			'active' => '',
			'default_mode' => 'off',
			'frontend_bar' => true,
			'bar_color' => 'primary',
			'environment_mode' => 'auto',
			'environment_colors' => ['local' => '', 'development' => '', 'staging' => '', 'production' => ''],
			'login_enabled' => false,
			'icons' => self::default_icons(),
			'gutenberg_palette' => false,
			'login_layout' => 'left',
			'login_alignment' => 'left',
			'login_logo_id' => 0,
			'login_banner_id' => 0,
			'login_brand_mode' => 'logo',
			'login_quote' => '',
			'login_quote_author' => '',
			'login_background_id' => 0,
			'login_position_x' => 50,
			'login_position_y' => 50,
			'login_overlay' => 35,
			'login_heading' => '',
			'login_message' => '',
			'login_show_title' => true,
			'login_show_tagline' => true,
			'login_gradient' => 'diagonal',
			'login_svg_confirmed' => false,
			'login_color_mode' => 'scheme',
			'login_colors' => ['background' => '', 'surface' => '', 'button' => '', 'page' => ''],
		];
	}

	/**
	 * Merge saved settings with defaults for fields added by newer versions.
	 * @return array<string,mixed>
	 */
	private static function settings(): array {
		$o = get_option( self::OPTION, [] );
		return array_replace_recursive( self::defaults(), is_array( $o ) ? $o : [] );
	}

	/**
	 * Resolves the visual environment badge without modifying WordPress behavior.
	 *
	 * Manual choice takes precedence. WordPress's production default is refined
	 * only when neither its constant nor its environment variable is configured.
	 *
	 * @return array{type:string,source:string}
	 */
	private static function environment_status(): array {
		$mode = self::settings()['environment_mode'];
		$allowed = ['local', 'development', 'staging', 'production'];
		if ( in_array( $mode, $allowed, true ) ) {
			return ['type' => $mode, 'source' => 'manual'];
		}

		$wp_type = wp_get_environment_type();
		$explicit_constant = defined( 'WP_ENVIRONMENT_TYPE' ) && WP_ENVIRONMENT_TYPE;
		$explicit_variable = function_exists( 'getenv' ) && '' !== getenv( 'WP_ENVIRONMENT_TYPE' ) && false !== getenv( 'WP_ENVIRONMENT_TYPE' );
		if ( 'production' !== $wp_type || $explicit_constant || $explicit_variable ) {
			return ['type' => $wp_type, 'source' => 'wordpress'];
		}

		// Only the saved home URL is used; the request Host header is untrusted.
		$host = wp_parse_url( home_url(), PHP_URL_HOST );
		$host = is_string( $host ) ? strtolower( trim( rtrim( $host, '.' ), '[]' ) ) : '';
		// Local by Flywheel uses .local; all 127/8 addresses and IPv6 ::1 loop back.
		$is_loopback_v4 = preg_match( '/^127(?:\.(?:25[0-5]|2[0-4]\d|1?\d?\d)){3}$/', $host );
		$is_loopback_v6 = in_array( $host, ['::1', '0:0:0:0:0:0:0:1'], true ) || preg_match( '/^::ffff:127\.(?:25[0-5]|2[0-4]\d|1?\d?\d)(?:\.(?:25[0-5]|2[0-4]\d|1?\d?\d)){2}$/', $host );
		if ( 'localhost' === $host || $is_loopback_v4 || $is_loopback_v6 || preg_match( '/\.(?:localhost|test|local)$/', $host ) ) {
			return ['type' => 'local', 'source' => 'url'];
		}
		if ( preg_match( '/^(?:staging|stage|stg)\./', $host ) ) {
			return ['type' => 'staging', 'source' => 'url'];
		}
		if ( preg_match( '/^(?:development|dev)\./', $host ) ) {
			return ['type' => 'development', 'source' => 'url'];
		}
		return ['type' => 'production', 'source' => 'default'];
	}

	/** Returns translated names for the four supported environment types. */
	private static function environment_labels(): array {
		return [
			'local'       => __( 'Local', 'brand-admin-schemes' ),
			'development' => __( 'Development', 'brand-admin-schemes' ),
			'staging'     => __( 'Staging', 'brand-admin-schemes' ),
			'production'  => __( 'Live', 'brand-admin-schemes' ),
		];
	}

	/**
	 * Accept only six-digit hexadecimal colors and normalize their case.
	 * @param mixed $value Candidate color.
	 * @return string Normalized hex color, or an empty string.
	 */
	private static function color( $value ): string {
		return is_string( $value ) && preg_match( '/^#[0-9a-fA-F]{6}$/D', $value ) ? strtolower( $value ): '';
	}

	/**
	 * Read Bricks color palettes when Bricks is available.
	 * @return array<int,array{id:string,name:string,colors:array<int,array{id:string,name:string,hex:string}>}>
	 */
	private static function palettes(): array {
		$out = [];
		if ( function_exists( 'bricks_is_builder' ) || defined( 'BRICKS_VERSION' ) || class_exists( '\\Bricks\\Database' ) ) {
			$data = get_option( 'bricks_color_palette', [] );
			if ( is_array( $data ) ) {
				foreach ( $data as $palette ) {
					if ( !is_array( $palette ) || empty( $palette['colors'] ) || !is_array( $palette['colors'] ) ) {
						continue;
					}
					$colors = [];
					foreach ( $palette['colors'] as $item ) {
						if ( !is_array( $item ) ) {
							continue;
						}
						$hex = self::color( $item['light'] ?? $item['hex'] ?? '' );
						if ( $hex ) {
							$colors[] = ['id' => sanitize_text_field( (string)( $item['id'] ?? $hex ) ), 'name' => sanitize_text_field( (string)( $item['name'] ?? $item['raw'] ?? $hex ) ), 'hex' => $hex];
						}
					}
					if ( $colors ) {
						$out[] = ['id' => sanitize_text_field( (string)( $palette['id'] ?? count( $out ) ) ), 'name' => sanitize_text_field( (string)( $palette['name'] ?? 'Bricks palette' ) ), 'colors' => $colors];
					}
				}
			}
		}
		return $out;
	}

	/**
	 * Extract simple hex custom properties from Core Framework generated CSS.
	 * @return array<int,array{id:string,name:string,hex:string}>
	 */
	private static function coreframework_colors(): array {
		if ( !class_exists( '\\CoreFramework\\Helper' ) ) {
			return [];
		}
		try {
			$helper = new \CoreFramework\Helper();
			if ( !method_exists( $helper, 'getStylesheetPath' ) ) {
				return [];
			}
			$path = $helper->getStylesheetPath();
			if ( !is_string( $path ) || !is_file( $path ) || !is_readable( $path ) ) {
				return [];
			}
			$css = file_get_contents( $path, false, null, 0, 1024 * 1024 );
			if ( !is_string( $css ) ) {
				return [];
			}
			preg_match_all( '/--([a-zA-Z][\w-]*)\s*:\s*(#[0-9a-fA-F]{6})\s*[;}]/', $css, $matches, PREG_SET_ORDER );
			$out = [];
			foreach ( $matches as $m ) {
				$out[] = ['id' => $m[1], 'name' => '--' . $m[1], 'hex' => strtolower( $m[2] )];
			}
			return array_slice( $out, 0, 300 );
		} catch ( Throwable $e ) {
			return [];
		}
	}

	/**
	 * Read enabled hex color roles from a compatible ACSS settings API.
	 * @return array<int,array{id:string,name:string,hex:string}>
	 */
	private static function acss_colors(): array {
		// Compatibility adapter: only offer ACSS when its installed version exposes readable colors.
		if ( !class_exists( '\\Automatic_CSS\\Model\\Database_Settings' ) ) {
			return [];
		}
		try {
			$class = '\\Automatic_CSS\\Model\\Database_Settings';
			if ( !is_callable( [$class, 'get_instance'] ) ) {
				return [];
			}
			$database = $class::get_instance();
			if ( !is_object( $database ) || !is_callable( [$database, 'get_vars'] ) ) {
				return [];
			}
			$vars = $database->get_vars();
			if ( !is_array( $vars ) ) {
				return [];
			}
			$out = [];
			foreach ( ['primary', 'secondary', 'tertiary', 'accent', 'base', 'neutral'] as $role ) {
				$enabled = $vars['option-' . $role . '-clr'] ?? 'on';
				if ( $enabled === 'off' || $enabled === false ) {
					continue;
				}
				$v = $vars['color-' . $role] ?? null;
				if ( !is_string( $v ) ) {
					continue;
				}
				$v = trim( $v );
				if ( preg_match( '/^#[0-9a-fA-F]{3}$/D', $v ) ) {
					$v = '#' . $v[1] . $v[1] . $v[2] . $v[2] . $v[3] . $v[3];
				}
				$hex = self::color( $v );
				if ( $hex ) {
					$out[] = ['id' => $role, 'name' => ucfirst( $role ), 'hex' => $hex];
				}
			}
			return $out;
		} catch ( Throwable $e ) {
			return [];
		}
	}

	/**
	 * Send currently readable source colors to the editor after nonce/capability checks.
	 */
	public static function sources_ajax(): void {
		check_ajax_referer( 'bas_nonce' );
		if ( !current_user_can( 'manage_options' ) ) {
			wp_send_json_error( __( 'Forbidden', 'brand-admin-schemes' ), 403 );
		}
		wp_send_json_success( ['bricks' => self::palettes(), 'core' => self::coreframework_colors(), 'acss' => self::acss_colors()] );
	}


	/** Validate a portable draft without saving it. */
	public static function bundle_validate( $raw ): array {
		$settings = self::validate( $raw );
		if ( !self::valid_scheme( $settings['scheme'] ) ) {
			wp_send_json_error( __( 'Invalid scheme colors', 'brand-admin-schemes' ), 400 );
		}
		return $settings;
	}

	/** Defaults keep existing installations unchanged until the feature is enabled. */
	private static function default_icons(): array {
		return ['enabled' => false, 'audience' => 'capability', 'frontend_mode' => 'generated', 'builder_style' => 'auto', 'environment_marker' => true,
			'frontend' => ['label' => '', 'symbol' => 'text', 'background' => '', 'foreground' => ''],
			'admin' => ['label' => '', 'symbol' => 'text', 'background' => '', 'foreground' => ''],
			'builder' => ['label' => '', 'symbol' => 'auto', 'background' => '', 'foreground' => '']];
	}

	/** Validate only finite icon choices and hex colors before rendering SVG. */
	private static function sanitize_icons( $raw ): array {
		$icons = self::default_icons();
		if ( !is_array( $raw ) ) {
			return $icons;
		}
		$icons['enabled'] = !empty( $raw['enabled'] );
		$icons['audience'] = 'everyone' === ( $raw['audience'] ?? '' ) ? 'everyone' : 'capability';
		$icons['environment_marker'] = !empty( $raw['environment_marker'] );
		$icons['frontend_mode'] = 'wordpress' === ( $raw['frontend_mode'] ?? '' ) ? 'wordpress' : 'generated';
		$icons['builder_style'] = in_array( $raw['builder_style'] ?? '', ['auto', 'bricks', 'elementor', 'oxygen'], true ) ? $raw['builder_style'] : 'auto';
		foreach ( ['frontend', 'admin', 'builder'] as $context ) {
			$design = isset( $raw[$context] ) && is_array( $raw[$context] ) ? $raw[$context] : [];
			$icons[$context]['label'] = substr( sanitize_text_field( is_scalar( $design['label'] ?? '' ) ? (string) ( $design['label'] ?? '' ) : '' ), 0, 12 );
			$icons[$context]['symbol'] = in_array( $design['symbol'] ?? '', ['auto', 'text', 'circle', 'diamond', 'spark', 'leaf', 'shield', 'grid', 'bricks', 'oxygen'], true ) ? $design['symbol'] : $icons[$context]['symbol'];
			foreach ( ['background', 'foreground'] as $color ) {
				$icons[$context][$color] = self::color( $design[$color] ?? '' );
			}
		}
		return $icons;
	}

	/** Preserve all saved settings when an explicit action adopts a core Site Icon. */
	public static function use_official_site_icon(): void {
		$settings = self::settings();
		$settings['icons']['frontend_mode'] = 'wordpress';
		update_option( self::OPTION, $settings, false );
		do_action( 'bas_site_settings_changed', get_current_blog_id(), 'site_icon' );
	}

	/** Expose sanitized settings to the icon renderer. */
	public static function icon_settings(): array {
		return self::settings()['icons'];
	}

	/** Expose validated palette settings to the optional Gutenberg adapter. */
	public static function palette_settings(): array {
		return self::settings();
	}

	/** Environment resolved from the same manual and automatic rules as the toolbar badge. */
	public static function icon_environment_type(): string {
		return self::environment_status()['type'];
	}

	/**
	 * Expose the existing badge resolution to read-only Site Health information.
	 *
	 * @since 0.17.0
	 * @return array<string,string> Resolved environment and localized labels.
	 */
	public static function site_health_environment(): array {
		$environment = self::environment_status();
		$sources = array(
			'manual' => __( 'Manual selection', 'brand-admin-schemes' ),
			'wordpress' => __( 'WordPress setting', 'brand-admin-schemes' ),
			'url' => __( 'Site address hint', 'brand-admin-schemes' ),
			'default' => __( 'WordPress default', 'brand-admin-schemes' ),
		);
		return array(
			'type' => $environment['type'],
			'label' => self::environment_labels()[ $environment['type'] ],
			'source' => $environment['source'],
			'source_label' => $sources[ $environment['source'] ],
		);
	}

	/** Share the active palette with automatically generated tab icons. */
	public static function icon_palette(): array {
		$settings = self::settings();
		$scheme = $settings['schemes'][$settings['active']]['colors'] ?? [];
		return ['frontend' => self::color( $scheme['brand_primary'] ?? '' ) ?: self::color( $settings['manual']['primary'] ?? '' ) ?: '#3858e9', 'admin' => self::color( $scheme['menu'] ?? '' ) ?: '#23282d'];
	}

	/** Offer the builder whose editor is installed; request detection remains separate. */
	public static function detected_builder(): string {
		if ( class_exists( 'Bricks\\Database' ) || defined( 'BRICKS_VERSION' ) || function_exists( 'bricks_is_builder' ) ) return 'bricks';
		if ( did_action( 'elementor/loaded' ) ) return 'elementor';
		if ( defined( 'CT_VERSION' ) || class_exists( 'CT_Component' ) ) return 'oxygen';
		return '';
	}

	/**
	 * Add the editor under the WordPress Settings menu.
	 */
	public static function menu(): void {
		add_options_page( __( 'Brand Admin Schemes', 'brand-admin-schemes' ), __( 'Brand Admin Schemes', 'brand-admin-schemes' ), 'manage_options', 'brand-admin-schemes', [__CLASS__, 'page'] );
	}

	/**
	 * Load the editor assets and bootstrap data only on its settings page.
	 * @param string $hook Current admin page hook suffix.
	 */
	public static function assets( $hook ): void {
		if ( $hook !== 'settings_page_brand-admin-schemes' ) {
			return;
		}
		wp_enqueue_style( 'bas-editor', plugins_url( 'assets/editor.css', __FILE__ ), [], self::VERSION );
		wp_enqueue_script( 'bas-documentation', plugins_url( 'assets/documentation.js', __FILE__ ), [], self::VERSION, true );
		wp_enqueue_media();
		wp_enqueue_script( 'bas-environment-colors', plugins_url( 'assets/environment-colors.js', __FILE__ ), [], '0.12.0', true );
		wp_enqueue_script( 'bas-editor', plugins_url( 'assets/editor.js', __FILE__ ), ['bas-environment-colors'], self::VERSION, true );
		$settings = self::settings();
		wp_add_inline_script( 'bas-editor', 'window.BAS_DATA=' . wp_json_encode( ['ajax' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( 'bas_nonce' ), 'settings' => $settings, 'i18n' => self::translations(), 'canUndo' => self::can_undo(), 'environment' => self::environment_status(), 'environmentIconBase' => plugins_url( 'assets/environment-', __FILE__ ), 'loginUrl' => wp_login_url(), 'siteName' => get_bloginfo( 'name' ), 'iconPalette' => self::icon_palette(), 'detectedBuilder' => self::detected_builder(), 'siteTagline' => get_bloginfo( 'description' ), 'siteIcon' => get_site_icon_url( 192, '' ), 'mediaEditBase' => admin_url( 'post.php?action=edit&post=' ), 'themeLogo' => self::login_image_url( (int) get_theme_mod( 'custom_logo' ), 'medium' ), 'safeSvg' => class_exists( 'SafeSvg\\safe_svg' ), 'gradientVariant' => hexdec( substr( md5( home_url() ), 0, 2 ) ) % 8, 'loginMedia' => ['logo' => self::login_image_url( $settings['login_logo_id'], 'medium', $settings['login_svg_confirmed'] ), 'banner' => self::login_image_url( $settings['login_banner_id'], 'large', $settings['login_svg_confirmed'] ), 'background' => self::login_image_url( $settings['login_background_id'], 'full' )]] ) . ';', 'before' );
	}

	/**
	 * Render the editor mount point and a localized loading message.
	 */
	public static function page(): void {
		if ( !current_user_can( 'manage_options' ) ) {
			return;
		}
		echo '<div class="wrap bas-root"><div class="bas-page-heading"><img src="' . esc_url( plugins_url( 'assets-github/icon.svg', __FILE__ ) ) . '" alt="" width="56" height="56"><div><h1>' . esc_html__( 'Brand Admin Schemes', 'brand-admin-schemes' ) . '</h1><p>' . esc_html__( 'Your brand colors, from the admin and login to browser tabs.', 'brand-admin-schemes' ) . '</p></div></div><div id="bas-app"><p>' . esc_html__( 'Loading editor…', 'brand-admin-schemes' ) . '</p></div>';
		if ( is_multisite() ) {
			echo '<p class="description">' . esc_html__( 'Multisite: branding and media belong to this website. Network activation makes the plugin available on every site; it does not copy settings between sites.', 'brand-admin-schemes' ) . '</p>';
		}
		self::footer();
		echo '</div>';
	}

	/** Render the local changelog link and localized Wiki documentation link. */
	private static function footer(): void {
		$wiki_url = 'https://github.com/deckerweb/brand-admin-schemes/wiki/' . ( \Deckerweb\BrandAdminSchemes\Changelog::is_german() ? 'Deutsch' : 'English' );
		echo '<footer class="bas-footer" aria-label="' . esc_attr__( 'Plugin information', 'brand-admin-schemes' ) . '"><div><strong>' . esc_html__( 'Brand Admin Schemes', 'brand-admin-schemes' ) . '</strong> <span>' . esc_html__( 'Version', 'brand-admin-schemes' ) . ' ' . esc_html( self::VERSION ) . '</span> · <a href="' . esc_url( \Deckerweb\BrandAdminSchemes\Changelog::url() ) . '" data-bas-document="changelog">' . esc_html__( 'Changelog', 'brand-admin-schemes' ) . '</a> · <a href="' . esc_url( $wiki_url ) . '">' . esc_html__( 'Documentation', 'brand-admin-schemes' ) . '</a><p>' . esc_html__( 'Your colors. Your WordPress.', 'brand-admin-schemes' ) . '</p></div><div><span>© 2022–2026 <a href="https://github.com/deckerweb" target="_blank" rel="noopener noreferrer">David Decker – DECKERWEB</a></span><a href="https://github.com/deckerweb/brand-admin-schemes" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Plugin website', 'brand-admin-schemes' ) . '</a></div></footer>';
		\Deckerweb\BrandAdminSchemes\Changelog::dialog();
	}

	/**
	 * Sanitize imported or submitted editor state before using it.
	 * @param mixed $raw Untrusted decoded JSON payload.
	 * @return array<string,mixed> Safe settings with bounded scheme count.
	 */
	private static function validate( $raw ): array {
		$d = self::defaults();
		if ( !is_array( $raw ) ) {
			return $d;
		}
		foreach ( $d as $key => $default ) {
			if ( isset( $raw[$key] ) && ( is_array( $default ) ? ! is_array( $raw[$key] ) : ! is_scalar( $raw[$key] ) ) ) {
				return $d;
			}
		}
		$d['source'] = in_array( $raw['source'] ?? '', ['manual', 'bricks', 'core', 'acss'], true ) ? $raw['source'] : 'manual';
		$d['palette'] = sanitize_text_field( (string)( $raw['palette'] ?? '' ) );
		if ( isset( $raw['manual'] ) ) {
			foreach ( $raw['manual'] as $value ) {
				if ( ! is_scalar( $value ) && null !== $value ) { return $d; }
			}
		}
		foreach ( $d['manual'] as $key => $value ) {
			$d['manual'][$key] = self::color( $raw['manual'][$key] ?? '' ) ?: $value;
		}
		if ( isset( $raw['mapping'] ) ) {
			foreach ( $raw['mapping'] as $value ) {
				if ( ! is_scalar( $value ) && null !== $value ) { return $d; }
			}
		}
		foreach ( $d['mapping'] as $key => $value ) {
			$d['mapping'][$key] = sanitize_text_field( (string)( $raw['mapping'][$key] ?? '' ) );
		}
		$d['mood'] = in_array( $raw['mood'] ?? '', ['balanced', 'calm', 'bold', 'dark'], true ) ? $raw['mood'] : 'balanced';
		$d['strength'] = max( 0, min( 100, (int)( $raw['strength'] ?? 50 ) ) );
		$d['name'] = sanitize_text_field( (string)( $raw['name'] ?? '' ) );
		$d['name'] = substr( $d['name'], 0, 80 );
		$d['active'] = sanitize_key( (string)( $raw['active'] ?? '' ) );
		$d['default_mode'] = in_array( $raw['default_mode'] ?? '', ['off', 'default', 'force'], true ) ? $raw['default_mode'] : 'off';
		$d['frontend_bar'] = !empty( $raw['frontend_bar'] );
		$d['bar_color'] = in_array( $raw['bar_color'] ?? '', ['primary', 'secondary', 'tertiary', 'accent'], true ) ? $raw['bar_color'] : 'primary';
		$d['environment_mode'] = in_array( $raw['environment_mode'] ?? '', ['auto', 'local', 'development', 'staging', 'production'], true ) ? $raw['environment_mode'] : 'auto';
		if ( isset( $raw['environment_colors'] ) ) {
			foreach ( $raw['environment_colors'] as $value ) {
				if ( ! is_scalar( $value ) && null !== $value ) { return $d; }
			}
		}
		foreach ( $d['environment_colors'] as $type => $value ) {
			$d['environment_colors'][$type] = self::color( $raw['environment_colors'][$type] ?? '' );
		}
		$d['icons'] = self::sanitize_icons( $raw['icons'] ?? [] );
		$d['gutenberg_palette'] = !empty( $raw['gutenberg_palette'] );
		$d['login_enabled'] = !empty( $raw['login_enabled'] );
		$d['login_layout'] = in_array( $raw['login_layout'] ?? '', ['left', 'right', 'center'], true ) ? $raw['login_layout'] : 'left';
		$d['login_alignment'] = 'center' === ( $raw['login_alignment'] ?? '' ) ? 'center' : 'left';
		$d['login_svg_confirmed'] = !empty( $raw['login_svg_confirmed'] );
		$d['login_brand_mode'] = 'banner' === ( $raw['login_brand_mode'] ?? '' ) ? 'banner' : 'logo';
		$d['login_quote'] = substr( sanitize_text_field( (string) ( $raw['login_quote'] ?? '' ) ), 0, 160 );
		$d['login_quote_author'] = substr( sanitize_text_field( (string) ( $raw['login_quote_author'] ?? '' ) ), 0, 60 );
		foreach ( ['logo', 'banner', 'background'] as $image ) {
			$id = absint( $raw['login_' . $image . '_id'] ?? 0 );
			$svg_logo = in_array( $image, ['logo', 'banner'], true ) && $d['login_svg_confirmed'] && class_exists( 'SafeSvg\\safe_svg' ) && 'image/svg+xml' === get_post_mime_type( $id );
			$d['login_' . $image . '_id'] = $id && ( 'image/svg+xml' === get_post_mime_type( $id ) ? $svg_logo : wp_attachment_is_image( $id ) ) ? $id : 0;
		}
		$d['login_position_x'] = max( 0, min( 100, (int)( $raw['login_position_x'] ?? 50 ) ) );
		$d['login_position_y'] = max( 0, min( 100, (int)( $raw['login_position_y'] ?? 50 ) ) );
		$d['login_overlay'] = max( 0, min( 80, (int)( $raw['login_overlay'] ?? 35 ) ) );
		$d['login_heading'] = substr( sanitize_text_field( (string)( $raw['login_heading'] ?? '' ) ), 0, 100 );
		$d['login_message'] = substr( sanitize_text_field( (string)( $raw['login_message'] ?? '' ) ), 0, 240 );
		$d['login_show_title'] = !empty( $raw['login_show_title'] );
		$d['login_show_tagline'] = !empty( $raw['login_show_tagline'] );
		$d['login_gradient'] = in_array( $raw['login_gradient'] ?? '', ['diagonal', 'aurora', 'radial', 'dusk', 'mist', 'bloom', 'horizon', 'satin', 'surprise'], true ) ? $raw['login_gradient'] : 'diagonal';
		$d['login_color_mode'] = 'custom' === ( $raw['login_color_mode'] ?? '' ) ? 'custom' : 'scheme';
		if ( isset( $raw['login_colors'] ) ) {
			foreach ( $raw['login_colors'] as $value ) {
				if ( ! is_scalar( $value ) && null !== $value ) { return $d; }
			}
		}
		foreach ( $d['login_colors'] as $key => $value ) {
			$d['login_colors'][$key] = self::color( $raw['login_colors'][$key] ?? '' );
		}
		// Limit imported collections and revalidate every saved color before persisting.
		$d['schemes'] = [];
		if ( isset( $raw['schemes'] ) && is_array( $raw['schemes'] ) ) {
			foreach ( array_slice( $raw['schemes'], 0, 30, true ) as $id => $item ) {
				$id = sanitize_key( (string) $id );
				if ( !preg_match( '/^bas-[a-z0-9_-]{1,40}$/', $id ) || !is_array( $item ) ) {
					continue;
				}
				$colors = isset( $item['colors'] ) && is_array( $item['colors'] ) ? $item['colors'] : $item;
				$entry = [];
				foreach ( ['menu', 'submenu', 'bar', 'highlight', 'button', 'link', 'text', 'brand_primary', 'brand_secondary', 'brand_tertiary', 'brand_accent', 'toolbar_primary', 'toolbar_secondary', 'toolbar_tertiary', 'toolbar_accent'] as $key ) {
					$entry[$key] = self::color( $colors[$key] ?? '' );
				}
				if ( self::valid_scheme( $entry ) ) {
					$d['schemes'][$id] = ['name' => substr( sanitize_text_field( is_scalar( $item['name'] ?? $id ) ? (string) ( $item['name'] ?? $id ) : $id ), 0, 80 ), 'colors' => $entry];
				}
			}
		}
		$scheme = $raw['scheme'] ?? [];
		if ( is_array( $scheme ) ) {
			foreach ( ['menu', 'submenu', 'bar', 'highlight', 'button', 'link', 'text', 'brand_primary', 'brand_secondary', 'brand_tertiary', 'brand_accent', 'toolbar_primary', 'toolbar_secondary', 'toolbar_tertiary', 'toolbar_accent'] as $key ) {
				$d['scheme'][$key] = self::color( $scheme[$key] ?? '' );
			}
		}
		return $d;
	}

	/**
	 * Save a generated scheme and assign it to the current administrator.
	 * Stores a snapshot for one-step undo; the editor sends the final color values.
	 */
	public static function save(): void {
		check_ajax_referer( 'bas_nonce' );
		if ( !current_user_can( 'manage_options' ) ) {
			wp_send_json_error( __( 'Forbidden', 'brand-admin-schemes' ), 403 );
		}
		$payload = $_POST['settings'] ?? '';
		$raw = is_string( $payload ) && strlen( $payload ) <= 300000 ? json_decode( wp_unslash( $payload ), true ) : null;
		$o = self::validate( $raw );
		if ( !self::valid_scheme( $o['scheme'] ) ) {
			wp_send_json_error( __( 'Invalid scheme colors', 'brand-admin-schemes' ), 400 );
		}
		$id = $o['active'];
		if ( !preg_match( '/^bas-[a-z0-9_-]{1,40}$/', $id ) ) {
			$id = 'bas-' . substr( md5( wp_generate_uuid4() ), 0, 12 );
		}
		if ( ! isset( $o['schemes'][$id] ) && count( $o['schemes'] ) >= 30 ) {
			wp_send_json_error( __( 'You can save up to 30 schemes. Reuse an existing scheme before adding another.', 'brand-admin-schemes' ), 400 );
		}
		$o['name'] = $o['name'] ?: __( 'CI · ', 'brand-admin-schemes' ) . ucfirst( $o['mood'] );
		$o['active'] = $id;
		$o['schemes'][$id] = ['name' => $o['name'], 'colors' => $o['scheme']];
		$previous = get_option( self::OPTION, null );
		$previous_color = get_user_meta( get_current_user_id(), \Deckerweb\BrandAdminSchemes\Multisite::color_key(), true );
		update_option( self::OPTION, $o, false );
		\Deckerweb\BrandAdminSchemes\Multisite::set_color( get_current_user_id(), $id );
		update_option( self::UNDO, ['color_key' => \Deckerweb\BrandAdminSchemes\Multisite::color_key(), 'user' => get_current_user_id(), 'before' => $previous, 'before_color' => $previous_color, 'after_color' => $id, 'after_hash' => md5( wp_json_encode( $o ) )], false );
		do_action( 'bas_site_settings_changed', get_current_blog_id(), 'save' );
		wp_send_json_success( ['settings' => $o, 'canUndo' => true] );
	}

	/**
	 * Allow undo only for the same user while the saved state is unchanged.
	 * @return bool
	 */
	private static function can_undo(): bool {
		$undo = get_option( self::UNDO, [] );
		return is_array( $undo ) && ( ( $undo['color_key'] ?? '' ) === \Deckerweb\BrandAdminSchemes\Multisite::color_key() || ( ! is_multisite() && ! isset( $undo['color_key'] ) ) ) && ( $undo['user'] ?? 0 ) === get_current_user_id() && ( ! isset( $undo['after_color'] ) || get_user_meta( get_current_user_id(), \Deckerweb\BrandAdminSchemes\Multisite::color_key(), true ) === $undo['after_color'] ) && isset( $undo['after_hash'] ) && md5( wp_json_encode( get_option( self::OPTION, [] ) ) ) === $undo['after_hash'];
	}

	/**
	 * Restore the settings and user color option from the last valid snapshot.
	 */
	public static function undo(): void {
		check_ajax_referer( 'bas_nonce' );
		if ( !current_user_can( 'manage_options' ) ) {
			wp_send_json_error( __( 'Forbidden', 'brand-admin-schemes' ), 403 );
		}
		if ( !self::can_undo() ) {
			wp_send_json_error( __( 'Undo is no longer available because settings changed.', 'brand-admin-schemes' ), 409 );
		}
		$undo = get_option( self::UNDO );
		if ( $undo['before'] === null ) {
			delete_option( self::OPTION );
		}
		else update_option( self::OPTION, $undo['before'], false );
		if ( $undo['before_color'] === '' ) {
			delete_user_meta( get_current_user_id(), \Deckerweb\BrandAdminSchemes\Multisite::color_key() );
		}
		else \Deckerweb\BrandAdminSchemes\Multisite::set_color( get_current_user_id(), $undo['before_color'] );
		delete_option( self::UNDO );
		do_action( 'bas_site_settings_changed', get_current_blog_id(), 'undo' );
		wp_send_json_success( ['settings' => self::settings(), 'canUndo' => false] );
	}

	/**
	 * Validate a bas/v1 JSON import and return it for preview without saving.
	 */
	public static function import(): void {
		check_ajax_referer( 'bas_nonce' );
		if ( !current_user_can( 'manage_options' ) ) {
			wp_send_json_error( __( 'Forbidden', 'brand-admin-schemes' ), 403 );
		}
		$payload = $_POST['settings'] ?? '';
		$raw = is_string( $payload ) && strlen( $payload ) <= 300000 ? json_decode( wp_unslash( $payload ), true ) : null;
		if ( !is_array( $raw ) || ( $raw['format'] ?? '' ) !== 'bas/v1' ) {
			wp_send_json_error( __( 'Unknown file format', 'brand-admin-schemes' ), 400 );
		}
		$o = self::validate( $raw['settings'] ?? null );
		if ( !self::valid_scheme( $o['scheme'] ) ) {
			wp_send_json_error( __( 'Invalid scheme colors', 'brand-admin-schemes' ), 400 );
		}
		$o['active'] = '';
		wp_send_json_success( ['settings' => $o] );
	}

	/**
	 * Check the required colors of a generated WordPress admin scheme.
	 * @param mixed $s Candidate scheme.
	 * @return bool
	 */
	private static function valid_scheme( $s ): bool {
		if ( !is_array( $s ) ) {
			return false;
		}
		foreach ( ['menu', 'submenu', 'bar', 'highlight', 'button', 'link', 'text'] as $key ) {
			if ( empty( $s[$key] ) ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Build CSS for a saved scheme after strict hex validation at save time.
	 * @param array<string,string> $s Validated scheme colors.
	 * @return string Admin CSS rules.
	 */
	private static function css( array $s ): string {
		$menu = $s['menu'];
		$sub = $s['submenu'];
		$bar = $s['bar'];
		$hi = $s['highlight'];
		$button = $s['button'];
		$link = $s['link'];
		$txt = $s['text'];
		return "#adminmenu,#adminmenuback,#adminmenuwrap{background:$menu}#adminmenu .wp-submenu{background:$sub}#adminmenu a,.wp-menu-name,#adminmenu div.wp-menu-image:before{color:$txt}#adminmenu .wp-submenu a{color:$txt}#adminmenu li.current a.menu-top,#adminmenu li.wp-has-current-submenu a.wp-has-current-submenu,#adminmenu li.menu-top:hover,#adminmenu li.opensub>a.menu-top{background:$hi;color:$txt}#adminmenu li.menu-top:hover .wp-menu-image:before,#adminmenu li.current .wp-menu-image:before{color:$txt}#wpadminbar{background:$bar}#wpadminbar .ab-item,#wpadminbar .ab-icon:before{color:$txt!important}#wpadminbar .menupop .ab-sub-wrapper{background:$sub}.wp-core-ui .button-primary{background:$button;border-color:$button;color:#fff}.wp-core-ui .button-primary:hover,.wp-core-ui .button-primary:focus{filter:brightness(.85);background:$button;border-color:$button;color:#fff}a,.wp-core-ui .button-link{color:$link}a:hover,.wp-core-ui .button-link:hover{color:$hi}:focus-visible{outline-color:$hi}";
	}

	/**
	 * Apply the site default or forced scheme through WordPress user options.
	 * @param mixed $result Existing user option value.
	 * @param string $option Requested user option name.
	 * @param mixed $user User object supplied by WordPress.
	 * @return mixed Existing value or active scheme ID.
	 */
	public static function admin_color_option( $result, $option, $user ) {
		$o = self::settings();
		// Core's reader prefers site metadata even in network admin; keep its
		// network profile display consistent with the global picker save.
		if ( is_multisite() && is_network_admin() ) {
			$user_id = is_object( $user ) ? (int) $user->ID : get_current_user_id();
			$global = get_user_meta( $user_id, 'admin_color', true );
			return is_string( $global ) && $global !== '' && ( ! str_starts_with( $global, 'bas-' ) || isset( $o['schemes'][$global] ) ) ? $global : 'fresh';
		}
		// A legacy global BAS selection may belong to another site in the network.
		if ( is_multisite() && is_string( $result ) && str_starts_with( $result, 'bas-' ) && ! isset( $o['schemes'][$result] ) ) {
			$result = 'modern';
		}
		if ( !$o['schemes'] || $o['default_mode'] === 'off' || !isset( $o['schemes'][$o['active']] ) ) {
			return $result;
		}
		if ( $o['default_mode'] === 'force' || !$result || $result === 'modern' ) {
			return $o['active'];
		}
		return $result;
	}

	/**
	 * Hide the profile color picker only when the scheme is forced.
	 */
	public static function hide_picker(): void {
		if ( ! is_network_admin() && self::settings()['default_mode'] === 'force' ) {
			remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
		}
	}

	/** Loads the compact badge styling in the backend and visible frontend toolbar. */
	public static function environment_style(): void {
		if ( is_admin_bar_showing() ) {
			wp_enqueue_style( 'bas-environment', plugins_url( 'assets/environment.css', __FILE__ ), ['admin-bar'], '0.12.0' );
			wp_enqueue_script( 'bas-environment-colors', plugins_url( 'assets/environment-colors.js', __FILE__ ), [], '0.12.0', true );
			wp_enqueue_script( 'bas-environment', plugins_url( 'assets/environment.js', __FILE__ ), ['bas-environment-colors'], '0.12.0', true );
			wp_add_inline_script( 'bas-environment', 'window.BAS_ENV_DATA=' . wp_json_encode( ['type' => self::environment_status()['type'], 'colors' => self::settings()['environment_colors']] ) . ';', 'before' );
		}
	}

	/**
	 * Adds a compact, accessible environment indicator to both admin bars.
	 *
	 * @param WP_Admin_Bar $admin_bar WordPress toolbar instance.
	 */
	public static function environment_badge( $admin_bar ): void {
		$status = self::environment_status();
		$type = $status['type'];
		$labels = self::environment_labels();
		$short = ['local' => 'LOC', 'development' => 'DEV', 'staging' => 'STG', 'production' => 'LIVE'];
		$source_labels = [
			'manual'    => __( 'Manual selection', 'brand-admin-schemes' ),
			'wordpress' => __( 'WordPress setting', 'brand-admin-schemes' ),
			'url'       => __( 'Site address hint', 'brand-admin-schemes' ),
			'default'   => __( 'WordPress default', 'brand-admin-schemes' ),
		];
		/* translators: %s: Local, Development, Staging or Live. */
		$label = sprintf( __( 'Installation environment: %s', 'brand-admin-schemes' ), $labels[$type] );
		$icon = plugins_url( 'assets/environment-' . $type . '.svg', __FILE__ );
		$title = '<span class="bas-env-pill"><img src="' . esc_url( $icon ) . '" alt="" width="16" height="16" aria-hidden="true"><span aria-hidden="true">' . esc_html( $short[$type] ) . '</span><span class="screen-reader-text">' . esc_html( $label ) . '</span></span>';
		$admin_bar->add_node( [
			'id'     => 'bas-environment',
			'parent' => 'top-secondary',
			'title'  => $title,
			'href'   => current_user_can( 'manage_options' ) ? admin_url( 'options-general.php?page=brand-admin-schemes' ) : false,
			'meta'   => ['title' => $label . ' — ' . $source_labels[$status['source']], 'class' => 'bas-env-' . $type],
		] );
		// Runtime details are visible only to users who can administer the site.
		if ( current_user_can( 'manage_options' ) ) {
			$admin_bar->add_node( [
				'id'     => 'bas-environment-php',
				'parent' => 'bas-environment',
				'title'  => esc_html__( 'PHP version', 'brand-admin-schemes' ) . ': ' . esc_html( PHP_VERSION ),
			] );
			$admin_bar->add_node( [
				'id'     => 'bas-environment-debug',
				'parent' => 'bas-environment',
				'title'  => 'WP_DEBUG: ' . esc_html( defined( 'WP_DEBUG' ) && WP_DEBUG ? __( 'Enabled', 'brand-admin-schemes' ) : __( 'Disabled', 'brand-admin-schemes' ) ),
			] );
		}
	}

	/**
	 * Color the visible frontend toolbar for users on a saved Brand Admin scheme.
	 */
	public static function frontend_bar(): void {
		$o = self::settings();
		if ( !$o['frontend_bar'] || !is_user_logged_in() || !is_admin_bar_showing() ) {
			return;
		}
		$id = get_user_option( 'admin_color' );
		if ( !isset( $o['schemes'][$id] ) ) {
			return;
		}
		$s = $o['schemes'][$id]['colors'];
		// New schemes keep a mood-adjusted toolbar tone for every brand role.
		// Older saved schemes retain their original role color until re-saved.
		$c = $s['toolbar_' . $o['bar_color']] ?? '';
		if ( !$c ) {
			$c = $s['brand_' . $o['bar_color']] ?? '';
		}
		if ( !$c ) {
			$c = $s['bar'];
		}
		// Compute relative luminance in linear sRGB for readable toolbar text.
		$rgb = sscanf( substr( $c, 1 ), '%02x%02x%02x' );
		$linear = array_map( static function( $v ) {
			$v /= 255;
			return $v <= 0.04045 ? $v / 12.92 : pow( ( $v + 0.055 ) / 1.055, 2.4 );
		}, $rgb );
		$lum = 0.2126 * $linear[0] + 0.7152 * $linear[1] + 0.0722 * $linear[2];
		$text = ( 1.05 / ( $lum + 0.05 ) >= 4.5 ) ? '#ffffff' : '#17202b';
		$css = '#wpadminbar{background:' . $c . '}#wpadminbar .ab-item,#wpadminbar .ab-icon:before,#wpadminbar .ab-label{color:' . $text . '}#wpadminbar .menupop .ab-sub-wrapper{background:' . $s['submenu'] . '}#wpadminbar .menupop .ab-sub-wrapper .ab-item{color:' . $s['text'] . '}';
		wp_add_inline_style( 'admin-bar', $css );
	}

	/** Resolve an image attachment without accepting an arbitrary external URL. */
	private static function login_image_url( $id, string $size, bool $allow_svg = false ): string {
		$svg = $id && 'image/svg+xml' === get_post_mime_type( (int) $id );
		if ( !$id || ( $svg ? !( $allow_svg && class_exists( 'SafeSvg\\safe_svg' ) ) : !wp_attachment_is_image( (int) $id ) ) ) {
			return '';
		}
		if ( $svg ) {
			return (string) wp_get_attachment_url( (int) $id );
		}
		return (string) wp_get_attachment_image_url( (int) $id, $size );
	}

	/** Blend validated hex colors for a subtle brand-tinted page background. */
	private static function login_mix( string $from, string $to, float $amount ): string {
		$a = sscanf( substr( $from, 1 ), '%02x%02x%02x' );
		$b = sscanf( substr( $to, 1 ), '%02x%02x%02x' );
		return sprintf( '#%02x%02x%02x', (int) round( $a[0] * ( 1 - $amount ) + $b[0] * $amount ), (int) round( $a[1] * ( 1 - $amount ) + $b[1] * $amount ), (int) round( $a[2] * ( 1 - $amount ) + $b[2] * $amount ) );
	}

	/** Build calm layered gradients with palette-derived intermediate colors. */
	private static function login_gradient( array $palette, string $style ): string {
		$styles = ['diagonal', 'aurora', 'radial', 'dusk', 'mist', 'bloom', 'horizon', 'satin'];
		if ( 'surprise' === $style ) {
			$style = $styles[hexdec( substr( md5( home_url() ), 0, 2 ) ) % count( $styles )];
		}
		$base = self::login_mix( $palette['brand'], $palette['deep'], .58 );
		$soft = self::login_mix( $palette['brand'], '#ffffff', .36 );
		$glow = self::login_mix( $palette['accent'], $palette['brand'], .72 );
		$night = self::login_mix( $palette['deep'], '#101827', .28 );
		$muted = self::login_mix( $palette['brand'], $palette['deep'], .25 );
		switch ( $style ) {
			case 'aurora': return "radial-gradient(ellipse at 24% 18%,{$soft},transparent 63%),radial-gradient(ellipse at 85% 82%,{$glow},transparent 62%),{$base}";
			case 'radial': return "radial-gradient(circle at 42% 34%,{$soft} 0%,{$muted} 46%,{$base} 100%)";
			case 'dusk': return "linear-gradient(160deg,{$muted} 0%,{$base} 52%,{$night} 100%)";
			case 'mist': return "radial-gradient(ellipse at 75% 22%,{$soft},transparent 70%),linear-gradient(125deg,{$base},{$muted})";
			case 'bloom': return "radial-gradient(ellipse at 70% 62%,{$glow},transparent 65%),linear-gradient(145deg,{$muted},{$base})";
			case 'horizon': return "linear-gradient(180deg,{$muted} 0%,{$base} 63%,{$night} 100%)";
			case 'satin': return "linear-gradient(115deg,{$base} 0%,{$muted} 42%,{$soft} 100%)";
			default: return "linear-gradient(135deg,{$muted} 0%,{$base} 55%,{$night} 100%)";
		}
	}

	/** Return the active site scheme used as the starting point for login colors. */
	private static function login_palette( array $settings ): array {
		$scheme = $settings['schemes'][$settings['active']]['colors'] ?? [];
		$brand = self::color( $scheme['brand_primary'] ?? '' ) ?: '#3858e9';
		$background = self::color( $scheme['menu'] ?? '' ) ?: '#1d2327';
		$accent = self::color( $scheme['brand_accent'] ?? '' ) ?: ( self::color( $scheme['highlight'] ?? '' ) ?: '#d54e21' );
		$button = $accent;
		if ( 'custom' === $settings['login_color_mode'] ) {
			$brand = $settings['login_colors']['background'] ?: $brand;
			$button = $settings['login_colors']['button'] ?: $button;
		}
		$surface = 'custom' === $settings['login_color_mode'] && $settings['login_colors']['surface'] ? $settings['login_colors']['surface'] : '#ffffff';
		$page = 'custom' === $settings['login_color_mode'] && $settings['login_colors']['page'] ? $settings['login_colors']['page'] : self::login_mix( $brand, '#ffffff', .94 );
		return ['brand' => $brand, 'deep' => $background, 'accent' => $accent, 'button' => $button, 'surface' => $surface, 'page' => $page, 'page_text' => self::login_text_color( $page ), 'button_text' => self::login_text_color( $button ), 'surface_text' => self::login_text_color( $surface )];
	}

	/** Choose readable light or dark text for an administrator-selected color. */
	private static function login_text_color( string $hex ): string {
		$channels = sscanf( substr( $hex, 1 ), '%02x%02x%02x' );
		$linear = array_map( static function( $value ) {
			$value /= 255;
			return $value <= .04045 ? $value / 12.92 : pow( ( $value + .055 ) / 1.055, 2.4 );
		}, $channels );
		$luminance = .2126 * $linear[0] + .7152 * $linear[1] + .0722 * $linear[2];
		return ( 1.05 / ( $luminance + .05 ) >= 4.5 ) ? '#ffffff' : '#17202b';
	}

	/** Load login styling while keeping the core login and recovery forms intact. */
	public static function login_assets(): void {
		$settings = self::settings();
		if ( !$settings['login_enabled'] ) {
			return;
		}
		$palette = self::login_palette( $settings );
		$logo = $settings['login_logo_id'] ? self::login_image_url( $settings['login_logo_id'], 'medium', $settings['login_svg_confirmed'] ) : '';
		$logo = $logo ?: ( get_site_icon_url( 192, '' ) ?: self::login_image_url( (int) get_theme_mod( 'custom_logo' ), 'medium' ) );
		$banner = 'banner' === $settings['login_brand_mode'] ? self::login_image_url( $settings['login_banner_id'], 'large', $settings['login_svg_confirmed'] ) : '';
		if ( $banner ) {
			$logo = $banner;
		}
		$image = self::login_image_url( $settings['login_background_id'], 'full' );
		$rgb = sscanf( substr( $palette['deep'], 1 ), '%02x%02x%02x' );
		$opacity = $settings['login_overlay'] / 100;
		$overlay = 'rgba(' . implode( ',', $rgb ) . ',' . $opacity . ')';
		$background = $image ? 'linear-gradient(135deg,' . $overlay . ',transparent),url(' . wp_json_encode( esc_url_raw( $image ) ) . ')' : self::login_gradient( $palette, $settings['login_gradient'] );
		$css = 'html{background:' . $palette['page'] . '!important}body.login.bas-login{--bas-login-brand:' . $palette['brand'] . ';--bas-login-deep:' . $palette['deep'] . ';--bas-login-button:' . $palette['button'] . ';--bas-login-button-text:' . $palette['button_text'] . ';--bas-login-surface:' . $palette['surface'] . ';--bas-login-surface-text:' . $palette['surface_text'] . ';--bas-login-page:' . $palette['page'] . ';--bas-login-page-text:' . $palette['page_text'] . ';--bas-login-image:' . $background . ';--bas-login-x:' . $settings['login_position_x'] . '%;--bas-login-y:' . $settings['login_position_y'] . '%}';
		if ( $logo ) {
			$css .= 'body.login.bas-login #login h1 a{background-image:url(' . wp_json_encode( esc_url_raw( $logo ) ) . ')!important;font-size:0!important;min-height:68px}';
			if ( !$banner && !$settings['login_logo_id'] && get_site_icon_url( 192, '' ) ) {
				$css .= 'body.login.bas-login #login h1 a{width:72px;height:72px}';
			}
		}
		if ( $banner ) {
			$metadata = wp_get_attachment_metadata( $settings['login_banner_id'] );
			$ratio = is_array( $metadata ) && !empty( $metadata['width'] ) && !empty( $metadata['height'] ) ? max( 2, min( 6, (float) $metadata['width'] / (float) $metadata['height'] ) ) : 4;
			$css .= 'body.login.bas-login.bas-login-banner #login h1 a{--bas-banner-ratio:' . (float) $ratio . '}';
		}
		$css .= 'body.login.bas-login.bas-login-right .bas-login-visual{grid-column:2;grid-row:1}body.login.bas-login.bas-login-right #login{grid-column:1;grid-row:1}';
		$css .= 'body.login.bas-login.bas-login-center .bas-login-visual{display:none}body.login.bas-login.bas-login-center #login{grid-column:1/-1;grid-row:1;max-width:480px;margin:auto}';
		wp_enqueue_style( 'bas-login', plugins_url( 'assets/login.css', __FILE__ ), [], self::VERSION );
		wp_add_inline_style( 'bas-login', $css );
		add_filter( 'login_body_class', static function( $classes ) use ( $settings ) {
			$classes[] = 'bas-login';
			$classes[] = 'bas-login-' . $settings['login_layout'];
			$classes[] = 'bas-login-align-' . $settings['login_alignment'];
			if ( 'banner' === $settings['login_brand_mode'] && self::login_image_url( $settings['login_banner_id'], 'large', $settings['login_svg_confirmed'] ) ) {
				$classes[] = 'bas-login-banner';
			}
			$classes[] = 'bas-login-' . ( self::login_image_url( $settings['login_background_id'], 'full' ) ? 'photo' : 'gradient' );
			return $classes;
		} );
	}

	/** Add the decorative visual panel beside the existing WordPress form. */
	public static function login_visual(): void {
		if ( self::settings()['login_enabled'] ) {
			echo '<div class="bas-login-visual"><span class="bas-login-visual-mark" aria-hidden="true"></span>';
			$settings = self::settings();
			if ( $settings['login_quote'] ) {
				echo '<figure class="bas-login-quote"><blockquote>' . esc_html( $settings['login_quote'] ) . '</blockquote>';
				if ( $settings['login_quote_author'] ) {
					echo '<figcaption>' . esc_html( $settings['login_quote_author'] ) . '</figcaption>';
				}
				echo '</figure>';
			}
			echo '</div>';
		}
	}

	/** Add optional customer greeting above the original login form. */
	public static function login_welcome( $message ): string {
		$settings = self::settings();
		if ( !$settings['login_enabled'] ) {
			return $message;
		}
		$welcome = '<div class="bas-login-welcome">';
		if ( $settings['login_show_title'] ) {
			$title = $settings['login_heading'] ?: ( get_bloginfo( 'name' ) ?: __( 'Welcome back', 'brand-admin-schemes' ) );
			$welcome .= '<h2>' . esc_html( self::group_login_title_suffix( $title ) ) . '</h2>';
		}
		$tagline = $settings['login_message'] ?: get_bloginfo( 'description' );
		if ( $settings['login_show_tagline'] && $tagline ) {
			$welcome .= '<p>' . esc_html( $tagline ) . '</p>';
		}
		return ( $settings['login_show_title'] || ( $settings['login_show_tagline'] && $tagline ) ? $welcome . '</div>' : '' ) . $message;
	}

	/** Keep a short organization suffix with its preceding word when wrapping. */
	private static function group_login_title_suffix( string $title ): string {
		$grouped = preg_replace( '/\s+(e\.\s?V\.|eG|GmbH|UG|Ltd\.|Inc\.)$/iu', "\xC2\xA0" . '$1', $title );
		return $grouped ?? $title;
	}

	/** Link a customer logo to the site, with its name as accessible text. */
	public static function login_logo_url( $url ): string {
		return self::settings()['login_enabled'] ? home_url( '/' ) : $url;
	}

	/** Return the site name for the login logo link. */
	public static function login_logo_text( $text ): string {
		return self::settings()['login_enabled'] ? get_bloginfo( 'name' ) : $text;
	}

	/**
	 * Register saved schemes with WordPress and print their active admin CSS.
	 */
	public static function register_scheme(): void {
		$o = self::settings();
		if ( !$o['schemes'] ) {
			return;
		}
		foreach ( $o['schemes'] as $id => $item ) {
			$colors = $item['colors'];
			wp_admin_css_color( $id, $item['name'], plugins_url( 'assets/scheme.css', __FILE__ ), array_slice( array_values( $colors ), 0, 4 ) );
		}
		// wp_admin_css_color registers the picker entry; saved colors are injected per user.
		add_action( 'admin_head', static function() use( $o ) {
			$id = get_user_option( 'admin_color' );
			if ( !isset( $o['schemes'][$id] ) ) {
				return;
			}
			echo '<style id="bas-active-scheme">' . self::css( $o['schemes'][$id]['colors'] ) . '</style>';
		}, 100 );
	}
}
require_once __DIR__ . '/includes/class-bas-multisite.php';
\Deckerweb\BrandAdminSchemes\Multisite::register();
require_once __DIR__ . '/includes/class-bas-context-icons.php';
require_once __DIR__ . '/includes/class-bas-bundle.php';
require_once __DIR__ . '/includes/class-bas-gutenberg-palette.php';
require_once __DIR__ . '/includes/class-bas-changelog.php';
require_once __DIR__ . '/includes/class-bas-github-updates.php';
require_once __DIR__ . '/includes/class-bas-site-health.php';
require_once __DIR__ . '/includes/class-bas-icon-library.php';
BAS_Plugin::boot();
( new \Deckerweb\BrandAdminSchemes\IconLibrary() )->register();
( new \Deckerweb\BrandAdminSchemes\SiteHealth() )->register();
( new \Deckerweb\BrandAdminSchemes\GitHubUpdates() )->register();

// Shared embedded catalog; elect one runtime after all active plugins have loaded.
require_once __DIR__ . '/includes/deckerweb-plugin-library/bootstrap.php';
deckerweb_library_register_v2( __FILE__, [], __DIR__ . '/includes/deckerweb-plugin-library' );
