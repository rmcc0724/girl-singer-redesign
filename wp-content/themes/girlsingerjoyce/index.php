<?php get_header(); ?>
<?php
/*
============================================================
If there are post, print all of the post content 
============================================================
*/
if(have_posts() ):
    while( have_posts() ): the_post(); ?>
  
<?php 
/*
============================================================
here we can specify templates for each of our posts using the hook below
This hook uses the content.php, content-image, and content-aside files along with the other 6 not listed
============================================================
*/
get_template_part('content' , get_post_format()); ?>

<?php endwhile;
endif;
?>

<h1>This is the indes.php file</h1>
<?php get_footer(); ?>