<?php
        //The functions file is the heart of the theme, all of your files are grabbed from here
function girlsinger_script_enqueue() {
    

        //Here we have the enqueue stlye function that grabs our custom css file and includes it in our theme
    wp_enqueue_style('customstyle', get_template_directory_uri() . '/css/girl-singer.css', array(), '1.0.0', 'all');
    
        //Here we have the enqueue script function that grabs our custom js file and includes it in our theme
    wp_enqueue_script('customjs', get_template_directory_uri() . '/js/girl-singer.js', array(), '1.0.0', true);
};

//Add action calls all of the scripts and triggers the above function 'awesome_script_enqueue'
add_action( 'wp_enqueue_scripts', 'girlsinger_script_enqueue');
?>