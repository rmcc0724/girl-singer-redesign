<?php
/**
 * The template used for displaying a meta links on single track pages.
 *
 * @package Obsidian
 * @since 1.0.0
 */

$purchase_url = get_audiotheme_track_purchase_url();
$download_url = is_audiotheme_track_downloadable();

if ( $purchase_url || $download_url ) :
?>

	<div class="meta-links">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Track Links', 'obsidian' ); ?></h2>
		<ul>
			<?php if ( $purchase_url ) : ?>
				<li><a class="button js-maybe-external" href="<?php echo esc_url( $purchase_url ); ?>" itemprop="url"><?php esc_html_e( 'Purchase', 'obsidian' ); ?></a></li>
			<?php endif; ?>

			<?php if ( $download_url ) : ?>
				<li><a class="button" href="<?php echo esc_url( $download_url ); ?>" itemprop="url" download="<?php esc_attr( basename( $download_url ) ); ?>"><?php esc_html_e( 'Download', 'obsidian' ); ?></a></li>
			<?php endif; ?>
		</ul>
	</div>

<?php
endif;
