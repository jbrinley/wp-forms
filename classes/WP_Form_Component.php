<?php

interface WP_Form_Component {
	public function render();

	public function get_type();

	public function get_id();

	public function get_name();

	/**
	 * @return bool Whether the component has been rendered
	 */
	public function is_rendered();

	/**
	 * @return WP_Form_View_Interface
	 */
	public function get_view();

	/**
	 * @return int
	 */
	public function get_priority();

	/**
	 * @return array
	 */
	public function get_errors();

	/**
	 * @param string $error
	 * @return void
	 */
	public function set_error( $error );

	public function clear_errors();

}
