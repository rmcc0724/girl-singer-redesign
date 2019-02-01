/*global _obsidianSettings:false, AudiothemeTracks:false */

window.cue = window.cue || {};
window.obsidian = window.obsidian || {};

(function( window, $, undefined ) {
	'use strict';

	var cue      = window.cue,
		obsidian = window.obsidian;

	// Localize jquery.cue.js.
	cue.l10n = $.extend( cue.l10n, _obsidianSettings.l10n );

	$.extend( obsidian, {
		config: {
			tracklist: {
				classPrefix: 'mejs-',
				cueSkin: 'obsidian-tracklist',
				cueSelectors: {
					playlist: '.tracklist-area',
					track: '.track',
					trackCurrentTime: '.track-current-time',
					trackDuration: '.track-duration'
				},
				enableAutosize: false,
				features: [ 'cueplaylist' ],
				pluginPath: _obsidianSettings.mejs.pluginPath,
				setDimensions: false,
				timeFormat: 'm:ss'
			}
		},

		init: function() {
			$( 'body' ).addClass( 'ontouchstart' in window || 'onmsgesturechange' in window ? 'touch' : 'no-touch' );

			// Open external links in a new window.
			$( '.js-maybe-external' ).each(function() {
				if ( this.hostname && this.hostname !== window.location.hostname ) {
					$( this ).attr( 'target', '_blank' );
				}
			});

			// Open new windows for links with a class of '.js-popup'.
			$( '.js-popup' ).on( 'click', function( e ) {
				var $this       = $( this ),
					popupId     = $this.data( 'popup-id' ) || 'popup',
					popupUrl    = $this.data( 'popup-url' ) || $this.attr( 'href' ),
					popupWidth  = $this.data( 'popup-width' ) || 550,
					popupHeight = $this.data( 'popup-height' ) || 260;

				e.preventDefault();

				window.open( popupUrl, popupId, [
					'width=' + popupWidth,
					'height=' + popupHeight,
					'directories=no',
					'location=no',
					'menubar=no',
					'scrollbars=no',
					'status=no',
					'toolbar=no'
				].join( ',' ) );
			});
		},

		/**
		 * Set up the background image.
		 *
		 * Prevents the background image from jumping/zooming on mobile devices
		 * after scrolling.
		 */
		setupBackground: function() {
			var isThrottled = false,
				$overlay = $( '.obsidian-background-overlay' );

			if ( ! this.isMobile() ) {
				return;
			}

			$overlay.css( 'bottom', 'auto' ).height( screen.height );

			$( window ).on( 'load orientationchange resize', function() {
				if ( isThrottled ) {
					return;
				}

				isThrottled = true;
				setTimeout(function() {
					$overlay.height( screen.height );
					isThrottled = false;
				}, 150 );
			});
		},

		/**
		 * Set up the main navigation.
		 */
		setupNavigation: function() {
			var $navigation = $( '.site-navigation' );

			// Toggle the main menu.
			$( '.site-navigation-toggle' ).on( 'click', function() {
				$navigation.toggleClass( 'is-open' );
			});

			$navigation.find( '.menu' ).cedaroNavMenu({
				breakpoint: 768,
				submenuToggleInsert: 'append'
			});
		},

		setupTracklist: function() {
			var $tracklist = $( '.tracklist-area' );

			if ( $tracklist.length && $.isFunction( $.fn.cuePlaylist ) ) {
				$tracklist.cuePlaylist( $.extend( this.config.tracklist, {
					cuePlaylistTracks: AudiothemeTracks.record
				}));
			}
		},

		/**
		 * Set up videos.
		 *
		 * - Makes videos responsive.
		 * - Moves videos embedded in page content to an '.entry-video'
		 *   container. Used primarily with the WPCOM single video templates.
		 */
		setupVideos: function() {
			if ( $.isFunction( $.fn.fitVids ) ) {
				$( '.hentry' ).fitVids();
			}

			$( 'body.page' ).find( '.single-video' ).find( '.jetpack-video-wrapper' ).first().appendTo( '.entry-video' );
		},

		/**
		 * Whether the current device is mobile.
		 *
		 * @return {boolean}
		 */
		isMobile: function() {
			return ( /Android|iPhone|iPad|iPod|BlackBerry/i ).test( navigator.userAgent || navigator.vendor || window.opera );
		}
	});

	// Document ready.
	jQuery(function() {
		obsidian.init();
		obsidian.setupBackground();
		obsidian.setupNavigation();
		obsidian.setupTracklist();
		obsidian.setupVideos();
	});
})( this, jQuery );
