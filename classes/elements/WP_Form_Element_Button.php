<?php

class WP_Form_Element_Button extends WP_Form_Element {
	protected $type = 'button';
	protected $default_decorators = array(
		'WP_Form_Decorator_HtmlTag' => array(),
	);
}
