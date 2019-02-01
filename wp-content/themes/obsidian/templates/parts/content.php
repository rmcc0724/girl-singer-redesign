<?php
/**
 * The template used for displaying content.
 *
 * @package Obsidian
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
	<header class="entry-header">
		<?php obsidian_entry_title(); ?>

		<div class="entry-meta">
			<?php obsidian_posted_by(); ?>
			<?php obsidian_posted_on(); ?>
		</div>
	</header>

	<?php if ( is_singular() && has_post_thumbnail() ) : ?>
		<figure class="entry-media">
			<?php the_post_thumbnail( 'full' ); ?>
		</figure>
	<?php endif; ?>

	<div class="entry-content" itemprop="articleBody">
		<?php do_action( 'obsidian_entry_content_top' ); ?>
		<?php the_content(); ?>
		<?php obsidian_page_links(); ?>
		<?php do_action( 'obsidian_entry_content_bottom' ); ?>
	</div>

	<footer class="entry-footer">
		<?php obsidian_entry_terms(); ?>
		<?php obsidian_entry_comments_link(); ?>
	</footer>
</article>
