<?php

/**
 * Appends the element's description
 */
class WP_Form_Decorator_Description extends WP_Form_Decorator {
	public function render( WP_Form_Component $element ) {
		$description = '';
		if ( is_callable(array($element, 'get_description')) ) {
			$description = $element->get_description();
		}
		if ( $description ) {
			$class = apply_filters('wp_form_description_html_class', 'description');
			$description = sprintf('<p class="%s">%s</label> ', $class, $description);
		}
		return $this->component_view->render($element) . $description;
	}
}
