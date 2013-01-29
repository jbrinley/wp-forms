<?php

class WP_Form_Submission {
	/** @var WP_Form */
	private $form = NULL;
	private $data = array();
	/** @var WP_Error */
	private $errors = NULL;

	public function __construct( WP_Form $form, array $data ) {
		$this->form = $form;
		$this->data = $data;
	}

	public function is_valid() {
		$this->validate(); // make sure we've validated
		$errors = $this->errors->get_error_codes();
		return empty($errors);
	}

	public function get_errors(){
		return $this->errors;
	}

	public function submit() {
		$processors = $this->form->get_processors();
		foreach ( $processors as $callback ) {
			call_user_func( $callback, $this, $this->form );
		}
	}

	/**
	 * @param string $key The form element name, as it would be displayed
	 * in the HTML.
	 *
	 * @return string|array|null The submitted value, or NULL if $key can't be found
	 */
	public function get_value( $key ) {
		$components = $this->parse_key($key);
		if ( empty($components) ) {
			return NULL; // invalid key
		}
		$data = $this->data;
		while ( ( $key = array_shift($components) ) !== NULL ) {
			if ( !is_array($data) || !isset($data[$key]) ) {
				return NULL; // key not found
			}
			$data = $data[$key]; // move down the array
		}
		return $data;
	}

	protected function validate() {
		if ( isset($this->errors) ) {
			return; // already validated, and data is immutable
		}

		$this->errors = new WP_Error();
		$validators = $this->form->get_validators();
		foreach ( $validators as $callback ) {
			call_user_func( $callback, $this->data, $this->errors, $this->form );
		}
	}

	/**
	 * @param string $key
	 * @return array
	 */
	protected function parse_key( $key ) {
		$components = explode('[', $key);
		foreach ( $components as &$c ) {
			$c = rtrim($c, ']');
		}
		return $components;
	}
}
