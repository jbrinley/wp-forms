<?php

class WP_Form_View_Markup extends WP_Form_View {
	public function render( WP_Form_Component $element ) {
		$type = $element->get_type();
		if ( method_exists( $this, $type ) ) {
			return call_user_func( array( $this, $type ), $element );
		} elseif ( $element instanceof WP_Form_Element ) {
			return $this->markup($element); // fallback to generic <input />
		}
		return '';
	}

	protected function markup( WP_Form_Element $element ) {
		$content = $element->get_content();

		$attributes = $element->get_all_attributes();

		unset($attributes['value'], $attributes['type']);
		$attributes = WP_Form_View::prepare_attributes($attributes);

		$template = '<div %s>%s</div>';
		return sprintf( $template, $attributes, $content );
	}

}
