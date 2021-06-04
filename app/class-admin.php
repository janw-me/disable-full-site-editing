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
		$href          = admin_url( 'tools.php?page=disable-fse' );
		$settings_link = '<a href="' . $href . '">' . __( 'Settings' ) . '</a>'; // phpcs:ignore WordPress.WP.I18n.MissingArgDomain
		array_unshift( $links, $settings_link );

		return $links;
	}

	/**
	 * Run on activation.
	 *
	 * @param string $plugin Path to the plugin file relative to the plugins directory.
	 * @param bool   $network_wide Whether to enable the plugin for all sites in the network or just the current site. Multisite only. Default false.
	 */
	public static function activate( $plugin, $network_wide = false ) {
		// do stuff.
	}

	/**
	 * @return bool
	 */
	public static function should_disable_fse() {
		// Always allow to force disable with the constant DISABLE_FSE.
		if ( defined( 'DISABLE_FSE' ) ) {
			return (bool) DISABLE_FSE;
		}

		wp_get_environment_type();
	}

	/**
	 * Check which part of FSE is enabled.
	 *
	 * @param bool $return_key Set to false to return a readable message.
	 *
	 * @return string Key fill have a easy "slug" Value a readable message.
	 */
	public static function is_fse_setup( $return_key = true ) {
		global $wp_version;

		$setup_statuses = array(
			'full'              => __( 'The complete full site editing is available. And the theme supports it.', 'disable-fse' ),
			'full-no-theme'     => __( 'The complete full site editing is available. But the current theme does not support it.', 'disable-fse' ),
			'template'          => __( 'Custom templates are supported. And the theme supports it.', 'disable-fse' ),
			'template-no-theme' => __( 'Custom templates are supported. But the current theme does not support it.', 'disable-fse' ),
			'only-theme'        => __( 'Your theme supports full site editing, install the Gutenberg plugin to use it.', 'disable-fse' ),
			'nothing'           => __( 'Full site editing is not enabled, to enable install the Gutenberg plugin and a compatible theme like TT1 Blocks.', 'disable-fse' ),
		);
		$key            = '';

		$wordpress_is_fse = false;
		if ( version_compare( $wp_version, '5.8' ) >= 0 ) {
			$wordpress_is_fse = true;
		}

		$gutenberg_is_fse = false;
		if ( defined( 'GUTENBERG_VERSION' ) && version_compare( GUTENBERG_VERSION, '10.7' ) >= 0 ) {
			$gutenberg_is_fse = true;
		}

		$theme_is_fse = false;
		if ( function_exists( 'gutenberg_is_fse_theme' ) && gutenberg_is_fse_theme() ) {
			$theme_is_fse = true;
		}

		if ( $gutenberg_is_fse && $theme_is_fse ) {
			$key = 'full';
		} elseif ( $gutenberg_is_fse && false === $theme_is_fse ) {
			$key = 'full-no-theme';
		} elseif ( $wordpress_is_fse && $theme_is_fse ) {
			$key = 'template';
		} elseif ( $wordpress_is_fse && false === $theme_is_fse ) {
			$key = 'template-no-theme';
		} elseif ( $theme_is_fse ) {
			$key = 'only-theme';
		} else {
			$key = 'nothing';
		}

		if ( $return_key ) {
			return $key;
		} else {
			return $setup_statuses[ $key ];
		}
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

