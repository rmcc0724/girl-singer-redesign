<?php
/**
 * PlayBar
 *
 * @package Cedaro\PlayBar
 * @copyright Copyright (c) 2014, Cedaro
 * @license GPL-2.0+
 * @since 1.0.0
 */

/**
 * Class to manage PlayBar.
 *
 * @package Cedaro\PlayBar
 * @since 1.0.0
 */
class Cedaro_PlayBar {
	/**
	 * The base URL for PlayBar.
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $base_uri = '';

	/**
	 * WP enqueue handle for jquery-cue.
	 *
	 * @since 1.0.0
	 * @type string
	 * @todo Add a default fallback in /assets/js/.
	 */
	protected $jquery_cue_handle = '';

	/**
	 * The theme object.
	 *
	 * @since 1.0.0
	 * @type Cedaro_Theme
	 */
	protected $theme;

	/**
	 * Tracks in the playlist.
	 *
	 * @since 1.0.0
	 * @type array
	 */
	protected $tracks;

	/**
	 * Constructor method.
	 *
	 * @since 1.0.0
	 */
	public function __construct( Cedaro_Theme $theme, $args = array() ) {
		$this->theme    = $theme;
		$this->base_uri = get_template_directory_uri() . '/includes/vendor/cedaro-playbar/';

		$keys = array_keys( get_object_vars( $this ) );
		foreach ( $keys as $key ) {
			if ( isset( $args[ $key ] ) ) {
				$this->$key = $args[ $key ];
			}
		}

		$this->register_hooks();
	}

	/**
	 * Set up PlayBar's hooks.
	 *
	 * @since 1.0.0
	 */
	public function register_hooks() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action( 'customize_register', array( $this, 'customize_register' ), 15 );
	}

	/**
	 * Enqueue scripts and styles.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_assets() {
		$tracks = $this->get_tracks();

		if ( empty( $tracks ) ) {
			return;
		}

		wp_enqueue_script(
			'playbar',
			$this->get_uri( 'assets/js/playbar.js' ),
			array( $this->jquery_cue_handle ),
			'1.0.0',
			true
		);

		wp_localize_script( 'playbar', '_playbarSettings', array(
			'l10n' => array(
				'togglePlayer' => esc_html__( 'Toggle Player', 'obsidian' ),
			),
		) );

		wp_enqueue_style(
			'playbar',
			$this->get_uri( 'assets/css/playbar.css' ),
			array( 'mediaelement' ),
			'1.0.0'
		);

		add_action( 'body_class', array( $this, 'body_class' ) );
		add_action( 'wp_footer', array( $this, 'display_player' ) );
	}

	/**
	 * Add a class to the body tag when PlayBar is active.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function body_class( $classes ) {
		$classes[] = 'has-playbar';
		return $classes;
	}

	/**
	 * Display the player bar.
	 *
	 * @since 1.0.0
	 */
	public function display_player() {
		$tracks = $this->get_tracks();

		if ( empty( $tracks ) ) {
			return;
		}

		$settings = array(
			'signature' => md5( implode( ',', wp_list_pluck( $tracks, 'id' ) ) ),
			'tracks'    => $tracks,
		);

		echo '<div class="cue-playlist-container">';
		include( dirname( __FILE__ ) . '/template.php' );
		echo '<script type="application/json" class="cue-playlist-data">' . json_encode( $settings ) . '</script>';
		echo '</div>';
	}

	/**
	 * Register Customizer settings and controls.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager.
	 */
	public function customize_register( $wp_customize ) {
		$wp_customize->add_setting( 'playbar_attachment_ids', array(
			'sanitize_callback' => array( 'Cedaro_Theme_Customize_Control_Playlist', 'sanitize_id_list' ),
		) );

		$wp_customize->add_control( new Cedaro_Theme_Customize_Control_Playlist( $wp_customize, 'playbar_attachment_ids', array(
			'label'    => esc_html__( 'PlayBar Playlist', 'obsidian' ),
			'section'  => 'theme_options',
			'settings' => 'playbar_attachment_ids',
			'priority' => 50,
		) ) );
	}

	/**
	 * Retrieve PlayBar tracks.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	protected function get_tracks() {
		if ( null === $this->tracks ) {
			$this->tracks = $this->theme->template->get_tracks( 'playbar_attachment_ids' );
		}
		return $this->tracks;
	}

	/**
	 * Retrieve a uri to the PlayBar directory.
	 *
	 * @since 1.0.0
	 *
	 * @param string $path Optional. Path to append to the base URI.
	 * @return string
	 */
	protected function get_uri( $path = '' ) {
		return $this->base_uri . ltrim( $path, '/' );
	}
}
