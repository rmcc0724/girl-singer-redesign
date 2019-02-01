/*global _:false, wp:false */

/**
 * Customizer enhancements for a better user experience.
 *
 * Contains handlers to make the Customizer preview load changes asynchronously.
 */

(function( $, _, wp ) {
	'use strict';

	var attr = $.attr,
		api = wp.customize,
		apiPreview = api.Preview,
		$body = $( 'body' ),
		cssSettings = [ 'background_color', 'background_image', 'background_overlay_opacity', 'background_position_x', 'background_position_y' ],
		stylesTemplate = wp.template( 'obsidian-customizer-styles' ),
		$styles = $( '#obsidian-custom-css' ),
		$siteDescription = $( '.site-description' ),
		$siteLogoAnchor = $( '.site-logo-link' ),
		$siteLogo = $( '.site-logo' ),
		$siteTitle = $( '.site-title a' );

	if ( ! $styles.length ) {
		$styles = $( 'head' ).append( '<style type="text/css" id="obsidian-custom-css"></style>' )
							 .find( '#obsidian-custom-css' );
	}

	function updateCSS() {
		var css = stylesTemplate({
			backgroundColor: api( 'background_color' )(),
			backgroundImage: api( 'background_image' )(),
			backgroundOverlayOpacity: api( 'background_overlay_opacity' )() / 100,
			backgroundPositionX: api( 'background_position_x' )(),
			// The vertical position is a new setting in WP 4.7.
			backgroundPositionY: api.has( 'background_position_y' ) ? api( 'background_position_y' )() : 'center'
		});

		$styles.html( css );
	}

	// Site title.
	api( 'blogname', function( value ) {
		value.bind(function( to ) {
			$siteTitle.text( to );
		});
	});

	// Site description.
	api( 'blogdescription', function( value ) {
		value.bind(function( to ) {
			$siteDescription.text( to );
		});
	});

	// Background image overlay.
	api( 'enable_full_size_background_image', function( value ) {
		value.bind(function( to ) {
			$body.toggleClass( 'background-cover', to );
		});
	});

	// Update CSS when colors are changed.
	_.each( cssSettings, function( settingId ) {
		api( settingId, function( setting ) {
			setting.bind( updateCSS );
		});
	});

	// Front page logo.
	function getFrontLogoUrl() {
		return api( 'front_page_logo_url' )() || api( 'site_logo' )()['url'];
	}

	function setLogoUrl() {
		var url = getFrontLogoUrl();

		// Only toggle the logo on the front page.
		if ( $body.hasClass( 'home' ) ) {
			$siteLogo.attr( 'src', url ).toggle( !! url );
			$siteLogoAnchor.toggle( !! url );
			$body.toggleClass( 'has-site-logo', !! url );
		}
	}

	// Proxy the call to set the logo image src attribute to
	// prevent multiple callbacks from quickly changing the src
	// and causing the image not to load in some browsers.
	$.attr = function( elem, name, value ) {
		if (
			1 === elem.nodeType &&
			'src' === name &&
			elem.classList.contains( 'site-logo' ) &&
			$body.hasClass( 'home' )
		) {
			// Use a placeholder to prevent browsers from requesting the
			// current page if the src attribute is empty.
			value = getFrontLogoUrl() || 'data:image/gif;base64,R0lGODlhAQABAAAAADs=';
		}

		return attr.call( this, elem, name, value );
	};

	_.each( [ 'front_page_logo_url', 'site_logo' ], function( settingId ) {
		api( settingId, function( value ) {
			value.bind( setLogoUrl );
		});
	});

	// Update the logo URL when the Customizer Preview is ready since
	// is_front_page() doesn't seem to work in the Customizer.
	api.bind( 'preview-ready', function() {
		setLogoUrl();
	});

	/**
	 * Prevent clicks on submenu toggle buttons from sending preview events to
	 * the customizer.
	 *
	 * @link https://core.trac.wordpress.org/ticket/39098
	 */
	api.Preview = apiPreview.extend({
		handleLinkClick: function( e ) {
			if ( $( e.target ).hasClass( 'sub-menu-toggle' ) ) {
				return;
			}

			return apiPreview.prototype.handleLinkClick.call( this, e );
		}
	});

})( jQuery, _, wp );
