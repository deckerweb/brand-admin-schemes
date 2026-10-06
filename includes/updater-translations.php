<?php
/** Translate shared updater messages through the BAS host catalog. */
defined( 'ABSPATH' ) || exit;
return static function ( string $message ): string {
    // Literal calls let the host's normal translation extractor collect every source string.
    switch ( $message ) {
        case 'Private mode must be boolean.':
            return __( 'Private mode must be boolean.', 'brand-admin-schemes' );
        case 'Invalid authentication provider.':
            return __( 'Invalid authentication provider.', 'brand-admin-schemes' );
        case 'The plugin must be installed in a stable slug directory.':
            return __( 'The plugin must be installed in a stable slug directory.', 'brand-admin-schemes' );
        case 'Invalid GitHub repository URL.':
            return __( 'Invalid GitHub repository URL.', 'brand-admin-schemes' );
        case 'The private update could not be authorized. Check the repository credentials and refresh updates.':
            return __( 'The private update could not be authorized. Check the repository credentials and refresh updates.', 'brand-admin-schemes' );
        case 'Could not create the update download file.':
            return __( 'Could not create the update download file.', 'brand-admin-schemes' );
        case 'The private update download failed. Check credentials and try again.':
            return __( 'The private update download failed. Check credentials and try again.', 'brand-admin-schemes' );
        case 'Could not access the update filesystem.':
            return __( 'Could not access the update filesystem.', 'brand-admin-schemes' );
        case 'GitHub release does not contain the plugin main file.':
            return __( 'GitHub release does not contain the plugin main file.', 'brand-admin-schemes' );
        case 'Could not prepare the GitHub release package.':
            return __( 'Could not prepare the GitHub release package.', 'brand-admin-schemes' );
        case 'See the release on GitHub.':
            return __( 'See the release on GitHub.', 'brand-admin-schemes' );
        default:
            return $message;
    }
};
