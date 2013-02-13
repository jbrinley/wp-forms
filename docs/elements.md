Element API
===========

Properties
----------

`default_value` - (mixed) The default value for the element.

`description` - (string) The element's description.

`id` - (string) The element's ID attribute.

`label` - (string) The element's label.

`name` - (string) The value of the element's `name` attribute.

`priority` - (integer) Controls sorting of elements in a form. Smaller numbers are rendered first.

`type` - (string, read-only) The element type.

`value` - (mixed) The submitted value for the element.

`view` - (WP_Form_View_Interface) The view that will render the element

Methods
-------

Form elements implement all methods defined in the [WP_Form_Component](../classes/WP_Form_Component.php) interface. See the PHPDocs for more information.

Form elements implement all methods defined in the [WP_Form_Attributes_Interface](../classes/WP_Form_Attributes_Interface.php) interface. See the PHPDocs for more information.

All of the above properties may be read using the `get_*` method, where * is the property name.

All of the above writable properties may be written using the `set_*` method, where * is the property name. Calls may be chained together if desired.

`apply_default_decorators()` - Wrap the currently assigned view in the element's default decorators.

`get_default_decorators()` - Get the decorators that will be applied by `apply_default_decorators()`.

`add_decorator( string $decorator_classname, array $args )` - Wrap the current view in a decorator.

Form Elements
=============

## Button

	WP_Form_Element::create('button');

### Default View

`WP_Form_View_Input`

To use a `<button>` element instead of an `<input type="button">` element, change the view to `WP_Form_View_Button`.

### Default Decorators
- `WP_Form_Decorator_HtmlTag`

## Checkbox

	WP_Form_Element::create('checkbox');

### Default View

`WP_Form_View_Input`

### Default Decorators

- `WP_Form_Decorator_Description`
- `WP_Form_Decorator_Label`
	- position: `WP_Form_Decorator::POSITION_SURROUND`
- `WP_Form_Decorator_HtmlTag`

## Checkbox Group

	WP_Form_Element::create('checkboxes');

Creates a group of checkboxes. Add options to the group using the `add_option()` method:

	$element = WP_Form_Element::create( 'checkboxes' )
		->set_label( 'Acceptable colors' )
		->add_option( 'red', 'Red' )
		->add_option( 'yellow', 'Yellow' )
		->add_option( 'blue', 'Blue' );

### Default View

`WP_Form_View_Checkboxes`

### Default Decorators

- `WP_Form_Decorator_Description`
- `WP_Form_Decorator_Errors`
- `WP_Form_Decorator_Label`
- `WP_Form_Decorator_HtmlTag`

## File Upload

	WP_Form_Element::create('file');

### Default View

`WP_Form_View_Input`

### Default Decorators

- `WP_Form_Decorator_Description`
- `WP_Form_Decorator_Errors`
- `WP_Form_Decorator_Label`
- `WP_Form_Decorator_HtmlTag`

## Hidden

	WP_Form_Element::create('hidden');

### Default View

`WP_Form_View_Input`

### Default Decorators

None

## Password

	WP_Form_Element::create('password');

### Default View

`WP_Form_View_Input`

### Default Decorators

- `WP_Form_Decorator_Description`
- `WP_Form_Decorator_Errors`
- `WP_Form_Decorator_Label`
- `WP_Form_Decorator_HtmlTag`

## Radio

	WP_Form_Element::create('radio');

### Default View

`WP_Form_View_Input`

### Default Decorators

- `WP_Form_Decorator_Description`
- `WP_Form_Decorator_Label`
	- position: `WP_Form_Decorator::POSITION_SURROUND`
- `WP_Form_Decorator_HtmlTag`

## Radio Group

	WP_Form_Element::create('radios');

Creates a group of radio buttons. Add options to the group using the `add_option()` method:

	$element = WP_Form_Element::create( 'radios' )
		->add_option( 'yes', 'I agree' )
		->add_option( 'no', 'I disagree' );

### Default View

`WP_Form_View_Radios`

### Default Decorators

- `WP_Form_Decorator_Description`
- `WP_Form_Decorator_Errors`
- `WP_Form_Decorator_Label`
- `WP_Form_Decorator_HtmlTag`

## Reset Button

	WP_Form_Element::create('reset');

### Default View

`WP_Form_View_Input`

To use a `<button type="reset">` element instead of an `<input type="reset">` element, change the view to `WP_Form_View_Button`.

### Default Decorators
- `WP_Form_Decorator_HtmlTag`

## Select Box

	WP_Form_Element::create('select');

To create a multiple select box, just set appropriate attributes:

	WP_Form_Element::create('select')
		->set_attribute('multiple', 'multiple')
		->set_attribute('size', 5);

### Default View

`WP_Form_View_Select`

### Default Decorators

- `WP_Form_Decorator_Description`
- `WP_Form_Decorator_Errors`
- `WP_Form_Decorator_Label`
- `WP_Form_Decorator_HtmlTag`

## Submit Button

	WP_Form_Element::create('submit');

### Default View

`WP_Form_View_Input`

To use a `<button type="submit">` element instead of an `<input type="submit">` element, change the view to `WP_Form_View_Button`.

### Default Decorators
- `WP_Form_Decorator_HtmlTag`

## Text

	WP_Form_Element::create('text');

### Default View

`WP_Form_View_Input`

### Default Decorators

- `WP_Form_Decorator_Description`
- `WP_Form_Decorator_Errors`
- `WP_Form_Decorator_Label`
- `WP_Form_Decorator_HtmlTag`

## Textarea

	WP_Form_Element::create('textarea');

### Default View

`WP_Form_View_Textarea`

To use WordPress's built-in visual editor:

	WP_Form_Element::create('textarea')
		->set_view(new WP_Form_View_WPEditor())
		->apply_default_decorators();

If you want to pass additional parameters to `wp_editor`:

	$view = new WP_Form_View_WPEditor();
	$view->setting('media_buttons', FALSE);
	$view->setting('tinymce', FALSE);
	$view->setting('quicktags', TRUE);

### Default Decorators

- `WP_Form_Decorator_Description`
- `WP_Form_Decorator_Errors`
- `WP_Form_Decorator_Label`
- `WP_Form_Decorator_HtmlTag`