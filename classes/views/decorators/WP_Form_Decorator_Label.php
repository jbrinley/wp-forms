<?php

class WP_Form_Decorator_Label extends WP_Form_Decorator {


	public function render( WP_Form_Component $element ) {
		$label = '';
		if ( is_callable(array($element, 'get_label')) ) {
			$label = $element->get_label();
		}
		if ( $label ) {
			$class = apply_filters('wp_form_label_html_class', 'form-label');
			$label = sprintf('<label for="%s" class="%s">%s</label> ', $element->get_id(), $class, $label);
		}
		return $label . $this->component_view->render($element);
	}
}
