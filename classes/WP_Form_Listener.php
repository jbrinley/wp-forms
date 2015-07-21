<?php

class WP_Form_Listener {
	/** @var WP_Form_Listener */
	private static $instance;

	private function add_hooks() {
		add_action( 'init', array( $this, 'check_form_submission' ), 111, 0 );
		add_action( 'wp_ajax_wp_forms', array( $this, 'check_form_submission_ajax' ) );
		add_action( 'wp_ajax_nopriv_wp_forms', array( $this, 'check_form_submission_ajax' ) );
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
			$submission->prepare_form();
			return;
		}
		$submission->submit();
		$submission->redirect();
	}

	/**
	 * Similar to check_form_submission() but for AJAX requests.
	 *
	 * @see check_form_submission()
	 *
	 * @throws Exception
	 */
	public function check_form_submission_ajax() {
		$kk = '';
		if ( empty($_REQUEST['data']['wp_form_id']) || empty($_REQUEST['data']['wp_form_nonce']) ) {
			return;
		}
		if ( !wp_verify_nonce($_REQUEST['data']['wp_form_nonce'], $_REQUEST['data']['wp_form_id']) ) {
			return;
		}

		$form = wp_get_form($_REQUEST['data']['wp_form_id']);
		$submission = new WP_Form_Submission($form, $_REQUEST['data']);
		if ( !$submission->is_valid() ) {
			/**
			 * похоже здесь это не надо вызывать, т к возможно эта штука втыкает ошибки в хтмл,
			 * а нам нужно просто подготовить ошибки и отправить их
			 */
			$submission->prepare_form();
			$submission->send_ajax_answer();
			return;
		}
		$submission->submit_ajax();
		$submission->send_ajax_answer();
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
