<?php
/**
 * Jetpack Compatibility File
 *
 * @package Obsidian
 * @since 1.0.0
 * @link https://jetpack.com/
 */

/**
 * Set up Jetpack theme support.
 *
 * Adds support for Infinite Scroll.
 *
 * @since 1.0.0
 */
function obsidian_jetpack_setup() {
	// Add support for Infinite Scroll
	add_theme_support( 'infinite-scroll', apply_filters( 'obsidian_infinite_scroll_args', array(
		'container'      => 'primary',
		'footer'         => 'footer',
		'footer_widgets' => 'footer-widgets',
		'render'         => 'obsidian_jetpack_infinite_scroll_render',
		'type'           => 'click',
	) ) );
}
add_action( 'after_setup_theme', 'obsidian_jetpack_setup' );

/**
 * Load required assets for Jetpack support.
 *
 * @since 1.2.0
 */
function obsidian_jetpack_enqueue_assets() {
	wp_enqueue_style(
		'obsidian-jetpack',
		get_template_directory_uri() . '/assets/css/jetpack.css',
		array( 'obsidian-style' )
	);

	wp_style_add_data( 'obsidian-jetpack', 'rtl', 'replace' );
}
add_action( 'wp_enqueue_scripts', 'obsidian_jetpack_enqueue_assets' );

if ( ! function_exists( 'obsidian_jetpack_infinite_scroll_render' ) ) :
/**
 * Callback for the Infinite Scroll module in Jetpack to render additional posts.
 *
 * @since 1.0.0
 */
function obsidian_jetpack_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'templates/parts/content', get_post_format() );
	}
}
endif;

/**
 * Infinite scroll credit text.
 *
 * @since 1.0.0
 *
 * @return string
 */
function obsidian_infinite_scroll_credit() {
	return obsidian_get_credits();
}
add_filter( 'infinite_scroll_credit', 'obsidian_infinite_scroll_credit' );
