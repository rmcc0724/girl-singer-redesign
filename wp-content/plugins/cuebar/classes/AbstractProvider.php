<?php
/**
 * Base hook provider.
 *
 * @package   CueBar
 * @copyright Copyright (c) 2016, AudioTheme, LLC
 * @license   GPL-2.0+
 * @since     1.2.0
 */

/**
 * Base hook provider class.
 *
 * @package CueBar
 * @since   1.2.0
 */
abstract class CueBar_AbstractProvider {
	/**
	 * Plugin instance.
	 *
	 * @since 1.2.0
	 * @var CueBar_Plugin
	 */
	protected $plugin;

	/**
	 * Set a reference to the main plugin instance.
	 *
	 * @since 1.2.0
	 *
	 * @param CueBar_Plugin $plugin Main plugin instance.
	 */
	public function set_plugin( $plugin ) {
		$this->plugin = $plugin;
		return $this;
	}

	/**
	 * Register hooks.
	 *
	 * @since 1.2.0
	 */
	abstract public function register_hooks();
}
