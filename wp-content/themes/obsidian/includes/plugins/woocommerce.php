<?php
/**
 * WooCommerce Compatibility File
 *
 * @package Obsidian
 * @since 1.0.0
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 */

/**
 * Set up WooCommerce theme support.
 *
 * @since 1.0.0
 */
function obsidian_woocommerce_setup() {
	add_theme_support( 'woocommerce' );

	// Disable the page title for the catalog and product archive pages.
	add_filter( 'woocommerce_show_page_title', '__return_false' );
}
add_action( 'after_setup_theme', 'obsidian_woocommerce_setup', 11 );

/**
 * Filter the sidebar status for WooCommerce pages.
 *
 * @since 1.0.0
 *
 * @param bool $is_active_sidebar Whether the sidebar is active.
 * @param string $index The sidebar id.
 * @return bool
 */
function obsidian_woocommerce_sidebar_status( $is_active_sidebar, $index ) {
	if ( 'sidebar-1' !== $index || ! $is_active_sidebar ) {
		return $is_active_sidebar;
	}

	if ( is_shop() || is_singular( 'product' ) ) {
		$is_active_sidebar = false;
	}

	return $is_active_sidebar;
}
add_filter( 'is_active_sidebar', 'obsidian_woocommerce_sidebar_status', 10, 2 );


/*
 * Plugin hooks.
 * -----------------------------------------------------------------------------
 */

/**
 * Remove the default WooCommerce content wrappers.
 *
 * @since 1.0.0
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );

/**
 * Print the default theme content open tag.
 *
 * Wraps WooCommerce content with the same elements used throughout the theme.
 *
 * @since 1.0.0
 */
function obsidian_woocommerce_before_main_content() {
	echo '<main id="primary" class="content-area" role="main" itemprop="mainContentOfPage">';
	do_action( 'obsidian_main_top' );
}
add_action( 'woocommerce_before_main_content', 'obsidian_woocommerce_before_main_content' );

/**
 * Print the default theme content wrapper close tag.
 *
 * @since 1.0.0
 */
function obsidian_woocommerce_after_main_content() {
	do_action( 'obsidian_main_bottom' );
	echo '</main>';
}
add_action( 'woocommerce_after_main_content', 'obsidian_woocommerce_after_main_content' );


/*
 * Theme hooks.
 * -----------------------------------------------------------------------------
 */

/**
 * Register template parts to load throughout the theme.
 *
 * @since 1.0.0
 */
function obsidian_woocomerce_singular_page_header() {
	if ( is_shop() ) {
		add_action( 'obsidian_main_top', 'obsidian_archive_title' );
	}
}
add_action( 'obsidian_register_template_parts', 'obsidian_woocomerce_singular_page_header' );

/**
 * Set shop pages to be full width.
 *
 * @since 1.0.0
 */
function obsidian_woocommerce_is_full_width_layout( $is_full_width ) {
	if ( is_shop() || is_singular( 'product' ) ) {
		$is_full_width = true;
	}

	return $is_full_width;
}
add_filter( 'obsidian_is_full_width_layout', 'obsidian_woocommerce_is_full_width_layout' );

/**
 * Filter the section title on WooCommerce pages.
 *
 * @since 1.0.0
 *
 * @param string $title Section title.
 * @return string
 */
function obsidian_woocommerce_shop_page_header_titles( $title ) {
	if ( is_shop() ) {
		$title = woocommerce_page_title( false );
	}

	return $title;
}
add_filter( 'get_the_archive_title', 'obsidian_woocommerce_shop_page_header_titles' );
