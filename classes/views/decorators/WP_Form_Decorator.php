<?php

abstract class WP_Form_Decorator implements WP_Form_View_Interface {
	/** @var WP_Form_View_Interface */
	protected $component_view;
	protected $args = array();

	public function __construct( WP_Form_View_Interface $view, array $args = array() ) {
		$this->component_view = $view;
		$this->args = $args;
	}

	public function render( WP_Form_Component $element ) {
		return $this->component_view->render($element);
	}

	public function __call( $method, $args ) {
		if ( method_exists($this->component_view, $method) ) {
			return call_user_func_array( array($this->component_view, $method), $args );
		}
		throw new BadMethodCallException(sprintf(__('Call to undefined method: %s', 'wp-forms'), $method));
	}
}
