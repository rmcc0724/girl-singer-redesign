<?php
/**
 * Deprecated methods.
 *
 * @package   CueBar
 * @copyright Copyright (c) 2014, AudioTheme, LLC
 * @license   GPL-2.0+
 * @since     1.2.0
 */

if ( ! defined( 'CUEBAR_DIR' ) ) {
	/**
	 * Path directory path.
	 *
	 * @since 1.0.0
	 * @type string CUEBAR_DIR
	 */
	define( 'CUEBAR_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'CUEBAR_URL' ) ) {
	/**
	 * URL to the plugin's root directory.
	 *
	 * Includes trailing slash.
	 *
	 * @since 1.0.0
	 * @type string CUEBAR_URL
	 */
	define( 'CUEBAR_URL', plugin_dir_url( __FILE__ ) );
}

class CueBar extends CueBar_Plugin {}
class CueBar_Customize extends CueBar_Provider_Customize {}
