Decorators
==========

Use decorators to wrap the basic views with additional data.

`WP_Form_Decorator_Description`
-------------------------------

Displays an element's description. The description will be placed after the element.

### Arguments

`tag` - The HTML tag for the description's containing element. Defaults to `p`.

`attributes` - Attributes to add to the tag containing the description. The `class` attribute defaults to 'description'. The class can be overridded using the `wp_form_description_html_class` filter.

TODO: argument to control placement of the description

`WP_Form_Decorator_Errors`
--------------------------

Displays error messages associated with the element.

TODO: arguments to control HTML tags and classes for the errors
TODO: argument to control placement of the errors

`WP_Form_Decorator_HtmlTag`
---------------------------

Wraps an element in an HTML tag.

### Arguments

`tag` - The HTML tag for the description's containing element. Defaults to `div`. The default can be overridden using the `wp_form_htmltag_default` filter.

`attributes` - Attributes to add to the tag.

`WP_Form_Decorator_Label`
-------------------------

Displays an element's label.

### Arguments

`position` - Where to put the label. Defaults to `WP_Form_Decorator::POSITION_BEFORE`

- `WP_Form_Decorator::POSITION_BEFORE` - place the label before the element
- `WP_Form_Decorator::POSITION_AFTER` - place the label after the element
- `WP_Form_Decorator::POSITION_SURROUND` - place the element inside the `<label>`, with the label's text after the element