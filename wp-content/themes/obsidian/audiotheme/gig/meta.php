<?php
/**
 * The template used for displaying a meta single gig pages.
 *
 * @package Obsidian
 * @since 1.0.0
 */
?>

<div class="gig-meta">
	<h2 class="section-title screen-reader-text"><?php esc_html_e( 'Gig Details', 'obsidian' ); ?></h2>

	<dl>
		<dt class="gig-time"><?php esc_html_e( 'Time', 'obsidian' ); ?></dt>
		<dd class="gig-time">
			<?php
			echo esc_html( get_audiotheme_gig_time(
				'',
				get_option( 'time_format', 'g:i A' ),
				false,
				array( 'empty_time' => esc_html__( 'TBD', 'obsidian' ) )
			) );
			?>
		</dd>

		<?php if ( audiotheme_gig_has_ticket_meta() ) : ?>
			<dt class="gig-tickets"><?php esc_html_e( 'Tickets', 'obsidian' ); ?></dt>
			<dd class="gig-tickets" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
				<?php if ( $gig_tickets_price = get_audiotheme_gig_tickets_price() ) : ?>
					<span itemprop="price"><?php echo esc_html( $gig_tickets_price ); ?></span>
				<?php endif; ?>

				<?php if ( $gig_tickets_url = get_audiotheme_gig_tickets_url() ) : ?>
					<span class="sep-price">&ndash;</span>
					<a class="js-maybe-external" href="<?php echo esc_url( $gig_tickets_url ); ?>" itemprop="url">
						<?php esc_html_e( 'Buy', 'obsidian' ); ?>
					</a>
				<?php endif; ?>
			</dd>
		<?php endif; ?>

		<?php if ( apply_filters( 'obsidian_show_gig_subscribe_links', true ) ) : ?>
			<dt class="gig-subscribe"><?php esc_html_e( 'Subscribe', 'obsidian' ); ?></dt>
			<dd class="gig-subscribe">
				<ul>
					<li class="nav-ical">
						<a href="<?php the_audiotheme_gig_ical_link(); ?>"><?php esc_html_e( 'iCal', 'obsidian' ); ?></a>
					</li>
					<li class="nav-gcal">
						<a class="js-popup" href="<?php the_audiotheme_gig_gcal_link(); ?>" data-popup-width="800" data-popup-height="600"><?php esc_html_e( 'Google', 'obsidian' ); ?></a>
					</li>
				</ul>
			</dd>
		<?php endif; ?>
	</dl>
</div>
