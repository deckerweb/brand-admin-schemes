<?php
/** Portable settings package with bounded, local raster image attachments. */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

final class BAS_Bundle {
	private const TYPES = ['logo' => 'login_logo_id', 'banner' => 'login_banner_id', 'background' => 'login_background_id'];
	private const EXTENSIONS = ['png', 'jpg', 'jpeg', 'webp', 'gif'];
	private const MAX_FILE = 4 * 1024 * 1024;
	private const MAX_BUNDLE = 13 * 1024 * 1024;

	public static function boot(): void {
		add_action( 'wp_ajax_bas_bundle_export', [__CLASS__, 'export'] );
		add_action( 'wp_ajax_bas_bundle_import', [__CLASS__, 'import'] );
	}

	private static function authorize(): void {
		check_ajax_referer( 'bas_nonce' );
		if ( !current_user_can( 'manage_options' ) ) {
			wp_send_json_error( __( 'Forbidden', 'brand-admin-schemes' ), 403 );
		}
		if ( !class_exists( 'ZipArchive' ) ) {
			wp_send_json_error( __( 'ZIP support is unavailable on this server.', 'brand-admin-schemes' ), 501 );
		}
	}

	/** Export the current editor draft and local raster attachments. */
	public static function export(): void {
		self::authorize();
		$payload = $_POST['settings'] ?? '';
		if ( !is_string( $payload ) ) {
			wp_send_json_error( __( 'Invalid agency package.', 'brand-admin-schemes' ), 400 );
		}
		$raw = json_decode( wp_unslash( $payload ), true );
		if ( !is_array( $raw ) ) {
			wp_send_json_error( __( 'Invalid agency package.', 'brand-admin-schemes' ), 400 );
		}
		$settings = BAS_Plugin::bundle_validate( $raw );
		$uploads = wp_get_upload_dir();
		$root = realpath( $uploads['basedir'] ?? '' );
		$paths = [];
		$media = [];
		foreach ( self::TYPES as $type => $field ) {
			$id = (int) $settings[$field];
			$path = $id ? realpath( get_attached_file( $id ) ?: '' ) : false;
			$extension = $path ? strtolower( pathinfo( $path, PATHINFO_EXTENSION ) ) : '';
			if ( !$root || !$path || !str_starts_with( $path, $root . DIRECTORY_SEPARATOR ) || !in_array( $extension, self::EXTENSIONS, true ) || !is_readable( $path ) || filesize( $path ) > self::MAX_FILE ) {
				continue;
			}
			$name = 'media/' . $type . '.' . $extension;
			$paths[$name] = $path;
			$media[$type] = $name;
		}
		$temporary = wp_tempnam( 'bas-bundle.zip' );
		$zip = new ZipArchive();
		if ( !$temporary || true !== $zip->open( $temporary, ZipArchive::CREATE | ZipArchive::OVERWRITE ) ) {
			if ( $temporary ) @unlink( $temporary );
			wp_send_json_error( __( 'Could not create the agency package.', 'brand-admin-schemes' ), 500 );
		}
		$manifest = wp_json_encode( ['format' => 'bas/bundle/v1', 'settings' => $settings, 'media' => $media] );
		$zip->addFromString( 'manifest.json', $manifest );
		foreach ( $paths as $name => $path ) {
			$zip->addFile( $path, $name );
		}
		$success = $zip->close();
		if ( !$success || !is_readable( $temporary ) ) {
			@unlink( $temporary );
			wp_send_json_error( __( 'Could not create the agency package.', 'brand-admin-schemes' ), 500 );
		}
		nocache_headers();
		header( 'Content-Type: application/zip' );
		header( 'Content-Disposition: attachment; filename="brand-admin-schemes-agency.zip"' );
		header( 'Content-Length: ' . filesize( $temporary ) );
		readfile( $temporary );
		@unlink( $temporary );
		exit;
	}

	/** Validate ZIP entries, then sideload bounded images for a draft import. */
	public static function import(): void {
		self::authorize();
		$file = $_FILES['bundle'] ?? null;
		if ( !is_array( $file ) || UPLOAD_ERR_OK !== ( $file['error'] ?? null ) || !is_uploaded_file( $file['tmp_name'] ?? '' ) || (int) ( $file['size'] ?? 0 ) > self::MAX_BUNDLE ) {
			wp_send_json_error( __( 'Invalid or oversized agency package.', 'brand-admin-schemes' ), 400 );
		}
		$zip = new ZipArchive();
		if ( true !== $zip->open( $file['tmp_name'] ) || $zip->numFiles > 4 ) {
			wp_send_json_error( __( 'Invalid agency package.', 'brand-admin-schemes' ), 400 );
		}
		$stat = $zip->statName( 'manifest.json' );
		if ( !$stat || $stat['size'] > 300000 ) {
			$zip->close();
			wp_send_json_error( __( 'Invalid agency package.', 'brand-admin-schemes' ), 400 );
		}
		$seen = [];
		for ( $i = 0; $i < $zip->numFiles; $i++ ) {
			$name = $zip->getNameIndex( $i );
			if ( !is_string( $name ) || isset( $seen[$name] ) || ( 'manifest.json' !== $name && !preg_match( '~^media/(logo|banner|background)\.(png|jpe?g|webp|gif)$~i', $name ) ) ) {
				$zip->close();
				wp_send_json_error( __( 'Invalid agency package.', 'brand-admin-schemes' ), 400 );
			}
			$seen[$name] = true;
		}
		$manifest = json_decode( $zip->getFromName( 'manifest.json' ), true );
		if ( !is_array( $manifest ) || 'bas/bundle/v1' !== ( $manifest['format'] ?? '' ) || !is_array( $manifest['media'] ?? null ) || !is_array( $manifest['settings'] ?? null ) ) {
			$zip->close();
			wp_send_json_error( __( 'Invalid agency package.', 'brand-admin-schemes' ), 400 );
		}
		$settings = BAS_Plugin::bundle_validate( $manifest['settings'] ?? null );
		$entries = [];
		$total = 0;
		foreach ( $manifest['media'] as $type => $name ) {
			if ( !isset( self::TYPES[$type] ) || !is_string( $name ) || !preg_match( '~^media/' . preg_quote( $type, '~' ) . '\.(png|jpe?g|webp|gif)$~i', $name ) ) {
				$zip->close();
				wp_send_json_error( __( 'Invalid image in agency package.', 'brand-admin-schemes' ), 400 );
			}
			$stat = $zip->statName( $name );
			if ( !$stat || $stat['size'] > self::MAX_FILE || ( $total += $stat['size'] ) > self::MAX_BUNDLE || !isset( $seen[$name] ) ) {
				$zip->close();
				wp_send_json_error( __( 'Invalid image in agency package.', 'brand-admin-schemes' ), 400 );
			}
			$bytes = $zip->getFromName( $name );
			$dimensions = is_string( $bytes ) ? getimagesizefromstring( $bytes ) : false;
			$expected_mime = ['png' => 'image/png', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'webp' => 'image/webp', 'gif' => 'image/gif'];
			$extension = strtolower( pathinfo( $name, PATHINFO_EXTENSION ) );
			if ( !$dimensions || $dimensions[0] > 6000 || $dimensions[1] > 6000 || ( $dimensions['mime'] ?? '' ) !== $expected_mime[$extension] ) {
				$zip->close();
				wp_send_json_error( __( 'Invalid image in agency package.', 'brand-admin-schemes' ), 400 );
			}
			$entries[$type] = ['name' => basename( $name ), 'bytes' => $bytes];
		}
		$zip->close();
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
		$created = [];
		foreach ( self::TYPES as $type => $field ) {
			$settings[$field] = 0;
			if ( !isset( $entries[$type] ) ) {
				continue;
			}
			$tmp = wp_tempnam( $entries[$type]['name'] );
			if ( !$tmp || false === file_put_contents( $tmp, $entries[$type]['bytes'] ) ) {
				self::rollback( $created );
				wp_send_json_error( __( 'Could not import package images.', 'brand-admin-schemes' ), 500 );
			}
			$id = media_handle_sideload( ['name' => $entries[$type]['name'], 'tmp_name' => $tmp, 'size' => strlen( $entries[$type]['bytes'] ), 'error' => 0], 0 );
			if ( is_wp_error( $id ) ) {
				@unlink( $tmp );
				self::rollback( $created );
				wp_send_json_error( __( 'Could not import package images.', 'brand-admin-schemes' ), 400 );
			}
			$created[] = $id;
			$settings[$field] = $id;
		}
		$settings['active'] = '';
		wp_send_json_success( ['settings' => $settings, 'importedImages' => count( $created )] );
	}

	private static function rollback( array $ids ): void {
		foreach ( $ids as $id ) {
			wp_delete_attachment( $id, true );
		}
	}
}
