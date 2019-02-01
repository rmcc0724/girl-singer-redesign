<?php
/**
 * The template used for displaying a gig venue meta single gig pages.
 *
 * @package Obsidian
 * @since 1.0.0
 */

$venue = get_audiotheme_venue( get_audiotheme_gig()->venue->ID );

if ( audiotheme_gig_has_venue() ) :
?>

<div class="venue-meta">
	<h2 class="section-title"><?php esc_html_e( 'Venue Details', 'obsidian' ); ?></h2>

	<dl itemprop="location" itemscope itemtype="http://schema.org/EventVenue">
		<dt class="venue-address"><?php esc_html_e( 'Address', 'obsidian' ); ?></dt>
		<dd class="venue-address">
			<?php
			the_audiotheme_venue_vcard( array(
				'container'         => '',
				'show_name_link'    => false,
				'show_phone'        => false,
				'separator_address' => '&nbsp;',
				'separator_country' => '',
			) );
			?>
		</dd>

		<?php if ( $venue->phone ) : ?>
			<dt class="venue-phone"><?php esc_html_e( 'Phone', 'obsidian' ); ?></dt>
			<dd class="venue-phone"><?php echo esc_html( $venue->phone ); ?></dd>
		<?php endif; ?>

		<?php if ( $venue->website ) : ?>
			<dt class="venue-website"><?php esc_html_e( 'Website', 'obsidian' ); ?></dt>
			<dd class="venue-website"><a href="<?php echo esc_url( $venue->website ); ?>" itemprop="url"><?php echo esc_html( audiotheme_simplify_url( $venue->website ) ); ?></a></dd>
		<?php endif; ?>
	</dl>
</div>

<?php
endif;
