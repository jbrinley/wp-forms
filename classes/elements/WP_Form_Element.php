<?php

/**
 * List magic properties for code completion:
 *
 * @property string type
 * @property int priority
 * @property string label
 * @property string name
 */
class WP_Form_Element implements WP_Form_Component {
	protected $type = 'text';
	protected $priority = 10;
	protected $label = '';
	protected $name = '';
	protected $default_value = '';
	protected $value = '';
	protected $name_context = '';

	protected $attributes;
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

	public function __construct( $args = array() ) {

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
			$this->{'set_'.$name}();
		} else {
			throw new InvalidArgumentException(sprintf(__('Undefined property: %s'), $name));
		}
	}

	/**
	 * @param $type
	 * @return WP_Form_Element
	 */
	public function set_type( $type ) {
		$this->type = $type;
		return $this;
	}

	public function get_type() {
		return $this->type;
	}

	public function set_name( $name ) {
		$this->name = $name;
		return $this;
	}

	public function get_name( $with_context = TRUE ) {
		$name = $this->name;
		$context = $this->get_name_context();
		if ( !$with_context || empty($context) ) {
			return $name;
		}
		if ( $position = strpos($name, '[') ) {
			$name = '['.substr($name, 0, $position).']'.substr($name, $position);
		} else {
			$name = '['.$name.']';
		}
		$name = $context.$name;
		return $name;
	}

	public function get_name_context() {
		return $this->name_context;
	}

	public function set_name_context( $context ) {
		$this->name_context = $context;
		return $this;
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

	public function render( $force = FALSE ) {
		if ( !$force && $this->rendered ) {
			return '';
		}
		$view = $this->get_view();
		$html = $view->render( $this );
		$this->rendered = TRUE;
		return $html;
	}

	public function add_child( $key, $definition ) {
		// TODO
		return $this;
	}

	public function remove_child( $key ) {
		// TODO
		return $this;
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
		// TODO: Implement get_description() method.
	}

	/**
	 * Get the attributes for the component. Attribute names
	 * should be keys, and their values should be unescaped strings or arrays.
	 *
	 * @return array
	 */
	public function get_attributes() {
		// TODO: Implement get_attributes() method.
	}

	public function get_id() {
		// TODO
	}

	/**
	 * @param WP_Form_Element[] $elements
	 */
	public static function sort_elements( array &$elements ) {
		uasort($elements, array( __CLASS__, 'priority_sort') );
	}

	public static function priority_sort( $a, $b ) {
		if ( $a->priority == $b->priority ) {
			return 0;
		}
		return ($a->priority < $b->priority) ? -1 : 1;
	}
}
