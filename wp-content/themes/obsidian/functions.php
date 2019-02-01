<?php
/**
 * Obsidian functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme (see https://codex.wordpress.org/Theme_Development
 * and https://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * see https://codex.wordpress.org/Plugin_API
 *
 * @package Obsidian
 * @since 1.0.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 720;
}

/**
 * Adjust the content width for full width pages.
 *
 * @since 1.0.0
 */
function obsidian_content_width() {
	global $content_width;

	if ( obsidian_is_full_width_layout() ) {
		$content_width = 1100;
	}
}
add_action( 'template_redirect', 'obsidian_content_width' );

/**
 * Load helper functions and libraries.
 */
require( get_template_directory() . '/includes/customizer.php' );
require( get_template_directory() . '/includes/hooks.php' );
require( get_template_directory() . '/includes/template-helpers.php' );
require( get_template_directory() . '/includes/template-tags.php' );
require( get_template_directory() . '/includes/vendor/cedaro-theme/autoload.php' );
obsidian_theme()->load();

/**
 * Set up theme defaults and register support for various WordPress features.
 *
 * @since 1.0.0
 */
function obsidian_setup() {
	// Add support for translating strings in this theme.
	// @link https://codex.wordpress.org/Function_Reference/load_theme_textdomain
	load_theme_textdomain( 'obsidian', get_template_directory() . '/languages' );

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array(
		is_rtl() ? 'assets/css/editor-style-rtl.css' : 'assets/css/editor-style.css',
		obsidian_fonts_icon_url(),
	) );

	// Add support for default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Add support for the title tag.
	// @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	add_theme_support( 'title-tag' );

	// Add support for a logo.
	add_theme_support( 'site-logo', array(
		'size' => 'full',
	) );

	// Add support for post thumbnails.
	add_theme_support( 'post-thumbnails' );

	// Set thumbnail size to cover 2 column grids and featured content thumbnail
	set_post_thumbnail_size( 530, 530, array( 'center', 'top' ) );
	add_image_size( 'obsidian-16x9', 530, 300, array( 'center', 'top' ) );

	// Add support for Custom Background functionality.
	add_theme_support( 'custom-background', array(
		'default-color' => '000000',
	) );

	// Add HTML5 markup for the comment forms, search forms and comment lists.
	add_theme_support( 'html5', array(
		'caption', 'comment-form', 'comment-list', 'gallery', 'search-form',
	) );

	// Register default nav menus.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'obsidian' ),
		'social'  => esc_html__( 'Social Links Menu', 'obsidian' ),
	) );

	// Register support for page type templates.
	obsidian_theme()->page_types->add_support()->register( 'grid', array(
		'archive_template' => 'templates/grid-page.php',
		'single_template'  => 'templates/grid-page-child.php',
	) );

	// Register support for archive content settings.
	obsidian_theme()->archive_content->add_support();

	// Register support for archive image settings.
	obsidian_theme()->archive_images->add_support();
}
add_action( 'after_setup_theme', 'obsidian_setup' );

/**
 * Register widget areas.
 *
 * @since 1.0.0
 */
function obsidian_register_widget_areas() {
	register_sidebar( array(
		'id'            => 'sidebar-1',
		'name'          => esc_html__( 'Main Sidebar', 'obsidian' ),
		'description'   => esc_html__( 'The default sidebar on all posts and pages.', 'obsidian' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'id'              => 'home-widgets',
		'name'            => esc_html__( 'Home', 'obsidian' ),
		'description'     => esc_html__( 'Widgets that appear on the homepage.', 'obsidian' ),
		'before_widget'   => '<section id="%1$s" class="widget %2$s block-grid-item">',
		'after_widget'    => '</section>',
		'before_title'    => '<h2 class="widget-title">',
		'after_title'     => '</h2>',
	) );

	register_sidebar( array(
		'id'            => 'footer-widgets',
		'name'          => esc_html__( 'Footer', 'obsidian' ),
		'description'   => esc_html__( 'Widgets that appear at the bottom of every page.', 'obsidian' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s block-grid-item">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'obsidian_register_widget_areas' );

/**
 * Enqueue scripts and styles.
 *
 * @since 1.0.0
 */
function obsidian_enqueue_assets() {
	// Add Themicons font, used in the main stylesheet.
	wp_enqueue_style( 'themicons', obsidian_fonts_icon_url(), array(), '2.3.1' );

	// Load main style sheet.
	wp_enqueue_style( 'obsidian-style', get_stylesheet_uri() );

	// Load RTL style sheet.
	wp_style_add_data( 'obsidian-style', 'rtl', 'replace' );

	wp_enqueue_script(
		'wp-nav-menus',
		get_template_directory_uri() . '/assets/js/vendor/wp-nav-menus.js',
		array(),
		'1.0.0',
		true
	);

	wp_localize_script( 'wp-nav-menus', '_cedaroNavMenuL10n', array(
		'collapseSubmenu' => esc_html__( 'Collapse submenu', 'obsidian' ),
		'expandSubmenu'   => esc_html__( 'Expand submenu', 'obsidian' ),
	) );

	// Load theme scripts.
	wp_enqueue_script(
		'obsidian',
		get_template_directory_uri() . '/assets/js/main.js',
		array( 'jquery', 'wp-nav-menus' ),
		'20150210',
		true
	);

	// Localize the main theme script.
	wp_localize_script( 'obsidian', '_obsidianSettings', array(
		'l10n' => array(
			'nextTrack'      => esc_html__( 'Next Track', 'obsidian' ),
			'previousTrack'  => esc_html__( 'Previous Track', 'obsidian' ),
			'togglePlaylist' => esc_html__( 'Toggle Playlist', 'obsidian' ),
		),
		'mejs' => array(
			'pluginPath' => includes_url( 'js/mediaelement/', 'relative' ),
		),
	) );

	// Load script to support comment threading when it's enabled.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Register scripts for enqueueing on demand.
	wp_register_style( 'obsidian-fonts', obsidian_fonts_url(), array(), null );
	wp_register_script( 'obsidian-cue', get_template_directory_uri() . '/assets/js/vendor/jquery.cue.js', array( 'jquery', 'mediaelement' ), '1.2.4', true );
}
add_action( 'wp_enqueue_scripts', 'obsidian_enqueue_assets' );

/**
 * JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since 1.0.0
 */
function obsidian_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'obsidian_javascript_detection', 0 );

/**
 * Configure MediaElement.js elements to aid styling.
 *
 * Extends the core _wpmejsSettings object to add a new feature via the
 * MediaElement.js plugin API.
 *
 * @since 1.0.0
 */
function obsidian_mejs_setup() {
	if ( ! wp_script_is( 'mediaelement', 'done' ) ) {
		return;
	}
	?>
	<script>
	(function() {
		var settings = window._wpmejsSettings || {};
		settings.features = settings.features || mejs.MepDefaults.features;
		settings.features.push( 'obsidiantheme' );

		MediaElementPlayer.prototype.buildobsidiantheme = function( player ) {
			var container = player.container[0] || player.container;

			if ( 'AUDIO' === player.node.nodeName ) {
				player.options.setDimensions = false;
				container.classList.add( 'obsidian-mejs-container' );
				container.style.height = '';
				container.style.width = '';
			}
		};
	})();
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'obsidian_mejs_setup' );

/**
 * Return the Google font stylesheet URL, if available.
 *
 * The default Google font usage is localized. For languages that use characters
 * not supported by the font, the font can be disabled.
 *
 * As of 1.1.0, this is only used on WordPress.com. It's still available and is
 * registered (but not enqueued) for backward compatibility. Custom fonts are
 * loaded on self-hosted installations by the Cedaro Theme library.
 *
 * @since 1.0.0
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function obsidian_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin';

	/*
	 * translators: If there are characters in your language that are not
	 * supported by these fonts, translate this to 'off'.
	 * Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Open Sans: on or off', 'obsidian' ) ) {
		$fonts[] = 'Open Sans:300italic,400italic,700italic,300,400,700';
	}

	/*
	 * translators: To add a character subset specific to your language,
	 * translate this to 'latin-ext', 'cyrillic', 'greek', or 'vietnamese'.
	 * Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Add new subset (latin-ext)', 'obsidian' );

	if ( 'latin-ext' === $subset ) {
		$subsets .= ',latin-ext';
	} elseif ( 'cyrillic' === $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' === $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'vietnamese' === $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$query_args = array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		);

		$fonts_url = esc_url_raw( add_query_arg( $query_args, 'https://fonts.googleapis.com/css' ) );
	}

	return $fonts_url;
}

/**
 * Retrieve the icon font style sheet URL.
 *
 * @since 1.0.0
 *
 * @return string Font stylesheet.
 */
function obsidian_fonts_icon_url() {
	return get_template_directory_uri() . '/assets/css/themicons.css';
}

/**
 * Wrapper for accessing the Cedaro_Theme instance.
 *
 * @since 1.0.0
 *
 * @return Cedaro_Theme
 */
function obsidian_theme() {
	static $instance;

	if ( null === $instance ) {
		Cedaro_Theme_Autoloader::register();
		$instance = new Cedaro_Theme( array( 'prefix' => 'obsidian' ) );
	}

	return $instance;
}
