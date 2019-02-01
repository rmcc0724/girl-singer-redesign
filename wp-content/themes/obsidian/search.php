<?php
/**
 * The template used for displaying search results.
 *
 * @package Obsidian
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="content-area" role="main" itemprop="mainContentOfPage">

	<?php do_action( 'obsidian_main_top' ); ?>

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Search Results', 'obsidian' ); ?></h1>
		</header>

		<div class="page-content" itemprop="text">
			<?php printf( esc_html__( 'Search Results for: %s', 'obsidian' ), get_search_query() ); ?>
		</div>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'templates/parts/content', 'search' ); ?>

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
