<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
// phpcs:disable WordPress.Security.EscapeOutput
$option         = get_option( 'disable_fse' );
$current_status = 'or';
if ( ! empty( $option['status'] ) ) {
	$current_status = $option['status'];
}

// If `DISABLE_FSE` is defined, always disable the options.
$disabled = false;
if ( defined( 'DISABLE_FSE' ) ) {
	$disabled = true;
}

/**
 * Set in \Disable_FSE\App\Admin::register_settings
 *
 * @var string $title
 */
?>
<fieldset>
	<legend class="screen-reader-text"><?php echo $title; ?></legend>

	<input type="radio" id="disable-fse-on" name="disable_fse[status]" value="on"
		<?php
		checked( 'on', $current_status );
		disabled( $disabled );
		?>
	>
	<label for="disable-fse-on"><?php _e( '<i>Enable</i> site editing ', 'disable-fse' ); ?></label>
	<br/>

	<input type="radio" id="disable-fse-off" name="disable_fse[status]" value="off"
		<?php
		checked( 'off', $current_status );
		disabled( $disabled );
		?>

	>
	<label for="disable-fse-off"><?php _e( '<i>Disable</i> site editing', 'disable-fse' ); ?></label>
	<br/>

	<input type="radio" id="disable-fse-or" name="disable_fse[status]" value="or"
		<?php
		checked( 'or', $current_status );
		disabled( $disabled );
		?>
	>
	<label
		for="disable-fse-or"><?php _e( 'Respect the <code>WP_ENVIRONMENT_TYPE</code> constant', 'disable-fse' ); ?></label>
	<br/>
	<p class="description" style="padding-left: 2em;">
		<?php _e( 'Will <i>enable</i> when set to <code>local</code> or <code>development</code>', 'disable-fse' ); ?><br/>
		<?php _e( 'Will <i>Disable</i> when set to <code>staging</code> or <code>production</code>', 'disable-fse' ); ?><br/>
		<?php
		// translators: The value for the current wp environment.
		printf( __( 'Currently set to <code>%s</code>', 'disable-fse' ), wp_get_environment_type() );
		?>
	</p>
</fieldset>
