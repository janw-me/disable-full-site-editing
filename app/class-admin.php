<?php

namespace Disable_FSE\App;

/**
 * Class Admin
 *
 * @package Disable_FSE\app
 */
class Admin {

	/**
	 * Add a settings link to the the plugin on the plugin page
	 *
	 * @param array $links An array of plugin action links.
	 *
	 * @return array
	 */
	public static function settings_link( array $links ): array {
		$href          = admin_url( 'options-general.php?page=janw-base-plugin' );
		$settings_link = '<a href="' . $href . '">' . __( 'Settings' ) . '</a>'; // phpcs:ignore WordPress.WP.I18n.MissingArgDomain
		array_unshift( $links, $settings_link );

		return $links;
	}

	/**
	 * Run on activation.
	 *
	 * @param string $plugin Path to the plugin file relative to the plugins directory.
	 * @param bool   $network_wide Whether to enable the plugin for all sites in the network
	 *                               or just the current site. Multisite only. Default false.
	 */
	public static function activate( $plugin, $network_wide = false ) {
		// do stuff.
	}
}

