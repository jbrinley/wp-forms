<?php

class WP_Form_View_Select extends WP_Form_View {

	protected function select( WP_Form_Element_Select $element ) {
		$attributes = $element->get_all_attributes();
		$attributes = WP_Form_View::prepare_attributes($attributes);
		$template = '<select %s>%s</select>';
		$options = $element->get_options();
		$option_template = '<option value="%s">%s</option>';
		$options_html = '';
		foreach ( $options as $key => $value ) {
			$options_html .= sprintf($option_template, esc_attr($key), esc_html($value));
		}
		return sprintf( $template, $attributes, $options_html );
	}

}
