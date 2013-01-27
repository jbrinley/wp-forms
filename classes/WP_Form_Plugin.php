<?php

/**
 * A utility class for managing/launching the WP-Forms plugin
 */
class WP_Form_Plugin {

	private static $plugin_file = '';


	/**
	 * Get the absolute system path to the plugin directory, or a file therein
	 * @static
	 * @param string $path
	 * @return string
	 */
	public static function plugin_path( $path ) {
		$base = dirname(self::$plugin_file);
		if ( $path ) {
			return trailingslashit($base).$path;
		} else {
			return untrailingslashit($base);
		}
	}

	/**
	 * Get the absolute URL to the plugin directory, or a file therein
	 * @static
	 * @param string $path
	 * @return string
	 */
	public static function plugin_url( $path ) {
		return plugins_url($path, self::$plugin_file);
	}

	/**
	 * Initialize the plugin
	 *
	 * @static
	 * @param string $plugin_file Path to the plugin base file
	 * @return void
	 */
	public static function init( $plugin_file ) {
		self::$plugin_file = $plugin_file;
		spl_autoload_register(array(__CLASS__, 'autoloader'));
		add_action( 'init', array( 'WP_Form_Registrar', 'init' ), 11, 0 );
	}

	public static function autoloader( $class ) {
		if ( strpos( $class, 'WP_Form' ) !== 0 ) {
			return;
		}
		$dir = self::plugin_path('classes');

		if ( strpos( $class, 'WP_Form_Element' ) === 0 ) {
			$dir .= '/elements';
		} elseif ( strpos( $class, 'WP_Form_View' ) === 0 ) {
			$dir .= '/views';
		} elseif ( strpos( $class, 'WP_Form_Decorator' ) === 0 ) {
			$dir .= '/views/decorators';
		}

		if ( file_exists("$dir/$class.php") ) {
			include_once("$dir/$class.php");
			return;
		}
	}

	/**
	 * Build a unique ID for a callback.
	 *
	 * Basically the same as _wp_filter_build_unique_id(),
	 * only slightly less complicated, and public
	 *
	 * @see _wp_filter_build_unique_id()
	 *
	 * @param callable $function
	 * @throws InvalidArgumentException
	 * @return string
	 */
	public static function unique_callback_id( $function ) {
		if ( is_string($function) ) {
			return $function;
		}

		if ( is_object($function) ) {
			// Closures are currently implemented as objects
			$function = array( $function, '' );
		} else {
			$function = (array) $function;
		}
		if (is_object($function[0]) ) {
			return spl_object_hash($function[0]) . $function[1];
		} elseif ( is_string($function[0]) ) {
			// Static Calling
			return $function[0].$function[1];
		}
		throw new InvalidArgumentException(__('Unrecognizable callback', 'wp-forms'));
	}


	/* Housekeeping */

	final public function __clone() {
		trigger_error( "Singleton. No cloning allowed!", E_USER_ERROR );
	}

	final public function __wakeup() {
		trigger_error( "Singleton. No serialization allowed!", E_USER_ERROR );
	}

	private function __construct() {
		// do not construct
	}
}
