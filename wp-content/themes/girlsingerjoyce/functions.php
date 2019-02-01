<?php
/*
============================================================
This function adds the custom JavaScript and CSS files to your custom theme 
============================================================
*/
function girlsinger_script_enqueue() {
	
    wp_enqueue_style('customstyle', get_template_directory_uri() . '/css/girl-singer.css', array(), '1.0.0', 'all');
    wp_enqueue_style('normalize', get_template_directory_uri() . '/css/normalize.css', array(), '1.0.0', 'all');
    wp_enqueue_style('customstyle-2', get_template_directory_uri() . '/style.css', array(), '1.0.0', 'all');
    wp_enqueue_script('customjs', get_template_directory_uri() . '/js/girl-singer.js', array(), '1.0.0', true);
    wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/bootstrap-custom.css', array(), '1.0.0', 'all');
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/bootstrap/dist/css/bootstrap.min.css');
	wp_enqueue_script('bootstrapjs', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '4.0.0', true);
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/bootstrap/font-awesome/css/font-awesome.min.css');
    wp_enqueue_style('Cormorant', 'https://fonts.googleapis.com/css?family=Cormorant+Unicase|Source+Sans+Pro|Roboto');
    wp_enqueue_style('bootstrap-social', get_template_directory_uri() . '/bootstrap/bootstrap-social/bootstrap-social.css');
    wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.3.1.slim.min.js');
};

/*
============================================================
Add action calls all of the scripts and triggers the above function 'awesome_script_enqueue'
============================================================
*/
add_action( 'wp_enqueue_scripts', 'girlsinger_script_enqueue');


/*
============================================================
This function adds the menus to your theme allowing for mutiple menus
============================================================
*/
function girlsinger_theme_setup() {
    add_theme_support('menus');
    register_nav_menu('primary', 'Primary Header Navigation');
    register_nav_menu('footer', 'Footer Navigation');    
    register_nav_menu('mobile', 'Mobile Navigation');    
}

/*
============================================================
This activates the custom features
============================================================
*/
add_action('init', 'girlsinger_theme_setup');

/*
============================================================
Here we activate our custom background, header, and post thumbnails
============================================================
*/
add_theme_support('custom-background');
add_theme_support('custom-header');
add_theme_support('post-thumbnails');

/*
============================================================
--Here we activate our post-format hook so we can customize our posts--
Audio, Video, Site, gallery, Link, image, quote, status, shot
============================================================
*/
add_theme_support('post-formats', array('aside', 'image', 'video'));



/*
	==========================================
	 Sidebar function
	==========================================
*/
function girlsinger_widget_setup() {
	
	register_sidebar(
		array(	
			'name'	=> 'Sidebar',
			'id'	=> 'sidebar-1',
			'class'	=> 'custom',
			'description' => 'Standard Sidebar',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		)
	);
	
}
add_action('widgets_init','girlsinger_widget_setup');


?>