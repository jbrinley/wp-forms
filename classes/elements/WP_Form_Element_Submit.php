<?php

class WP_Form_Element_Submit extends WP_Form_Element {
	protected $type = 'submit';
	protected $default_decorators = array(
		'WP_Form_Decorator_HtmlTag' => array(),
	);

	/**
	 * @return array
	 */
	public function get_all_attributes() {
		$attributes = parent::get_all_attributes();
		if ( empty($attributes['value']) && isset($attributes['value']) ) {
			unset($attributes['value']);
		}
		return $attributes;
	}
}
