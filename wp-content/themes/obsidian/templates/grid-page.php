<?php
/**
 * Template Name: Grid Page
 *
 * @package Obsidian
 * @since 1.3.0
 */

get_header();
?>

<main id="primary" class="content-area archive-grid" role="main">

	<?php do_action( 'obsidian_main_top' ); ?>

	<header class="page-header">
		<?php the_title( '<h1 class="page-title" itemprop="headline">', '</h1>' ); ?>
	</header>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php if ( '' !== $post->post_content ) : ?>
			<div class="page-content" itemprop="text">
				<?php the_content(); ?>
			</div>
		<?php endif; ?>

	<?php endwhile; ?>

	<?php
	$loop = obsidian_page_type_query();
	if ( $loop->have_posts() ) :
	?>

		<div class="<?php obsidian_block_grid_classes( 'block-grid-3' ); ?>">

			<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

				<article id="block-grid-item-<?php the_ID(); ?>" <?php post_class( 'block-grid-item' ); ?>>
					<a class="block-grid-item-thumbnail" href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>

					<?php the_title( '<h2 class="block-grid-item-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
				</article>

			<?php endwhile; ?>

			<?php wp_reset_postdata(); ?>
		</div>

	<?php else : ?>

		<div class="page-content">
			<?php obsidian_page_type_notice(); ?>
		</div>

	<?php endif; ?>

	<?php do_action( 'obsidian_main_bottom' ); ?>

</main>


<?php
get_footer();
