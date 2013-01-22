<?php

class WP_Form_View_Form extends WP_Form_View {

	public function form( WP_Form $form ) {
		return sprintf(
			'<form id="%s" action="%s" method="%s" %s>%s</form>',
			esc_attr($form->get_id()),
			esc_attr($form->get_action()),
			esc_attr($form->get_method()),
			WP_Form_View::prepare_attributes($form->get_attributes()),
			$form->render_children()
		);
	}

}
