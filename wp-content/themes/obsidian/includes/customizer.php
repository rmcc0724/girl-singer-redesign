<?php
/**
 * Customizer
 *
 * @package Obsidian
 * @since 1.0.0
 */

/**
 * Add settings to the Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function obsidian_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	$wp_customize->add_section( 'theme_options', array(
		'title'    => esc_html__( 'Theme Options', 'obsidian' ),
		'priority' => 120,
	) );

	$wp_customize->add_setting( 'front_page_logo_url', array(
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'obsidian_front_page_logo', array(
		'label'           => esc_html__( 'Front Page Logo', 'obsidian' ),
		'description'     => '',
		'section'         => 'title_tagline',
		'settings'        => 'front_page_logo_url',
		'priority'        => 5,
		'active_callback' => 'is_front_page',
	) ) );

	$wp_customize->add_setting( 'background_overlay_opacity', array(
		'capability'        => 'edit_theme_options',
		'default'           => 80,
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'obsidian_background_overlay_opacity', array(
		'label'       => esc_html__( 'Background Overlay Opacity', 'obsidian' ),
		'description' => esc_html__( 'Applies background color over the image.', 'obsidian' ),
		'section'     => 'background_image',
		'settings'    => 'background_overlay_opacity',
		'type'        => 'range',
		'priority'    => 15,
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 95,
			'step'  => 5,
			'style' => 'width: 100%',
		),
	) );

	$wp_customize->add_setting( 'enable_full_size_background_image', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'obsidian_customize_sanitize_checkbox',
		'transport'         => 'postMessage',
	) );

	// WP 4.7 includes a new 'size' control. This needs to be kept for backward compatibility.
	if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
		$wp_customize->add_control( 'obsidian_enable_full_size_background_image', array(
			'label'    => esc_html__( 'Enable full-width background image.', 'obsidian' ),
			'section'  => 'background_image',
			'settings' => 'enable_full_size_background_image',
			'type'     => 'checkbox',
			'priority' => 15,
		) );
	}
}
add_action( 'customize_register', 'obsidian_customize_register' );

/**
 * Bind JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since 1.0.0
 */
function obsidian_customize_preview_assets() {
	wp_enqueue_script(
		'obsidian-customize-preview',
		get_template_directory_uri() . '/assets/js/customize-preview.js',
		array( 'customize-preview', 'underscore' ),
		'20150213',
		true
	);
}
add_action( 'customize_preview_init', 'obsidian_customize_preview_assets', 15 );

/**
 * Enqueue scripts for the Customizer.
 *
 * @since 1.0.0
 */
function obsidian_customize_enqueue_controls_assets() {
	wp_enqueue_script(
		'obsidian-customize-controls',
		get_template_directory_uri() . '/assets/js/customize-controls.js',
		array( 'customize-controls', 'underscore' ),
		'20150325',
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'obsidian_customize_enqueue_controls_assets' );

/**
 * Register default values for custom CSS.
 *
 * @since 1.1.0
 */
function obsidian_customize_get_default_css_values() {
	$values = array(
		'background_color'           => get_theme_support( 'custom-background', 'default-color' ),
		'background_image'           => get_theme_support( 'custom-background', 'default-image' ),
		'background_overlay_opacity' => 50,
		'background_position_x'      => get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) ),
		'background_position_y'      => get_theme_mod( 'background_position_y', get_theme_support( 'custom-background', 'default-position-y' ) ),
	);

	if ( ! in_array( $values['background_position_x'], array( 'left', 'center', 'right' ), true ) ) {
		$values['background_position_x'] = 'center';
	}

	if ( ! in_array( $values['background_position_y'], array( 'top', 'center', 'bottom' ), true ) ) {
		$values['background_position_y'] = 'center';
	}

	return $values;
}

/**
 * Print an Underscore template with CSS to generate based on options
 * selected in the Customizer.
 *
 * @since 1.1.0
 */
function obsidian_customize_styles_template() {
	if ( ! is_customize_preview() ) {
		return;
	}

	$values = array(
		'background_color'           => '{{ data.backgroundColor }}',
		'background_image'           => '{{ data.backgroundImage }}',
		'background_overlay_opacity' => '{{ data.backgroundOverlayOpacity }}',
		'background_position_x'      => '{{ data.backgroundPositionX }}',
		'background_position_y'      => '{{ data.backgroundPositionY }}',
	);

	printf(
		'<script type="text/html" id="tmpl-obsidian-customizer-styles">%s</script>',
		obsidian_get_custom_css( $values )
	);
}
add_action( 'wp_footer', 'obsidian_customize_styles_template' );

/**
 * Enqueue front-end CSS for custom colors.
 *
 * @since 1.1.0
 *
 * @see WP_Styles::print_inline_style()
 */
function obsidian_customize_add_inline_css() {
	$css = preg_replace( '/[\s]{2,}/', '', obsidian_get_custom_css() );
	printf( "<style id='obsidian-custom-css' type='text/css'>\n%s\n</style>\n", $css ); // WPCS: XSS OK.
}
add_action( 'wp_head', 'obsidian_customize_add_inline_css', 11 );

/**
 * Retrieve CSS rules for implementing custom colors.
 *
 * @since 1.1.0
 *
 * @param array $colors Optional. An array of colors.
 * @return string
 */
function obsidian_get_custom_css( $values = array() ) {
	$css      = '';
	$defaults = obsidian_customize_get_default_css_values();

	$values = wp_parse_args( $values, array(
		'background_color'           => get_background_color() ? '#' . get_background_color() : '',
		'background_image'           => get_background_image(),
		'background_overlay_opacity' => get_theme_mod( 'background_overlay_opacity', $defaults['background_overlay_opacity'] ),
		'background_position_x'      => $defaults['background_position_x'],
		'background_position_y'      => $defaults['background_position_y'],
	) );

	// Normalize the opacity value.
	$opacity = $values['background_overlay_opacity'];
	$values['background_overlay_opacity'] = is_numeric( $opacity ) ? $opacity / 100 : $opacity;

	$css = obsidian_get_background_overlay_css( $values );

	return $css;
}

/**
 * Get background overlay CSS.
 *
 * @since 1.1.0
 *
 * @param  array $values CSS values.
 * @return string
 */
function obsidian_get_background_overlay_css( $values ) {
	$css = <<<CSS
	.obsidian-background-overlay:before {
		background-color: {$values['background_color']};
		opacity: {$values['background_overlay_opacity']};
	}

	.background-cover .obsidian-background-overlay {
		background-image: url("{$values['background_image']}");
		background-position: {$values['background_position_x']} {$values['background_position_y']};
	}
CSS;

	return $css;
}

/**
 * Sanitization callback for checkbox controls in the Customizer.
 *
 * @since 1.0.0
 *
 * @param string $value Setting value.
 * @return string 1 if checked, empty string otherwise.
 */
function obsidian_customize_sanitize_checkbox( $value ) {
	return empty( $value ) || ! $value ? '' : '1';
}

/**
 * Sanitization callback for content display in the Customizer.
 *
 * @since 1.0.0
 *
 * @param string $value Setting value.
 * @return string Empty by default, value string otherwise.
 */
function obsidian_customize_sanitize_content_display( $value ) {
	if ( ! in_array( $value, array( 'site', 'page' ) ) ) {
		$value = 'site';
	}

	return $value;
}

/**
 * Sanitize callback for layout settings in the Customizer.
 *
 * @since 1.3.2
 *
 * @param string $value Setting value.
 * @return string (menu_order|date|title).
 */
function obsidian_customize_sanitize_page_type_order( $value ) {
	if ( ! in_array( $value, array( 'menu_order', 'date', 'title' ), true ) ) {
		$value = 'menu_order';
	}

	return $value;
}
