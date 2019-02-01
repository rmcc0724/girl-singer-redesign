<?php
/**
 * Module collection.
 *
 * @package   AudioTheme\Modules
 * @copyright Copyright 2012 AudioTheme
 * @license   GPL-2.0+
 * @link      https://audiotheme.com/
 * @since     2.0.0
 */

/**
 * Module collection class.
 *
 * @package AudioTheme\Modules
 * @since   2.0.0
 */
class AudioTheme_ModuleCollection implements ArrayAccess, Countable, Iterator {
	/**
	 * Modules.
	 *
	 * @since 2.0.0
	 * @var array
	 */
	protected $modules;

	/**
	 * Register a module.
	 *
	 * @since 2.0.0
	 *
	 * @param string            $id Module id.
	 * @param AudioTheme_Module $module Module object.
	 * @return $this
	 */
	public function register( $module ) {
		$this->modules[ $module->id ] = $module;
		return $this;
	}

	/**
	 * Whether a module is active.
	 *
	 * @since 2.0.0
	 *
	 * @param string $module_id Module identifier.
	 * @return bool
	 */
	public function is_active( $module_id ) {
		if ( isset( $this->modules[ $module_id ] ) ) {
			return $this->modules[ $module_id ]->is_active();
		}

		return false;
	}

	/**
	 * Retrieve all module ids.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	public function keys() {
		return array_keys( $this->modules );
	}

	/**
	 * Retrieve all active modules.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	public function get_active_keys() {
		$module_ids = array();
		foreach ( $this->keys() as $id ) {
			if ( ! $this->is_active( $id ) ) {
				continue;
			}
			$module_ids[] = $id;
		}
		return $module_ids;
	}

	/**
	 * Retrieve inactive modules.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	public function get_inactive_keys() {
		$module_ids = array();
		foreach ( $this->keys() as $id ) {
			if ( $this->is_active( $id ) ) {
				continue;
			}
			$module_ids[] = $id;
		}
		return $module_ids;
	}

	/**
	 * Activate a module.
	 *
	 * @since 2.0.0
	 *
	 * @param string $module_id Module identifier.
	 * @return $this
	 */
	public function activate( $module_id ) {
		$modules = $this->get_inactive_keys();
		unset( $modules[ array_search( $module_id, $modules ) ] );
		update_option( 'audiotheme_inactive_modules', array_values( $modules ) );
		return $this;
	}

	/**
	 * Deactivate a module.
	 *
	 * @since 2.0.0
	 *
	 * @param string $module_id Module identifier.
	 * @return $this
	 */
	public function deactivate( $module_id ) {
		$modules = $this->get_inactive_keys();
		$modules = array_unique( array_merge( $modules, array( $module_id ) ) );
		sort( $modules );
		update_option( 'audiotheme_inactive_modules', $modules );
		return $this;
	}

	/**
	 * Prepare a module for use in JavaScript.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	public function prepare_for_js() {
		$data = array();
		foreach ( $this->modules as $module ) {
			$data[] = $module->prepare_for_js();
		}
		return $data;
	}

	/**
	 * Retrieve the number of registered modules.
	 *
	 * @since 2.0.0
	 *
	 * @return int
	 */
	public function count() {
		return count( $this->modules );
	}

	/**
	 * Retrieve the current module in an iterator.
	 *
	 * @since 2.0.0
	 *
	 * @return AudioTheme_Module
	 */
	public function current() {
		return current( $this->modules );
	}

	/**
	 * Retrieve the key of the current module in an iterator.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	public function key() {
		return key( $this->modules );
	}

	/**
	 * Move the pointer to the next module.
	 *
	 * @since 2.0.0
	 */
	public function next() {
		next( $this->modules );
	}

	/**
	 * Reset to the first module.
	 *
	 * @since 2.0.0
	 */
	public function rewind() {
		reset( $this->modules );
	}

	/**
	 * Check if the current position is valid.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function valid() {
		return key( $this->modules ) !== null;
	}

	/**
	 * Whether an item exists at the given offset.
	 *
	 * @since 2.0.0
	 *
	 * @param string $offset Item identifier.
	 * @return bool
	 */
	public function offsetExists( $offset ) {
		return isset( $this->modules[ $offset ] );
	}

	/**
	 * Retrieve a module.
	 *
	 * @since 2.0.0
	 *
	 * @param string $offset Item identifier.
	 * @return array
	 */
	public function offsetGet( $offset ) {
		return isset( $this->modules[ $offset ] ) ? $this->modules[ $offset ] : null;
	}

	/**
	 * Register a module.
	 *
	 * @since 2.0.0
	 *
	 * @param string $offset Item identifier.
	 * @param array  $value Item data.
	 */
	public function offsetSet( $offset, $value ) {
		$this->modules[ $offset ] = $value;
	}

	/**
	 * Remove a module.
	 *
	 * @since 2.0.0
	 *
	 * @param string $offset Item identifier.
	 */
	public function offsetUnset( $offset ) {
		unset( $this->modules[ $offset ] );
	}
}
