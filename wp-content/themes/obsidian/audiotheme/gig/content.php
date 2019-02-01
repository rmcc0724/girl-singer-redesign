<?php
/**
 * The template used for displaying individual gigs.
 *
 * @package Obsidian
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'vevent' ); ?> itemscope itemtype="http://schema.org/MusicEvent">
	<header class="entry-header entry-sidebar">
		<?php the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' ); ?>

		<h2 class="gig-date">
			<meta content="<?php echo esc_attr( get_audiotheme_gig_time( 'c' ) ); ?>" itemprop="startDate">
			<time datetime="<?php echo esc_attr( get_audiotheme_gig_time( 'c' ) ); ?>">
				<?php echo esc_html( get_audiotheme_gig_time( get_option( 'date_format', 'F d, Y' ) ) ); ?>
			</time>
		</h2>

		<h3 class="gig-location">
			<?php echo obsidian_allowed_tags( get_audiotheme_venue_location( get_audiotheme_gig()->venue->ID ) ); ?>
		</h3>

		<?php the_audiotheme_gig_description( '<div class="gig-description" itemprop="description">', '</div>' ); ?>
	</header>

	<div class="entry-meta">
		<?php get_template_part( 'audiotheme/gig/meta' ); ?>
		<?php get_template_part( 'audiotheme/gig/venue/map' ); ?>
		<?php get_template_part( 'audiotheme/gig/venue/meta' ); ?>
	</div>

	<div class="entry-content" itemprop="description">
		<?php do_action( 'obsidian_entry_content_top' ); ?>
		<?php the_content( '' ); ?>
		<?php do_action( 'obsidian_entry_content_bottom' ); ?>
	</div>
</article>
