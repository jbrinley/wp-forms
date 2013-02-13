`WP_Form` Class Reference
=========================

Properties
----------

`action` - (string) The URL the form submits to.

`id` - (string, read-only) The form ID.

`method` - (string) The HTTP method for submitting the form.

`redirect` - (string) The default redirect destination after the form submits.

`type` - (string) The form component type, which will always be 'form'.

`view` - (WP_Form_View_Interface) The view that will render the form.


Methods
-------

`WP_Form` implements the [WP_Form_Aggregate](../classes/WP_Form_Aggregate.php) interface. See the PHPDocs for more details.

`WP_Form` implements the [WP_Form_Component](../classes/WP_Form_Component.php) interface. See the PHPDocs for more details.

All of the above properties may be read using the `get_*` method, where * is the property name.

All of the above writable properties may be written using the `set_*` method, where * is the property name. Calls may be chained together if desired.

`clear_errors( $recursive = TRUE )` - Clear errors on the form and all of its child elements.

`setup_nonce_fields()` - Add nonce fields to the form for validation purposes. A form built with `wp_get_form()` has these automatically added and will validate them before processing a form submission.

`add_validator( callable $callback, $priority = 10 )` - Add a validation callback. Callbacks will be called in priority order.

`remove_validator( callable $callback, $priority = 10 )` - Remove a previously registered callback.

`get_validators()` - Get an array of all registered validation callbacks for the form

`add_processor( callable $callback, $priority = 10 )` - Add a processing callback. Callbacks will be called in priority order.

`remove_processor( callable $callback, $priority = 10 )` - Remove a previously registered callback.

`get_processor()` - Get an array of all registered processing callbacks for the form