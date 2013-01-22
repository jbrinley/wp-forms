<?php

class WP_Form_View_Hidden extends WP_Form_View {

	public function hidden( WP_Form_Element $element ) {
		$template = '<input type="hidden" value="%s" name="%s" />';
		return sprintf( $template, $element->get_value(), $element->get_name() );
	}

}
