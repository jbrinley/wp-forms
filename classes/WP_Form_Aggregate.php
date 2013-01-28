<?php

/**
 * A form component that can have children
 */
interface WP_Form_Aggregate extends WP_Form_Component {

	/**
	 * @param WP_Form_Component $element
	 * @param string $key
	 *
	 * @return void
	 */
	public function add_element( WP_Form_Component $element, $key = '' );

	/**
	 * @param string $key
	 *
	 * @return void
	 */
	public function remove_element( $key );

	/**
	 * @param string $key
	 *
	 * @return WP_Form_Component
	 */
	public function get_element( $key );

	/**
	 * @return WP_Form_Component[]
	 */
	public function get_children();

}
