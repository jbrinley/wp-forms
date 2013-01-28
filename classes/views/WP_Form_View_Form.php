<?php

class WP_Form_View_Form extends WP_Form_View {
	protected $children = '';

	public function form( WP_Form $form ) {
		$this->render_children($form);
		$output = sprintf(
			'<form %s>%s</form>',
			WP_Form_View::prepare_attributes($form->get_all_attributes()),
			$this->children
		);
		$this->children = ''; // clean up our mess
		return $output;
	}

	/**
	 * Walk through each child and render it
	 *
	 * @param WP_Form $form
	 */
	protected function render_children( WP_Form $form ) {
		$walker = new WP_Form_Walker( $form );
		$walker->walk( array( $this, 'render_child' ) );
	}

	/**
	 * Callback for the walker.
	 *
	 * @access private
	 * @see WP_Form_Walker::walk()
	 * @param WP_Form_Component $element
	 */
	public function render_child( WP_Form_Component $element ) {
		$this->children .= $element->render();
	}

}
