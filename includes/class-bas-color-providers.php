<?php
/** Read optional website palettes without changing their owners' settings.
 * @package BrandAdminSchemes
 */
namespace Deckerweb\BrandAdminSchemes;
defined( 'ABSPATH' ) || exit;

/** Bounded, request-local adapters for native and optional builder color palettes. */
final class ColorProviders {
	/** Cached snapshots, isolated by website and active theme. @var array<string,array> */
	private static array $memo = [];

	/** Read the new providers once for the current website; perform no remote requests.
	 * @return array<string,array> Provider identifiers mapped to named palettes.
	 */
	public static function read(): array {
		$key = get_current_blog_id() . ':' . get_stylesheet() . ':' . determine_locale();
		if ( isset( self::$memo[$key] ) ) { return self::$memo[$key]; }
		return self::$memo[$key] = [ 'wordpress' => self::wordpress(), 'elementor' => self::elementor(), 'oxygen-classic' => self::oxygen() ];
	}

	/** Normalize solid source colors; never evaluate CSS variables or expressions.
	 * @param mixed $value Source value.
	 * @return string Six-digit lowercase HEX, or empty for unsupported/translucent values.
	 */
	public static function hex( $value ): string {
		if ( ! is_string( $value ) || strlen( $value ) > 100 ) { return ''; }
		$value = trim( $value );
		if ( preg_match( '/^#([a-f0-9]{3})$/iD', $value, $m ) ) { return strtolower( '#' . $m[1][0] . $m[1][0] . $m[1][1] . $m[1][1] . $m[1][2] . $m[1][2] ); }
		if ( preg_match( '/^#[a-f0-9]{6}$/iD', $value ) ) { return strtolower( $value ); }
		if ( preg_match( '/^(#[a-f0-9]{6})ff$/iD', $value, $m ) ) { return strtolower( $m[1] ); }
		if ( preg_match( '/^rgba?\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})(?:\s*,\s*(1(?:\.0+)?))?\s*\)$/iD', $value, $m ) ) {
			if ( str_starts_with( strtolower( $value ), 'rgba' ) && empty( $m[4] ) ) { return ''; }
			if ( ! str_starts_with( strtolower( $value ), 'rgba' ) && isset( $m[4] ) ) { return ''; }
			if ( max( (int) $m[1], (int) $m[2], (int) $m[3] ) <= 255 ) { return sprintf( '#%02x%02x%02x', (int) $m[1], (int) $m[2], (int) $m[3] ); }
		}
		return '';
	}

	/** Convert bounded owner rows to the existing BAS color contract.
	 * @param mixed $rows Palette entries supplied by the owner.
	 * @param string $id_field Entry identifier field.
	 * @param string $name_field Human-readable name field.
	 * @param string $color_field Literal color field.
	 * @param string $prefix Stable namespace inside this palette.
	 * @param bool $exclude_bas Exclude reserved BAS output slugs only for the native palette.
	 * @return array<int,array{id:string,name:string,hex:string}> Valid entries in source order.
	 */
	private static function colors( $rows, string $id_field, string $name_field, string $color_field, string $prefix = '', bool $exclude_bas = false ): array {
		if ( ! is_array( $rows ) ) { return []; }
		$out = []; $seen = [];
		foreach ( array_slice( $rows, 0, 300 ) as $row ) {
			if ( ! is_array( $row ) ) { continue; }
			$id = $row[$id_field] ?? null; $name = $row[$name_field] ?? null; $hex = self::hex( $row[$color_field] ?? null );
			if ( ! is_scalar( $id ) || '' === (string) $id || ! $hex || ( $exclude_bas && str_starts_with( (string) $id, 'bas-brand-' ) ) ) { continue; }
			$id = $prefix . substr( sanitize_text_field( (string) $id ), 0, 100 );
			if ( '' === $id || isset( $seen[$id] ) ) { continue; }
			$seen[$id] = true;
			$out[] = [ 'id' => $id, 'name' => is_string( $name ) && '' !== trim( $name ) ? substr( sanitize_text_field( $name ), 0, 160 ) : $hex, 'hex' => $hex ];
		}
		return $out;
	}

	/** Read the resolved theme and user palettes through the WordPress global-settings API.
	 * @return array Named origin palettes, excluding colors written by BAS itself.
	 */
	private static function wordpress(): array {
		if ( ! function_exists( 'wp_get_global_settings' ) ) { return []; }
		// Core's resolver is request-global; a switched blog must not reuse another site's theme data.
		if ( class_exists( '\WP_Theme_JSON_Resolver' ) ) { \WP_Theme_JSON_Resolver::clean_cached_data(); }
		try { $data = wp_get_global_settings( [ 'color', 'palette' ] ); } catch ( \Throwable $error ) { return []; }
		if ( ! is_array( $data ) ) { return []; }
		$names = [ 'theme' => __( 'Theme colors', 'brand-admin-schemes' ), 'custom' => __( 'Custom global colors', 'brand-admin-schemes' ), 'default' => __( 'WordPress default colors', 'brand-admin-schemes' ) ]; $out = [];
		foreach ( $names as $origin => $name ) {
			if ( 'default' === $origin && false === wp_get_global_settings( [ 'color', 'defaultPalette' ] ) ) { continue; }
			$colors = self::colors( $data[$origin] ?? [], 'slug', 'name', 'color', '', true );
			if ( $colors ) { $out[] = [ 'id' => $origin, 'name' => $name, 'colors' => $colors ]; }
		}
		return $out;
	}

	/** Check actual per-site/network activation even after a Multisite blog switch.
	 * @param mixed $file Owner's main file constant.
	 * @return bool Whether the owner is active for this website.
	 */
	private static function active( $file ): bool {
		if ( ! is_string( $file ) ) { return false; }
		$basename = plugin_basename( $file ); $local = get_option( 'active_plugins', [] );
		$network = is_multisite() ? get_site_option( 'active_sitewide_plugins', [] ) : [];
		return ( is_array( $local ) && in_array( $basename, $local, true ) ) || ( is_array( $network ) && isset( $network[$basename] ) );
	}

	/** Read the active Elementor kit, using a fresh document to avoid cross-blog instance caches.
	 * @return array One palette of system and custom colors; no kit is created or changed.
	 */
	private static function elementor(): array {
		if ( ! defined( 'ELEMENTOR__FILE__' ) || ! self::active( ELEMENTOR__FILE__ ) || ! class_exists( '\Elementor\Core\Kits\Documents\Kit' ) ) { return []; }
		$id = absint( get_option( 'elementor_active_kit', 0 ) ); $post = $id ? get_post( $id ) : null;
		if ( ! $post || 'elementor_library' !== $post->post_type || 'trash' === $post->post_status || 'kit' !== get_post_meta( $id, '_elementor_template_type', true ) ) { return []; }
		try {
			$kit = new \Elementor\Core\Kits\Documents\Kit( [ 'post_id' => $id ] );
			$system = $kit->get_settings( 'system_colors' ); $custom = $kit->get_settings( 'custom_colors' );
		} catch ( \Throwable $error ) { return []; }
		$colors = array_merge( self::colors( $system, '_id', 'title', 'color', 'system:' ), self::colors( $custom, '_id', 'title', 'color', 'custom:' ) );
		return $colors ? [ [ 'id' => 'active-kit', 'name' => __( 'Global colors', 'brand-admin-schemes' ), 'colors' => $colors ] ] : [];
	}

	/** Read Oxygen Classic's stored color sets; never use its request-global palette cache.
	 * @return array Named Classic sets, with no dependency on Oxygen 6+.
	 */
	private static function oxygen(): array {
		if ( ! defined( 'CT_VERSION' ) || ! is_string( CT_VERSION ) || ! version_compare( CT_VERSION, '4.0', '>=' ) || ! version_compare( CT_VERSION, '5.0', '<' ) || ! defined( 'CT_PLUGIN_MAIN_FILE' ) || ! self::active( CT_PLUGIN_MAIN_FILE ) || ! function_exists( 'oxy_get_global_colors' ) ) { return []; }
		$data = get_option( 'oxygen_vsb_global_colors', [] );
		if ( ! is_array( $data ) || ! is_array( $data['sets'] ?? null ) || ! is_array( $data['colors'] ?? null ) ) { return []; }
		$out = []; $seen = [];
		foreach ( array_slice( $data['sets'], 0, 100 ) as $set ) {
			if ( ! is_array( $set ) || ! is_scalar( $set['id'] ?? null ) ) { continue; }
			$id = (string) $set['id']; if ( isset( $seen[$id] ) ) { continue; } $seen[$id] = true;
			$rows = array_filter( array_slice( $data['colors'], 0, 300 ), static fn( $row ) => is_array( $row ) && is_scalar( $row['set'] ?? null ) && (string) $row['set'] === $id );
			$colors = self::colors( $rows, 'id', 'name', 'value' );
			if ( $colors ) { $out[] = [ 'id' => $id, 'name' => is_string( $set['name'] ?? null ) ? substr( sanitize_text_field( $set['name'] ), 0, 160 ) : __( 'Global colors', 'brand-admin-schemes' ), 'colors' => $colors ]; }
		}
		return $out;
	}
}
