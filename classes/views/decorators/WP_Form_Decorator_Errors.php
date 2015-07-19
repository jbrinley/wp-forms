<?php

class WP_Form_Decorator_Errors extends WP_Form_Decorator {
	const POSITION_BEFORE = 0;
	const POSITION_AFTER = 1;

	public function render( WP_Form_Component $element ) {
		$errors = $element->get_errors();
		if ( $errors ) {
			$output = '';
			$args = wp_parse_args(
				$this->args,
				array(
					'tag' => 'ul',
					'tag_single' => 'li',
					'class_single' => 'error',
					'attributes' => array(),
					'position' => self::POSITION_AFTER
				)
			);

			foreach ( $errors as $error ) {
				$output .= '<' . $args['tag_single'] . ' class="' . $args['class_single']. '">' . $error . '</' . $args['tag_single'] . '>';
			}
			$output = sprintf(
				'<%1$s %2$s>%3$s</%1$s>',
				$args['tag'],
				WP_Form_View::prepare_attributes( $args['attributes'] ),
				$output
			);

			switch ( $args['position'] ) {
				case self::POSITION_AFTER:
					return $this->component_view->render($element) . $output;
					break;

				case self::POSITION_BEFORE:
				default:
					return $output . $this->component_view->render($element);
					break;
			}
		}

		return $this->component_view->render($element);
	}
}
