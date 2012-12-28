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
	}

	public static function autoloader( $class ) {
		if ( strpos( $class, 'WP_Form') !== 0 ) {
			return;
		}
		$dir = self::plugin_path('classes');

		if ( file_exists("$dir/$class.php") ) {
			include_once("$dir/$class.php");
			return;
		}
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
