<?php

namespace Disable_FSE\App;

/**
 * Class Admin
 *
 * @package Disable_FSE\app
 */
class Settings {

	/**
	 * Add a settings link to the the plugin on the plugin page
	 *
	 * @param array $links An array of plugin action links.
	 *
	 * @return array
	 */
	public static function settings_link( array $links ): array {
		$href          = admin_url( 'tools.php?page=disable-fse' );
		$settings_link = '<a href="' . $href . '">' . __( 'Settings' ) . '</a>'; // phpcs:ignore WordPress.WP.I18n.MissingArgDomain
		array_unshift( $links, $settings_link );

		return $links;
	}

	/**
	 * Register the menu page for the settings
	 */
	public static function register_menu_page() {
		add_submenu_page(
			'tools.php',
			__( 'Disable Full site editing Settings', 'disable-fse' ),
			__( 'Disable Full site editing', 'disable-fse' ),
			'manage_options',
			'disable-fse',
			function () {
				require_once DISABLE_FSE_TEMPLATE_DIR . 'settings-page.php';
			},
			1000
		);
	}

	/**
	 * Register settings to save.
	 */
	public static function register_settings() {
		$empty_function = function () {
		};

		// register the global setting.
		register_setting(
			'disable-fse-settings',
			'disable_fse',
			array( 'sanitize_callback' => array( self::class, 'sanitize_settings' ) )
		);
		add_settings_section(
			'page-section',
			'', // empty section title.
			$empty_function,
			'disable-fse'
		);

		$title = __( 'Toggle on/off', 'disable-fse' );
		add_settings_field(
			'disable_fse_status',
			$title,
			function () use ( $title ) {
				$args = func_get_args();
				require_once DISABLE_FSE_TEMPLATE_DIR . 'on-off-switch.php';
			},
			'disable-fse',
			'page-section'
		);
	}

	/**
	 * Sanitize the disable_fse options
	 *
	 * @param array|null $settings the current value(s) of the options.
	 *
	 * @return array
	 */
	public static function sanitize_settings( $settings ): array {
		if ( empty( $settings['status'] ) ) {
			$settings['status'] = 'or';
		} elseif ( ! in_array( $settings['status'], array( 'on', 'off', 'or' ), true ) ) {
			$settings['status'] = 'or';
		}

		return $settings;
	}
}

