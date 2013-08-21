<?php

/**
 * A form component that can have children
 */
interface WP_Form_Aggregate extends WP_Form_Component {

	/**
	 * Add a child component
	 *
	 * @param WP_Form_Component $element
	 * @param string $key A unique key for the component.
	 *                    Any existing component with the same key
	 *                    will be overwritten. If $key is empty,
	 *                    an attempt will be made to generate a
	 *                    unique key.
	 *
	 * @return WP_Form_Aggregate
	 */
	public function add_element( WP_Form_Component $element, $key = '' );

	/**
	 * Remove a child component
	 *
	 * @param string $key
	 *
	 * @return WP_Form_Aggregate
	 */
	public function remove_element( $key );

	/**
	 * Get the element with the given key
	 *
	 * @param string $key
	 *
	 * @return WP_Form_Component|NULL
	 */
	public function get_element( $key );

	/**
	 * Get an array of all child components.
	 *
	 * @return WP_Form_Component[]
	 */
	public function get_children();

}
