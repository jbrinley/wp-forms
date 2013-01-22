<?php

class WP_Form_Decorator_Errors extends WP_Form_Decorator {
	public function render( WP_Form_Component $element ) {
		// TODO: render errors
		return $this->component_view->render($element);
	}
}
