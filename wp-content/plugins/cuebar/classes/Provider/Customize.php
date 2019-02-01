<?php
/**
 * Customizer integration.
 *
 * @package   CueBar
 * @copyright Copyright (c) 2014, AudioTheme, LLC
 * @license   GPL-2.0+
 * @since     1.3.0
 */

/**
 * Customizer integration class.
 *
 * @package CueBar
 * @since   1.3.0
 */
class CueBar_Provider_Customize extends CueBar_AbstractProvider {
	/**
	 * Register hooks.
	 *
	 * @since 1.3.0
	 */
	public function register_hooks() {
		add_action( 'wp_head',                                 array( $this, 'add_inline_css' ) );
		add_action( 'admin_enqueue_scripts',                   array( $this, 'register_assets' ), 8 );
		add_action( 'wp_enqueue_scripts',                      array( $this, 'register_assets' ), 8 );
		add_action( 'customize_register',                      array( $this, 'customize_register' ), 15 );
		add_action( 'customize_preview_init',                  array( $this, 'enqueue_customizer_preview_assets' ) );
		add_action( 'customize_controls_enqueue_scripts',      array( $this, 'enqueue_customizer_controls_assets' ) );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'print_styles_template' ) );

		if ( is_customize_preview() ) {
			add_action( 'wp_footer', array( $this, 'print_styles_template' ) );
		}
	}

	/**
	 * Register scripts and styles.
	 *
	 * @since 1.3.0
	 */
	public function register_assets() {
		wp_register_script(
			'cuebar-customize-helpers',
			$this->plugin->get_url( 'assets/js/customize-helpers.js' ),
			array( 'wp-util' ),
			'1.3.0',
			true
		);
	}

	/**
	 * Add custom CSS to the document head.
	 *
	 * @since 1.1.0
	 */
	public function add_inline_css() {
		if ( ! function_exists( 'get_cue_player_playlist_id' ) ) {
			return;
		}

		if ( '#14181a' == $this->get_color( 'player', '#14181a' ) ) {
			return;
		}

		$playlist_id = get_cue_player_playlist_id( 'cuebar' );
		if ( empty( $playlist_id ) ) {
			return;
		}

		$css = preg_replace( '/[\s]{2,}/', '', $this->get_css() );
		printf( "<style id='cuebar-custom-css' type='text/css'>\n%s\n</style>\n", $css );
	}

	/**
	 * Register Customizer settings and controls.
	 *
	 * @since 1.3.0
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager.
	 */
	public function customize_register( $wp_customize ) {
		$wp_customize->get_control( 'cue_player_cuebar' )->label    = esc_html__( 'CueBar Playlist', 'cuebar' );
		$wp_customize->get_control( 'cue_player_cuebar' )->priority = 50;

		// Can't sanitize CSS, so return an empty string.
		$wp_customize->add_setting( 'cuebar_styles', array(
			'default'           => '',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => '__return_empty_string',
			'transport'         => 'postMessage',
			'type'              => 'option',
		) );

		$wp_customize->add_setting( 'cuebar_colors[alt_background]', array(
			'default'           => 'rgba(255, 255, 255, 0.2)',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => array( $this, 'sanitize_rgba' ),
			'transport'         => 'postMessage',
			'type'              => 'option',
		) );

		$wp_customize->add_setting( 'cuebar_colors[contrast]', array(
			'default'           => 'white',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
			'type'              => 'option',
		) );

		$wp_customize->add_setting( 'cuebar_colors[loaded_bar]', array(
			'default'           => 'rgba(255, 255, 255, 0.05)',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => array( $this, 'sanitize_rgba' ),
			'transport'         => 'postMessage',
			'type'              => 'option',
		) );

		$wp_customize->add_setting( 'cuebar_colors[play_bar]', array(
			'default'           => 'rgba(255, 255, 255, 0.15)',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => array( $this, 'sanitize_rgba' ),
			'transport'         => 'postMessage',
			'type'              => 'option',
		) );

		$wp_customize->add_setting( 'cuebar_colors[player]', array(
			'default'           => '#14181a',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
			'type'              => 'option',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cuebar_player_color', array(
			'label'    => esc_html__( 'CueBar Color' ),
			'section'  => 'cue',
			'settings' => 'cuebar_colors[player]',
			'type'     => 'color',
			'priority' => 51,
		) ) );
	}

	/**
	 * Enqueue scripts to display in the Customizer preview.
	 *
	 * @since 1.3.0
	 */
	public function enqueue_customizer_preview_assets() {
		wp_enqueue_script(
			'cuebar-customize-preview',
			$this->plugin->get_url( 'assets/js/customize-preview.js' ),
			array( 'cuebar-customize-helpers', 'customize-preview', 'underscore', 'wp-util' ),
			'1.3.0',
			true
		);
	}

	/**
	 * Enqueue scripts to display in the Customizer preview.
	 *
	 * @since 1.3.0
	 */
	public function enqueue_customizer_controls_assets() {
		wp_enqueue_script(
			'cuebar-customize-controls',
			$this->plugin->get_url( 'assets/js/customize-controls.js' ),
			array( 'cuebar-customize-helpers', 'customize-controls', 'underscore' ),
			'1.3.0',
			true
		);
	}

	/**
	 * Print JavaScript templates in the Customizer footer.
	 *
	 * @since 1.3.0
	 */
	public function print_styles_template() {
		$colors = array(
			'alt_background' => '{{ data.altBackgroundColor }}',
			'contrast'       => '{{ data.contrastColor }}',
			'loaded_bar'     => '{{ data.loadedBarColor }}',
			'play_bar'       => '{{ data.playBarColor }}',
			'player'         => '{{ data.playerColor }}',
		);
		?>
		<script type="text/html" id="tmpl-cuebar-styles">
		<?php
		echo $this->get_css( $colors );
		do_action( 'cuebar_styles' );
		?>
		</script>
		<?php
	}

	/**
	 * Sanitize a CSS RGBA color.
	 *
	 * @since 1.1.0
	 *
	 * @param string $value String to sanitize.
	 * @return string
	 */
	public function sanitize_rgba( $value ) {
		if ( ! preg_match( '|^rgba?\(\s*(?:(\d{1,3})\s*,?\s*){3}(:?,\s?[0-1]?\.?[0-9]+)?\s*\)$|', $value ) ) {
			$value = '';
		}
		return $value;
	}

	/**
	 * Retrieve the value for a color.
	 *
	 * @since 1.1.0
	 *
	 * @param string $key Color key.
	 * @param string $default Default value.
	 * @return string
	 */
	protected function get_color( $key, $default = '' ) {
		$colors = get_option( 'cuebar_colors', array() );
		return empty( $colors[ $key ] ) ? $default : $colors[ $key ];
	}

	/**
	 * Retrieve CSS.
	 *
	 * @since 1.1.0
	 *
	 * @param array $colors Color values to insert in the template.
	 * @return string
	 */
	protected function get_css( $colors = array() ) {
		$colors = wp_parse_args( $colors, array(
			'alt_background' => $this->get_color( 'alt_background', 'rgba(255, 255, 255, 0.2)' ),
			'contrast'       => $this->get_color( 'contrast',       '#ffffff' ),
			'loaded_bar'     => $this->get_color( 'loaded_bar',     'rgba(255, 255, 255, 0.05)' ),
			'play_bar'       => $this->get_color( 'play_bar',       'rgba(255, 255, 255, 0.15)' ),
			'player'         => $this->get_color( 'player',         '#14181a' ),
		) );

		$css = <<<CSS
.cuebar,
.cuebar .cue-skin-cuebar.mejs-container .mejs-controls .mejs-volume-button .mejs-volume-slider {
	background-color: {$colors['player']};
}

.cuebar .cue-skin-cuebar.mejs-container .mejs-controls {
	border-color: {$colors['player']};
}

.cuebar .cue-skin-cuebar.mejs-container .mejs-controls .mejs-next-button button,
.cuebar .cue-skin-cuebar.mejs-container .mejs-controls .mejs-playpause-button button,
.cuebar .cue-skin-cuebar.mejs-container .mejs-controls .mejs-previous-button button,
.cuebar .cue-skin-cuebar.mejs-container .mejs-controls .mejs-toggle-player-button button,
.cuebar .cue-skin-cuebar.mejs-container .mejs-controls .mejs-toggle-playlist-button button,
.cuebar .cue-skin-cuebar.mejs-container .mejs-controls .mejs-volume-button button,
.cuebar .cue-skin-cuebar.mejs-container .mejs-layers,
.cuebar .cue-skin-cuebar.mejs-container .mejs-controls .mejs-time span {
	color: {$colors['contrast']};
}

.cuebar .cue-skin-cuebar.mejs-container .mejs-controls .mejs-volume-button .mejs-volume-slider .mejs-volume-current,
.cuebar .cue-skin-cuebar.mejs-container .mejs-controls .mejs-volume-button .mejs-volume-slider .mejs-volume-handle {
	background-color: {$colors['contrast']};
}

.cuebar .cue-skin-cuebar.mejs-container .mejs-controls .mejs-toggle-player-button,
.cuebar .cue-skin-cuebar.mejs-container .mejs-controls .mejs-volume-button .mejs-volume-slider .mejs-volume-total {
	background-color: {$colors['alt_background']};
}

.cuebar .cue-skin-cuebar.mejs-container .mejs-controls .mejs-time-rail .mejs-time-current {
	background-color: {$colors['play_bar']};
}

.cuebar .cue-skin-cuebar.mejs-container .mejs-controls .mejs-time-rail .mejs-time-loaded {
	background-color: {$colors['loaded_bar']};
}
CSS;

		return $css;
	}
}
