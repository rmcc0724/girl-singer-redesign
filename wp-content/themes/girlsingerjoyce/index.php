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
    
<!--
============================================================
Here we add the php hook to call the post thumbnail image
============================================================
-->

    <div class="thumbnail-img"><?php the_post_thumbnail('thumbnail'); ?></div>
<!--
============================================================
Here we add the php hook to call the posted time
============================================================
-->

    <small>Posted on: <?php the_time('F, j, Y'); ?> at <?php the_time('g:i a'); ?>, in <?php the_category(); ?></small>
    <p><?php the_content(); ?></p>
    
<?php endwhile;
endif;
?>

<h1>This is my theme</h1>
<?php get_footer(); ?>