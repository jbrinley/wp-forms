<?php

class WP_Form_Decorator_HtmlTag extends WP_Form_Decorator {
	public function render( WP_Form_Component $element ) {
		$args = wp_parse_args(
			array(
				'tag' => apply_filters('wp_form_htmltag_default', 'p'),
				'attributes' => array(),
			),
			$this->args
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
