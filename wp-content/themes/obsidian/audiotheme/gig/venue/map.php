<?php
/**
 * The template used for displaying a gig map on single gig pages.
 *
 * @package Obsidian
 * @since 1.0.0
 */

if ( audiotheme_gig_has_venue() ) :
?>

	<figure class="venue-map stretch-left">
		<?php
		echo get_audiotheme_google_map_embed(
			array(
				'width'  => '100%',
				'height' => 255,
			),
			get_audiotheme_gig()->venue->ID
		);
		?>
	</figure>

<?php
endif;
