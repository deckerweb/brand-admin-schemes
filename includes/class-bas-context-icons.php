<?php
/** Context-aware SVG favicons for the frontend, WordPress admin and builders. */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

final class BAS_Context_Icons {
	/** Attach icon output after WordPress writes its standard Site Icon. */
	public static function boot(): void {
		add_filter( 'site_icon_meta_tags', [__CLASS__, 'filter_site_icon'], 100 );
		add_action( 'wp_head', [__CLASS__, 'render'], 101 );
		add_action( 'admin_head', [__CLASS__, 'render'], 101 );
		add_action( 'login_head', [__CLASS__, 'render'], 101 );
	}

	/** Keep WordPress's Site Icon when the feature or context is not configured. */
	public static function filter_site_icon( array $tags ): array {
		return self::current_icon() ? array_values( array_filter( $tags, static fn( $tag ) => false === stripos( $tag, 'rel="icon"' ) ) ) : $tags;
	}

	/** Generate a constrained SVG data URI, with no user-supplied markup or files. */
	public static function uri( array $design, string $context = 'frontend', string $builder = '', string $environment = '' ): string {
		$colors = self::colors( $context, $builder );
		$background = self::hex( $design['background'] ?? '' ) ?: $colors[0];
		$foreground = self::hex( $design['foreground'] ?? '' ) ?: self::contrast( $background );
		$symbol = $design['symbol'] ?? 'auto';
		if ( 'auto' === $symbol ) {
			$symbol = 'builder' === $context && $builder ? $builder : 'text';
		}
		$label = self::label( $design['label'] ?? '' );
		$art = match ( $symbol ) {
			'circle' => '<circle cx="32" cy="32" r="16" fill="none" stroke="' . $foreground . '" stroke-width="5"/>',
			'spark' => '<path d="M32 9 38 26 55 32 38 38 32 55 26 38 9 32 26 26Z" fill="none" stroke="' . $foreground . '" stroke-width="4" stroke-linejoin="round"/>',
			'leaf' => '<path d="M48 14C23 14 13 25 16 39c2 10 17 13 26 4 8-8 7-19 6-29ZM19 45c6-8 13-14 24-20" fill="none" stroke="' . $foreground . '" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>',
			'shield' => '<path d="M32 9 51 17v14c0 12-8 19-19 24-11-5-19-12-19-24V17Z" fill="none" stroke="' . $foreground . '" stroke-width="4" stroke-linejoin="round"/>',
			'diamond' => '<path d="M32 12 52 32 32 52 12 32Z" fill="none" stroke="' . $foreground . '" stroke-width="5" stroke-linejoin="round"/>',
			'grid', 'elementor' => '<path d="M15 15h14v14H15zM35 15h14v14H35zM15 35h14v14H15zM35 35h14v14H35z" fill="none" stroke="' . $foreground . '" stroke-width="4"/>',
			'bricks' => '<path d="M9 14h22v15H9zM33 14h22v15H33zM9 35h22v15H9zM33 35h22v15H33z" fill="none" stroke="' . $foreground . '" stroke-width="4" stroke-linejoin="round"/>',
			'oxygen' => '<circle cx="32" cy="32" r="18" fill="none" stroke="' . $foreground . '" stroke-width="5"/><circle cx="32" cy="32" r="8" fill="none" stroke="' . $foreground . '" stroke-width="4"/>',
			default => '<text x="32" y="33" text-anchor="middle" dominant-baseline="middle" fill="' . $foreground . '" font-family="system-ui,sans-serif" font-size="' . ( strlen( $label ) > 2 ? '24' : '31' ) . '" font-weight="750">' . esc_html( $label ) . '</text>',
		};
		$svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><rect width="64" height="64" rx="13" fill="' . $background . '"/>' . $art . self::marker( $environment ) . '</svg>';
		return 'data:image/svg+xml,' . rawurlencode( $svg );
	}

	/** Small color-and-letter marker also identifies the installation at tab size. */
	private static function marker( string $type ): string {
		$marks = ['local' => ['#087e70', 'L'], 'development' => ['#b45f09', 'D'], 'staging' => ['#7654c5', 'S'], 'production' => ['#25804a', 'P']];
		if ( !isset( $marks[$type] ) ) {
			return '';
		}
		[$color, $letter] = $marks[$type];
		return '<circle cx="52" cy="52" r="11" fill="' . $color . '" stroke="#ffffff" stroke-width="3"/><text x="52" y="53" text-anchor="middle" dominant-baseline="middle" fill="#ffffff" font-family="system-ui,sans-serif" font-size="12" font-weight="800">' . $letter . '</text>';
	}

	/** Print the active icon, including on sites without an existing Site Icon. */
	public static function render(): void {
		$icon = self::current_icon();
		if ( !$icon ) {
			return;
		}
		echo '<link id="bas-context-icon" rel="icon" type="image/svg+xml" href="' . esc_attr( $icon ) . '">' . "\n";
		// Builder shells can rewrite their head after load; apply the icon once more.
		if ( self::builder() ) {
			echo '<script>(function(){var u=' . wp_json_encode( $icon ) . ';function apply(){var l=document.querySelector("#bas-context-icon");if(!l){l=document.createElement("link");l.id="bas-context-icon";l.rel="icon";l.type="image/svg+xml";document.head.appendChild(l)}l.href=u}document.addEventListener("DOMContentLoaded",apply);window.addEventListener("load",apply);setTimeout(apply,1200)})();</script>' . "\n";
		}
	}

	/** Return a generated favicon only for a configured top-level tab. */
	private static function current_icon(): string {
		$settings = BAS_Plugin::icon_settings();
		if ( !$settings['enabled'] ) {
			return '';
		}
		if ( !is_admin() && ( ( isset( $_GET['bricks'] ) && isset( $_GET['brickspreview'] ) ) || isset( $_GET['ct_inner'] ) || isset( $_GET['oxygen_iframe'] ) || isset( $_GET['elementor-preview'] ) ) ) {
			return '';
		}
		$builder = self::builder();
		$marker = $settings['environment_marker'] ? BAS_Plugin::icon_environment_type() : '';
		if ( $builder ) {
			return self::uri( $settings['builder'], 'builder', 'auto' === $settings['builder_style'] ? $builder : $settings['builder_style'], $marker );
		}
		if ( is_admin() ) {
			return self::uri( $settings['admin'], 'admin', '', $marker );
		}
		return 'generated' === $settings['frontend_mode'] ? self::uri( $settings['frontend'], 'frontend', '', $marker ) : '';
	}

	/** Recognize the editor shell rather than every page made with a builder. */
	private static function builder(): string {
		if ( !is_user_logged_in() || !current_user_can( 'edit_posts' ) ) {
			return '';
		}
		if ( ( class_exists( 'Bricks\\Database' ) || defined( 'BRICKS_VERSION' ) || function_exists( 'bricks_is_builder' ) ) && isset( $_GET['bricks'] ) && is_string( $_GET['bricks'] ) && 'run' === sanitize_key( wp_unslash( $_GET['bricks'] ) ) ) {
			return 'bricks';
		}
		if ( did_action( 'elementor/loaded' ) && is_admin() && isset( $_GET['action'] ) && is_string( $_GET['action'] ) && 'elementor' === sanitize_key( wp_unslash( $_GET['action'] ) ) ) {
			return 'elementor';
		}
		if ( ( defined( 'CT_VERSION' ) || class_exists( 'CT_Component' ) ) && isset( $_GET['ct_builder'] ) && is_string( $_GET['ct_builder'] ) && 'true' === sanitize_key( wp_unslash( $_GET['ct_builder'] ) ) ) {
			return 'oxygen';
		}
		return '';
	}

	/** Derive three related contexts from the active brand palette. */
	private static function colors( string $context, string $builder ): array {
		if ( 'builder' === $context ) {
			return match ( $builder ) {
				'bricks' => ['#ffd54a', '#111111'],
				'elementor' => ['#92003b', '#ffffff'],
				'oxygen' => ['#2563eb', '#ffffff'],
				default => ['#384b65', '#ffffff'],
			};
		}
		$settings = BAS_Plugin::icon_palette();
		return 'admin' === $context ? [$settings['admin'], self::contrast( $settings['admin'] )] : [$settings['frontend'], self::contrast( $settings['frontend'] )];
	}

	private static function hex( $value ): string {
		return is_string( $value ) && preg_match( '/^#[a-f0-9]{6}$/i', $value ) ? strtolower( $value ) : '';
	}

	private static function contrast( string $hex ): string {
		$red = hexdec( substr( $hex, 1, 2 ) );
		$green = hexdec( substr( $hex, 3, 2 ) );
		$blue = hexdec( substr( $hex, 5, 2 ) );
		return ( .2126 * $red + .7152 * $green + .0722 * $blue ) > 145 ? '#17202b' : '#ffffff';
	}

	private static function label( $value ): string {
		$value = preg_replace( '/[^\\p{L}\\p{N}]/u', '', (string) $value );
		if ( !$value ) {
			$words = preg_split( '/\\s+/u', trim( get_bloginfo( 'name' ) ) );
			$value = '';
			foreach ( array_slice( $words ?: [], 0, 2 ) as $word ) {
				preg_match( '/^./u', $word, $letter );
				$value .= $letter[0] ?? '';
			}
		}
		$short = implode( '', array_slice( preg_split( '//u', $value, -1, PREG_SPLIT_NO_EMPTY ) ?: [], 0, 3 ) );
		return ( function_exists( 'mb_strtoupper' ) ? mb_strtoupper( $short, 'UTF-8' ) : strtoupper( $short ) ) ?: 'W';
	}
}
