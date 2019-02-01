<?php
/**
 * The template for displaying the audio player bar across the bottom of the
 * site when it's enabled.
 *
 * @package CueBar
 * @since 1.0.0
 */
?>

<div class="cuebar is-loading" itemscope itemtype="http://schema.org/MusicPlaylist">
	<meta itemprop="numTracks" content="<?php echo count( $tracks ); ?>" />

	<audio src="<?php echo esc_url( $tracks[0]['audioUrl'] ); ?>" controls preload="none" class="cue-audio" style="width: 100%; height: auto"></audio>

	<div class="cue-tracks">
		<ol class="cue-tracks-list">

			<?php foreach ( $tracks as $track ) : ?>

				<li class="cue-track" itemprop="track" itemscope itemtype="http://schema.org/MusicRecording">
					<?php do_action( 'cuebar_track_before', $track ); ?>

					<span class="cue-track-details cue-track-cell">
						<span class="cue-track-title" itemprop="name"><?php echo $track['title']; ?></span>
						<span class="cue-track-artist" itemprop="byArtist"><?php echo esc_html( $track['artist'] ); ?></span>
					</span>

					<?php
					if ( function_exists( 'cue_track_action_links' ) ) :
						cue_track_action_links( $track, array(
							'container_class' => 'cue-track-actions cue-track-cell',
						) );
					endif;
					?>

					<span class="cue-track-length cue-track-cell"><?php echo esc_html( $track['length'] ); ?></span>

					<?php do_action( 'cuebar_track_after', $track ); ?>
				</li>

			<?php endforeach; ?>

		</ol>
	</div>

	<svg class="cue-icon-close" data-cue-control=".mejs-toggle-playlist-button button" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" fill="#000000" viewBox="0 0 32 32" height="32" width="32"><path d="M 19,15l 13,13l-2,2l-13-13l-13,13l-2-2l 13-13l-13-13l 2-2l 13,13l 13-13l 2,2z"></path></svg>
	<svg class="cue-icon-list" data-cue-control=".mejs-toggle-playlist-button button" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" viewBox="0 0 32 32" height="32" width="32"><path d="M 32,4l0,4 l-32,0 l0-4 l 32,0 zM0,14l 32,0 l0,4 l-32,0 l0-4 zM0,24l 32,0 l0,4 l-32,0 l0-4 z"></path></svg>
	<svg class="cue-icon-left-arrow" data-cue-control=".mejs-toggle-player-button button" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" viewBox="0 0 32 32" height="32" width="32"><path d="M 32,30l-15-15l 15-15l0,30 z"></path></svg>
	<svg class="cue-icon-next" data-cue-control=".mejs-next-button button" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" viewBox="0 0 32 32" height="32" width="32"><path d="M 20,16l-16,10l0-20 zM 28,6l0,20 l-6,0 l0-20 l 6,0 z"></path></svg>
	<svg class="cue-icon-pause" data-cue-control=".mejs-playpause-button button" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" fill="#000000" height="32" width="32"><path d="M 14,6l0,20 l-6,0 l0-20 l 6,0 zM 24,6l0,20 l-6,0 l0-20 l 6,0 z"></path></svg>
	<svg class="cue-icon-play" data-cue-control=".mejs-playpause-button button" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" viewBox="0 0 32 32" height="32" width="32"><path d="M 24,16l-16,10l0-20 z"></path></svg>
	<svg class="cue-icon-previous" data-cue-control=".mejs-previous-button button" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" viewBox="0 0 32 32" height="32" width="32"><path d="M 10,6l0,20 l-6,0 l0-20 l 6,0 zM 28,6l0,20 l-16-10z"></path></svg>
	<svg class="cue-icon-right-arrow" data-cue-control=".mejs-toggle-player-button button" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" viewBox="0 0 32 32" height="32" width="32"><path d="M0,30l 15-15l-15-15l0,30 z"></path></svg>
	<svg class="cue-icon-volume" data-cue-control=".mejs-volume-button button" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" viewBox="0 0 32 32" height="32" width="32"><path d="M 10,12l 6-6l0,20 l-6-6l-6,0 l0-8 l 6,0 zM 21.656,10.344l 1.422-1.422q 1.375,1.391 2.148,3.219t 0.773,3.859q0,1.359 -0.359,2.656t-1.008,2.398t-1.555,2.023l-1.422-1.422q 1.109-1.109 1.727-2.57t 0.617-3.086t-0.617-3.086t-1.727-2.57zM 18.828,13.172l 1.422-1.422q 0.406,0.422 0.727,0.898t 0.547,1.016t 0.352,1.133t 0.125,1.203 q0,1.219 -0.461,2.313t-1.289,1.938l-1.422-1.422q 1.172-1.172 1.172-2.828t-1.172-2.828z"></path></svg>
</div>
