<?php

class WP_Form_View_Textarea extends WP_Form_View {
	public function render( WP_Form_Component $element ) {
		$type = $element->get_type();
		if ( method_exists( $this, $type ) ) {
			return call_user_func( array( $this, $type ), $element );
		} elseif ( $element instanceof WP_Form_Element ) {
			return $this->textarea($element); // fallback to generic <input />
		}
		return '';
	}

	protected function textarea( WP_Form_Element $element ) {
		$attributes = $element->get_all_attributes();
		$value = '';
		if ( isset($attributes['value']) ) {
			$value = esc_textarea( $attributes['value'] );
			unset($attributes['value']);
		}
		$attributes = WP_Form_View::prepare_attributes($attributes);
		$template = '<textarea %s>%s</textarea>';
		return sprintf( $template, $attributes, $value );
	}

}
