<?php

/**
 * List magic properties for code completion:
 *
 * @property-read string type
 * @property int priority
 * @property string label
 * @property string name
 * @property string default_value
 * @property string value
 * @property string description
 * @property string id
 * @property WP_Form_View_Interface view
 */
class WP_Form_Element implements WP_Form_Component, WP_Form_Attributes_Interface {
	protected $type = '';
	protected $priority = 10;
	protected $label = '';
	protected $default_value = '';
	protected $value = '';
	protected $description = '';
	protected $errors = array();

	/** @var WP_Form_Attributes_Interface */
	protected $attributes = NULL;
	protected $children;
	protected $options;
	protected $view;
	protected $default_view = 'WP_Form_View_Input';
	protected $default_decorators = array(
		'WP_Form_Decorator_Description' => array(),
		'WP_Form_Decorator_Errors' => array(),
		'WP_Form_Decorator_Label' => array(),
		'WP_Form_Decorator_HtmlTag' => array(),
	);

	public function __construct( $args = array() ) {
		$this->attributes = new WP_Form_Attributes();
		if ( !empty($args['type']) && empty($this->type) ) {
			$this->type = $args['type'];
		}
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

	public function get_type() {
		return $this->type;
	}

	/**
	 * @param string $name
	 * @return $this
	 */
	public function set_name( $name ) {
		$this->attributes->set_attribute('name', $name);
		return $this;
	}

	/**
	 * @return string
	 */
	public function get_name() {
		return $this->attributes->get_attribute('name');
	}

	/**
	 * @param int $priority
	 * @return $this
	 */
	public function set_priority( $priority ) {
		$this->priority = (int)$priority;
		return $this;
	}

	/**
	 * @return int
	 */
	public function get_priority() {
		return $this->priority;
	}


	/**
	 * @param mixed $default_value
	 * @return $this
	 */
	public function set_default_value( $default_value ) {
		$this->default_value = $default_value;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function get_default_value() {
		return $this->default_value;
	}

	/**
	 * @param string $label
	 * @return $this
	 */
	public function set_label( $label ) {
		$this->label = $label;
		return $this;
	}

	/**
	 * @return string
	 */
	public function get_label() {
		return $this->label;
	}

	/**
	 * @return mixed
	 */
	public function get_value() {
		return $this->value;
	}


	/**
	 * @param mixed $value
	 * @return $this
	 */
	public function set_value( $value ) {
		$this->value = $value;
		return $this;
	}

	/**
	 * @return string
	 */
	public function get_description() {
		return $this->description;
	}

	/**
	 * @param mixed $description
	 * @return $this
	 */
	public function set_description( $description ) {
		$this->description = $description;
		return $this;
	}

	/**
	 * @return string
	 */
	public function get_id() {
		return $this->attributes->get_attribute('id');
	}

	/**
	 * @param string $id
	 * @return $this
	 */
	public function set_id( $id ) {
		$this->attributes->set_attribute('id', $id );
		return $this;
	}

	/**
	 * @param string $error
	 * @return $this
	 */
	public function set_error( $error ) {
		$this->errors[] = $error;
		return $this;
	}

	public function get_errors() {
		return $this->errors;
	}

	/**
	 * @return $this
	 */
	public function clear_errors() {
		$this->errors = array();
		return $this;
	}

	/**
	 * @return string
	 */
	public function render() {
		$view = $this->get_view();
		$html = $view->render( $this );
		return $html;
	}

	/**
	 * @return WP_Form_View_Interface
	 */
	public function get_view() {
		if ( empty($this->view) ) {
			$classes = array( $this->default_view, 'WP_Form_View_'.ucfirst($this->get_type()) );
			$classes = array_filter($classes);
			$classes = apply_filters( 'wp_form_view_classes', $classes, $this );
			foreach ( $classes as $class ) {
				if ( class_exists($class) ) {
					$this->view = new $class();
					break;
				}
			}
			if ( empty($this->view) ) {
				$this->view = new WP_Form_View_Input();
			}
			// allow other plugins/themes finer-grained control over defaults than just modifying the defaults array
			$callback = apply_filters( 'wp_forms_default_decorators_callback', array($this, 'apply_default_decorators'), $this );
			call_user_func($callback, $this);
		}
		return $this->view;
	}

	/**
	 * @return $this
	 */
	public function apply_default_decorators() {
		$defaults = $this->get_default_decorators();
		foreach ( $defaults as $class => $args ) {
			$this->add_decorator( $class, $args );
		}
		return $this;
	}

	/**
	 * @return array
	 */
	public function get_default_decorators() {
		$defaults = apply_filters( 'wp_form_default_decorators', $this->default_decorators, $this );
		return $defaults;
	}

	/**
	 * Add a decorator to the element's view
	 *
	 * @param string $decorator_class
	 * @param array $args
	 *
	 * @return $this
	 * @throws InvalidArgumentException
	 */
	public function add_decorator( $decorator_class, $args = array() ) {
		if ( !class_exists($decorator_class) ) {
			throw new InvalidArgumentException(sprintf(__('Invalid decorator class: %s', 'wp-forms'), $decorator_class));
		}
		$this->view = new $decorator_class($this->view, $args);
		return $this;
	}

	/**
	 * @param WP_Form_View_Interface $view
	 * @return $this
	 */
	public function set_view( WP_Form_View_Interface $view ) {
		$this->view = $view;
		return $this;
	}

	/* WP_Form_Attributes_Interface ***********************
	*******************************************************/


	/**
	 * @param string $key
	 * @param string $value
	 *
	 * @throws InvalidArgumentException
	 * @return $this
	 */
	public function set_attribute( $key, $value ) {
		if ( $key == 'type' ) { // we don't let the type attribute change
			throw new InvalidArgumentException(__('"type" attribute may not be changed', 'wp-forms'));
		} elseif ( $key == 'value' ) {
			throw new InvalidArgumentException(__("Use WP_Form_Element::set_value() to change an element's value", 'wp-forms'));
		}
		$this->attributes->set_attribute($key, $value);
		return $this;
	}

	/**
	 * @param string $key
	 *
	 * @return string
	 */
	public function get_attribute( $key ) {
		switch ( $key ) {
			case 'type':
				return $this->type;
			case 'value':
				if ( !empty($this->value) ) {
					return $this->value;
				}
				return $this->default_value;
			default:
				return $this->attributes->get_attribute($key);
		}
	}

	/**
	 * @return array
	 */
	public function get_all_attributes() {
		$attributes = $this->attributes->get_all_attributes();
		$attributes['type'] = $this->type;
		$attributes['value'] = $this->get_attribute('value');
		return $attributes;
	}

	/**
	 * @param string $class
	 *
	 * @return $this
	 */
	public function add_class( $class ) {
		$this->attributes->add_class($class);
		return $this;
	}

	/**
	 * @param string $class
	 *
	 * @return $this
	 */
	public function remove_class( $class ) {
		$this->attributes->remove_class($class);
		return $this;
	}

	/**
	 * @param array $classes
	 *
	 * @return $this
	 */
	public function set_classes( array $classes ) {
		$this->attributes->set_classes($classes);
		return $this;
	}

	/**
	 * @return array
	 */
	public function get_classes() {
		return $this->attributes->get_classes();
	}

	/* Static class interface ****************
	******************************************/

	/**
	 * @param WP_Form_Element[] $elements
	 * @return WP_Form_Element[] A numeric array of elements
	 */
	public static function sort_elements( array $elements ) {
		// use a schwartzian transform to keep elements with the same priority in the same order
		// see http://notmysock.org/blog/php/schwartzian-transform.html
		$elements = array_values($elements); // we don't care about associative array keys
		array_walk( $elements, create_function( '&$v, $k' , '$v = array( $v->get_priority(), $k, $v );'));
		asort($elements); // sorts by priority, then key
		array_walk( $elements, create_function( '&$v, $k', '$v = $v[2];'));
		return $elements;
	}


	/**
	 * @param $type
	 * @param array $args
	 *
	 * @return WP_Form_Element|null
	 */
	public static function create( $type, $args = array() ) {
		$element = NULL;
		$classes = array( $type, 'WP_Form_Element_'.ucfirst($type) );
		$classes = apply_filters( 'wp_form_element_classes', $classes, $type );
		foreach ( $classes as $class ) {
			if ( class_exists($class) ) {
				$element = new $class( $args );
				break;
			}
		}
		if ( empty($element) ) {
			$element = new self( array_merge(array( 'type' => $type ), $args) );
		}
		return $element;
	}
}
