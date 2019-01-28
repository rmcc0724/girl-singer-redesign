<?php get_header(); ?>

<div class="row">
	
	<div>

		<?php 
		
		if( have_posts() ):
			
			while( have_posts() ): the_post(); ?>
				
				<?php get_template_part('content',get_post_format()); ?>
			
			<?php endwhile;
			
		endif;
				
		?>
	
	</div>

<div><?php get_sidebar(); 
?></div>

<h1>This is the index.php file</h1>
<?php get_footer(); ?>