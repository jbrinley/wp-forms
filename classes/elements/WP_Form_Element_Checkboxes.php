<?php

class WP_Form_Element_Checkboxes extends WP_Form_Element_Multiple {
	protected $type = 'checkboxes';
	protected $default_view = 'WP_Form_View_Checkboxes';

	public function get_selected() {
		if ( !empty($this->value) ) {
			return $this->value;
		}
		return $this->default_value;
	}
}
