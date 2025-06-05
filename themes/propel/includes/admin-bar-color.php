<?php
/**
 * Utility to change adminbar color based on environment.
 *
 * @package Propel
 * @since   2.0.0
 */

/**
 * Utility to change adminbar color based on environment
 *
 * @return void
 */
function admin_bar_color() {
	if ( ! defined( 'WP_ENV' ) ) {
		return;
	}

	if ( WP_ENV === 'development' ) {
		echo '<style>#wpadminbar {background: #650100;}</style>';
	}

	if ( WP_ENV === 'staging' ) {
		echo '<style>#wpadminbar {background: #0d4b00;}</style>';
	}
}
add_action( 'wp_head', 'admin_bar_color' );
add_action( 'admin_head', 'admin_bar_color' );
