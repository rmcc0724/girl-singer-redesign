<?php
/**
 * CueBar
 *
 * @package   CueBar
 * @copyright Copyright (c) 2014, AudioTheme, LLC
 * @license   GPL-2.0+
 * @since     1.0.0
 */

/**
 * Main plugin class.
 *
 * @package CueBar
 * @since   1.0.0
 */
class CueBar_Plugin extends CueBar_AbstractPlugin {
	/**
	 * Load the plugin.
	 *
	 * @since 1.0.0
	 */
	public function load_plugin() {
		if ( ! class_exists( 'Cue' ) ) {
			add_action( 'admin_notices', array( $this, 'display_cue_required_notice' ) );
			return;
		}

		add_action( 'init', array( $this, 'attach_hooks' ) );
	}

	/**
	 * Set up the plugin's hooks.
	 *
	 * @since 1.0.0
	 */
	public function attach_hooks() {
		add_filter( 'cue_players',           array( $this, 'register_players' ) );
		add_filter( 'cue_template_paths',    array( $this, 'register_template_path' ) );
		add_filter( 'cue_playlist_settings', array( $this, 'playlist_settings' ), 10, 3 );
		add_action( 'wp_enqueue_scripts',    array( $this, 'enqueue_assets' ) );
		add_action( 'wp_footer',             array( $this, 'display_player' ) );
	}

	/**
	 * Enqueue scripts and styles.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_assets() {
		$playlist_id = get_cue_player_playlist_id( 'cuebar' );
		if ( empty( $playlist_id ) ) {
			return;
		}

		wp_enqueue_script(
			'cuebar',
			$this->get_url( 'assets/js/cuebar.js' ),
			array( 'jquery-cue' ),
			'1.0.1',
			true
		);

		wp_localize_script( 'cuebar', '_cuebarSettings', array(
			'l10n' => array(
				'togglePlayer' => __( 'Toggle Player', 'cuebar' ),
			),
		) );

		wp_enqueue_style(
			'cuebar',
			$this->get_url( 'assets/css/cuebar.min.css' ),
			array( 'mediaelement' ),
			'1.0.0'
		);

		wp_style_add_data( 'cuebar', 'rtl', 'replace' );
		wp_style_add_data( 'cuebar', 'suffix', '.min' );

		add_action( 'body_class', array( $this, 'body_class' ) );
	}

	/**
	 * Add a class to the body tag when PlayBar is active.
	 *
	 * @since 1.1.0
	 *
	 * @return array
	 */
	public function body_class( $classes ) {
		$classes[] = 'has-cuebar';
		return $classes;
	}

	/**
	 * Register the CueBar player.
	 *
	 * @since 1.0.0
	 *
	 * @param array $players List of registered players.
	 * @return array
	 */
	public function register_players( $players ) {
		$players['cuebar'] = esc_html__( 'CueBar', 'cuebar' );
		return $players;
	}

	/**
	 * Add the local templates directory as a valid template path.
	 *
	 * @since 1.0.0
	 *
	 * @param array $paths List of template directories.
	 * @return array
	 */
	public function register_template_path( $paths ) {
		$paths[90] = $this->get_path( 'templates' );
		return $paths;
	}

	/**
	 * Filter the playlist settings.
	 *
	 * Adds the playlist post modified date to use a signature so the history
	 * cache can be cleared when there are changes to the playlist.
	 *
	 * @since 1.0.0
	 *
	 * @param array $settings Playlist settings.
	 * @param int $playlist Playlist post ID.
	 * @param array $args Original playlist args.
	 * @return array
	 */
	public function playlist_settings( $settings, $playlist = 0, $args = array() ) {
		if ( isset( $args['player'] ) && 'cuebar' == $args['player'] ) {
			$settings['signature'] = preg_replace( '/[^\d]+/', '', get_post( $playlist )->post_modified );
		}
		return $settings;
	}

	/**
	 * Display the player bar.
	 *
	 * @since 1.0.0
	 */
	public function display_player() {
		cue_player( 'cuebar' );
	}

	/**
	 * Display a notice that Cue is required.
	 *
	 * @since 1.0.0
	 */
	public function display_cue_required_notice() {
		global $pagenow;

		// Don't show the notice when Cue is being installed.
		if ( 'update.php' == $pagenow ) {
			return;
		}

		$is_cue_installed = 0 === validate_plugin( 'cue/cue.php' );
		?>
		<div class="error">
			<p>
				<?php
				if ( $is_cue_installed && current_user_can( 'activate_plugins' ) ) {
					$activate_url = wp_nonce_url(
						self_admin_url( 'plugins.php?action=activate&amp;plugin=cue/cue.php' ),
						'activate-plugin_cue/cue.php'
					);

					printf( '%s <a href="%s"><strong>%s</strong></a>',
						esc_html__( 'CueBar requires Cue to be activated.', 'cuebar' ),
						esc_url( $activate_url ),
						esc_html__( 'Activate Now', 'cuebar' )
					);
				} elseif ( current_user_can( 'install_plugins' ) ) {
					$install_url = wp_nonce_url(
						self_admin_url( 'update.php?action=install-plugin&amp;plugin=cue' ),
						'install-plugin_cue'
					);

					printf( '%s <a href="%s"><strong>%s</strong></a>',
						esc_html__( 'CueBar requires Cue to be installed and activated.', 'cuebar' ),
						esc_url( $install_url ),
						esc_html__( 'Install Now', 'cuebar' )
					);
				}
				?>
			</p>
		</div>
		<?php
	}
}
