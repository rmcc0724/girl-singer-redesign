<?php
/**
 * The template for displaying a single gig.
 *
 * @package Obsidian
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="content-area single-gig" role="main" itemprop="mainContentOfPage">

	<?php do_action( 'obsidian_main_top' ); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'audiotheme/gig/content' ); ?>

		<?php comments_template( '', true ); ?>

	<?php endwhile; ?>

	<?php do_action( 'obsidian_main_bottom' ); ?>

</main>

<?php
get_footer();
