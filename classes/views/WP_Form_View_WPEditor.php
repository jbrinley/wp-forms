<?php

class WP_Form_View_WPEditor extends WP_Form_View_Textarea {
	private $settings = array();

	public function render( WP_Form_Component $element ) {
		$type = $element->get_type();
		if ( method_exists( $this, $type ) ) {
			return call_user_func( array( $this, $type ), $element );
		} elseif ( $element instanceof WP_Form_Element ) {
			return $this->textarea($element); // fallback to generic <input />
		}
		return '';
	}

	public function setting( $key, $value ) {
		$this->settings[$key] = $value;
	}

	protected function textarea( WP_Form_Element $element ) {
		$attributes = $element->get_all_attributes();
		$content = '';
		if ( isset($attributes['value']) ) {
			$content = $attributes['value'];
			unset($attributes['value']);
		}
		$settings = $this->settings;
		if ( empty($settings['textarea_name']) && !empty($attributes['name']) ) {
			$settings['textarea_name'] = $attributes['name'];
		}
		if ( empty($settings['textarea_rows']) && !empty($attributes['rows']) ) {
			$settings['textarea_rows'] = $attributes['rows'];
		}
		$classes = $element->get_classes();
		if ( empty($settings['editor_class']) && !empty($classes) ) {
			$settings['editor_class'] = implode(' ', $classes);
		}
		$id = $element->get_id();
		if ( empty($id) && !empty($attributes['name']) ) {
			$id = $attributes['name'];
		}
		ob_start();
		wp_editor($content, $id, $settings);
		return ob_get_clean();
	}

}
