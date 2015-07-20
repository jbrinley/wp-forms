<?php
/*
Plugin Name: WP Forms
Plugin URI: https://github.com/jbrinley/wp-forms
Description: An API for creating, altering, validating, and submitting forms via code.
Author: Flightless
Author URI: http://flightless.us/
Version: 0.5
*/
/*
Copyright (c) 2013 Flightless, Inc. http://flightless.us/

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
"Software"), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be included
in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/


/**
 * Load all the plugin files and initialize appropriately
 *
 * @return void
 */
if ( !function_exists('WP_Forms_load') ) {
	function WP_Forms_load() {
		require_once('classes/WP_Form_Plugin.php');
		require_once('template-tags.php');
		WP_Form_Plugin::init(__FILE__);
	}
	// Fire it up!
	WP_Forms_load();
}
