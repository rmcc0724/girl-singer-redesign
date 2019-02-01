<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Obsidian
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="content-area" role="main">

	<?php do_action( 'obsidian_main_top' ); ?>

	<?php if ( have_posts() ) : ?>

		<?php obsidian_archive_title(); ?>

		<?php the_archive_description( '<div class="page-content" itemprop="text">', '</div>' ); ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'templates/parts/content', get_post_format() ); ?>

		<?php endwhile; ?>

		<?php obsidian_content_navigation(); ?>

	<?php else : ?>

		<?php get_template_part( 'templates/parts/content', 'none' ); ?>

	<?php endif; ?>

	<?php do_action( 'obsidian_main_bottom' ); ?>

</main>

<?php
get_sidebar();

get_footer();
