<?php
/*
============================================================
This function adds the custom JavaScript and CSS files to your custom theme 
============================================================
*/
function girlsinger_script_enqueue() {
    
        //Here we have the enqueue stlye function that grabs our custom css file and includes it in our theme
    wp_enqueue_style('customstyle', get_template_directory_uri() . '/css/girl-singer.css', array(), '1.0.0', 'all');
    
        //Here we have the enqueue script function that grabs our custom js file and includes it in our theme
    wp_enqueue_script('customjs', get_template_directory_uri() . '/js/girl-singer.js', array(), '1.0.0', true);
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
?>