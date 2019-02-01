<?php
/**
 * The template for displaying the site footer.
 *
 * @package Obsidian
 * @since 1.0.0
 */
?>

<footer id="footer" class="site-footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">

	<?php do_action( 'obsidian_footer_top' ); ?>

	<?php
	if ( is_active_sidebar( 'footer-widgets' ) ) :
		get_sidebar( 'footer' );
	endif;
	?>

	<?php if ( has_nav_menu( 'social' ) ) : ?>

		<nav class="social-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Social Media Profiles', 'obsidian' ); ?></h2>

			<?php
			wp_nav_menu( array(
				'theme_location' => 'social',
				'container'      => false,
				'depth'          => 1,
				'link_before'    => '<span class="screen-reader-text">',
				'link_after'     => '</span>',
			) );
			?>
		</nav>

	<?php endif; ?>

	<div class="credits">
		<?php obsidian_credits(); ?>
	</div>

	<?php do_action( 'obsidian_footer_bottom' ); ?>

</footer>
