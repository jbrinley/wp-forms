<?php

class WP_Form_Submission {
	/** @var WP_Form */
	private $form = NULL;
	private $data = array();
	/** @var WP_Error */
	private $errors = NULL;
	private $redirect = '';

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

	public function redirect() {
		$url = $this->get_redirect();
		$url = apply_filters( 'wp_forms_redirect_url', $url, $this, $this->form );
		if ( $url === NULL ) {
			return FALSE;
		}
		if ( empty($url) ) {
			$url = $_SERVER['REQUEST_URI'];
		}
		wp_redirect($url);
		exit();
	}

	public function get_redirect() {
		// NULL means do not redirect
		if ( $this->redirect === NULL ) {
			return NULL;
		}
		// If this submission doesn't have an explicit redirect,
		// defer to the form's default
		if ( empty($this->redirect) ) {
			$redirect = $this->form->get_redirect();
			if ( empty($redirect) ) {
				return '';
			}
			return $redirect;
		}
		return $this->redirect;
	}

	/**
	 * @param string|NULL $url The redirect URL, or NULL to prevent redirect
	 */
	public function set_redirect( $url = '' ) {
		$this->redirect = $url;
	}

	/**
	 * Set values and errors on the form
	 * to prepare it for rendering
	 */
	public function prepare_form() {
		$this->prepare_form_values( $this->form );
		$this->prepare_form_errors( $this->form );
	}

	protected function validate() {
		if ( isset($this->errors) ) {
			return; // already validated, and data is immutable
		}

		$this->errors = new WP_Error();
		$validators = $this->form->get_validators();
		foreach ( $validators as $callback ) {
			call_user_func( $callback, $this, $this->errors, $this->form );
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

	protected function prepare_form_errors( WP_Form_Component $component ) {
		$errors = $this->errors->get_error_messages($component->get_name());
		foreach ( $errors as $e ) {
			$component->set_error($e);
		}
		if ( $component instanceof WP_Form_Aggregate ) {
			foreach ( $component->get_children() as $child ) {
				$this->prepare_form_errors( $child );
			}
		}
	}

	protected function prepare_form_values( WP_Form_Component $component ) {
		if ( $component instanceof WP_Form_Aggregate ) {
			foreach ( $component->get_children() as $child ) {
				$this->prepare_form_values( $child );
			}
		} elseif ( $component instanceof WP_Form_Element ) {
			$value = $this->get_value($component->get_name());
			$component->set_value($value);
		}
	}
}
