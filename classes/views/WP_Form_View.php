<?php

abstract class WP_Form_View implements WP_Form_View_Interface {
	public function render( WP_Form_Component $element ) {
		$type = $element->get_type();
		if ( method_exists( $this, $type ) ) {
			return call_user_func( array( $this, $type ), $element );
		}
		return '';
	}

	protected function input( WP_Form_Element $element ) {
		$attributes = $element->get_all_attributes();
		$attributes = WP_Form_View::prepare_attributes($attributes);
		$template = '<input %s />';
		return sprintf( $template, $attributes );
	}

	public static function prepare_attributes( $attributes ) {
		$atts = array();
		foreach ( $attributes as $key => $value ) {
			if ( is_array($value) ) {
				$value = implode(' ', array_map('esc_attr', $value));
			} else {
				$value = esc_attr($value);
			}
			$atts[] = sprintf('%s="%s"', esc_attr($key), $value);
		}
		return implode(' ', $atts);
	}
}
