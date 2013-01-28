<?php

class WP_Form_View_Hidden extends WP_Form_View {

	public function hidden( WP_Form_Element $element ) {
		return $this->input($element);
	}

}
