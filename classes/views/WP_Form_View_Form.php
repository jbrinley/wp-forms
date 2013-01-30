<?php

class WP_Form_View_Form extends WP_Form_View {

	public function form( WP_Form $form ) {
		$children = $this->render_children($form);
		$output = sprintf(
			'<form %s>%s</form>',
			WP_Form_View::prepare_attributes($form->get_all_attributes()),
			$children
		);
		return $output;
	}

	/**
	 * Walk through each child and render it
	 *
	 * @param WP_Form $form
	 * @return string
	 */
	protected function render_children( WP_Form $form ) {
		$children = '';
		foreach ( $form->get_children() as $child ) {
			$children .= $this->render_child($child);
		}
		return $children;
	}

	/**
	 * @param WP_Form_Component $element
	 */
	protected function render_child( WP_Form_Component $element ) {
		return $element->render();
	}

}
