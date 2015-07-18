<?php

/**
 * Class WP_Form_View_Fieldset
 */
class WP_Form_View_Wrapper extends WP_Form_View {
	public function render( WP_Form_Component $element ) {
		$type = $element->get_type();
		if ( method_exists( $this, $type ) ) {
			return call_user_func( array( $this, $type ), $element );
		} elseif ( $element instanceof WP_Form_Element_Wrapper ) {
			return $this->wrapper($element); // fallback to generic <fieldset />
		}
		return '';
	}

	protected function wrapper( WP_Form_Element_Wrapper $element ) {
		$children = $this->render_children($element);

		$attributes = $element->get_all_attributes();
		// Because this is just a tag (div, span) we don't need this attrs in tag.
		unset($attributes['name'], $attributes['tag_name'], $attributes['type'], $attributes['value']);
		$attributes = WP_Form_View::prepare_attributes($attributes);

		$tag_name = $element->get_attribute('tag_name');
		if( empty( $tag_name ) ) {
			$tag_name = 'div';
		}
		$output = sprintf(
			'<%1$s %2$s>%3$s</%1$s>',
			$tag_name,
			$attributes,
			$children
		);
		return $output;
	}

	/**
	 * Walk through each child and render it
	 *
	 * @param WP_Form_Aggregate $fieldset
	 * @return string
	 */
	protected function render_children( WP_Form_Aggregate $wrapper ) {
		$children = '';
		foreach ( $wrapper->get_children() as $child ) {
			$children .= $this->render_child($child);
		}
		return $children;
	}

	/**
	 * @param WP_Form_Component $element
	 * @return string
	 */
	protected function render_child( WP_Form_Component $element ) {
		return $element->render();
	}

}
