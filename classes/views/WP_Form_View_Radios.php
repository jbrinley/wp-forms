<?php

class WP_Form_View_Radios extends WP_Form_View {
	protected function radios( WP_Form_Element_Radios $element ) {
		$attributes = $element->get_all_attributes();
		if ( empty($attributes['name']) ) {
			throw new LogicException(__('Cannot render radio group without a name', 'wp-forms'));
		}
		$options = $element->get_options();
		$output = '';
		foreach ( $options as $key => $label ) {
			$output .= $this->radio( $key, $label, $attributes );
		}
		return $output;
	}

	protected function radio( $key, $label, $attributes ) {
		$radio = WP_Form_Element::create('radio')
			->set_name($attributes['name'])
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
			$radio->set_attribute($att, $value);
		}
		do_action('wp_form_radio_group_member', $radio);
		return $radio->render();
	}
}
