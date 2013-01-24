<?php

class WP_Form_Element_Submit extends WP_Form_Element {
	protected $type = 'submit';
	protected $default_view = 'WP_Form_View_Submit';
	protected $default_decorators = array(
		'WP_Form_Decorator_HtmlTag' => array(),
	);
}
