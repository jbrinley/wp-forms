<?php

class WP_Form_Element_Select extends WP_Form_Element_Multiple {
	protected $type = 'select';
	protected $default_view = 'WP_Form_View_Select';


	/**
	 * Don't need the extra attributes of an input element
	 * @return array
	 */
	public function get_all_attributes() {
		$attributes = $this->attributes->get_all_attributes();
		return $attributes;
	}

	public function get_selected() {
		if ( !empty($this->value) ) {
			return $this->value;
		}
		return $this->default_value;
	}
}
