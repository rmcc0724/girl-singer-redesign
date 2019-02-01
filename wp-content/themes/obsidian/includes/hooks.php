<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * @package Obsidian
 * @since 1.0.0
 */

/**
 * Register template parts to load throughout the theme.
 *
 * Take note of the priorities. Changing them will allow template parts to be
 * loaded in a different order.
 *
 * To remove any of these parts, use remove_action() in the
 * "obsidian_register_template_parts" hook or later.
 *
 * @since 1.0.0
 */
function obsidian_register_template_parts() {
	// Inject the background overlay.
	add_action( 'obsidian_before', 'obsidian_background_overlay' );

	// Load the home widgets area on the front page.
	if ( is_front_page() ) {
		add_action( 'obsidian_content_bottom', 'obsidian_front_page_sidebar' );
	}

	// Load the archive page header on singular pages that are not a page.
	if ( is_singular() && ! is_page() ) {
		add_action( 'obsidian_main_top', 'obsidian_archive_title' );
	}

	do_action( 'obsidian_register_template_parts' );
}
add_action( 'template_redirect', 'obsidian_register_template_parts', 9 );

/**
 * Add classes to the 'body' element.
 *
 * @since 1.0.0
 *
 * @param array $classes Default classes.
 * @return array
 */
function obsidian_body_class( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'full-screen-header';
	}

	// Center content on pages that can show the main sidebar, but the sidebar
	// is not active.
	if ( ! is_active_sidebar( 'sidebar-1' ) && obsidian_has_main_sidebar() ) {
		$classes[] = 'layout-content';
	}

	if ( is_404() || is_page_template( 'templates/no-sidebar.php' ) ) {
		$classes[] = 'layout-content';
	}

	if ( obsidian_is_full_width_layout() ) {
		$classes[] = 'layout-full';
	}

	if ( get_theme_mod( 'enable_full_size_background_image' ) ) {
		$classes[] = 'background-cover';
	}

	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Remove custom background class if there is not a custom color or image.
	if ( '000000' === get_background_color() && false === get_background_image() ) {
		$classes[] = 'no-custom-background';
		$classes = array_diff( $classes, array( 'custom-background' ) );
	}

	return array_unique( $classes );
}
add_filter( 'body_class', 'obsidian_body_class' );

/**
 * Add an image itemprop attribute to image attachments.
 *
 * @since 1.1.0
 *
 * @param  array $attr Attributes for the image markup.
 * @return array
 */
function obsidian_attachment_image_attributes( $attr ) {
	$attr['itemprop'] = 'image';
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'obsidian_attachment_image_attributes' );

/**
 * Filter the archive title based on the queried object.
 *
 * @since 1.0.0
 *
 * @param string $title Archive title.
 * @return string
 */
function obsidian_get_the_archive_title( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif ( is_year() ) {
		$title = get_the_date( 'Y' );
	} elseif ( is_month() ) {
		$title = get_the_date( 'F Y' );
	} elseif ( is_day() ) {
		$title = get_the_date( 'F j, Y' );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	}

	return $title;
}
add_filter( 'get_the_archive_title', 'obsidian_get_the_archive_title' );

/**
 * Filter the archive title for singlular page archive link titles.
 *
 * @since 1.0.0
 *
 * @param string $title Archive title to be displayed.
 */
function obsidian_singular_archive_title( $title ) {

	if ( is_singular() ) {
		$title = get_post_type_object( get_post()->post_type )->label;
	}

	return $title;
}
add_filter( 'get_the_archive_title', 'obsidian_singular_archive_title' );

/**
 * Filter the archive title for the to display posts page title when set.
 *
 * @since 1.0.0
 *
 * @param string $title Archive title to be displayed.
 */
function obsidian_posts_page_archive_title( $title ) {
	if ( is_home() ) {
		$title = esc_html__( 'Posts', 'obsidian' );
	}

	if ( 'page' === get_option( 'show_on_front' ) ) {
		if ( is_front_page() ) {
			$post_id = (int) get_option( 'page_on_front' );
			$title   = get_the_title( $post_id );
		} elseif ( is_home() || is_singular( 'post' ) ) {
			$post_id = (int) get_option( 'page_for_posts' );
			$title   = get_the_title( $post_id );
		}
	}

	return $title;
}
add_filter( 'get_the_archive_title', 'obsidian_posts_page_archive_title' );
