<?php

/**
 * A form element with multiple options (e.g., selects, radios, checkboxes)
 */
abstract class WP_Form_Element_Multiple extends WP_Form_Element {
	protected $options = array();

	public function add_option( $key, $value, $priority = 10 ) {
		$this->options[$key] = new WP_Form_Element_Option($key, $value, $priority);
		return $this;
	}

	public function remove_option( $key ) {
		if ( isset($this->options[$key]) ) {
			unset($this->options[$key]);
		}
		return $this;
	}

	public function get_options() {
		$output = array();
		foreach( $this->sort_options($this->options) as $option ) {
			$output[$option->key] = $option->value;
		}
		return $output;
	}

	public function sort_options( $options ) {
		if ( empty($options) ) {
			return $options;
		}

		// use a schwartzian transform to keep elements with the same priority in the same order
		// see http://notmysock.org/blog/php/schwartzian-transform.html
		$options = array_values($options);
		array_walk( $options, create_function( '&$v, $k' , '$v = array( $v->priority, $k, $v );'));
		asort($options); // sorts by priority, then key
		array_walk( $options, create_function( '&$v, $k', '$v = $v[2];'));
		return $options;
	}
}

class WP_Form_Element_Option {
	private $key = '';
	private $value = '';
	private $priority = 10;

	public function __construct( $key, $value, $priority = 10 ) {
		$this->key = $key;
		$this->value = $value;
		$this->priority = $priority;
	}

	public function __get( $name ) {
		if ( isset($this->$name) ) {
			return $this->$name;
		}
		throw new InvalidArgumentException(sprintf(__('Undefined property: %s'), $name));
	}
}