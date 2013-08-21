<?php

/**
 * Class WP_Form_View_Fieldset
 */
class WP_Form_View_Fieldset extends WP_Form_View {
	public function render( WP_Form_Component $element ) {
		$type = $element->get_type();
		if ( method_exists( $this, $type ) ) {
			return call_user_func( array( $this, $type ), $element );
		} elseif ( $element instanceof WP_Form_Element_Fieldset ) {
			return $this->fieldset($element); // fallback to generic <fieldset />
		}
		return '';
	}

	protected function fieldset( WP_Form_Element_Fieldset $element ) {
		$children = $this->render_children($element);
		$legend = $this->get_legend($element);
		$output = sprintf(
			'<fieldset %s>%s%s</fieldset>',
			WP_Form_View::prepare_attributes($element->get_all_attributes()),
			$legend,
			$children
		);
		return $output;
	}

	protected function get_legend( WP_Form_Element_Fieldset $element ) {
		$legend = '';
		$label = $element->get_label();
		if ( !empty($label) ) {
			$legend = sprintf('<legend>%s</legend>', $label);
		}
		return $legend;
	}

	/**
	 * Walk through each child and render it
	 *
	 * @param WP_Form_Aggregate $fieldset
	 * @return string
	 */
	protected function render_children( WP_Form_Aggregate $fieldset ) {
		$children = '';
		foreach ( $fieldset->get_children() as $child ) {
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
