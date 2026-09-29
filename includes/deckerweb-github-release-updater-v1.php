<?php
/**
 * DECKERWEB GitHub Release Updater, API v1.
 * Copyright © 2022–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
namespace Deckerweb\GitHubReleaseUpdater\V1;
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Connects one public GitHub repository to WordPress plugin update APIs.
 *
 * API v1 is intended to be copied into several plugins without class collisions.
 * It never turns on automatic updates or handles private repository credentials.
 */
final class Updater {
	/**
	 * WordPress plugin basename, for example slug/slug.php.
	 * @var string
	 */
	private string $file;
	/**
	 * Stable installed directory name.
	 * @var string
	 */
	private string $slug;
	/**
	 * Normalized public GitHub repository URL.
	 * @var string
	 */
	private string $repo;
	/**
	 * GitHub REST API repository URL.
	 * @var string
	 */
	private string $api;
	/**
	 * Repository-specific site transient key.
	 * @var string
	 */
	private string $cache;
	/**
	 * Display name for the WordPress plugin information dialog.
	 * @var string
	 */
	private string $name;
	/**
	 * Short description shown in plugin information.
	 * @var string
	 */
	private string $description;
	/**
	 * Validate the installed plugin basename and repository identity.
	 * @param string $main_file Absolute path to the main plugin file.
	 * @param string $repository_url Public https://github.com/owner/repository URL.
	 * @param string $name Plugin display name.
	 * @param string $description Short description for update details.
	 * @throws \InvalidArgumentException If the slug or repository URL is invalid.
	 */
	public function __construct( string $main_file, string $repository_url, string $name, string $description ) {
		$this->file = \plugin_basename( $main_file );
		$this->slug = \dirname( $this->file );
		if ( $this->slug === '.' || !\preg_match( '/^[a-z0-9_-]+$/D', $this->slug ) ) {
			throw new \InvalidArgumentException( 'The plugin must be installed in a stable slug directory.' );
		}
		if ( !\preg_match( '~^https://github\.com/([A-Za-z0-9-]+)/([A-Za-z0-9._-]+)/?$~D', $repository_url, $matches ) ) {
			throw new \InvalidArgumentException( 'Invalid public GitHub repository URL.' );
		}
		$this->repo = 'https://github.com/' . $matches[1] . '/' . $matches[2];
		$this->api = 'https://api.github.com/repos/' . $matches[1] . '/' . $matches[2];
		$this->cache = 'ddw_ghru_' . \substr( \md5( $this->repo ), 0, 24 );
		$this->name = $name;
		$this->description = $description;
	}

	/**
	 * Register the update, information, and extracted archive hooks.
	 */
	public function register(): void {
		\add_filter( 'update_plugins_github.com', [$this, 'update'], 10, 4 );
		\add_filter( 'plugins_api', [$this, 'information'], 20, 3 );
		\add_filter( 'upgrader_source_selection', [$this, 'select_source'], 20, 4 );
	}

	/**
	 * Fetch the latest published release and choose its installable ZIP.
	 * Caches successful responses for 30 minutes and failures for 10 minutes.
	 * @return array{version:string,package:string,notes:string,published:string}|null
	 */
	private function release(): ?array {
		$cached = \get_site_transient( $this->cache );
		if ( \is_array( $cached ) ) {
			return !empty( $cached['failed'] ) ? null : $cached;
		}
		$response = \wp_remote_get(
			$this->api . '/releases/latest',
			[
				'timeout'     => 6,
				'redirection' => 2,
				'headers'     => [
					'Accept'               => 'application/vnd.github+json',
					'User-Agent'           => 'DECKERWEB-WordPress-GitHub-Release-Updater',
					'X-GitHub-Api-Version' => '2022-11-28',
				],
			]
		);
		if ( \is_wp_error( $response ) || \wp_remote_retrieve_response_code( $response ) !== 200 ) {
			\set_site_transient( $this->cache, ['failed' => true], 10 * MINUTE_IN_SECONDS );
			return null;
		}
		$data = \json_decode( \wp_remote_retrieve_body( $response ), true );
		if ( !\is_array( $data ) || !empty( $data['draft'] ) || !empty( $data['prerelease'] ) || !\is_string( $data['tag_name'] ?? null ) || !\preg_match( '/^v?(\d+\.\d+\.\d+(?:-[0-9A-Za-z.-]+)?)$/D', $data['tag_name'], $match ) ) {
			\set_site_transient( $this->cache, ['failed' => true], 10 * MINUTE_IN_SECONDS );
			return null;
		}
		// Prefer a release asset with the stable slug; otherwise use the source archive.
		$version = $match[1];
		$package = '';
		foreach ( ( \is_array( $data['assets'] ?? null ) ? $data['assets'] : [] ) as $asset ) {
			if ( !\is_array( $asset ) || ( $asset['state'] ?? 'uploaded' ) !== 'uploaded' ) {
				continue;
			}
			$asset_name = \is_string( $asset['name'] ?? null ) ? $asset['name'] : '';
			if ( $asset_name !== $this->slug . '.zip' && $asset_name !== $this->slug . '-' . $version . '.zip' ) {
				continue;
			}
			$url = \is_string( $asset['browser_download_url'] ?? null ) ? $asset['browser_download_url'] : '';
			if ( \strpos( $url, $this->repo . '/releases/download/' ) === 0 ) {
				$package = $url;
				break;
			}
		}
		if ( !$package ) {
			$url = \is_string( $data['zipball_url'] ?? null ) ? $data['zipball_url'] : '';
			if ( \strpos( $url, $this->api . '/zipball/' ) === 0 ) {
				$package = $url;
			}
		}
		if ( !$package ) {
			\set_site_transient( $this->cache, ['failed' => true], 10 * MINUTE_IN_SECONDS );
			return null;
		}
		$release = [
			'version' => $version,
			'package' => $package,
			'notes' => \is_string( $data['body'] ?? null ) ? $data['body'] : '',
			'published' => \is_string( $data['published_at'] ?? null ) ? $data['published_at'] : '',
		];
		\set_site_transient( $this->cache, $release, 30 * MINUTE_IN_SECONDS );
		return $release;
	}

	/**
	 * Provide an update only for this plugin and its matching Update URI.
	 * @param mixed $response Current WordPress update response.
	 * @param array<string,mixed> $plugin_data Installed plugin headers.
	 * @param string $plugin_file Plugin basename supplied by WordPress.
	 * @param mixed $locales Requested locales, unused.
	 * @return mixed Existing response or WordPress update data.
	 */
	public function update( $response, $plugin_data, $plugin_file, $locales ) {
		// The hostname hook may run for multiple GitHub plugins on the same site.
		if ( $plugin_file !== $this->file || ( $plugin_data['UpdateURI'] ?? '' ) !== $this->repo ) {
			return $response;
		}
		$release = $this->release();
		if ( !$release || \version_compare( $release['version'], (string)( $plugin_data['Version'] ?? '0' ), '<=' ) ) {
			return $response;
		}
		return [
			'id' => $this->repo,
			'slug' => $this->slug,
			'version' => $release['version'],
			'url' => $this->repo . '/releases',
			'package' => $release['package'],
			'requires' => (string)( $plugin_data['RequiresWP'] ?? '' ),
			'requires_php' => (string)( $plugin_data['RequiresPHP'] ?? '' ),
		];
	}

	/**
	 * Populate the WordPress plugin details modal from release metadata.
	 * @param mixed $response Current plugin information response.
	 * @param string $action WordPress plugins API action.
	 * @param mixed $args Request arguments.
	 * @return mixed Existing response or plugin information object.
	 */
	public function information( $response, $action, $args ) {
		if ( $action !== 'plugin_information' || !\is_object( $args ) || ( $args->slug ?? '' ) !== $this->slug ) {
			return $response;
		}
		$release = $this->release();
		if ( !$release ) {
			return $response;
		}
		return (object) [
			'name'           => $this->name,
			'slug'           => $this->slug,
			'version'        => $release['version'],
			'author'         => 'David Decker – DECKERWEB',
			'author_profile' => 'https://github.com/deckerweb',
			'homepage'       => $this->repo,
			'last_updated'   => $release['published'],
			'download_link'  => $release['package'],
			'sections'       => [
				'description' => \esc_html( \__( $this->description, $this->slug ) ),
				'changelog'   => \wpautop( \esc_html( $release['notes'] ?: 'See the release on GitHub.' ) ),
			],
		];
	}

	/**
	 * Verify and normalize the extracted plugin directory before installation.
	 * @param mixed $source Path to extracted archive, or a WP_Error.
	 * @param mixed $remote_source Remote source path, unused.
	 * @param mixed $upgrader WordPress upgrader instance, unused.
	 * @param array<string,mixed> $hook_extra Upgrade context.
	 * @return mixed Valid source directory or WP_Error.
	 */
	public function select_source( $source, $remote_source, $upgrader, $hook_extra ) {
		if ( \is_wp_error( $source ) || !\is_string( $source ) || ( $hook_extra['plugin'] ?? '' ) !== $this->file || ( $hook_extra['type'] ?? '' ) !== 'plugin' || ( $hook_extra['action'] ?? '' ) !== 'update' ) {
			return $source;
		}
		global $wp_filesystem;
		if ( !$wp_filesystem ) {
			return new \WP_Error( 'ddw_ghru_filesystem', \__( 'Could not access the update filesystem.', $this->slug ) );
		}
		$root = \untrailingslashit( $source );
		$main = \basename( $this->file );
		// Accept an asset's slug folder; a GitHub source ZIP needs renaming.
		// Refuse archives missing the expected main file before WordPress replaces anything.
		if ( $wp_filesystem->is_file( $root . '/' . $this->slug . '/' . $main ) ) {
			return \trailingslashit( $root . '/' . $this->slug );
		}
		if ( !$wp_filesystem->is_file( $root . '/' . $main ) ) {
			return new \WP_Error( 'ddw_ghru_archive', \__( 'GitHub release does not contain the plugin main file.', $this->slug ) );
		}
		$target = \dirname( $root ) . '/' . $this->slug;
		if ( $root === $target ) {
			return $source;
		}
		if ( $wp_filesystem->exists( $target ) || !$wp_filesystem->move( $root, $target, false ) ) {
			return new \WP_Error( 'ddw_ghru_rename', \__( 'Could not prepare the GitHub release package.', $this->slug ) );
		}
		return \trailingslashit( $target );
	}
}
