<?php

class WP_Form_Element_Reset extends WP_Form_Element {
	protected $type = 'reset';
	protected $default_decorators = array(
		'WP_Form_Decorator_HtmlTag' => array(),
	);

	/**
	 * @return array
	 */
	public function get_all_attributes() {
		$attributes = parent::get_all_attributes();
		// don't explicitly set an empty value, let the browser use its default
		if ( empty($attributes['value']) && isset($attributes['value']) ) {
			unset($attributes['value']);
		}
		return $attributes;
	}
}
