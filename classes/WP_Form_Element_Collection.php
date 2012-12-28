<?php

class WP_Form_Element_Collection extends ArrayObject {
	/**
	 * @desc Overriding ArrayObject::append to add typechecking
	 * @param mixed $val – a value to append to the array
	 */
	public function append( $val ) {
		$this->typeCheck( $val );
		parent::append( $val );
	}

	/**
	 * @desc Overriding ArrayObject::offsetSet to add typechecking; this method is called when values are set using the []
	 * @param int $idx – the index of the array element to set
	 * @param mixed $val – the value to set
	 */
	public function offsetSet( $idx, $val ) {
		$this->typeCheck( $val );
		parent::offsetSet( $idx, $val );
	}

	/**
	 * @desc abstract method must be implemented by subclasses to define type-checking behavior
	 *
	 * @param mixed $val – the value to be type-checked
	 *
	 * @throws Exception
	 * @return void
	 */
	public function typeCheck( $val ) {
		if ( !is_a($val, 'WP_Form_Element') ) {
			throw new Exception(__('Non-WP_Form_Element supplied to WP_Form_Element_Collection', 'wp-forms'));
		}
	}
}
