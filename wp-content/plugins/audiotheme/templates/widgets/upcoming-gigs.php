<?php
/**
 * Template to display an Upcoming Gigs widget.
 *
 * @package AudioTheme\Template
 * @since 1.5.0
 */
?>

<?php
if ( ! empty( $title ) ) :
	echo $before_title . $title . $after_title;
endif;
?>

<?php if ( $loop->have_posts() ) : ?>

	<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

		<dl class="vevent">

			<?php
			$gig = get_audiotheme_gig();
			echo get_audiotheme_gig_link( $gig, array( 'before' => '<dt>', 'after' => '</dt>', 'microdata' => false ) );
			?>

			<?php if ( audiotheme_gig_has_venue() ) : ?>
				<dd class="location">
					<a href="<?php the_permalink(); ?>"><span class="gig-title"><?php echo get_audiotheme_gig_location(); ?></span></a>
				</dd>
			<?php endif; ?>

			<dd class="date">
				<meta content="<?php echo esc_attr( get_audiotheme_gig_time( 'c' ) ); ?>">
				<time class="dtstart" datetime="<?php echo esc_attr( get_audiotheme_gig_time( 'c' ) ); ?>">
					<?php echo get_audiotheme_gig_time( $date_format ); ?>
				</time>
			</dd>

			<?php if ( ! empty( $gig->post_title ) && audiotheme_gig_has_venue() ) : ?>
				<dd class="venue"><?php echo esc_html( get_audiotheme_venue( $gig->venue->ID )->name ); ?></dd>
			<?php endif; ?>

			<?php if ( $gig_description = get_audiotheme_gig_description() ) : ?>
				<dd class="description"><?php echo wp_strip_all_tags( $gig_description ); ?></dd>
			<?php endif; ?>

		</dl>

	<?php endwhile; ?>

<?php endif; ?>
