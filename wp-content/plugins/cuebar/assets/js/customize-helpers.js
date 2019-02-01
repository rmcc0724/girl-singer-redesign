/*global _:false, wp:false */

window.cuebar = window.cuebar || {};

(function( $, _, wp, undefined ) {
	'use strict';

	var cuebar = window.cuebar,
		stylesTemplate = wp.template( 'cuebar-styles' );

	// http://24ways.org/2010/calculating-color-contrast/
	function getContrastYIQ( hexcolor ){
		var r, g, b, yiq;

		hexcolor = 0 === hexcolor.indexOf( '#' ) ? hexcolor.substr( 1 ) : hexcolor;
		r = parseInt( hexcolor.substr( 0, 2 ), 16 );
		g = parseInt( hexcolor.substr( 2, 2 ), 16 );
		b = parseInt( hexcolor.substr( 4, 2 ), 16 );
		yiq = ( ( r * 299 ) + ( g * 587 ) + ( b * 114 ) ) / 1000;
	
		return ( yiq >= 128 ) ? 'black' : 'white';
	}

	cuebar.getColors = function( playerColor ) {
		var contrastColor = getContrastYIQ( playerColor );

		return {
			altBackgroundColor: 'black' === contrastColor ? 'rgba(0, 0, 0, 0.15)' : 'rgba(255, 255, 255, 0.2)',
			contrastColor: 'black' === contrastColor ? '#000000' : '#ffffff',
			loadedBarColor: 'black' === contrastColor ? 'rgba(0, 0, 0, 0.03)' : 'rgba(255, 255, 255, 0.05)',
			playBarColor: 'black' === contrastColor ? 'rgba(0, 0, 0, 0.1)' : 'rgba(255, 255, 255, 0.15)',
			playerColor: playerColor
		};
	};

	cuebar.getPlayerStyles = function( playerColor ) {
		return stylesTemplate( cuebar.getColors( playerColor ) ).replace( /[\s]{2,}/g, '' );
	};

})( jQuery, _, wp );
