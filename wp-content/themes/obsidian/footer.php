<?php
/**
 * The template for displaying the site footer.
 *
 * @package Obsidian
 * @since 1.0.0
 */
?>


			<?php do_action( 'obsidian_content_bottom' ); ?>

		</div><!-- #content -->

		<?php do_action( 'obsidian_footer_before' ); ?>

		<?php get_template_part( 'templates/parts/site-footer' ); ?>

		<?php do_action( 'obsidian_footer_after' ); ?>

	</div><!-- #page -->

	<?php do_action( 'obsidian_after' ); ?>

	<?php wp_footer(); ?>

</body>
</html>
