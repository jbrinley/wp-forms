<?php

/**
 * @param string $form_id
 * @param callback $callback
 *
 * @return bool TRUE if the form was registered, otherwise FALSE
 */
function wp_register_form( $form_id, $callback ) {
	try {
		WP_Form::register($form_id, $callback);
		return TRUE;
	} catch ( InvalidArgumentException $e ) {
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
	return WP_Form::deregister($form_id);
}