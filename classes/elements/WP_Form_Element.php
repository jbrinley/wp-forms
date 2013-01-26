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
 */
class WP_Form_Element implements WP_Form_Component, WP_Form_Attributes_Interface {
	protected $type = 'text';
	protected $priority = 10;
	protected $label = '';
	protected $name = '';
	protected $default_value = '';
	protected $value = '';
	protected $description = '';


	/** @var WP_Form_Attributes_Interface */
	protected $attributes = NULL;
	protected $children;
	protected $options;
	protected $view;
	protected $default_view = 'WP_Form_View_Text';
	protected $default_decorators = array(
		'WP_Form_Decorator_Description' => array(),
		'WP_Form_Decorator_Errors' => array(),
		'WP_Form_Decorator_Label' => array(),
		'WP_Form_Decorator_HtmlTag' => array(),
	);
	protected $rendered = FALSE;

	public function __construct() {
		$this->attributes = new WP_Form_Attributes();
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

	public function set_name( $name ) {
		$this->name = $name;
		return $this;
	}

	public function get_name() {
		return $this->name;
	}

	/**
	 * @param int $priority
	 * @return WP_Form_Element
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

	public function set_default_value( $default_value ) {
		$this->default_value = $default_value;
		return $this;
	}

	public function get_default_value() {
		return $this->default_value;
	}

	/**
	 * @param string $label
	 * @return WP_Form_Element
	 */
	public function set_label( $label ) {
		$this->label = $label;
		return $this;
	}

	public function get_label() {
		return $this->label;
	}

	/**
	 * @return mixed
	 */
	public function get_value() {
		return $this->value;
	}

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

	public function set_description( $description ) {
		$this->description = $description;
		return $this;
	}

	public function get_id() {
		return $this->attributes->get_attribute('id');
	}

	public function render( $force = FALSE ) {
		if ( !$force && $this->rendered ) {
			return '';
		}
		$view = $this->get_view();
		$html = $view->render( $this );
		$this->rendered = TRUE;
		return $html;
	}

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
				$this->view = new WP_Form_View_Text();
			}
			$this->apply_default_decorators();
		}
		return $this->view;
	}

	public function apply_default_decorators() {
		$defaults = $this->get_default_decorators();
		foreach ( $defaults as $class => $args ) {
			$this->add_decorator( $class, $args );
		}
	}

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
	 * @return WP_Form_Element
	 * @throws InvalidArgumentException
	 */
	public function add_decorator( $decorator_class, $args = array() ) {
		if ( !class_exists($decorator_class) ) {
			throw new InvalidArgumentException(sprintf(__('Invalid decorator class: %s', 'wp-forms'), $decorator_class));
		}
		$this->view = new $decorator_class($this->view, $args);
		return $this;
	}

	public function set_view( WP_Form_View_Interface $view ) {
		$this->view = $view;
		return $this;
	}

	/**
	 * @return bool Whether the component has been rendered
	 */
	public function is_rendered() {
		return $this->rendered;
	}

	/* WP_Form_Attributes_Interface ***********************
	*******************************************************/


	/**
	 * @param string $key
	 * @param string $value
	 *
	 * @return WP_Form_Element
	 */
	public function set_attribute( $key, $value ) {
		$this->attributes->set_attribute($key, $value);
		return $this;
	}

	/**
	 * @param string $key
	 *
	 * @return string
	 */
	public function get_attribute( $key ) {
		return $this->attributes->get_attribute($key);
	}

	/**
	 * @return array
	 */
	public function get_all_attributes() {
		$attributes = $this->attributes->get_all_attributes();
		// TODO: add attributes not managed by the attributes object
		return $attributes;
		// TODO: Implement get_all_attributes() method.
	}

	/**
	 * @param string $class
	 *
	 * @return WP_Form_Element
	 */
	public function add_class( $class ) {
		$this->attributes->add_class($class);
		return $this;
	}

	/**
	 * @param string $class
	 *
	 * @return WP_Form_Element
	 */
	public function remove_class( $class ) {
		$this->attributes->remove_class($class);
		return $this;
	}

	/**
	 * @param array $classes
	 *
	 * @return WP_Form_Element
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
	 */
	public static function sort_elements( array &$elements ) {
		// use a schwartzian transform to keep elements with the same priority in the same order
		// see http://notmysock.org/blog/php/schwartzian-transform.html
		array_walk( $elements, create_function( '&$v, $k' , '$v = array( $v->priority, $k, $v );'));
		asort($elements); // sorts by priority, then key
		array_walk( $elements, create_function( '&$v, $k', '$v = $v[2];'));
	}


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
