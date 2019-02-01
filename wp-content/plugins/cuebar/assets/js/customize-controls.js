/*global _:false, wp:false */

(function( $, _, wp, cuebar, undefined ) {
	'use strict';

	var api = wp.customize;
	
	api( 'cuebar_colors[player]', function( setting ) {
		setting.bind( _.throttle(function( value ) {
			var colors = cuebar.getColors( value );

			api( 'cuebar_colors[alt_background]' ).set( colors.altBackgroundColor );
			api( 'cuebar_colors[contrast]' ).set( colors.contrastColor );
			api( 'cuebar_colors[loaded_bar]' ).set( colors.loadedBarColor );
			api( 'cuebar_colors[play_bar]' ).set( colors.playBarColor );

			api( 'cuebar_styles' ).set( cuebar.getPlayerStyles( value ) );
		}, 250 ));
	});

	$( document ).ready(function() {
		api.control( 'cuebar_player_color' )
			.container
			.find( '.color-picker-hex' ).iris( 'option', 'palettes', [
				'#000',
				'#fff',
				'#e54839',
				'#bf9469',
				'#1470cc',
				'#6f6680',
				'#e5e65c',
				'#19a6a6',
				'#d5dbe0'
			]);
	});

})( jQuery, _, wp, window.cuebar || {} );
