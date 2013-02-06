<?php

class WP_Form_View_Select extends WP_Form_View {

	protected function select( WP_Form_Element_Select $element ) {
		$attributes = $element->get_all_attributes();
		$attributes = WP_Form_View::prepare_attributes($attributes);
		$template = '<select %s>%s</select>';
		$options = $element->get_options();
		$options_html = '';
		$selected = $element->get_selected();
		foreach ( $options as $key => $value ) {
			if ( is_array($value) ) {
				$options_html .= $this->optgroup( $key, $value, $selected );
			} else {
				$options_html .= $this->option( $key, $value, $selected );
			}
		}
		return sprintf( $template, $attributes, $options_html );
	}

	protected function optgroup( $label, $options, $selected ) {
		$html = sprintf( '<optgroup label="%s">', esc_attr($label) );
		foreach ( $options as $key => $value ) {
			$html .= $this->option( $key, $value, $selected );
		}
		$html .= '</optgroup>';
		return $html;
	}

	protected function option( $key, $label, $selected ) {
		$option_template = '<option value="%s"%s>%s</option>';
		return sprintf($option_template, esc_attr($key), selected($selected, $key, FALSE), esc_html($label));
	}

}
