<?php

class WP_Form_Decorator_Errors extends WP_Form_Decorator {
	public function render( WP_Form_Component $element ) {
		$errors = $element->get_errors();
		$output = '';
		if ( $errors ) {
			$output = '<ul class="errors">';
			foreach ( $errors as $e ) {
				$output .= '<li class="error">'.$e.'</li>';
			}
			$output .= '</ul>';
		}
		return $output . $this->component_view->render($element);
	}
}
