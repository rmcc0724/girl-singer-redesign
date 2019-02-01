<?php
/**
 * The template used for displaying a tacklist for individual tracks.
 *
 * @package Obsidian
 * @since 1.0.0
 */
?>

<div class="tracklist-area">
	<h2 class="screen-reader-text"><?php esc_html_e( 'Record Tracklist', 'obsidian' ); ?></h2>

	<ol class="tracklist">
		<li id="track-<?php the_ID(); ?>" class="track" itemprop="track" itemscope itemtype="http://schema.org/MusicRecording">
			<?php the_title( '<span class="track-title" itemprop="name">', '</span>' ); ?>
			<meta content="<?php the_permalink(); ?>" itemprop="url" />
			<span class="track-meta">
				<span class="track-current-time">-:--</span>
				<span class="track-sep-duration"> / </span>
				<span class="track-duration"><?php obsidian_audiotheme_track_length(); ?></span>
			</span>
		</li>

		<?php enqueue_audiotheme_tracks( get_the_ID(), 'record' ); ?>
	</ol>
</div>
