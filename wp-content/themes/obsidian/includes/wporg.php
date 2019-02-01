<?php
/**
 * Functionality specific to self-hosted installations of WordPress, including
 * any plugin support.
 *
 * @package Obsidian
 * @since 1.0.0
 */

/**
 * Set up custom fonts for self-hosted sites.
 *
 * @since 1.1.0
 */
function obsidian_wporg_setup_custom_fonts() {
	obsidian_theme()->fonts
		->add_support()
		->register_text_groups( array(
			array(
				'id'          => 'site-title',
				'label'       => esc_html__( 'Site Title', 'obsidian' ),
				'selector'    => '.site-title',
				'family'      => 'Open Sans',
				'variations'  => '300',
				'tags'        => array( 'content', 'heading' ),
			),
			array(
				'id'          => 'site-navigation',
				'label'       => esc_html__( 'Site Navigation', 'obsidian' ),
				'selector'    => '.site-navigation, .site-navigation-toggle',
				'family'      => 'Open Sans',
				'variations'  => '400,700',
				'tags'        => array( 'content', 'heading' ),
			),
			array(
				'id'          => 'headings',
				'label'       => esc_html__( 'Headings', 'obsidian' ),
				'selector'    => 'h1, h2, h3, h4, h5, h6',
				'family'      => 'Open Sans',
				'variations'  => '300,400,700',
				'tags'        => array( 'content', 'heading' ),
			),
			array(
				'id'          => 'content',
				'label'       => esc_html__( 'Content', 'obsidian' ),
				'selector'    => 'body, button, input, select, textarea, .button, .tracklist .track:before, #infinite-handle span',
				'family'      => 'Open Sans',
				'variations'  => '400,400italic,700,700italic',
				'tags'        => array( 'content' ),
			),
		) );
}
add_action( 'after_setup_theme', 'obsidian_wporg_setup_custom_fonts' );

/**
 * Enqueue scripts and styles for front-end.
 *
 * @since 1.1.0
 */
function obsidian_wporg_enqueue_assets() {
	wp_enqueue_script(
		'jquery-fitvids', get_template_directory_uri() . '/assets/js/vendor/jquery.fitvids.js',
		array( 'jquery' ),
		'1.1',
		true
	);
}
add_action( 'wp_enqueue_scripts', 'obsidian_wporg_enqueue_assets' );

/**
 * Filter the style sheet URI to point to the parent theme when a child theme is
 * being used.
 *
 * @since 1.2.0
 *
 * @param  string $uri Style sheet URI.
 * @return string
 */
function obsidian_stylesheet_uri( $uri ) {
	return get_template_directory_uri() . '/style.css';
}
add_filter( 'stylesheet_uri', 'obsidian_stylesheet_uri' );

/**
 * Enqueue the child theme styles.
 *
 * The action priority must be set to load after any stylesheet that need to be
 * overridden in the child theme stylesheet.
 *
 * @since 1.2.0
 */
function obsidian_enqueue_child_assets() {
	if ( is_child_theme() ) {
		wp_enqueue_style( 'obsidian-child-style', get_stylesheet_directory_uri() . '/style.css' );
	}

	// Deregister old handle recommended in sample child theme.
	if ( wp_style_is( 'obsidian-parent-style', 'enqueued' ) ) {
		wp_dequeue_style( 'obsidian-parent-style' );
		wp_deregister_style( 'obsidian-parent-style' );
	}
}
add_action( 'wp_enqueue_scripts', 'obsidian_enqueue_child_assets', 20 );


/*
 * Plugin support.
 * -----------------------------------------------------------------------------
 */

/**
 * Load AudioTheme support or display a notice that it's needed.
 */
if ( function_exists( 'audiotheme_load' ) ) {
	include( get_template_directory() . '/includes/plugins/audiotheme.php' );
} else {
	include( get_template_directory() . '/includes/vendor/class-audiotheme-themenotice.php' );
	new Audiotheme_ThemeNotice();
}

/**
 * Load Jetpack support.
 */
if ( class_exists( 'Jetpack' ) ) {
	include_once( get_template_directory() . '/includes/plugins/jetpack.php' );
}

/**
 * Load WooCommerce support.
 */
if ( class_exists( 'WooCommerce' ) ) {
	include( get_template_directory() . '/includes/plugins/woocommerce.php' );
}
