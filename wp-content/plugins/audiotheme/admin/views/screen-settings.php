<?php
/**
 * View to display the settings screen.
 *
 * @package   AudioTheme\Settings
 * @copyright Copyright 2012 AudioTheme
 * @license   GPL-2.0+
 * @link      https://audiotheme.com/
 * @since     2.0.0
 */
?>

<div class="wrap">
	<h1><?php _e( 'AudioTheme Settings', 'audiotheme' ); ?></h1>

	<form action="options.php" method="post">
		<?php settings_fields( 'audiotheme-settings' ); ?>
		<?php do_settings_sections( 'audiotheme-settings' ); ?>
		<?php submit_button(); ?>
	</form>
</div>
