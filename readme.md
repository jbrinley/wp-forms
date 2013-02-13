WP Forms is an API for creating, editing, validating, and processing forms programatically. Create individual form elements to throw into meta boxes, complete forms for the front-end, or anything else you might want a form for.

Quick Links
===========

[`WP_Form` Class Reference](docs/forms.md)

[`WP_Form_Element` Class Reference](docs/elements.md)

[`WP_Form_View` Class Reference](docs/views.md)

[`WP_Form_Decorator` Class Reference](docs/decorators.md)

Basic Usage
===========

## Creating an element

	$element = WP_Form_Element::create('text');

You can add various properties to your element:

	$element = WP_Form_Element::create('text')
		->set_name('first_name')
		->set_label('First Name')
		->set_attribute('placeholder', 'Your Name Here')
		->set_description('This is where you put your first name');

Acceptable parameters to `WP_Form_Element::create()` include:

- [text](docs/elements.md#text)
- [textarea](docs/elements.md#textarea)
- [hidden](docs/elements.md#hidden)
- [password](docs/elements.md#password)
- [radios](docs/elements.md#radio-group) (or [radio](docs/elements.md#radio))
- [checkboxes](docs/elements.md#checkbox-group) (or [checkbox](docs/elements.md#checkbox))
- [file](docs/elements.md#file)
- [select](docs/elements.md#select-box)
- [submit](docs/elements.md#submit-button)
- [reset](docs/elements.md#reset-button)
- [button](docs/elements.md#button)

## Creating forms

Forms should be created in a callback function you register during the `wp_forms_register` action.

	add_action( 'wp_forms_register', 'register_my_form', 10, 0 );
	function register_my_form() {
		wp_register_form( 'my-unique-form-id', 'my_form_building_callback' );
	}
	function my_form_building_callback( $form ) {
		$form
			->add_element(
				WP_Form_Element::create('text')
					->set_name('first_name')
					->set_label('First Name')
			)
			->add_element(
				WP_form_Element::create('text')
					->set_name('last_name')
					->set_label('Last Name')
			);
	}

## Rendering forms

To render a registered form in your template, simply `echo wp_get_form('my-unique-form-id');`.

## Rendering Elements

If you've created individual elements (e.g., to add to a meta box in the admin), echo the results of the `render()` method on that element.

	$element = WP_Form_Element::create('text')->set_name('first_name');
	echo $element->render();

## Validation

To add a validation callback to a form, use the `add_validator( $callback, $priority = 10)` method.

	$form->add_validator( 'my_validation_callback', 10 );
	function my_validation_callback( WP_Form_Submission $submission, WP_Form $form ) {
		if ( $submission->get_value('first_name') != 'Jonathan' ) {
			$submission->add_error('first_name', 'Your name should be Jonathan');
		}
	}

A form will not be submitted if any validation callback sets an error. You can set multiple error messages for each form element. All error messages will be displayed when the form is re-rendered.

If the form has multiple validation callbacks, they will be called in priority order.

## Processing

After a form has passed validation, its processing callback(s) will be called.

	$form->add_processor( 'my_processing_callback', 10 );
	function my_processing_callback( WP_Form_Submission $submission, WP_Form $form ) {
		$first_name = $submission->get_value('first_name');
		// do something with $first_name

		// redirect the user after the form is submitted successfully
		$submission->set_redirect(home_url('aPage'));
	}

Advanced Topics
===============

## Changing [Views](docs/views.md)

Forms and elements are rendered using views. Each element has an appropriate default view, but different views (built into WP Forms, or your own custom classes) can be applied.

For example, to use a `<button>` element instead of an `<input>` element for a button:

	$button = WP_Form_Element::create('button')->set_value('This is <em>a button</em>!');
	$button->set_view(new WP_Form_View_Button()); // defaults to WP_Form_View_Input
	$button->apply_default_decorators();

Your theme can globally override the default view for an element type. Use the `wp_form_view_classes` filter and prepend your preferred view to the array of candidate view classes. Example:

	add_filter( 'wp_form_view_classes', 'filter_button_views', 10, 2 );
	function filter_button_views( $classes, $element ) {
		if ( $element->type == 'button' ) {
			array_unshift( $classes, 'WP_Form_View_Button' );
		}
		return $classes;
	}

## [Decorators](docs/decorators.md)

What's that about `apply_default_decorators()`? Each element's view has a default set of decorators wrapping it. These add additional HTML to the final output, like labels, descriptions, HTML wrappers, etc. When you add your custom view, it won't have these wrappers by default, but you can easily add them using `apply_default_decorators()`.

If you want different decorators, don't call `apply_default_decorators()`. Give the element your own decorators:

	$button = WP_Form_Element::create('button')->set_value('This is <em>a button</em>!');
	$button->set_view(new WP_Form_View_Button());
	$button->add_decorator('WP_Form_Decorator_HtmlTag', array('tag' => 'p', 'attributes' => array( 'class' => 'button-wrapper' )));

Your theme can also filter the default decorators for all elements, using the `wp_form_default_decorators` filter.

	add_filter( 'wp_form_default_decorators', 'filter_button_decorators', 10, 2 );
	function filter_button_views( $decorators, $element ) {
		if ( $element->type == 'button' ) {
			$decorators = array(
				'WP_Form_Decorator_HtmlTag' => array('tag' => 'p', 'attributes' => array( 'class' => 'button-wrapper' )),
			);
		}
		return $decorators;
	}
