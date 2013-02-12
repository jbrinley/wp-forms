<?php

/**
 * Renders a form's children without the enclosing <form> tag.
 */
class WP_Form_View_PartialForm extends WP_Form_View_Form {
	public function form( WP_Form $form ) {
		return $this->render_children($form);
	}
}
