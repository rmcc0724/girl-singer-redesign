/*global _playbarSettings:false, MediaElementPlayer:false, mejs:false */

(function( window, $, undefined ) {
	'use strict';

	$.extend( MediaElementPlayer.prototype, {
		buildplaybarplayertoggle: function( player, controls, layers, media ) {
			var state = 'open',
				history = player.cueHistory || null,
				selectors = player.options.cueSelectors;

			if ( history ) {
				state = history.get( 'visibility' ) || 'open';
			}

			$( selectors.playlist ).toggleClass( 'is-closed', ( 'closed' === state ) );

			$( '<div class="mejs-button mejs-toggle-player-button mejs-toggle-player">' +
				'<button type="button" aria-controls="' + player.id + '" title="' + _playbarSettings.l10n.togglePlayer + '"></button>' +
				'</div>' )
			.appendTo( player.controls )
			.on( 'click', function() {
				state = 'open' === state ? 'closed' : 'open';
				$( this ).closest( selectors.playlist ).toggleClass( 'is-closed', ( 'closed' === state ) );

				if ( history ) {
					history.set( 'visibility', state );
				}
			});
		}
	});

	$( document ).ready(function( $ ) {
		var $window = $( window ),
			$toolbar = $( '#wpadminbar' ),
			$playbar = $( '.playbar' ),
			$tracklist = $playbar.find( '.cue-tracks' ),
			$data = $playbar.siblings( '.cue-playlist-data, script' ).eq( 0 ),
			data = {},
			throttle = false;

		if ( $data.length ) {
			data = JSON.parse( $data.html() );
		}

		$window.on( 'load resize orientationchange scroll', function() {
			if ( throttle ) {
				return;
			}

			throttle = true;
			setTimeout(function() {
				var windowHeight = window.innerHeight || $window.height();
				$tracklist.css( 'maxHeight', windowHeight - $toolbar.height() - $playbar.height() + 'px' );
				throttle = false;
			}, 250 );
		});

		// Initialize the PlayBar.
		$playbar.cuePlaylist({
			audioVolume: 'vertical',
			classPrefix: 'mejs-',
			cueDisableControlsSizing: true,
			cueId: 'playbar',
			cuePlaylistLoop: false,
			cuePlaylistToggle: '',
			cueResponsiveProgress: true,
			cueSelectors: {
				playlist: '.playbar',
				tracklist: '.cue-tracks'
			},
			cueSkin: 'cue-skin-playbar',
			cueSignature: data.signature,
			enableAutosize: false,
			features: [
				'cuehistory',
				'playbarhistory',
				'cueartwork',
				'cuecurrentdetails',
				'cueprevioustrack',
				'playpause',
				'cuenexttrack',
				'progress',
				'current',
				'duration',
				'volume',
				'cueplaylist',
				'cueplaylisttoggle',
				'playbarplayertoggle',
				'cueicons'
			],
			setDimensions: false,
			timeFormat: 'm:ss'
		});
	});

})( window, jQuery );
