=== Disable Full Site Editing ===
Contributors: janw.oostendorp
Tags: ful-site-edit
Requires at least: 5.0
Tested up to: 5.7.2
Requires PHP: 7.2
Stable tag: 1.0.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Allow to disable full site editing in the admin, useful to protect a production site.

== Description ==

Allow to disable full site editing in the admin, useful to protect a production site.
A block theme will continue to work as intended on the frontend while making sure the theme can't be messed up.

> *⚠️ Full site editing is in beta, therefore there might be compatability bugs.*
For the coming months I'll keep testing the plugin with new (beta) releases or gutenberg and WordPres.

 - If you find a bug,
 - If you have questions,
 - Feature requests,
 - Anything else,
Please contact me [here](https://wordpress.org/support/plugin/disable-full-site-editing/) or on the [github repository](https://github.com/janw-me/disable-fse).

== Tested combinations ==

As Full site editing is in beta I'm keeping up with Gutenberg and WordPress beta versions.
Last updated, June 11th

- WP 5.7.2 & Gutenberg 10.7.0
- All WP & Gutenberg versions in between the above and below.
- WP 5.7.2 & Gutenberg 10.8.0
- WP 5.8-beta1 & Gutenberg 10.8.0.
- WP 5.8-beta1.

== Installation ==

Just install the plugin and activate.
There is a admin settings page or set the `DISABLE_FSE` constant.

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

= 1.0.0 =
* Launch

= 1.0.1 =
* Added more functions checks.

= 1.0.2 =

* More precise disabling of FSE, it was to broad.
* Disable adding/editing templates in the editor itself.

= 1.0.3 =

* Fixed a JS bug
