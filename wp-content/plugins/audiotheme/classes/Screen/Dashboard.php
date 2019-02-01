<?php
/**
 * Dashboard screen functionality.
 *
 * @package   AudioTheme\Administration
 * @copyright Copyright 2012 AudioTheme
 * @license   GPL-2.0+
 * @link      https://audiotheme.com/
 * @since     2.0.0
 */

/**
 * Dashboard screen class.
 *
 * @package AudioTheme\Administration
 * @since   2.0.0
 */
class AudioTheme_Screen_Dashboard extends AudioTheme_Screen_AbstractScreen {
	/**
	 * Register hooks.
	 *
	 * @since 2.0.0
	 */
	public function register_hooks() {
		add_action( 'admin_menu', array( $this, 'add_menu_item' ) );
		add_action( 'wp_ajax_audiotheme_ajax_toggle_module', array( $this, 'ajax_toggle_module' ) );
	}

	/**
	 * Add menu items.
	 *
	 * @since 2.0.0
	 */
	public function add_menu_item() {
		$page_hook = add_menu_page(
			__( 'AudioTheme', 'audiotheme' ),
			__( 'AudioTheme', 'audiotheme' ),
			'edit_posts',
			'audiotheme',
			array( $this, 'display_screen' ),
			audiotheme_encode_svg( 'admin/images/dashicons/audiotheme.svg' ),
			511
		);

		add_submenu_page(
			'audiotheme',
			__( 'Features', 'audiotheme' ),
			__( 'Features', 'audiotheme' ),
			'edit_posts',
			'audiotheme',
			array( $this, 'display_screen' )
		);

		add_action( 'load-' . $page_hook, array( $this, 'load_screen' ) );
	}

	/**
	 * Set up the main Dashboard screen.
	 *
	 * @since 2.0.0
	 */
	public function load_screen() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	/**
	 * Enqueue assets for the Dashboard screen.
	 *
	 * @since 2.0.0
	 */
	public function enqueue_assets() {
		$modules = $this->plugin->modules;

		wp_enqueue_script( 'audiotheme-dashboard' );
		wp_enqueue_style( 'audiotheme-dashboard' );

		// Hide menu items for inactive modules on initial load.
		$styles = '';
		foreach ( $modules->get_inactive_keys() as $module_id ) {
			$styles .= sprintf(
				'#%1$s, .wp-submenu > li.%1$s { display: none;}',
				$modules[ $module_id ]->admin_menu_id
			);
		}

		wp_add_inline_style( 'audiotheme-dashboard', $styles );
	}

	/**
	 * Display the screen header.
	 *
	 * @since 2.0.0
	 */
	public function display_screen_header() {
		include( $this->plugin->get_path( 'admin/views/screen-dashboard-header.php' ) );
	}

	/**
	 * Display the screen footer.
	 *
	 * @since 2.0.0
	 */
	public function display_screen_footer() {
		include( $this->plugin->get_path( 'admin/views/screen-dashboard-footer.php' ) );
	}

	/**
	 * Display the Dashboard screen.
	 *
	 * @since 2.0.0
	 */
	public function display_screen() {
		$modules = $this->plugin->modules;
		foreach ( $modules as $id => $module ) {
			if ( ! $module->show_in_dashboard() ) {
				unset( $modules[ $id ] );
			}
		}

		$this->display_screen_header();
		include( $this->plugin->get_path( 'admin/views/screen-dashboard-modules.php' ) );
		$this->display_screen_footer();
		include( $this->plugin->get_path( 'admin/views/templates-dashboard.php' ) );
	}

	/**
	 * Toggle a module's status.
	 *
	 * @since 2.0.0
	 */
	public function ajax_toggle_module() {
		if ( empty( $_POST['module'] ) ) {
			wp_send_json_error();
		}

		$module_id = $_POST['module'];

		check_ajax_referer( 'toggle-module_' . $module_id, 'nonce' );

		$modules = $this->plugin->modules;
		$module  = $modules[ $module_id ];

		if ( $module->is_active() ) {
			$modules->deactivate( $module_id );
		} else {
			$modules->activate( $module_id );
		}

		wp_send_json_success( $module->prepare_for_js() );
	}
}
