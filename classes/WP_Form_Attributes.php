<?php

class WP_Form_Attributes implements WP_Form_Attributes_Interface {
	private $attributes = array();
	private $classes = array();

	public function set_attribute( $key, $value ) {
		if ( $key == 'class' && !is_array($value) ) {
			if ( !is_array($value) ) {
				$value = explode(' ', $value);
			}
			$this->set_classes($value);
			return;
		}
		if ( !is_scalar($value) ) {
			throw new InvalidArgumentException(__('set_attribute() expects a scalar value', 'wp-forms'));
		}
		$this->attributes[$key] = $value;
	}

	public function get_attribute( $key ) {
		if ( $key == 'class' ) {
			$value = implode(' ', $this->get_classes());
			return $value;
		}
		if ( isset($this->attributes[$key]) ) {
			return $this->attributes[$key];
		}
		return '';
	}

	public function get_all_attributes() {
		$attributes = $this->attributes;
		$classes = $this->get_classes();
		if ( !empty($classes) ) {
			$attributes['class'] = implode(' ', $classes);
		}
		return $attributes;
	}

	public function add_class( $class ) {
		if ( !is_scalar($class) ) {
			throw new InvalidArgumentException(__('add_class() expects a scalar value', 'wp-forms'));
		}
		$this->classes[$class] = TRUE;
	}

	public function remove_class( $class ) {
		if ( !is_scalar($class) ) {
			throw new InvalidArgumentException(__('remove_class() expects a scalar value', 'wp-forms'));
		}
		if ( isset($this->classes[$class]) ) {
			unset($this->classes[$class]);
		}
	}

	public function set_classes( array $classes ) {
		$this->classes = array(); // clear previous values
		foreach ( $classes as $class ) {
			$this->add_class($class);
		}
	}

	public function get_classes() {
		return array_keys($this->classes);
	}
}
