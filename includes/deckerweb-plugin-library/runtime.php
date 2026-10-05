<?php
/** Copyright 2026 David Decker – DECKERWEB. SPDX-License-Identifier: GPL-2.0-or-later */
if ( ! defined( 'ABSPATH' ) ) { exit; }
require_once __DIR__ . '/src/I18n.php';
require_once __DIR__ . '/src/History.php';
require_once __DIR__ . '/src/Catalog.php';
require_once __DIR__ . '/src/Requirements.php';
require_once __DIR__ . '/src/Package.php';
require_once __DIR__ . '/src/Library.php';
return static function( array $chosen, array $hosts ) {
	$runtime = new \Deckerweb\PluginLibrary\V0_5_0\Library( $chosen, $hosts );
	$runtime->register();
	return $runtime;
};
