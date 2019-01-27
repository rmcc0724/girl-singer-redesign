<?php get_header(); ?>
<?php
/*
============================================================
If there are post, print all of the post content 
============================================================
*/
if(have_posts() ):
    while( have_posts() ): the_post(); ?>
    
    <h3><?php the_title(); ?></h3>
    <p><?php the_content(); ?></p>
    
<?php endwhile;
endif;
?>

<h1>This is my theme</h1>
<?php get_footer(); ?>