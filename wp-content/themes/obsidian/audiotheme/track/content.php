<?php
/**
 * The template used for displaying individual tracks.
 *
 * @package Obsidian
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' ); ?>
		<?php get_template_part( 'audiotheme/track/meta' ); ?>
	</header>

	<div class="entry-sidebar">
		<?php get_template_part( 'audiotheme/track/artwork' ); ?>
		<?php get_template_part( 'audiotheme/track/meta-links' ); ?>
	</div>

	<?php
	if ( get_audiotheme_track_file_url() ) :
		get_template_part( 'audiotheme/track/tracklist' );
	endif;
	?>

	<div class="entry-content" itemprop="description">
		<?php do_action( 'obsidian_entry_content_top' ); ?>
		<?php the_content( '' ); ?>
		<?php do_action( 'obsidian_entry_content_bottom' ); ?>
	</div>
</article>
