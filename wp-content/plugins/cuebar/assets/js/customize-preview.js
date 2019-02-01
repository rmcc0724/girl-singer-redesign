/*global _:false, wp:false */

(function( window, $, _, wp, cuebar, undefined ) {
	'use strict';

	var api = wp.customize,
		$styles = $( '#cuebar-custom-css' );

	if ( ! $styles.length ) {
		$styles = $( 'head' ).append( '<style type="text/css" id="cuebar-custom-css"></style>' )
		                     .find( '#cuebar-custom-css' );
	}

	api( 'cuebar_styles', function( setting ) {
		setting.bind(function( value ) {
			$styles.html( value );
		});
	});

})( this, jQuery, _, wp, window.cuebar || {} );
