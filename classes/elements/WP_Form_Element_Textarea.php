<?php

class WP_Form_Element_Textarea extends WP_Form_Element {
	protected $type = 'textarea';
	protected $default_view = 'WP_Form_View_Textarea';

	/**
	 * @return array
	 */
	public function get_all_attributes() {
		$attributes = parent::get_all_attributes();
		if ( !isset($attributes['rows']) ) {
			$attributes['rows'] = 5;
		}
		if ( !isset($attributes['cols']) ) {
			$attributes['cols'] = 40;
		}
		return $attributes;
	}
}
