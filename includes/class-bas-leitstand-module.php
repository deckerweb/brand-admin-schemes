<?php
/**
 * Optional module for the verified Leitstand Module interface.
 * @package BrandAdminSchemes
 * Copyright © 2022–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
namespace Deckerweb\BrandAdminSchemes;
defined( 'ABSPATH' ) || exit;

/** Link network branding workflows without copying or depending on Leitstand. */
final class LeitstandModule implements \Deckerweb\Leitstand\Module {
	/** Return the unique module key. @return string */
	public function id(): string { return 'bas-branding'; }
	/** Return the translated module title through the BAS domain. @return string */
	public function title(): string { return __( 'Website branding', 'brand-admin-schemes' ); }
	/** Render bounded website links and the optional network starter form. @return void */
	public function render(): void {
		if ( ! is_multisite() || ! current_user_can( 'manage_network_options' ) ) { return; }
		echo '<h2>' . esc_html( $this->title() ) . '</h2><p>' . esc_html__( 'Each website keeps independent branding. Open its editor to review or change settings.', 'brand-admin-schemes' ) . '</p><ul>';
		$page = max( 1, absint( $_GET['bas_page'] ?? 1 ) );
		$sites = get_sites( [ 'network_id' => get_current_network_id(), 'number' => 51, 'offset' => ( $page - 1 ) * 50, 'deleted' => 0 ] );
		foreach ( array_slice( $sites, 0, 50 ) as $site ) {
			echo '<li><a href="' . esc_url( get_admin_url( (int) $site->blog_id, 'options-general.php?page=brand-admin-schemes' ) ) . '">' . esc_html( $site->domain . $site->path ) . '</a></li>';
		}
		echo '</ul>';
		if ( $page > 1 ) { echo '<a class="button" href="' . esc_url( add_query_arg( 'bas_page', $page - 1 ) ) . '">' . esc_html__( 'Previous websites', 'brand-admin-schemes' ) . '</a> '; }
		if ( count( $sites ) > 50 ) { echo '<a class="button" href="' . esc_url( add_query_arg( 'bas_page', $page + 1 ) ) . '">' . esc_html__( 'More websites', 'brand-admin-schemes' ) . '</a>'; }
		echo '<p><a class="button" href="' . esc_url( network_admin_url( 'settings.php?page=bas-network-template' ) ) . '">' . esc_html__( 'Branding starter template', 'brand-admin-schemes' ) . '</a></p>';
	}
}
