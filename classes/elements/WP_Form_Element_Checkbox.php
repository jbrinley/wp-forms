<?php

class WP_Form_Element_Checkbox extends WP_Form_Element {
	protected $type = 'checkbox';
	protected $default_decorators = array(
		'WP_Form_Decorator_Label' => array('position' => WP_Form_Decorator::POSITION_SURROUND),
		'WP_Form_Decorator_Description' => array(),
		'WP_Form_Decorator_HtmlTag' => array(),
	);
}
