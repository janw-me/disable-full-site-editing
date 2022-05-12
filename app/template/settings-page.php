<?php
/**
 * Displays the HTML of the settings page.
 *
 * @package Disable_FSE
 */

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
// phpcs:disable WordPress.Security.EscapeOutput

// If `DISABLE_FSE` is defined, always disable the options.
use Disable_FSE\App\Helper;

$submit_attr = array();
if ( defined( 'DISABLE_FSE' ) ) {
	$submit_attr['disabled'] = 'disabled';
}
?>

<div class="wrap">
	<h1><?php esc_html_e( 'Disable Full site editing Settings', 'disable-full-site-editing' ); ?></h1>

	<h2><?php _e( 'Current setup', 'disable-full-site-editing' ); ?></h2>
	<p><?php echo esc_html( Helper::is_fse_setup( false ) ); ?></p>

	<?php if ( defined( 'DISABLE_FSE' ) && (bool) DISABLE_FSE ) : ?>
		<div class="notice notice-error">
			<p>
				<span class="dashicons dashicons-warning"></span>
				<?php _e( 'The toggle is disabled by the <code>DISABLE_FSE</code> constant.', 'disable-full-site-editing' ); ?><br/>
				<?php _e( 'Full site editing is <strong>enabled</strong>, to re-enable the toggle remove the constant.', 'disable-full-site-editing' ); ?>
			</p>
		</div>
	<?php elseif ( defined( 'DISABLE_FSE' ) && ! (bool) DISABLE_FSE ) : ?>
		<div class="notice notice-error">
			<p>
				<span class="dashicons dashicons-warning"></span>
				<?php _e( 'The toggle is disabled by the <code>DISABLE_FSE</code> constant.', 'disable-full-site-editing' ); ?><br/>
				<?php _e( 'Full site editing is <strong>Disabled</strong>, to re-enable the toggle remove the constant.', 'disable-full-site-editing' ); ?>
			</p>
		</div>
	<?php endif; ?>

	<form action="options.php" method="POST">
		<?php settings_fields( 'disable-fse-settings' ); ?>
		<?php do_settings_sections( 'disable-fse' ); ?>
		<?php submit_button( __( 'Save', 'disable-full-site-editing' ), 'primary', 'submit', true, $submit_attr ); ?>
	</form>
</div>
