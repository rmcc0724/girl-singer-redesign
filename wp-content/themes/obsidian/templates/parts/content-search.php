<?php
/**
 * The template used for displaying search content.
 *
 * @package obsidian
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php obsidian_entry_title(); ?>
	</header>

	<div class="entry-content" itemprop="text">
		<?php do_action( 'obsidian_entry_content_top' ); ?>
		<?php the_excerpt(); ?>
		<?php do_action( 'obsidian_entry_content_bottom' ); ?>
	</div>

	<?php if ( 'post' === get_post_type() ) : ?>
		<footer class="entry-footer">
			<?php obsidian_posted_by(); ?>
			<?php obsidian_posted_on(); ?>
		</footer>
	<?php endif; ?>
</article>
