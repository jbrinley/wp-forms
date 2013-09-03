<?php
/**
 * Used by PhpStorm to map factory methods to classes for code completion, source code analysis, etc.
 *
 * The code is not ever actually executed and it only needed during development when coding with PhpStorm.
 *
 * @see http://confluence.jetbrains.com/display/PhpStorm/PhpStorm+Advanced+Metadata
 * @see http://blog.jetbrains.com/webide/2013/04/phpstorm-6-0-1-eap-build-129-177/
 */

namespace PHPSTORM_META {
	/** @noinspection PhpUnusedLocalVariableInspection */                 // just to have a green code below
	/** @noinspection PhpIllegalArrayKeyTypeInspection */
	$STATIC_METHOD_TYPES = [                                              // we make sections for scopes
		\WP_Form_Element::create('') => [
			'button' instanceof \WP_Form_Element_Button,
			'checkbox' instanceof \WP_Form_Element_Checkbox,
			'checkboxes' instanceof \WP_Form_Element_Checkboxes,
			'fieldset' instanceof \WP_Form_Element_Fieldset,
			'file' instanceof \WP_Form_Element_File,
			'hidden' instanceof \WP_Form_Element_Hidden,
			'password' instanceof \WP_Form_Element_Password,
			'radio' instanceof \WP_Form_Element_Radio,
			'radios' instanceof \WP_Form_Element_Radios,
			'reset' instanceof \WP_Form_Element_Reset,
			'select' instanceof \WP_Form_Element_Select,
			'submit' instanceof \WP_Form_Element_Submit,
			'text' instanceof \WP_Form_Element_Text,
			'textarea' instanceof \WP_Form_Element_Textarea,
		],
	];
}