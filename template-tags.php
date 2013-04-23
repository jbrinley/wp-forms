<?php

/**
 * @param string $form_id
 * @param callback $callback
 *
 * @throws InvalidArgumentException when WP_DEBUG is on
 * @return bool TRUE if the form was registered, otherwise FALSE
 */
function wp_register_form( $form_id, $callback ) {
	$registrar = WP_Form_Registrar::get_instance();
	try { // mask the exceptions for the non-OO API
		$registrar->register( $form_id, $callback );
		return TRUE;
	} catch ( InvalidArgumentException $e ) {
		if ( defined('WP_DEBUG') && WP_DEBUG ) {
			throw $e;
		}
		return FALSE; // the form was not registered
	}
}


/**
 * Deregister a form.
 *
 * @param string $form_id
 * @return bool TRUE if removed, FALSE if it didn't exist to begin with
 * Either way, it's not registered anymore
 */
function wp_deregister_form( $form_id ) {
	$registrar = WP_Form_Registrar::get_instance();
	return $registrar->deregister( $form_id );
}


/**
 * Get a registered form
 *
 * @param string $form_id
 *
 * @throws Exception when WP_DEBUG is on
 * @return bool|WP_Form
 */
function wp_get_form( $form_id ) {
	$registrar = WP_Form_Registrar::get_instance();
	try {
		$args = func_get_args();
		$form = call_user_func_array( array( $registrar, 'get_form' ), $args );
	} catch ( Exception $e ) {
		if ( defined('WP_DEBUG') && WP_DEBUG ) {
			throw $e;
		}
		return FALSE;
	}
	return $form;
}