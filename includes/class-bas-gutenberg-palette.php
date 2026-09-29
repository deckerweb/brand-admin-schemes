<?php
/** Optional brand palette extension for WordPress global editor settings. */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

final class BAS_Gutenberg_Palette {
	public static function boot(): void {
		add_filter( 'wp_theme_json_data_theme', [__CLASS__, 'add_colors'], 30 );
	}

	/** Preserve the theme's palette entries and append namespaced brand roles. */
	public static function add_colors( $theme_json ) {
		$settings = BAS_Plugin::palette_settings();
		if ( !$settings['gutenberg_palette'] || !is_object( $theme_json ) || !method_exists( $theme_json, 'get_data' ) || !method_exists( $theme_json, 'update_with' ) ) {
			return $theme_json;
		}
		$scheme = $settings['schemes'][$settings['active']]['colors'] ?? [];
		$roles = ['primary' => __( 'Brand Primary', 'brand-admin-schemes' ), 'secondary' => __( 'Brand Secondary', 'brand-admin-schemes' ), 'tertiary' => __( 'Brand Tertiary', 'brand-admin-schemes' ), 'accent' => __( 'Brand Accent', 'brand-admin-schemes' )];
		$data = $theme_json->get_data();
		$current = $data['settings']['color']['palette'] ?? [];
		if ( false === $current ) {
			return $theme_json;
		}
		$existing = isset( $current['theme'] ) && is_array( $current['theme'] ) ? $current['theme'] : $current;
		$existing = is_array( $existing ) ? array_values( array_filter( $existing, 'is_array' ) ) : [];
		// Repeated resolver calls must not accumulate earlier BAS entries.
		$existing = array_values( array_filter( $existing, static fn( $entry ) => !str_starts_with( (string) ( $entry['slug'] ?? '' ), 'bas-brand-' ) ) );
		foreach ( $roles as $role => $name ) {
			$color = $scheme['brand_' . $role] ?? '';
			if ( !is_string( $color ) || !preg_match( '/^#[a-f0-9]{6}$/i', $color ) ) {
				continue;
			}
			$existing[] = ['slug' => 'bas-brand-' . $role, 'name' => $name, 'color' => strtolower( $color )];
		}
		return $theme_json->update_with( ['version' => 2, 'settings' => ['color' => ['palette' => $existing]]] );
	}
}
