<?php
/**
 * The template for displaying a track artwork.
 *
 * @package Obsidian
 * @since 1.0.0
 */

if ( $thumbnail_id = get_audiotheme_track_thumbnail_id() ) :
?>

	<figure class="record-artwork">
		<a class="post-thumbnail" href="<?php echo esc_url( get_permalink( $post->post_parent ) ); ?>">
			<?php echo wp_get_attachment_image( $thumbnail_id, 'large' ); ?>
		</a>
	</figure>

<?php
endif;
