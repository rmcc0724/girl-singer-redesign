<?php
/**
 * The template used for displaying videos on archives.
 *
 * @package Obsidian
 * @since 1.0.0
 */
?>

<article id="block-grid-item-<?php the_ID(); ?>" <?php post_class( 'block-grid-item' ); ?>>
	<?php do_action( 'obsidian_entry_content_top' ); ?>

	<a class="block-grid-item-thumbnail" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'obsidian-16x9' ); ?></a>

	<?php the_title( '<h2 class="block-grid-item-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

	<?php do_action( 'obsidian_entry_content_bottom' ); ?>
</article>
