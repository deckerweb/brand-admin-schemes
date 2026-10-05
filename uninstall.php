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

// BAS has no scheduled tasks or persistent caches. Undo is a temporary snapshot.
if ( is_multisite() ) {
	$offset = 0;
	do {
		$sites = get_sites( [ 'fields' => 'ids', 'number' => 100, 'offset' => $offset ] );
		foreach ( $sites as $site_id ) {
			delete_blog_option( (int) $site_id, 'bas_last_undo' );
		}
		$offset += count( $sites );
	} while ( count( $sites ) === 100 );
} else {
	delete_option( 'bas_last_undo' );
}

// This repository-specific Updater V2 cache is temporary, not the shared
// WordPress update_plugins transient or another plugin's update state.
$cache = 'ddw_ghru_' . substr( md5( 'https://github.com/deckerweb/brand-admin-schemes' ), 0, 24 );
if ( is_multisite() ) {
	foreach ( get_networks( [ 'fields' => 'ids', 'number' => 0 ] ) as $network_id ) {
		delete_network_option( (int) $network_id, '_site_transient_' . $cache );
		delete_network_option( (int) $network_id, '_site_transient_timeout_' . $cache );
	}
	wp_cache_delete( $cache, 'site-transient' );
} else {
	delete_site_transient( $cache );
}
