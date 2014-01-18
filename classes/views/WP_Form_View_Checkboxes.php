<?php

class WP_Form_View_Checkboxes extends WP_Form_View {
	protected function checkboxes( WP_Form_Element_Checkboxes $element ) {
		$attributes = $element->get_all_attributes();
		if ( empty($attributes['name']) ) {
			throw new LogicException(__('Cannot render checkbox group without a name', 'wp-forms'));
		}
		$options = $element->get_options();
		$selected = $element->get_selected();
		$output = '';
		foreach ( $options as $key => $label ) {
			$checked = false;
			if ( is_array( $selected ) && in_array( $key, $selected ) ) {
				$checked = true;
			}
			$output .= $this->checkbox( $key, $label, $attributes, $checked );
		}
		return $output;
	}

	protected function checkbox( $key, $label, $attributes, $checked ) {
		$checkbox = WP_Form_Element::create('checkbox')
			->set_name($attributes['name'].'[]')
			->set_label($label)
			->set_value($key)
			->set_attribute('id', $attributes['name'].'-'.$key);
		if ( isset($attributes['type']) ) {
			unset($attributes['type']);
		}
		if ( isset($attributes['name']) ) {
			unset($attributes['name']);
		}
		if ( isset($attributes['value']) ) {
			unset($attributes['value']);
		}
		foreach ( $attributes as $att => $value ) {
			$checkbox->set_attribute($att, $value);
		}
		if ( $checked ) {
			$checkbox->set_attribute('checked', 'checked');
		}
		return $checkbox->render();
	}
}
