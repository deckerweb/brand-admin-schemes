<?php
/** Shared-component cleanup; retain BAS settings and media.
 * @package BrandAdminSchemes
 * Copyright © 2022–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
require_once __DIR__ . '/includes/deckerweb-plugin-library/lifecycle.php';
deckerweb_library_uninstall_v2( __DIR__ . '/brand-admin-schemes.php' );

/** Run owned cleanup in local scope without leaking temporary variables. @return void */
(static function(): void {
	// BAS has no scheduled tasks or persistent caches. Undo is a temporary snapshot.
	if ( is_multisite() ) {
		$brand_admin_schemes_offset = 0;
		do {
			$brand_admin_schemes_sites = get_sites( [ 'fields' => 'ids', 'number' => 100, 'offset' => $brand_admin_schemes_offset ] );
			foreach ( $brand_admin_schemes_sites as $brand_admin_schemes_site_id ) {
				if ( ! empty( get_blog_option( (int) $brand_admin_schemes_site_id, 'bas_settings', [] )['delete_workflows'] ) ) {
					delete_blog_option( (int) $brand_admin_schemes_site_id, 'bas_templates' );
					delete_blog_option( (int) $brand_admin_schemes_site_id, 'bas_history' );
				}
				delete_blog_option( (int) $brand_admin_schemes_site_id, 'bas_last_undo' );
				delete_blog_option( (int) $brand_admin_schemes_site_id, 'bas_write_lock' );
			}
			$brand_admin_schemes_offset += count( $brand_admin_schemes_sites );
		} while ( count( $brand_admin_schemes_sites ) === 100 );
	} else {
		if ( ! empty( get_option( 'bas_settings', [] )['delete_workflows'] ) ) { delete_option( 'bas_templates' ); delete_option( 'bas_history' ); }
		delete_option( 'bas_last_undo' );
		delete_option( 'bas_write_lock' );
	}

	// This repository-specific Updater V2 cache is temporary, not the shared
	// WordPress update_plugins transient or another plugin's update state.
	$brand_admin_schemes_cache = 'ddw_ghru_' . substr( md5( 'https://github.com/deckerweb/brand-admin-schemes' ), 0, 24 );
	if ( is_multisite() ) {
		foreach ( get_networks( [ 'fields' => 'ids', 'number' => 0 ] ) as $network_id ) {
			delete_network_option( (int) $network_id, '_site_transient_' . $brand_admin_schemes_cache );
			delete_network_option( (int) $network_id, '_site_transient_timeout_' . $brand_admin_schemes_cache );
		}
		wp_cache_delete( $brand_admin_schemes_cache, 'site-transient' );
	} else {
		delete_site_transient( $brand_admin_schemes_cache );
	}
})();
