<?php
/**
 * The template used for displaying a gig in gig archives.
 *
 * @package Obsidian
 * @since 1.0.0
 */
?>

<dl id="post-<?php the_ID(); ?>" <?php post_class( array( 'gig-card', 'vevent' ) ); ?> itemscope itemtype="http://schema.org/MusicEvent">
	<dt class="gig-date"><?php esc_html_e( 'Date', 'obsidian' ); ?></dt>
	<dd class="gig-date date">
		<meta itemprop="startDate" content="<?php the_audiotheme_gig_time( 'c' ); ?>">
		<time class="dtstart" datetime="<?php the_audiotheme_gig_time( 'c' ); ?>">
			<span class="date-format"><?php the_audiotheme_gig_time( get_option( 'date_format' ) ); ?></span>
			<span class="date-format date-format--month"><?php the_audiotheme_gig_time( 'M' ); ?></span>
			<span class="date-format date-format--day"><?php the_audiotheme_gig_time( 'd' ); ?></span>
		</time>
	</dd>

	<dt class="gig-title" itemprop="name"><?php echo obsidian_allowed_tags( get_audiotheme_gig_title() ); ?></dt>

	<?php if ( audiotheme_gig_has_venue() ) : ?>

		<dt class="gig-venue"><span class="gig-location"><?php echo obsidian_allowed_tags( get_audiotheme_gig_location() ); ?></span></dt>
		<dd class="gig-venue location vcard screen-reader-text" itemprop="location" itemscope itemtype="http://schema.org/EventVenue">
			<?php
			the_audiotheme_venue_vcard( array(
				'container' => '',
			) );
			?>
		</dd>

		<?php
		if ( ! is_singular( 'audiotheme_gig' ) ) :
			the_audiotheme_gig_description(
				'<dt class="gig-description screen-reader-text">' . esc_html__( 'Note', 'obsidian' ) . '</dt><dd class="gig-description" itemprop="description">',
				'</dd>'
			);
		endif;
		?>

		<dd class="gig-permalink">
			<a href="<?php the_permalink(); ?>" itemprop="url"><span class="screen-reader-text"><?php esc_html_e( 'More', 'obsidian' ); ?></span></a>
		</dd>

	<?php else : ?>

		<dd class="gig-venue no-gig-venue">
			<?php edit_post_link( esc_html__( 'Edit Gig', 'obsidian' ) ); ?>
		</dd>

		<dd class="gig-description no-gig-venu">
			<span class="gig-title"><?php esc_html_e( 'Gig venue details are missing or incomplete.', 'obsidian' ); ?></span>
		</dd>

	<?php endif; ?>
</dl>
