<?php
/**
 * Displays the HTML of the settings page.
 *
 * @package Disable_FSE
 */

?>

<div class="wrap">
	<h1><?php esc_html_e( 'Disable Full site editing Settings', 'disable-fse' ); ?></h1>

	<h2><?php _e( 'Current setup', 'disable-fse' ) ?></h2>
	<p><?php echo esc_html( \Disable_FSE\App\Admin::is_fse_setup( false ) ); ?></p>

	<form action="options.php" method="POST">
		<?php settings_fields( 'disable-fse-settings' ); ?>
		<?php do_settings_sections( 'disable-fse' ); ?>
		<?php submit_button( __( 'Save shipping page', 'disable-fse' ) ); ?>
	</form>




</div>
