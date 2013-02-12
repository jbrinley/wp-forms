<?php

/**
 * Appends the element's description
 */
class WP_Form_Decorator_Description extends WP_Form_Decorator {
	public function render( WP_Form_Component $element ) {
		$description = '';
		if ( is_callable(array($element, 'get_description')) ) {
			$description = $element->get_description();
		}
		if ( $description ) {
			$args = wp_parse_args(
				$this->args,
				array(
					'tag' => 'p',
					'attributes' => array(),
				)
			);
			if ( empty($args['attributes']['class']) ) {
				$args['attributes']['class'] = 'description';
			}
			$args['attributes']['class'] = apply_filters('wp_form_description_html_class', $args['attributes']['class']);

			$start = $this->open_tag($args['tag'], $args['attributes']);
			$end = $this->close_tag($args['tag']);
			$description = $start.$description.$end;
		}
		return $this->component_view->render($element) . $description;
	}

	private function open_tag( $tag, $attributes = array() ) {
		return sprintf("<%s %s>", $tag, WP_Form_View::prepare_attributes($attributes));
	}

	private function close_tag( $tag ) {
		return "</$tag>";
	}
}
