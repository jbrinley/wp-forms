<?php

/**
 * Class WP_Form_Element_Fieldset
 */
class WP_Form_Element_Wrapper extends WP_Form_Element implements WP_Form_Aggregate {
	protected $type = 'wrapper';
	protected $default_view = 'WP_Form_View_Wrapper';
	protected $default_decorators = array();

	/** @var WP_Form_Component[] */
	protected $elements = array();

	/**
	 * Add a child component
	 *
	 * @param WP_Form_Component $element
	 * @param string $key A unique key for the component.
	 *                    Any existing component with the same key
	 *                    will be overwritten. If $key is empty,
	 *                    an attempt will be made to generate a
	 *                    unique key.
	 * @throws InvalidArgumentException
	 * @return $this
	 */
	public function add_element( WP_Form_Component $element, $key = '' ) {
		if ( empty($key) ) {
			$key = $element->get_name();
		}
		if ( empty($key) ) {
			throw new InvalidArgumentException(__('Cannot add nameless element to a wrapper', 'wp-forms'));
		}
		$this->elements[$key] = $element;
		return $this;
	}

	/**
	 * Remove a child component
	 *
	 * @param string $key
	 * @return $this
	 */
	public function remove_element( $key ) {
		if ( isset($this->elements[$key]) ) {
			unset($this->elements[$key]);
		}
		return $this;
	}

	/**
	 * Get the element with the given key
	 *
	 * @param string $key
	 *
	 * @return WP_Form_Component|NULL
	 */
	public function get_element( $key ) {
		if ( !empty($this->elements[$key]) ) {
			return $this->elements[$key];
		}
		foreach ( $this->elements as $e ) {
			if ( $e instanceof WP_Form_Aggregate ) {
				$child = $e->get_element($key);
				if ( !empty($child) ) {
					return $child;
				}
			}
		}
		return NULL;
	}

	/**
	 * Get an array of all child components, sorted by priority.
	 *
	 * @return WP_Form_Component[]
	 */
	public function get_children() {
		$elements = WP_Form_Element::sort_elements($this->elements);
		return $elements;
	}
}
