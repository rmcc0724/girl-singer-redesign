<?php
/*
============================================================
here we can set a template name for our pages which allows full customization of our layouts
============================================================
*/

/*
Template Name: About
*/

get_header(); ?>
<?php
/*
============================================================
If there are post, print all of the post content 
============================================================
*/
if(have_posts() ):
    while( have_posts() ): the_post(); ?>
    
    <p><?php the_content(); ?></p
        <h3><?php the_title(); ?></h3>
    
<?php endwhile;
endif;
?>

<h1>This is my theme</h1>
<?php get_footer(); ?>