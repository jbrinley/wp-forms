<?php

interface WP_Form_Attributes_Interface {

	/**
	 * @param string $key
	 * @param string $value
	 *
	 * @return void
	 */
	public function set_attribute( $key, $value );

	/**
	 * @param string $key
	 *
	 * @return string
	 */
	public function get_attribute( $key );

	/**
	 * @return array
	 */
	public function get_all_attributes();

	/**
	 * @param string $class
	 *
	 * @return void
	 */
	public function add_class( $class );

	/**
	 * @param string $class
	 *
	 * @return void
	 */
	public function remove_class( $class );

	/**
	 * @param array $classes
	 *
	 * @return void
	 */
	public function set_classes( array $classes );

	/**
	 * @return array
	 */
	public function get_classes();

}
