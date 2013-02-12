<?php

interface WP_Form_Attributes_Interface {

	/**
	 * Set an attribute
	 *
	 * @param string $key
	 * @param string $value
	 *
	 * @return void
	 */
	public function set_attribute( $key, $value );

	/**
	 * Get the value of an attribute
	 *
	 * @param string $key
	 *
	 * @return string
	 */
	public function get_attribute( $key );

	/**
	 * Get all attributes that have been set
	 *
	 * @return array
	 */
	public function get_all_attributes();

	/**
	 * Add a class
	 *
	 * @param string $class
	 *
	 * @return void
	 */
	public function add_class( $class );

	/**
	 * Remove a class
	 *
	 * @param string $class
	 *
	 * @return void
	 */
	public function remove_class( $class );

	/**
	 * Overwrite all currently set classes with a new array of classes
	 *
	 * @param array $classes
	 *
	 * @return void
	 */
	public function set_classes( array $classes );

	/**
	 * Get an array of all assigned classes
	 *
	 * @return array
	 */
	public function get_classes();

}
