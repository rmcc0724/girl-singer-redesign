/*global _cuebarSettings:false, MediaElementPlayer:false, mejs:false */

window.cuebar = window.cuebar || {};

(function( window, $, undefined ) {
	'use strict';

	var cuebar = window.cuebar;

	$.extend( mejs.MepDefaults, {
		cuebarId: 'cuebar',
		cuebarSignature: ''
	});

	$.extend( MediaElementPlayer.prototype, {
		buildcuebarplayertoggle: function( player, controls, layers, media ) {
			var state = player.options.cuebarInitialState,
				history = player.cueHistory || null,
				selectors = player.options.cueSelectors;

			if ( history ) {
				state = history.get( 'visibility' ) || state;
			}

			$( selectors.playlist ).toggleClass( 'is-closed', ( 'closed' === state ) );

			$( '<div class="mejs-button mejs-toggle-player-button mejs-toggle-player">' +
				'<button type="button" aria-controls="' + player.id + '" title="' + _cuebarSettings.l10n.togglePlayer + '"></button>' +
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

	$.extend( cuebar, {
		settings: {
			audioVolume: 'vertical',
			classPrefix: 'mejs-',
			cuebarInitialState: 'open',
			cueDisableControlsSizing: true,
			cuePlaylistLoop: false,
			cuePlaylistToggle: '',
			cueResponsiveProgress: true,
			cueSelectors: {
				playlist: '.cuebar',
				tracklist: '.cue-tracks'
			},
			cueSkin: 'cue-skin-cuebar',
			enableAutosize: false,
			features: [
				'cuehistory',
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
				'cuebarplayertoggle',
				'cueicons'
			],
			setDimensions: false,
			timeFormat: 'm:ss'
		}
	});

	$( document ).ready(function( $ ) {
		var $window = $( window ),
			$toolbar = $( '#wpadminbar' ),
			$cuebar = $( '.cuebar' ),
			$tracklist = $cuebar.find( '.cue-tracks' ),
			$data = $cuebar.siblings( '.cue-playlist-data, script' ).eq( 0 ),
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
				$tracklist.css( 'maxHeight', windowHeight - $toolbar.height() - $cuebar.height() + 'px' );
				throttle = false;
			}, 250 );
		});

		if ( ! ( 'cueSignature' in cuebar.settings ) && 'signature' in data ) {
			cuebar.settings.cueSignature = data.signature;
		}

		// Initialize the CueBar.
		$cuebar.cuePlaylist( cuebar.settings );
	});

})( window, jQuery );
