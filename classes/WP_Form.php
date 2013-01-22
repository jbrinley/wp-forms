<?php

class WP_Form implements WP_Form_Component {
	/** @var WP_Form_Component[] */
	protected $elements = array();
	protected $method = 'post';
	protected $action = '';
	protected $classes = array();
	protected $attributes = array();
	/** @var WP_Form_View_Form */
	protected $view = NULL;
	protected $rendered = 0; // the number of times the form has been rendered
	protected $id = '';

	public function __construct( $id ) {
		$this->id = $id;
	}

	/**
	 * @param WP_Form_Component $element
	 * @return WP_Form
	 */
	public function add_element( WP_Form_Component $element ) {
		$key = $element->get_name();
		$this->elements[$key] = $element;
		return $this;
	}

	public function remove_element( $key ) {
		if ( isset($this->elements[$key]) ) {
			unset($this->elements[$key]);
		}
		return $this;
	}

	public function render( $force = FALSE ) {
		if ( !$force && $this->is_rendered() ) {
			return '';
		}
		$view = $this->get_view();
		$html = $view->render( $this );
		$this->rendered++;
		return $html;
	}

	public function render_children() {
		$children = '';
		WP_Form_Element::sort_elements($this->elements);
		foreach ( $this->elements as $element ) {
			$children .= $element->render();
		}
		return $children;
	}

	public function __toString() {
		return $this->render();
	}

	public function get_view() {
		if ( empty($this->view) ) {
			$this->set_view( new WP_Form_View_Form() );
		}
		return $this->view;
	}

	public function set_view( WP_Form_View $view ) {
		$this->view = $view;
		return $this;
	}

	public function set_action( $action ) {
		$this->action = $action;
		return $this;
	}

	public function get_action() {
		return $this->action;
	}

	public function set_method( $method ) {
		$method = strtolower($method);
		$this->method = $method;
		return $this;
	}

	public function get_method() {
		return $this->method;
	}

	public function get_attributes() {
		return $this->attributes;
	}

	public function get_attribute( $key ) {
		if ( isset($this->attributes[$key]) ) {
			return $this->attributes[$key];
		} else {
			return NULL;
		}
	}

	public function set_attribute( $key, $value ) {
		if ( $key == 'class' && !is_array($value) ) {
			$value = explode(' ', $value);
		}
		$this->attributes[$key] = $value;
		return $this;
	}

	public function add_class( $class ) {
		if ( empty($class) ) {
			return $this;
		}
		if ( empty($this->attributes['class']) ) {
			$this->attributes['class'] = array();
		}
		$this->attributes['class'][] = $class;
		return $this;
	}

	/**
	 * @return bool Whether the component has been rendered
	 */
	public function is_rendered() {
		return ($this->rendered > 0);
	}

	public function get_type() {
		return 'form';
	}

	public function get_name() {
		return $this->get_id();
	}

	public function get_id() {
		if ( !empty($this->attributes['id']) ) {
			return $this->attributes['id'];
		}
		return $this->id;
	}

	public function setup_nonce_fields() {
		$nonce = wp_create_nonce($this->id);
		$this->add_element(WP_Form_Element::create('hidden')->set_name('wp_form_id')->set_value($this->id)->set_priority(-10));
		$this->add_element(WP_Form_Element::create('hidden')->set_name('wp_form_nonce')->set_value($nonce)->set_priority(-10));
	}
}
