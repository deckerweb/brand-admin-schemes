<?php
/**
 * Compact, read-only Site Health information.
 *
 * @package Brand_Admin_Schemes
 * @since 0.17.0
 * @copyright 2022–2026 David Decker – DECKERWEB
 */

namespace Deckerweb\BrandAdminSchemes;

/** Reports configuration without status tests, provider reads or remote requests. */
final class SiteHealth {
	/** Register only the native WordPress information section. */
	public function register(): void {
		add_filter( 'debug_information', array( $this, 'information' ) );
	}

	/**
	 * Add non-sensitive values to the copyable Site Health report.
	 *
	 * Names, colors, media references and customer texts are deliberately omitted.
	 * Unknown stored values must not break diagnostics.
	 *
	 * @param array $information Existing WordPress diagnostic sections.
	 * @return array Diagnostic sections including this plugin's configuration.
	 */
	public function information( array $information ): array {
		$settings = \BAS_Plugin::palette_settings();
		$schemes  = is_array( $settings['schemes'] ?? null ) ? $settings['schemes'] : array();
		$active   = $settings['active'] ?? '';
		$selected = is_string( $active ) && isset( $schemes[ $active ] ) && is_array( $schemes[ $active ] );
		$source   = $settings['source'] ?? 'manual';
		$mode     = $settings['default_mode'] ?? 'off';
		$unknown  = __( 'Unknown', 'brand-admin-schemes' );
		$enabled  = __( 'Enabled', 'brand-admin-schemes' );
		$disabled = __( 'Disabled', 'brand-admin-schemes' );
		$sources  = array( 'manual' => __( 'Manual', 'brand-admin-schemes' ), 'core' => 'Core Framework', 'bricks' => 'Bricks', 'acss' => 'Automatic.css' );
		$modes    = array(
			'off'     => __( 'No default', 'brand-admin-schemes' ),
			'default' => __( 'Default; allow personal selection', 'brand-admin-schemes' ),
			'force'   => __( 'Force for all users', 'brand-admin-schemes' ),
		);
		$environment = \BAS_Plugin::site_health_environment();
		$information['brand-admin-schemes'] = array(
			'label'  => __( 'Brand Admin Schemes', 'brand-admin-schemes' ),
			'fields' => array(
				'site-scheme-selected' => array( 'label' => __( 'Site scheme selected', 'brand-admin-schemes' ), 'value' => $selected ? __( 'Yes', 'brand-admin-schemes' ) : __( 'No', 'brand-admin-schemes' ), 'debug' => $selected ? 'yes' : 'no' ),
				'palette-source' => array( 'label' => __( 'Palette source', 'brand-admin-schemes' ), 'value' => is_string( $source ) ? ( $sources[ $source ] ?? $unknown ) : $unknown ),
				'default-mode' => array( 'label' => __( 'Default for users', 'brand-admin-schemes' ), 'value' => is_string( $mode ) ? ( $modes[ $mode ] ?? $unknown ) : $unknown ),
				'login' => array( 'label' => __( 'Login design', 'brand-admin-schemes' ), 'value' => empty( $settings['login_enabled'] ) ? $disabled : $enabled ),
				'toolbar' => array( 'label' => __( 'Frontend toolbar styling', 'brand-admin-schemes' ), 'value' => empty( $settings['frontend_bar'] ) ? $disabled : $enabled ),
				'tab-icons' => array( 'label' => __( 'Browser tab icons', 'brand-admin-schemes' ), 'value' => empty( $settings['icons']['enabled'] ) ? $disabled : $enabled ),
				'environment' => array( 'label' => __( 'Displayed environment', 'brand-admin-schemes' ), 'value' => $environment['label'], 'debug' => $environment['type'] ),
				'environment-source' => array( 'label' => __( 'Environment source', 'brand-admin-schemes' ), 'value' => $environment['source_label'], 'debug' => $environment['source'] ),
			),
		);
		return $information;
	}
}
