<?php

namespace Disable_FSE\App;

use PHP_CodeSniffer\Standards\Squiz\Sniffs\Classes\SelfMemberReferenceSniff;

/**
 * Class Cleaner
 *
 * Cleanup the all FSE from the wp-admin
 * phpcs:disable Squiz.Commenting.InlineComment
 *
 * @package Disable_FSE\App
 */
class Cleaner {


	/**
	 * Removal of all actions & filters as soon as available te remove.
	 */
	public static function clean_early() {
		if ( ! Helper::should_disable_fse() ) {
			return;
		}

		// menu items need to be removed later.
		add_action( 'admin_menu', array( self::class, 'remove_menus' ), 100 );

		// Add a script that will disable the template buttons.
		add_action( 'enqueue_block_editor_assets', array( 'Disable_FSE\App\Cleaner', 'enqueue_template_stripper' ) );

		// ./gutenberg/lib/init.php:108
		remove_action( 'admin_menu', 'gutenberg_site_editor_menu', 9 );
		// ./gutenberg/lib/full-site-editing/full-site-editing.php:67:
		remove_action( 'admin_menu', 'gutenberg_remove_legacy_pages' );
		// ./gutenberg/lib/full-site-editing/full-site-editing.php:99:
		remove_action( 'admin_bar_menu', 'gutenberg_adminbar_items', 50 );
		// ./gutenberg/lib/full-site-editing/templates.php:160:
		remove_action( 'admin_menu', 'gutenberg_fix_template_admin_menu_entry' );
		// ./gutenberg/lib/full-site-editing/template-parts.php:129:
		remove_action( 'admin_menu', 'gutenberg_fix_template_part_admin_menu_entry' );

		// ./gutenberg/lib/full-site-editing/full-site-editing.php:104
		remove_filter( 'custom_menu_order', '__return_true' );
		// ./gutenberg/lib/full-site-editing/full-site-editing.php:105
		remove_filter( 'menu_order', 'gutenberg_menu_order' );

		//phpcs:disable PEAR.Functions.FunctionCallSignature
		add_action('template_redirect', function() {
			// ./wp-includes/class-wp-admin-bar.php:645
			remove_action( 'admin_bar_menu', 'wp_admin_bar_edit_site_menu', 40 );
		}, 100);
		//phpcs:enable PEAR.Functions.FunctionCallSignature
	}

	/**
	 * Remove the menu items for the custom post types.
	 */
	public static function remove_menus() {
		remove_submenu_page( 'themes.php', 'edit.php?post_type=wp_template' );
		remove_submenu_page( 'themes.php', 'edit.php?post_type=wp_template_part' );
		remove_submenu_page( 'themes.php', 'site-editor.php' );
	}

	/**
	 * Add ht escript that will remove the "new" & "edit" from the templates
	 */
	public static function enqueue_template_stripper() {
		if ( ! post_type_exists( 'wp_template' ) ) {
			return;
		}

		wp_enqueue_script(
			'disable-fse-js',
			DISABLE_FSE_URL . 'src/disable-fse.js',
			array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-i18n' ),
			DISABLE_FSE_VERSION,
			true
		);
	}
}
