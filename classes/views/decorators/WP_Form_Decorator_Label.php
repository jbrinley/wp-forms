<?php

class WP_Form_Decorator_Label extends WP_Form_Decorator {

	public function render( WP_Form_Component $element ) {
		$label = '';
		if ( is_callable(array($element, 'get_label')) ) {
			$label = $element->get_label();
		}
		if ( empty($label) ) {
			return $this->component_view->render($element);
		}

		$position = self::POSITION_BEFORE;
		if ( !empty($this->args['position']) ) {
			$position = $this->args['position'];
		}
		$class = apply_filters('wp_form_label_html_class', 'form-label');
		switch ( $position ) {
			case self::POSITION_AFTER:
				$template = '%4$s <label for="%1$s" class="%2$s">%3$s</label>';
				break;
			case self::POSITION_SURROUND:
				$template = '<label for="%1$s" class="%2$s">%4$s %3$s</label>';
				break;
			case self::POSITION_BEFORE:
			default:
				$template = '<label for="%1$s" class="%2$s">%3$s</label> %4$s';
				break;
		}
		return sprintf($template, $element->get_id(), $class, $label, $this->component_view->render($element));
	}
}
