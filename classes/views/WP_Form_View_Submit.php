<?php

class WP_Form_View_Submit extends WP_Form_View {

	public function submit( WP_Form_Element $element ) {
		$template = '<input type="submit" value="%s" />';
		return sprintf( $template, $element->get_value() );
	}

}
