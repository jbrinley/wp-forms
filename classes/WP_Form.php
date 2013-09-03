<?php

/**
 * @property string action
 * @property-read string id
 * @property string method
 * @property string redirect
 * @property-read string type
 * @property WP_Form_View_Interface view
 */
class WP_Form implements WP_Form_Aggregate, WP_Form_Attributes_Interface {
	/** @var WP_Form_Component[] */
	protected $elements = array();

	/** @var WP_Form_Attributes_Interface */
	protected $attributes = NULL;

	/** @var WP_Form_View_Form */
	protected $view = NULL;
	protected $id = '';
	protected $errors = array();

	protected $redirect = ''; // where to redirect users after this form is submitted

	protected $validators = array(); // validation callbacks
	protected $processors = array(); // submission callbacks

	public function __construct( $id ) {
		$this->id = $id;
		$this->attributes = new WP_Form_Attributes();
		$this->set_default_attributes();
	}

	public function __get( $name ) {
		if ( method_exists( $this, 'get_'.$name ) ) {
			return $this->{'get_'.$name}();
		} else {
			throw new InvalidArgumentException(sprintf(__('Undefined property: %s'), $name));
		}
	}
	public function __set( $name, $value ) {
		if ( method_exists( $this, 'set_'.$name ) ) {
			return $this->{'set_'.$name}( $value );
		} else {
			throw new InvalidArgumentException(sprintf(__('Undefined property: %s'), $name));
		}
	}

	/**
	 * @param WP_Form_Component $element
	 * @param string $key A key for referencing the element. Defaults to the element's name
	 * @throws InvalidArgumentException
	 * @return WP_Form
	 */
	public function add_element( WP_Form_Component $element, $key = '' ) {
		if ( empty($key) ) {
			$key = $element->get_name();
		}
		if ( empty($key) ) {
			throw new InvalidArgumentException(__('Cannot add nameless element to form', 'wp-forms'));
		}
		$this->elements[$key] = $element;
		return $this;
	}

	/**
	 * @param $key
	 * @return WP_Form
	 */
	public function remove_element( $key ) {
		if ( isset($this->elements[$key]) ) {
			unset($this->elements[$key]);
		}
		return $this;
	}

	/**
	 * @param $key
	 * @return null|WP_Form_Component
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
	 * @return WP_Form_Component[], sorted by priority
	 */
	public function get_children() {
		$elements = WP_Form_Element::sort_elements($this->elements);
		return $elements;
	}

	/**
	 * @return string
	 */
	public function render() {
		$view = $this->get_view();
		$html = $view->render( $this );
		return $html;
	}

	public function __toString() {
		return $this->render();
	}

	public function get_view() {
		if ( empty($this->view) ) {
			$classes = array( 'WP_Form_View_Form' );
			$classes = apply_filters( 'wp_form_view_classes', $classes, $this );
			foreach ( $classes as $class ) {
				if ( class_exists($class) ) {
					$this->view = new $class();
					break;
				}
			}
			if ( empty($this->view) ) {
				$this->view = new WP_Form_View_Form();
			}
		}
		return $this->view;
	}

	public function set_view( WP_Form_View $view ) {
		$this->view = $view;
		return $this;
	}

	public function set_redirect( $url ) {
		$this->redirect = $url;
		return $this;
	}

	public function get_redirect() {
		return $this->redirect;
	}

	/**
	 * @param string $error
	 * @return WP_Form
	 */
	public function set_error( $error ) {
		$this->errors[] = $error;
		return $this;
	}

	public function get_errors() {
		return $this->errors;
	}

	/**
	 * @param bool $recursive
	 * @return WP_Form
	 */
	public function clear_errors( $recursive = TRUE ) {
		$this->errors = array();
		if ( $recursive ) {
			foreach ( $this->get_children() as $child ) {
				$child->clear_errors();
			}
		}
		return $this;
	}

	public function set_action( $action ) {
		$this->attributes->set_attribute('action', $action);
		return $this;
	}

	public function get_action() {
		return $this->attributes->get_attribute('action');
	}

	public function set_method( $method ) {
		$this->attributes->set_attribute('method', strtolower($method));
		return $this;
	}

	public function get_method() {
		return $this->attributes->get_attribute('method');
	}

	public function get_all_attributes() {
		$attributes = $this->attributes->get_all_attributes();
		if ( !isset($attributes['action']) ) {
			$attributes['action'] = ''; // required attributes
		}
		// TODO: automatically set enctype to multipart/form-data if a file input is included
		return $attributes;
	}

	public function get_attribute( $key ) {
		return $this->attributes->get_attribute($key);
	}

	public function set_attribute( $key, $value ) {
		$this->attributes->set_attribute($key, $value);
		return $this;
	}

	public function add_class( $class ) {
		$this->attributes->add_class($class);
		return $this;
	}

	public function remove_class( $class ) {
		$this->attributes->remove_class($class);
		return $this;
	}

	public function set_classes( array $classes ) {
		$this->attributes->set_classes($classes);
		return $this;
	}

	public function get_classes() {
		return $this->attributes->get_classes();
	}

	public function get_type() {
		return 'form';
	}

	public function get_priority() {
		return 0;
	}

	public function get_name() {
		return $this->get_id();
	}

	public function get_id() {
		return $this->attributes->get_attribute('id');
	}

	public function setup_nonce_fields() {
		$nonce = wp_create_nonce($this->id);
		$this->add_element(WP_Form_Element::create('hidden')->set_name('wp_form_id')->set_value($this->id)->set_priority(-10));
		$this->add_element(WP_Form_Element::create('hidden')->set_name('wp_form_nonce')->set_value($nonce)->set_priority(-10));
	}

	public function add_validator( $callback, $priority = 10 ) {
		$this->add_callback($this->validators, $callback, $priority);
		return $this;
	}

	public function remove_validator( $callback, $priority = 10 ) {
		$this->remove_callback($this->validators, $callback, $priority);
		return $this;
	}

	public function get_validators() {
		return $this->get_callbacks($this->validators);
	}

	public function add_processor( $callback, $priority = 10 ) {
		$this->add_callback($this->processors, $callback, $priority);
		return $this;
	}

	public function remove_processor( $callback, $priority = 10 ) {
		$this->remove_callback($this->processors, $callback, $priority);
		return $this;
	}

	public function get_processors() {
		return $this->get_callbacks($this->processors);
	}

	private function add_callback( &$collection, $callback, $priority ) {
		$idx = WP_Form_Plugin::unique_callback_id( $callback );
		$collection[$priority][$idx] = $callback;
	}

	private function remove_callback( &$collection, $callback, $priority ) {
		$idx = WP_Form_Plugin::unique_callback_id( $callback );
		if ( isset($collection[$priority][$idx]) ) {
			unset($collection[$priority][$idx]);
		}
	}

	private function get_callbacks( &$collection ) {
		$priorities = array_keys($collection);
		sort($priorities);
		$callbacks = array();
		foreach ( $priorities as $priority ) {
			$callbacks = array_merge($callbacks, array_values($collection[$priority]));
		}
		return $callbacks;
	}

	private function set_default_attributes() {
		$this->set_method('post');
		$this->set_attribute('id', $this->id);
	}
}
