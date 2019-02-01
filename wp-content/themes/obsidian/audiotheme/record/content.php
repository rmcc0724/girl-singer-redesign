<?php
/**
 * The template used for displaying individual records.
 *
 * @package Obsidian
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' ); ?>
		<?php get_template_part( 'audiotheme/record/meta' ); ?>
	</header>

	<div class="entry-sidebar">
		<?php get_template_part( 'audiotheme/record/artwork' ); ?>
		<?php get_template_part( 'audiotheme/record/meta', 'links' ); ?>
	</div>

	<?php get_template_part( 'audiotheme/record/tracklist' ); ?>

	<div class="entry-content" itemprop="description">
		<?php do_action( 'obsidian_entry_content_top' ); ?>
		<?php the_content( '' ); ?>
		<?php do_action( 'obsidian_entry_content_bottom' ); ?>
	</div>
</article>
