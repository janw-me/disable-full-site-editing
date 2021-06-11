<?php
/**
 * Plugin Name:       Disable Full site editing
 * Plugin URI:        PLUGIN SITE HERE
 * Description:       Allow to disable full site editing in the admin.
 * Author:            janw.oostendorp
 * Author URI:        https://janw.me
 * Text Domain:       disable-fse
 * Domain Path:       /languages
 * Requires at least: 5.0
 * Requires PHP:      7.2
 * Version:           1.0.2
 *
 * @package         Disable_FSE
 */

namespace Disable_FSE;

define( 'DISABLE_FSE_VERSION', '1.0.3' );
define( 'DISABLE_FSE_DIR', plugin_dir_path( __FILE__ ) );
define( 'DISABLE_FSE_TEMPLATE_DIR', DISABLE_FSE_DIR . 'app' . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR );
define( 'DISABLE_FSE_URL', plugin_dir_url( __FILE__ ) );
define( 'DISABLE_FSE_NAME', basename( __DIR__ ) . DIRECTORY_SEPARATOR . basename( __FILE__ ) );

/**
 * Autoload classes.
 */
spl_autoload_register( function ( $full_class_name ) { //phpcs:ignore PEAR.Functions.FunctionCallSignature
	if ( strpos( $full_class_name, __NAMESPACE__ . '\App' ) !== 0 ) {
		return; // Not in the plugin namespace, don't check.
	}

	$full_class_name = strtolower( str_replace( '_', '-', $full_class_name ) );
	$class_parts     = explode( '\\', $full_class_name );
	unset( $class_parts[0] ); // Unset the __NAMESPACE__.

	$class_file    = 'class-' . array_pop( $class_parts ) . '.php';
	$class_parts[] = $class_file;

	require_once DISABLE_FSE_DIR . implode( DIRECTORY_SEPARATOR, $class_parts );
} );//phpcs:ignore PEAR.Functions.FunctionCallSignature

/**
 * Hook everything.
 */

// Adds a link to the settings page on the plugin overview.
add_filter( 'plugin_action_links_' . DISABLE_FSE_NAME, array( '\Disable_FSE\App\Settings', 'settings_link' ) );

// Settings.
add_action( 'admin_menu', array( '\Disable_FSE\App\Settings', 'register_menu_page' ) );
add_action( 'admin_init', array( '\Disable_FSE\App\Settings', 'register_settings' ) );

// Cleanup.
add_action( 'plugins_loaded', array( 'Disable_FSE\App\Cleaner', 'clean_early' ), 1 );
