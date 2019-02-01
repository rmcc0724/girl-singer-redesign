/* global _, _audiothemeTracklistSettings, Backbone, jQuery, wp */

(function( window, $, _, Backbone, wp, undefined ) {
	'use strict';

	var settings = _audiothemeTracklistSettings;

	$( document ).ready(function() {
		$( '#record-links' ).audiothemeRepeater();

		$( '#record-tracklist' )
			.audiothemeRepeater({ items: JSON.parse( settings.tracks ) })
			.on( 'addItem.audiotheme', function( e, track ) {
				wp.ajax.post( 'audiotheme_ajax_get_default_track', {
					record: settings.postId,
					nonce: settings.nonce
				}).done(function( response ) {
					track.find( 'input.post-id' ).val( response.track.ID );
					settings.nonce = response.nonce;
				});
			});

		$( '#record-tracklist' ).on( 'selectionChange.audiotheme', function( e, selection ) {
			var $track = $( e.target ).closest( 'tr' ),
				attachment = selection.first().toJSON();

			_.each( [ 'title', 'artist', 'length' ], function( key ) {
				var $field = $track.find( '.audiotheme-tracklist-track-' + key ),
					value = $field.val();

				if ( '' === value && value !== attachment.audiotheme[ key ] ) {
					key = 'length' === key ? 'length_formatted' : key;
					$field.val( attachment.audiotheme[ key ] ).trigger( 'change' );
				}
			});
		});
	});

})( window, jQuery, _, Backbone, wp );
