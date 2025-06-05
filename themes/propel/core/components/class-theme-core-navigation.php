<?php
/**
 * Navigation.
 *
 * This component handles navigation menus.
 *
 * @package Propel
 * @since   1.0
 */

defined( 'ABSPATH' ) || die();

/**
 * Class managing this themes navigation menus and menu locations.
 */
class Theme_Core_Navigation extends Theme_Core_Component {

	/**
	 * Register navigation menus added in the settings file.
	 */
	protected function init() {
		$nav_array = array();
		foreach ( $this->settings->register_nav_menus as $key => $value ) {
			$nav_array[ $key ] = $value;
		}

		register_nav_menus( $nav_array );
	}
}
