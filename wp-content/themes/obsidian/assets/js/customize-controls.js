/*global _:false, wp:false */

(function( $, _, wp, undefined ) {
	'use strict';

	var api = wp.customize,
		controls = [
			'obsidian_background_overlay_opacity',
			'obsidian_enable_full_size_background_image'
		];

	api( 'background_image', function( setting ) {
		_.each( controls, function( controlId ) {
			api.control( controlId, function( control ) {
				var toggleVisibility = function( value ) {
					control.container.toggle( '' !== value );
				};

				toggleVisibility( setting() );
				setting.bind( toggleVisibility );
			});
		});
	});

	// Set 'enable_full_size_background_image' setting to true when the core
	// background settings match. WP 4.7 introduced the 'background_size'
	// setting.
	function updateFullSizeBackgroundImageSetting() {
		var attachment = api( 'background_attachment' )(),
			size = api( 'background_size' )();

		api( 'enable_full_size_background_image' ).set( 'fixed' === attachment && 'cover' === size );
	}

	api.bind( 'ready', function() {
		if ( api.has( 'background_size' ) ) {
			// Update the 'enable_full_size_background_image' setting when size or
			// attachment settings change.
			_.each([ 'background_attachment', 'background_size'], function( settingId ) {
				api( settingId, function( setting ) {
					setting.bind( updateFullSizeBackgroundImageSetting );
				});
			});
		}
	});

})( jQuery, _, wp );
