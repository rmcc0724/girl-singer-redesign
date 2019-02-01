<?php
/**
 * The template used for displaying a meta on single record pages.
 *
 * @package Obsidian
 * @since 1.0.0
 */

$artist = get_audiotheme_record_artist();
$year   = get_audiotheme_record_release_year();
$genre  = get_audiotheme_record_genre();

if ( $artist || $year || $genre ) :
?>

	<div class="record-meta">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Record Details', 'obsidian' ); ?></h2>

		<dl>
			<?php if ( $artist ) : ?>
				<dt class="record-artist screen-reader-text"><?php esc_html_e( 'Artist', 'obsidian' ); ?></dt>
				<dd class="record-artist" itemprop="byArtist"><?php echo esc_html( $artist ); ?></dd>
			<?php endif; ?>

			<?php if ( $year ) : ?>
				<dt class="record-year"><?php esc_html_e( 'Release', 'obsidian' ); ?></dt>
				<dd class="record-year" itemprop="dateCreated"><?php echo esc_html( $year ); ?></dd>
			<?php endif; ?>

			<?php if ( $genre ) : ?>
				<dt class="record-genre"><?php esc_html_e( 'Genre', 'obsidian' ); ?></dt>
				<dd class="record-genre" itemprop="genre"><?php echo esc_html( $genre ); ?></dd>
			<?php endif; ?>
		</dl>
	</div>

<?php
endif;
