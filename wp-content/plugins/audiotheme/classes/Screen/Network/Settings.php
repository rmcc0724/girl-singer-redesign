<?php
/**
 * Network settings screen functionality.
 *
 * @package   AudioTheme\Settings
 * @copyright Copyright 2012 AudioTheme
 * @license   GPL-2.0+
 * @link      https://audiotheme.com/
 * @since     2.0.0
 */

/**
 * Network settings screen class.
 *
 * @package AudioTheme\Settings
 * @since   2.0.0
 */
class AudioTheme_Screen_Network_Settings extends AudioTheme_Screen_AbstractScreen {
	/**
	 * Register hooks.
	 *
	 * @since 2.0.0
	 */
	public function register_hooks() {
		add_action( 'network_admin_menu', array( $this, 'add_menu_item' ) );
		add_action( 'admin_init',         array( $this, 'register_sections' ) );
		add_action( 'admin_init',         array( $this, 'save_network_settings' ) );
	}

	/**
	 * Add the settings menu item.
	 *
	 * @since 2.0.0
	 */
	public function add_menu_item() {
		add_submenu_page(
			'settings.php',
			__( 'Settings', 'audiotheme' ),
			__( 'AudioTheme', 'audiotheme' ),
			'manage_network_options',
			'audiotheme-network-settings',
			array( $this, 'display_screen' )
		);
	}

	/**
	 * Register settings sections.
	 *
	 * @since 2.0.0
	 */
	public function register_sections() {
		add_settings_section(
			'default',
			'',
			'__return_null',
			'audiotheme-network-settings'
		);
	}

	/**
	 * Display the screen.
	 *
	 * @since 2.0.0
	 */
	public function display_screen() {
		include( $this->plugin->get_path( 'admin/views/screen-network-settings.php' ) );
	}

	/**
	 * Fire an action when a network settings screen is saved.
	 *
	 * Plugins need to manually save each registered options. Check the nonce in
	 * $_POST['_wpnonce'] to be sure the action is '{$option_group}-options'.
	 *
	 * Don't call wp_die() or exit() since all network settings screens will use
	 * the same action.
	 *
	 * @since 2.0.0
	 */
	public function save_network_settings() {
		if ( ! is_network_admin() || empty( $_GET['action'] ) || 'audiotheme-save-network-settings' !== $_GET['action'] ) {
			return;
		}

		do_action( 'audiotheme_save_network_settings' );

		$redirect = add_query_arg( 'page', 'audiotheme-network-settings', admin_url( 'network/settings.php' ) );
		wp_safe_redirect( esc_url_raw( $redirect ) );
		exit;
	}
}
