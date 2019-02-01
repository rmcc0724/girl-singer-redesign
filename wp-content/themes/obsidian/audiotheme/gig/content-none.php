<?php
/**
 * The template for displaying a message when there aren't any upcoming gigs.
 *
 * @package Obsidian
 * @since 1.0.0
 */

$post_type   = 'audiotheme_gig';
$recent_gigs = obsidian_audiotheme_recent_gigs_query();
?>

<section class="no-results not-found">
	<header class="page-header">
		<?php the_audiotheme_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
		<?php obsidian_post_type_navigation( $post_type ); ?>
	</header>

	<div class="page-content">
		<?php if ( current_user_can( 'publish_posts' ) ) : ?>
			<p>
				<?php
				echo obsidian_allowed_tags( sprintf( _x( 'Ready to publish your next gig? <a href="%1$s">Get started here</a>.', 'add post type link', 'obsidian' ),
					esc_url( add_query_arg( 'post_type', get_post_type_object( 'audiotheme_gig' )->name, admin_url( 'post-new.php' ) ) )
				) );
				?>
			</p>
		<?php else : ?>
			<p>
				<?php esc_html_e( "There currently aren't any upcoming shows. Check back soon!", 'obsidian' ); ?>
			</p>
		<?php endif; ?>
	</div>

	<?php if ( $recent_gigs->have_posts() ) : ?>
		<div id="gigs" class="gig-list vcalendar">
			<?php while ( $recent_gigs->have_posts() ) : $recent_gigs->the_post(); ?>
				<?php get_template_part( 'audiotheme/gig/card' ); ?>
			<?php endwhile; ?>
		</div>
	<?php endif; ?>
</section>
