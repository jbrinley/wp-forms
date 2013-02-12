<?php

interface WP_Form_Component {
	/**
	 * @return string The rendered component, as defined by its current view
	 */
	public function render();

	/**
	 * @return string The component type
	 */
	public function get_type();

	/**
	 * @return string The component's ID
	 */
	public function get_id();

	/**
	 * @return string The component's name
	 */
	public function get_name();

	/**
	 * @return WP_Form_View_Interface The view that
	 *         will render the component
	 */
	public function get_view();

	/**
	 * @return int The sorting priority
	 *             of the component. Smaller numbers
	 *             come before larger numbers.
	 */
	public function get_priority();

	/**
	 * @return array A list of errors for this component
	 */
	public function get_errors();

	/**
	 * Set an error on this component.
	 *
	 * @param string $error
	 * @return WP_Form_Component
	 */
	public function set_error( $error );

	/**
	 * Clear all errors that have been set on this component.
	 *
	 * @return WP_Form_Component
	 */
	public function clear_errors();

}
