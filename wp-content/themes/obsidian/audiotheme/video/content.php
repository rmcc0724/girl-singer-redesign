<?php
/**
 * The template used for displaying individual videos.
 *
 * @package Obsidian
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
	<?php if ( $thumbnail = get_post_thumbnail_id() ) : ?>
		<meta itemprop="thumbnailUrl" content="<?php echo esc_url( wp_get_attachment_url( $thumbnail, 'full' ) ); ?>">
	<?php endif; ?>

	<?php get_template_part( 'audiotheme/video/media' ); ?>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' ); ?>
	</header>

	<div class="entry-content" itemprop="description">
		<?php do_action( 'obsidian_entry_content_top' ); ?>
		<?php the_content( '' ); ?>
		<?php do_action( 'obsidian_entry_content_bottom' ); ?>
	</div>
</article>
