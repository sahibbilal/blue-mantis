<?php
/**
 * Theme Support.
 *
 * This component registers theme support for WP features.
 *
 * @package Propel
 * @since   1.0
 */

defined( 'ABSPATH' ) || die();

/**
 * Class used to define this themes support of WP functionality.
 */
class Theme_Core_Theme_Support extends Theme_Core_Component {

	/**
	 * Kicks off this class' functionality.
	 */
	protected function init() {
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );
		add_theme_support( 'title-tag' );
		remove_theme_support( 'core-block-patterns' );
	}
}
