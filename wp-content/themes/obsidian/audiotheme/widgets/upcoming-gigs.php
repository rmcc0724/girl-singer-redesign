<?php
/**
 * Template to display the Upcoming Gigs widget.
 *
 * @package Obsidian
 * @since 1.0.0
 */

if ( ! empty( $title ) ) :
	echo $before_title . esc_html( $title ) . $after_title;
endif;
?>

<?php if ( $loop->have_posts() ) : ?>

	<div class="vcalendar">
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

			<?php get_template_part( 'audiotheme/gig/card' ); ?>

		<?php endwhile; ?>
	</div>

	<footer class="widget-footer">
		<?php
		printf( '<a class="gigs-archive-link" href="%1$s">%2$s</a>',
			esc_url( get_post_type_archive_link( get_post_type() ) ),
			esc_html__( 'View All Gigs', 'obsidian' )
		);
		?>
	</footer>

<?php else : ?>

	<p class="no-results">
		<?php esc_html_e( 'No gigs are currently scheduled.', 'obsidian' ); ?>
	</p>

<?php
endif;
