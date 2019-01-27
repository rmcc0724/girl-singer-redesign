<?php 
/*
Template Name: Page No Title
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
    
    <h1>This is my static title</h1>
    <p><?php the_content(); ?></p

<?php endwhile;
endif;
?>

<h1>This is my theme</h1>
<?php get_footer(); ?>