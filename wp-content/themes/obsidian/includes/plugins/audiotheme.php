<?php
/**
 * AudioTheme Compatibility File
 *
 * @package Obsidian
 * @since 1.0.0
 * @link https://audiotheme.com/
 */

/**
 * Set up theme defaults and register support for AudioTheme features.
 *
 * @since 1.0.0
 */
function obsidian_audiotheme_setup() {
	// Add AudioTheme automatic updates support
	add_theme_support( 'audiotheme-automatic-updates' );

	// Register nav menus.
	register_nav_menus( array(
		'audiotheme_gig'    => esc_html__( 'Gigs Menu', 'obsidian' ),
		'audiotheme_record' => esc_html__( 'Records Menu', 'obsidian' ),
		'audiotheme_video'  => esc_html__( 'Videos Menu', 'obsidian' ),
	) );

	// Add support for AudioTheme widgets.
	add_theme_support( 'audiotheme-widgets', array(
		'recent-posts', 'record', 'track', 'upcoming-gigs', 'video',
	) );
}
add_action( 'after_setup_theme', 'obsidian_audiotheme_setup', 11 );

/**
 * Unregister default widgets.
 *
 * The default recent posts widget is replaced by a similar widget from
 * AudioTheme using the same identifier so that settings can be  migrated while
 * switching between them.
 *
 * @since 1.0.0
 */
function obsidian_audiotheme_unregister_widgets() {
	unregister_widget( 'WP_Widget_Recent_Posts' );
}
add_action( 'widgets_init', 'obsidian_audiotheme_unregister_widgets' );

/**
 * Load required scripts for AudioTheme support.
 *
 * @since 1.0.0
 */
function obsidian_audiotheme_enqueue_assets() {
	wp_enqueue_style(
		'obsidian-audiotheme',
		get_template_directory_uri() . '/assets/css/audiotheme.css',
		array( 'obsidian-style' )
	);

	wp_style_add_data( 'obsidian-audiotheme', 'rtl', 'replace' );

	if ( in_array( get_post_type(), array( 'audiotheme_record', 'audiotheme_track' ) ) ) {
		wp_enqueue_script( 'obsidian-cue' );
	}
}
add_action( 'wp_enqueue_scripts', 'obsidian_audiotheme_enqueue_assets' );

/**
 * Add classes to the <body> element.
 *
 * @since 1.0.0
 *
 * @param array $classes Default classes.
 * @return array
 */
function obsidian_audiotheme_body_class( $classes ) {
	if (
		is_audiotheme_post_type_archive() ||
		is_tax( array( 'audiotheme_record_type', 'audiotheme_video_category' ) )
	) {
		$classes[] = 'layout-full';
	}

	if ( is_singular( array( 'audiotheme_record', 'audiotheme_track', 'audiotheme_gig' ) ) ) {
		$classes[] = 'layout-sidebar-content';
	}

	return $classes;
}
add_filter( 'body_class', 'obsidian_audiotheme_body_class' );

/**
 * Add additional HTML classes to posts.
 *
 * @since 1.0.0
 *
 * @param array $classes List of HTML classes.
 * @return array
 */
function obsidian_audiotheme_post_class( $classes ) {
	if ( is_singular( array( 'audiotheme_record', 'audiotheme_track', 'audiotheme_gig' ) ) ) {
		$classes[] = 'has-entry-sidebar';
	}

	return array_unique( $classes );
}
add_filter( 'post_class', 'obsidian_audiotheme_post_class', 10 );

/**
 * Set single audiotheme page titles.
 *
 * Singular page titles are output via an action in
 * obsidian_register_template_parts().
 *
 * @since  1.0.0
 *
 * @param string Archive title.
 */
function obsidian_audiotheme_single_page_titles( $title ) {
	// Use parent record title for track page titles.
	if ( is_singular( 'audiotheme_track' ) ) {
		$title = get_the_title( get_post()->post_parent );
	}
	// Use AudioTheme archive page titles for singluar gigs, records, and videos.
	elseif (
		is_singular( array( 'audiotheme_gig', 'audiotheme_record', 'audiotheme_video' ) ) &&
		$page_id = get_audiotheme_post_type_archive( get_post_type() )
	) {
		$title = get_post( $page_id )->post_title;
	}

	return $title;
}
add_filter( 'get_the_archive_title', 'obsidian_audiotheme_single_page_titles' );


/*
 * Plugin hooks.
 * -----------------------------------------------------------------------------
 */

/**
 * Activate default archive setting fields.
 *
 * @since 1.0.0
 *
 * @param array $fields List of default fields to activate.
 * @param string $post_type Post type archive.
 * @return array
 */
function obsidian_audiotheme_archive_settings_fields( $fields, $post_type ) {
	if ( ! in_array( $post_type, array( 'audiotheme_record', 'audiotheme_video' ) ) ) {
		return $fields;
	}

	if ( 'audiotheme_record' === $post_type ) {
		$fields['columns'] = array(
			'choices' => range( 3, 4 ),
			'default' => 3,
		);
	}

	if ( 'audiotheme_video' === $post_type ) {
		$fields['columns'] = array(
			'choices' => range( 2, 3 ),
			'default' => 3,
		);
	}

	$fields['posts_per_archive_page'] = true;

	return $fields;
}
add_filter( 'audiotheme_archive_settings_fields', 'obsidian_audiotheme_archive_settings_fields', 10, 2 );

/**
 * Modify post type support for the AudioTheme Recent Posts widget.
 *
 * @since 1.0.0
 *
 * @param array $post_types Allowed post type objects.
 * @return array Array of supported post type objects.
 */
function obsidian_audiotheme_widget_recent_posts_post_types( $post_types ) {
	$post_types = array(
		'post'              => get_post_type_object( 'post' ),
		'audiotheme_record' => get_post_type_object( 'audiotheme_record' ),
		'audiotheme_video'  => get_post_type_object( 'audiotheme_video' ),
	);

	return $post_types;
}
add_filter( 'audiotheme_widget_recent_posts_post_types', 'obsidian_audiotheme_widget_recent_posts_post_types' );
add_filter( 'audiotheme_widget_recent_posts_show_post_type_dropdown', '__return_true' );

/**
 * Adjust AudioTheme widget image sizes.
 *
 * @since 1.0.0
 *
 * @param string|array Image size.
 * @return array
 */
function obsidian_audiotheme_widget_image_size( $size ) {
	return array( 680, 680 ); // sidebar width x 2
}
add_filter( 'audiotheme_widget_record_image_size', 'obsidian_audiotheme_widget_image_size' );
add_filter( 'audiotheme_widget_track_image_size', 'obsidian_audiotheme_widget_image_size' );
add_filter( 'audiotheme_widget_video_image_size', 'obsidian_audiotheme_widget_image_size' );


/*
 * Supported plugin hooks.
 * -----------------------------------------------------------------------------
 */

/**
 * Disable Jetpack Infinite Scroll on AudioTheme post types.
 *
 * @since 1.0.0
 *
 * @param bool $supported Whether Infinite Scroll is supported for the current request.
 * @return bool
 */
function obsidian_audiotheme_infinite_scroll_archive_supported( $supported ) {
	$post_type = get_post_type() ? get_post_type() : get_query_var( 'post_type' );

	if ( $post_type && is_string( $post_type ) && false !== strpos( $post_type, 'audiotheme_' ) ) {
		$supported = false;
	}

	return $supported;
}
add_filter( 'infinite_scroll_archive_supported', 'obsidian_audiotheme_infinite_scroll_archive_supported' );


/*
 * Theme hooks.
 * -----------------------------------------------------------------------------
 */

/**
 * Add classes to archive block grids.
 *
 * @since 1.0.0
 *
 * @param array $classes List of HTML classes.
 * @return array
 */
function obsidian_audiotheme_archive_block_grid_classes( $classes ) {
	if (
		is_post_type_archive( array( 'audiotheme_record', 'audiotheme_video' ) ) ||
		is_tax( array( 'audiotheme_record_type', 'audiotheme_video_category' ) )
	) {
		$classes[] = 'block-grid-' . get_audiotheme_archive_meta( 'columns', true, 3 );
	}

	return $classes;
}
add_filter( 'obsidian_block_grid_classes', 'obsidian_audiotheme_archive_block_grid_classes' );

/**
 * Don't display sidebar on AudioTheme gig date archives.
 *
 * @since  1.0.0
 *
 * @param  bool $show_sidebar Can this page show the main sidebar if available?
 * @return bool
 */
function obsidian_audiotheme_has_main_sidebar( $show_sidebar ) {
	if ( is_post_type_archive( 'audiotheme_gig' ) ) {
		$show_sidebar = false;
	}

	return $show_sidebar;
}
add_filter( 'obsidian_has_main_sidebar', 'obsidian_audiotheme_has_main_sidebar' );

/**
 * Set single tracks archive link to its parent record.
 *
 * @since  1.0.0
 *
 * @param string Archive URL.
 */
function obsidian_audiotheme_track_archive_link( $link ) {
	if ( is_singular( 'audiotheme_track' ) ) {
		$link = get_permalink( get_post()->post_parent );
	}

	return $link;
}
add_filter( 'obsidian_archive_link', 'obsidian_audiotheme_track_archive_link', 1 );

/**
 * Return a set of recent gigs.
 *
 * @since  1.0.0
 */
function obsidian_audiotheme_recent_gigs_query() {
	$args = array(
		'order'          => 'desc',
		'posts_per_page' => 5,
		'meta_query'     => array(
			array(
				'key'     => '_audiotheme_gig_datetime',
				'value'   => current_time( 'mysql' ),
				'compare' => '<=',
				'type'    => 'DATETIME',
			),
		),
	);

	return new Audiotheme_Gig_Query( apply_filters( 'obsidian_recent_gigs_query_args', $args ) );
}

/**
 * Display a track's duration.
 *
 * @since 1.0.0
 *
 * @param int $track_id Track ID.
 */
function obsidian_audiotheme_track_length( $track_id = 0 ) {
	$track_id = empty( $track_id ) ? get_the_ID() : $track_id;
	$length   = get_audiotheme_track_length( $track_id );

	if ( empty( $length ) ) {
		$length = _x( '-:--', 'default track length', 'obsidian' );
	}

	echo esc_html( $length );
}

/**
 * Display a track's title.
 *
 * This is for backward compatibility with versions of AudioTheme prior to
 * 2.1.0.
 *
 * @since 1.3.2
 *
 * @param int|WP_Post $post Optional. Post ID or object.
 * @param array
 */
function obsidian_audiotheme_track_title( $post = 0, $args = array() ) {
	$post = get_post( $post );

	if ( function_exists( 'get_audiotheme_track_title' ) ) {
		echo get_audiotheme_track_title( $post, $args );
	} else {
		printf(
			'<a href="%s" class="track-title" itemprop="url"><span itemprop="name">%s</span></a>',
			esc_url( get_permalink( $post ) ),
			get_the_title( $post )
		);
	}
}
