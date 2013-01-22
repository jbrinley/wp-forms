<?php

class WP_Form_View_Text extends WP_Form_View {

	public function text( WP_Form_Element $element ) {
		$template = '<input type="text" value="%s" name="%s" />';
		return sprintf( $template, $element->get_value(), $element->get_name() );
	}

}
