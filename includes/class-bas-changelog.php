<?php
/** Local structured history, generated from the shared documentation source.
 * @package BrandAdminSchemes
 * Copyright © 2022–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
namespace Deckerweb\BrandAdminSchemes;
defined( 'ABSPATH' ) || exit;

/** Render local history as escaped headings, dates, category badges and lists. */
final class Changelog {
	public static function is_german(): bool {
		return 1 === preg_match( '/^de(?:_|$)/i', determine_locale() );
	}
	/** Full plain-text history remains available without JavaScript. */
	public static function url(): string {
		return plugins_url( self::is_german() ? 'docs/changelog-de.txt' : 'docs/changelog.txt', BAS_PLUGIN_FILE );
	}
	/** Display recent versions; the complete history stays in the text fallback. */
	public static function content(): string {
		$file = BAS_PLUGIN_DIR . 'docs/history.json';
		if ( ! is_readable( $file ) || filesize( $file ) > 262144 ) {
			return '';
		}
		$data = json_decode( (string) file_get_contents( $file ), true );
		if ( ! is_array( $data ) || ! is_array( $data['versions'] ?? null ) ) {
			return '';
		}
		$locale = determine_locale();
		$lang = 'de_DE_formal' === $locale ? 'de_DE_formal' : ( self::is_german() ? 'de_DE' : 'en' );
		$categories = self::is_german() ? [ 'New' => 'Neu', 'Improved' => 'Verbessert', 'Fix' => 'Behoben', 'Misc' => 'Sonstiges' ] : [ 'New' => 'New', 'Improved' => 'Improved', 'Fix' => 'Fix', 'Misc' => 'Misc' ];
		$html = '';
		foreach ( array_slice( $data['versions'], 0, max( 7, min( 100, (int) ( $data['display_count'] ?? 7 ) ) ) ) as $release ) {
			if ( ! is_array( $release ) || ! is_string( $release['version'] ?? null ) || ! is_array( $release['entries'] ?? null ) ) {
				continue;
			}
			$html .= '<section class="bas-changelog-release"><h3>' . esc_html( $release['version'] ) . '</h3>';
			$date = $release['date'] ?? '';
			if ( is_string( $date ) && preg_match( '/^\d{4}-\d{2}-\d{2}$/D', $date ) ) {
				$html .= '<p class="bas-changelog-date"><time datetime="' . esc_attr( $date ) . '">' . esc_html( $date ) . '</time>';
			} else {
				$html .= '<p class="bas-changelog-date">' . ( 'prepared' === ( $release['status'] ?? '' ) ? esc_html__( 'Release prepared; publication pending', 'brand-admin-schemes' ) : esc_html__( 'Release date not recorded', 'brand-admin-schemes' ) );
			}
			if ( 'development' === ( $release['status'] ?? '' ) ) {
				$html .= ' · ' . esc_html__( 'Unpublished test build', 'brand-admin-schemes' );
			}
			$html .= '</p>';
			foreach ( $categories as $category => $label ) {
				$items = '';
				foreach ( $release['entries'] as $entry ) {
					if ( is_array( $entry ) && $category === ( $entry['category'] ?? '' ) && is_string( $entry[$lang] ?? null ) ) {
						$items .= '<li>' . esc_html( $entry[$lang] ) . '</li>';
					}
				}
				if ( $items !== '' ) {
					$html .= '<h4><span class="bas-changelog-badge bas-changelog-' . esc_attr( strtolower( $category ) ) . '">' . esc_html( $label ) . '</span></h4><ul>' . $items . '</ul>';
				}
			}
			$html .= '</section>';
		}
		return $html;
	}
	public static function dialog(): void {
		$content = self::content();
		if ( '' === $content ) {
			return;
		}
		echo '<dialog id="bas-document-changelog" class="bas-document-dialog" aria-labelledby="bas-document-changelog-title"><header class="bas-document-header"><h2 id="bas-document-changelog-title">Brand Admin Schemes · ' . esc_html__( 'Changelog', 'brand-admin-schemes' ) . '</h2><button type="button" class="button" data-bas-close autofocus>' . esc_html__( 'Close', 'brand-admin-schemes' ) . '</button></header><div class="bas-document-content" tabindex="0">';
		echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- All JSON text is escaped in content(); markup is fixed.
		echo '</div><p class="bas-document-source"><a href="' . esc_url( self::url() ) . '">' . esc_html__( 'Complete changelog', 'brand-admin-schemes' ) . '</a></p></dialog>';
	}
}
