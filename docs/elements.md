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
	- position: `WP_Form_Decorator_Label::POSITION_SURROUND`
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
	- position: `WP_Form_Decorator_Label::POSITION_SURROUND`
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

### Default Decorators

- `WP_Form_Decorator_Description`
- `WP_Form_Decorator_Errors`
- `WP_Form_Decorator_Label`
- `WP_Form_Decorator_HtmlTag`