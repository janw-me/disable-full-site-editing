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
	 * In the editor remove the ability to create new templates.
	 * Only allow to select from the existing ones.
	 *
	 * @param array $editor_settings The current editor settings.
	 *
	 * @return array
	 */
	public static function remove_new_templates( $editor_settings ) {
		if ( ! Helper::should_disable_fse() ) {
			return $editor_settings; // Disable FSE not active.
		}
		$editor_settings['supportsTemplateMode'] = false;

		return $editor_settings;
	}

	/**
	 * The existence of .html files in the theme is used to define a block theme.
	 * In the admin we hide all .html templates to disable FSE.
	 *
	 * @param string $path The path to a template file.
	 *
	 * @return string
	 *
	 * @see wp_is_block_theme() The function we "break".
	 */
	public static function hide_html_templates( $path ) {
		if ( ! Helper::should_disable_fse() ) {
			return $path;  // Disable FSE not active.
		}
		if ( ! is_admin() ) {
			return $path; // We only check the admin, otherwise the frontend would break.
		}

		if ( str_ends_with( $path, '.html' ) ) {
			return $path . '.disable-fse'; // append '.disable-fse' to the filename, now it's not an html file anymore.
		}

		return $path;
	}

}
