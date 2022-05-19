=== Disable Full Site Editing ===
Contributors: janw.oostendorp
Tags: ful-site-edit
Requires at least: 5.0
Tested up to: 6.0
Requires PHP: 7.2
Stable tag: 1.1.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Allow disabling full site editing in the admin, useful to protect a production site.

== Description ==

Allow disabling full site editing in the admin, useful to protect a production site.
A block theme will continue to work as intended on the frontend while making sure the theme can't be messed up.

> *⚠️ Full site editing is still fresh.*
For the coming months I'll keep testing the plugin with new (beta) releases of gutenberg and WordPres.

 - If you find a bug,
 - If you have questions,
 - Feature requests,
 - Anything else,
Please contact me [on the forum](https://wordpress.org/support/plugin/disable-full-site-editing/) or on the [github repository](https://github.com/janw-me/disable-full-site-editing).

== Installation ==

Just install the plugin and activate.
There is an admin settings page or set the `DISABLE_FSE` constant.

== Frequently Asked Questions ==

= In what order does the plugin check if full site editing is allowed? =

1. The constant `DISABLE_FSE` set to true/false.
   You can add the constant in your `wp-config.php` file.
2. The setting in the wp-admin (a sub page of the tools menu)
3. The current `WP_ENVIRONMENT_TYPE`. [Docs](https://developer.wordpress.org/reference/functions/wp_get_environment_type/), [A bit more details](https://make.wordpress.org/core/2020/07/24/new-wp_get_environment_type-function-in-wordpress-5-5/)

= How does the `DISABLE_FSE` constant work? =

In your `wp-config.php` paste the following to always disable FSE:

	define( 'DISABLE_FSE', true );

or to always enable FSE

	define( 'DISABLE_FSE', false );

== Changelog ==

= 1.1.2 =
* Removed unused files from SVN

= 1.1.1 =
* The translations via Polyglot now work correctly thanks to [Alex Lion](https://profiles.wordpress.org/alexclassroom/)

= 1.1.0 =
* Fixed a couple of bugs.
* Now also tested on multisite.

= 1.0.3 =
* Fixed a JS bug

= 1.0.2 =
* More precise disabling of FSE, it was to broad.
* Disable adding/editing templates in the editor itself.

= 1.0.1 =
* Added more functions checks.

= 1.0.0 =
* Launch
