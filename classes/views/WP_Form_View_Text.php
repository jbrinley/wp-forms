<?php

class WP_Form_View_Text extends WP_Form_View {

	public function text( WP_Form_Element $element ) {
		return $this->input($element);
	}

}
