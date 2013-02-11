<?php

class WP_Form_Registrar {
	/** @var WP_Form_Registrar */
	private static $instance;

	private $registered_forms = array();
	private $instantiated_forms = array();

	/**
	 * @param string $form_id
	 * @param callback $callback
	 *
	 * @throws InvalidArgumentException when the form ID is already registered
	 */
	public function register( $form_id, $callback ){
		if ( empty($this->registered_forms[$form_id]) ) {
			$this->registered_forms[$form_id] = $callback;
		} else {
			throw new InvalidArgumentException(sprintf(__('Form %s already registered', 'wp-forms'), $form_id));
		}
	}

	/**
	 * @param string $form_id
	 * @return bool TRUE if removed, FALSE if it didn't exist to begin with
	 * Either way, it's not registered anymore
	 */
	public function deregister( $form_id ) {
		if ( isset($this->registered_forms[$form_id]) ) {
			unset($this->registered_forms[$form_id]);
			return TRUE;
		}
		return FALSE;
	}

	public function get_form( $form_id ) {
		if ( !isset($this->registered_forms[$form_id]) ) {
			throw new InvalidArgumentException(sprintf(__('Form %s is not registered.', 'wp-forms'), $form_id));
		}
		if ( !is_callable($this->registered_forms[$form_id]) ) {
			throw new BadFunctionCallException(sprintf(__('Invalid callback for form %s', 'wp-forms'), $form_id));
		}
		if ( !isset($this->instantiated_forms[$form_id]) ) {
			$form = new WP_Form( $form_id ); // The form that we'll we working with today
			$form->setup_nonce_fields();
			call_user_func($this->registered_forms[$form_id], $form);
			do_action( 'wp_form_get_form', $form );
			$this->instantiated_forms[$form_id] = $form;
		}
		return $this->instantiated_forms[$form_id];
	}

	/********** Singleton *************/

	/**
	 * Create the instance of the class
	 *
	 * @static
	 * @return void
	 */
	public static function init() {
		self::get_instance(); // make sure we're initialized
		do_action( 'wp_forms_register' );
	}

	/**
	 * Get (and instantiate, if necessary) the instance of the class
	 * @static
	 * @return WP_Form_Registrar
	 */
	public static function get_instance() {
		if ( !is_a( self::$instance, __CLASS__ ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	final public function __clone() {
		trigger_error( "Singleton. No cloning allowed!", E_USER_ERROR );
	}

	final public function __wakeup() {
		trigger_error( "Singleton. No serialization allowed!", E_USER_ERROR );
	}

	protected function __construct() {}
}
