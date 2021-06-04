<?php
/**
 * Plugin Name:       Disable Full site editing
 * Plugin URI:        PLUGIN SITE HERE
 * Description:       Allow to disable full site editing, useful to protect a production site.
 * Author:            janw.oostendorp
 * Author URI:        https://janw.me
 * Text Domain:       disable-fse
 * Domain Path:       /languages
 * Requires at least: 5.0
 * Requires PHP:      7.2
 * Version:           0.1.0
 *
 * @package         Disable_FSE
 */

namespace Disable_FSE;

define( 'DISABLE_FSE_VERSION', '0.1.0' );
define( 'DISABLE_FSE_DIR', plugin_dir_path( __FILE__ ) );
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

// Plugin activation.
register_activation_hook( __FILE__, array( '\Disable_FSE\App\Admin', 'activate' ) );

// Adds a link to the settings page on the plugin overview.
add_filter( 'plugin_action_links_' . DISABLE_FSE_NAME, array( '\Disable_FSE\App\Admin', 'settings_link' ) );

// add the rest of the hooks & filters.
