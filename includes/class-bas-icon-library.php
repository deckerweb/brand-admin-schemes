<?php
/**
 * Explicit PNG media and WordPress Site Icon actions.
 *
 * @package Brand_Admin_Schemes
 * @since 0.18.0
 * @copyright 2022–2026 David Decker – DECKERWEB
 */
namespace Deckerweb\BrandAdminSchemes;

/** Store only bounded PNGs; SVG downloads never enter the Media Library. */
final class IconLibrary {
	/** Register an authenticated endpoint; no public upload action exists. */
	public function register(): void {
		add_action( 'wp_ajax_bas_icon_media', array( $this, 'save' ) );
	}

	/** Validate the browser-rendered image before any filesystem write. */
	public static function decode_png( $value ) {
		if ( ! is_string( $value ) || strlen( $value ) > 2800000 || ! str_starts_with( $value, 'data:image/png;base64,' ) ) {
			return new \WP_Error( 'bas_icon_png', __( 'A valid 512 × 512 PNG icon is required.', 'brand-admin-schemes' ) );
		}
		$bytes = base64_decode( substr( $value, 22 ), true );
		$size = is_string( $bytes ) ? @getimagesizefromstring( $bytes ) : false;
		if ( ! $size || IMAGETYPE_PNG !== $size[2] || 512 !== $size[0] || 512 !== $size[1] || strlen( $bytes ) > 2 * MB_IN_BYTES ) {
			return new \WP_Error( 'bas_icon_png', __( 'A valid 512 × 512 PNG icon is required.', 'brand-admin-schemes' ) );
		}
		return $bytes;
	}

	/**
	 * Add a media attachment and optionally set the official WordPress Site Icon.
	 * This explicit action is independent of saving the editor draft.
	 */
	public function save(): void {
		check_ajax_referer( 'bas_nonce' );
		if ( ! current_user_can( 'manage_options' ) || ! current_user_can( 'upload_files' ) ) {
			wp_send_json_error( __( 'Forbidden', 'brand-admin-schemes' ), 403 );
		}
		$context = isset( $_POST['context'] ) && is_string( $_POST['context'] ) ? wp_unslash( $_POST['context'] ) : '';
		$purpose = isset( $_POST['purpose'] ) && is_string( $_POST['purpose'] ) ? wp_unslash( $_POST['purpose'] ) : '';
		if ( ! in_array( $context, array( 'frontend', 'admin', 'builder' ), true ) || ! in_array( $purpose, array( 'media', 'siteicon' ), true ) ) {
			wp_send_json_error( __( 'Invalid icon action.', 'brand-admin-schemes' ), 400 );
		}
		$bytes = self::decode_png( isset( $_POST['png'] ) && is_string( $_POST['png'] ) ? wp_unslash( $_POST['png'] ) : '' );
		if ( is_wp_error( $bytes ) ) {
			wp_send_json_error( $bytes->get_error_message(), 400 );
		}
		$allowed = get_allowed_mime_types();
		if ( ! isset( $allowed['png'] ) || strlen( $bytes ) > wp_max_upload_size() ) {
			wp_send_json_error( __( 'PNG uploads are not available on this site.', 'brand-admin-schemes' ), 400 );
		}
		if ( is_multisite() && function_exists( 'upload_is_user_over_quota' ) && upload_is_user_over_quota( false ) ) {
			wp_send_json_error( __( 'The upload quota is exhausted.', 'brand-admin-schemes' ), 400 );
		}
		if ( is_multisite() && ! get_site_option( 'upload_space_check_disabled' ) && strlen( $bytes ) > get_upload_space_available() ) {
			wp_send_json_error( __( 'The upload quota is exhausted.', 'brand-admin-schemes' ), 400 );
		}
		$upload = wp_upload_bits( 'brand-admin-schemes-' . $context . '.png', null, $bytes );
		if ( ! empty( $upload['error'] ) ) {
			wp_send_json_error( __( 'The icon could not be saved to the Media Library.', 'brand-admin-schemes' ), 500 );
		}
		// Decode and re-encode through WordPress before accepting a media attachment.
		// This rejects damaged images and strips unneeded client-supplied metadata.
		$image = wp_get_image_editor( $upload['file'] );
		$written = is_wp_error( $image ) ? $image : $image->save( $upload['file'], 'image/png' );
		if ( is_wp_error( $written ) ) {
			wp_delete_file( $upload['file'] );
			wp_send_json_error( __( 'WordPress could not process the PNG icon.', 'brand-admin-schemes' ), 400 );
		}
		$labels = array( 'frontend' => __( 'Website browser tab', 'brand-admin-schemes' ), 'admin' => __( 'WordPress admin browser tab', 'brand-admin-schemes' ), 'builder' => __( 'Builder editor browser tab', 'brand-admin-schemes' ) );
		$id = wp_insert_attachment( array( 'post_mime_type' => 'image/png', 'post_title' => __( 'Brand Admin Schemes', 'brand-admin-schemes' ) . ' · ' . $labels[ $context ], 'post_status' => 'inherit' ), $upload['file'], 0, true );
		if ( is_wp_error( $id ) ) {
			wp_delete_file( $upload['file'] );
			wp_send_json_error( __( 'The icon could not be saved to the Media Library.', 'brand-admin-schemes' ), 500 );
		}
		require_once ABSPATH . 'wp-admin/includes/image.php';
		$metadata = wp_generate_attachment_metadata( $id, $upload['file'] );
		wp_update_attachment_metadata( $id, $metadata );
		update_post_meta( $id, '_bas_icon_context', $context );
		if ( 'siteicon' === $purpose ) {
			update_option( 'site_icon', $id );
			\BAS_Plugin::use_official_site_icon();
		}
		wp_send_json_success( array( 'id' => $id, 'url' => wp_get_attachment_url( $id ), 'purpose' => $purpose ) );
	}
}
