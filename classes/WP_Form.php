<?php

class WP_Form {
	private static $registered_forms = array();

	/**
	 * @param string $form_id
	 * @param callback $callback
	 *
	 * @throws InvalidArgumentException when the form ID is already registered
	 */
	public static function register( $form_id, $callback ){
		if ( empty(self::$registered_forms[$form_id]) ) {
			self::$registered_forms[$form_id] = $callback;
		} else {
			throw new InvalidArgumentException(sprintf(__('Form %s already registered', 'wp-forms'), $form_id));
		}
	}

	/**
	 * @param string $form_id
	 * @return bool TRUE if removed, FALSE if it didn't exist to begin with
	 * Either way, it's not registered anymore
	 */
	public static function deregister( $form_id ) {
		if ( isset(self::$registered_forms[$form_id]) ) {
			unset(self::$registered_forms[$form_id]);
			return TRUE;
		}
		return FALSE;
	}
}
