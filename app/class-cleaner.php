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
	 * Removal of all actions as soon as available te remove.
	 */
	public static function clean_early() {
		if ( ! Helper::should_disable_fse() ) {
			return;
		}
		self::manual_exceptions();
		self::remove_action();
		self::remove_filter();
		self::re_add();
	}

	/**
	 * Not all problems are set in the `lib/full-site-editing` folder.
	 */
	public static function manual_exceptions() {
		// ./gutenberg/lib/init.php:108
		remove_action( 'admin_menu', 'gutenberg_site_editor_menu', 9 );
	}

	/**
	 * Some actions/filters we do want for the FE rendering, make sure they are not removed.
	 * Readding them is easier to keep track of then cleaning up the exceptions.
	 */
	public static function re_add() {
		// ./gutenberg/lib/full-site-editing/template-loader.php:24:
		if ( function_exists( 'gutenberg_add_template_loader_filters' ) ) {
			add_action( 'wp_loaded', 'gutenberg_add_template_loader_filters' );
		}
		// ./gutenberg/lib/full-site-editing/template-loader.php:120:
		if ( function_exists( 'gutenberg_viewport_meta_tag' ) ) {
			add_action( 'wp_head', 'gutenberg_viewport_meta_tag', 0 );
		}
		// ./gutenberg/lib/full-site-editing/template-loader.php:124:
		if ( function_exists( 'gutenberg_render_title_tag' ) ) {
			add_action( 'wp_head', 'gutenberg_render_title_tag', 1 );
		}
		// ./gutenberg/lib/full-site-editing/template-loader.php:267
		if ( function_exists( 'gutenberg_template_render_without_post_block_context' ) ) {
			add_filter( 'render_block_context', 'gutenberg_template_render_without_post_block_context' );
		}
	}

	/**
	 * Found by using.
	 *      `grep -rn 'add_action( '"'" ./gutenberg/lib/full-site-editing/ -nr`
	 */
	protected static function remove_action() {
		// ./gutenberg/lib/full-site-editing/full-site-editing.php:39:
		remove_action( 'admin_notices', 'gutenberg_full_site_editing_notice' );
		// ./gutenberg/lib/full-site-editing/full-site-editing.php:67:
		remove_action( 'admin_menu', 'gutenberg_remove_legacy_pages' );
		// ./gutenberg/lib/full-site-editing/full-site-editing.php:99:
		remove_action( 'admin_bar_menu', 'gutenberg_adminbar_items', 50 );
		// ./gutenberg/lib/full-site-editing/template-loader.php:24:
		remove_action( 'wp_loaded', 'gutenberg_add_template_loader_filters' );
		// ./gutenberg/lib/full-site-editing/template-loader.php:120:
		remove_action( 'wp_head', 'gutenberg_viewport_meta_tag', 0 );
		// ./gutenberg/lib/full-site-editing/template-loader.php:124:
		remove_action( 'wp_head', 'gutenberg_render_title_tag', 1 );
		// ./gutenberg/lib/full-site-editing/edit-site-page.php:155:
		remove_action( 'admin_enqueue_scripts', 'gutenberg_edit_site_init' );
		// ./gutenberg/lib/full-site-editing/edit-site-page.php:181:
		remove_action( 'init', 'register_site_editor_homepage_settings', 10 );
		// ./gutenberg/lib/full-site-editing/templates.php:81:
		remove_action( 'init', 'gutenberg_register_template_post_type' );
		// ./gutenberg/lib/full-site-editing/templates.php:110:
		remove_action( 'init', 'gutenberg_register_wp_theme_taxonomy' );
		// ./gutenberg/lib/full-site-editing/templates.php:160:
		remove_action( 'admin_menu', 'gutenberg_fix_template_admin_menu_entry' );
		// ./gutenberg/lib/full-site-editing/templates.php:164:
		remove_action( 'manage_wp_template_posts_custom_column', 'gutenberg_render_templates_lists_custom_column', 10 );
		// ./gutenberg/lib/full-site-editing/templates.php:194:
		remove_action( 'save_post_wp_template', 'set_unique_slug_on_create_template' );
		// ./gutenberg/lib/full-site-editing/templates.php:285:
		remove_action( 'wp_footer', 'gutenberg_the_skip_link' );
		// ./gutenberg/lib/full-site-editing/template-parts.php:61:
		remove_action( 'init', 'gutenberg_register_template_part_post_type' );
		// ./gutenberg/lib/full-site-editing/template-parts.php:90:
		remove_action( 'init', 'gutenberg_register_wp_template_part_area_taxonomy' );
		// ./gutenberg/lib/full-site-editing/template-parts.php:129:
		remove_action( 'admin_menu', 'gutenberg_fix_template_part_admin_menu_entry' );
		// ./gutenberg/lib/full-site-editing/template-parts.php:133:
		remove_action( 'manage_wp_template_part_posts_custom_column', 'gutenberg_render_templates_lists_custom_column', 10 );
		// ./gutenberg/lib/full-site-editing/template-parts.php:163:
		remove_action( 'save_post_wp_template_part', 'set_unique_slug_on_create_template_part' );
	}

	/**
	 * Found by using.
	 *      `grep -rn 'add_filter( '"'" ./gutenberg/lib/full-site-editing/ -nr`
	 */
	protected static function remove_filter() {
		// ./gutenberg/lib/full-site-editing/full-site-editing.php:104
		remove_filter( 'custom_menu_order', '__return_true' );
		// ./gutenberg/lib/full-site-editing/full-site-editing.php:105
		remove_filter( 'menu_order', 'gutenberg_menu_order' );
		// ./gutenberg/lib/full-site-editing/full-site-editing.php:145
		remove_filter( 'should_load_block_editor_scripts_and_styles', 'gutenberg_site_editor_load_block_editor_scripts_and_styles' );
		// ./gutenberg/lib/full-site-editing/block-templates.php:496
		remove_filter( 'pre_wp_unique_post_slug', 'gutenberg_filter_wp_template_unique_post_slug', 10 );
		// ./gutenberg/lib/full-site-editing/template-loader.php:267
		remove_filter( 'render_block_context', 'gutenberg_template_render_without_post_block_context' );
		// ./gutenberg/lib/full-site-editing/page-templates.php:27
		remove_filter( 'theme_templates', 'gutenberg_load_block_page_templates' );
		// ./gutenberg/lib/full-site-editing/templates.php:136
		remove_filter( 'user_has_cap', 'gutenberg_grant_template_caps' );
		// ./gutenberg/lib/full-site-editing/templates.php:163
		remove_filter( 'manage_wp_template_posts_columns', 'gutenberg_templates_lists_custom_columns' );
		// ./gutenberg/lib/full-site-editing/templates.php:165
		remove_filter( 'views_edit-wp_template', 'gutenberg_filter_templates_edit_views' );
		// ./gutenberg/lib/full-site-editing/template-parts.php:132
		remove_filter( 'manage_wp_template_part_posts_columns', 'gutenberg_templates_lists_custom_columns' );
		// ./gutenberg/lib/full-site-editing/template-parts.php:134
		remove_filter( 'views_edit-wp_template_part', 'gutenberg_filter_templates_edit_views' );
	}
}
