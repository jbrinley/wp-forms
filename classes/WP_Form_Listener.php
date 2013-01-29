<?php

class WP_Form_Listener {
	/** @var WP_Form_Listener */
	private static $instance;

	private function add_hooks() {
		add_action( 'init', array( $this, 'check_form_submission' ), 111, 0 );
	}

	public function check_form_submission() {
		if ( empty($_REQUEST['wp_form_id']) || empty($_REQUEST['wp_form_nonce']) ) {
			return;
		}
		if ( !wp_verify_nonce($_REQUEST['wp_form_nonce'], $_REQUEST['wp_form_id']) ) {
			return;
		}
		$form = wp_get_form($_REQUEST['wp_form_id']);
		$submission = new WP_Form_Submission($form, $_REQUEST);
		if ( !$submission->is_valid() ) {
			$errors = $submission->get_errors();
			// TODO: set errors on the form
			return;
		}
		$submission->submit();
		$submission->redirect();
	}

	/********** Singleton *************/

	/**
	 * Create the instance of the class
	 *
	 * @static
	 * @return void
	 */
	public static function init() {
		self::$instance = self::get_instance();
	}

	/**
	 * Get (and instantiate, if necessary) the instance of the class
	 * @static
	 * @return WP_Form_Listener
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

	protected function __construct() {
		$this->add_hooks();
	}
}
