<?php
/**
 * The template for displaying 404 (Not Found) pages.
 *
 * @package Obsidian
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="content-area" role="main" itemprop="mainContentOfPage">

	<?php do_action( 'obsidian_main_top' ); ?>

	<section class="error-404 not-found">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( '404 Error', 'obsidian' ); ?></h1>
		</header>

		<div class="page-content">
			<p>
				<?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'obsidian' ); ?>
			</p>

			<?php get_search_form(); ?>
		</div>
	</section>

	<?php do_action( 'obsidian_main_bottom' ); ?>

</main>

<?php
get_footer();
