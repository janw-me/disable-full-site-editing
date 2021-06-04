<?php


namespace Disable_FSE\App;

/**
 * Class Helper
 *
 * Holds generic functions.
 *
 * @package Disable_FSE\App
 */
class Helper {

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
	 * TODO.
	 *
	 * @return bool
	 */
	public static function should_disable_fse() {
		// Always allow to force disable with the constant DISABLE_FSE.

		/**
		 * Allow to override the should_disable in a filter before all other checks.
		 */
		$override = apply_filters( 'disable_fse_should_disable', null );
		if ( ! is_null( $override ) ) {
			return $override;
		}

		if ( defined( 'DISABLE_FSE' ) ) {
			return (bool) DISABLE_FSE;
		}

		$option         = get_option( 'disable_fse' );
		$current_status = 'or';
		if ( ! empty( $option['status'] ) ) {
			$current_status = $option['status'];
		}

		if ( 'on' === $current_status ) {
			return false; // FSE is ON.
		}
		if ( 'off' === $current_status ) {
			return true; // FSE is OFF.
		}
		$current_env = wp_get_environment_type();

		if ( in_array( $current_env, array( 'local', 'development' ), true ) ) {
			return false;
		}
		if ( in_array( $current_env, array( 'staging', 'production' ), true ) ) {
			return true;
		}

		return false;
	}
}
