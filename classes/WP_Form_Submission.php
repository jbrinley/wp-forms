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

	public function submit() {
		$processors = $this->form->get_processors();
		foreach ( $processors as $callback ) {
			call_user_func( $callback, $this->data, $this->form );
		}
	}

	public function get_errors(){
		return $this->errors;
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
}
