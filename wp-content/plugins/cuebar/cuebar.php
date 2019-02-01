<?php
/**
 * CueBar
 *
 * @package   CueBar
 * @copyright Copyright (c) 2014, AudioTheme, LLC
 * @license   GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: CueBar
 * Plugin URI:  https://audiotheme.com/view/cuebar/
 * Description: Showcase your music with a sleek, fun audio bar anchored to the bottom of your website and allow visitors to hear your tunes as they browse.
 * Version:     1.3.2
 * Author:      AudioTheme
 * Author URI:  https://audiotheme.com/
 * License:     GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cuebar
 * Domain Path: /languages
 */

/**
 * Include functions and libraries.
 */
require( dirname( __FILE__ ) . '/classes/AbstractPlugin.php' );
require( dirname( __FILE__ ) . '/classes/AbstractProvider.php' );
require( dirname( __FILE__ ) . '/classes/Provider/Customize.php' );
require( dirname( __FILE__ ) . '/classes/Plugin.php' );
require( dirname( __FILE__ ) . '/includes/deprecated.php' );

/**
 * Retrieve the main plugin instance.
 *
 * @since 1.0.0
 *
 * @return CueBar_Plugin
 */
function cuebar() {
	static $instance;

	if ( null === $instance ) {
		$instance = new CueBar_Plugin();
	}

	return $instance;
}

/**
 * Initialize the plugin.
 */
$cuebar = cuebar()
	->set_basename( plugin_basename( __FILE__ ) )
	->set_directory( plugin_dir_path( __FILE__ ) )
	->set_file( __FILE__ )
	->set_slug( 'cuebar' )
	->set_url( plugin_dir_url( __FILE__ ) )
	->register_hooks( new CueBar_Provider_Customize() );

/**
 * Localize the plugin.
 *
 * @since 1.2.0
 */
function cuebar_load_textdomain() {
	$plugin_rel_path = dirname( plugin_basename( __FILE__ ) ) . '/languages';
	load_plugin_textdomain( 'cuebar', false, $plugin_rel_path );
}
add_action( 'plugins_loaded', 'cuebar_load_textdomain' );

/**
 * Load the plugin.
 */
add_action( 'plugins_loaded', array( $cuebar, 'load_plugin' ) );
