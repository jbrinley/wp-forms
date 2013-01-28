<?php

class WP_Form_View_Submit extends WP_Form_View {

	public function submit( WP_Form_Element $element ) {
		return $this->input($element);
	}

}
