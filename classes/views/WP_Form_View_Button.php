<?php

class WP_Form_View_Button extends WP_Form_View {
	public function render( WP_Form_Component $element ) {
		$type = $element->get_type();
		if ( method_exists( $this, $type ) ) {
			return call_user_func( array( $this, $type ), $element );
		} elseif ( $element instanceof WP_Form_Element ) {
			return $this->button($element); // fallback to generic <input />
		}
		return '';
	}

	protected function button( WP_Form_Element $element ) {
		$attributes = $element->get_all_attributes();
		$label = $element->get_label();
		$attributes = WP_Form_View::prepare_attributes($attributes);
		$template = '<button %s>%s</button>';
		return sprintf( $template, $attributes, $label );
	}

}
