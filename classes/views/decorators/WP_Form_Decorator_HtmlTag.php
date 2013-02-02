<?php

/**
 * Wrap a form component in an HTML tag
 */
class WP_Form_Decorator_HtmlTag extends WP_Form_Decorator {
	// TODO: some sort of callback for context-aware attributes
	public function render( WP_Form_Component $element ) {
		$args = wp_parse_args(
			$this->args,
			array(
				'tag' => apply_filters('wp_form_htmltag_default', 'div'),
				'attributes' => array(),
			)
		);
		return $this->open_tag($args['tag'], $args['attributes']) . $this->component_view->render($element) . $this->close_tag($args['tag']);
	}

	private function open_tag( $tag, $attributes = array() ) {
		return sprintf("<%s %s>", $tag, WP_Form_View::prepare_attributes($attributes));
	}

	private function close_tag( $tag ) {
		return "</$tag>";
	}
}
