<?php

class WP_Form_Walker {
	/** @var WP_Form_Aggregate */
	private $component = NULL;

	public function __construct( WP_Form_Aggregate $component ) {
		$this->component = $component;
	}

	/**
	 * Walk through each child of the component, and pass it as
	 * the parameter to $callback
	 *
	 * @param callable $callback
	 */
	public function walk( $callback ) {
		$children = $this->component->get_children();
		foreach ( $children as $child ) {
			call_user_func($callback, $child);
		}
	}
}
