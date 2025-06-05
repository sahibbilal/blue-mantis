<?php
/**
 * Get the previous page based on the server referrer.
 *
 * @package Propel
 * @since   1.0
 */

/**
 * Get the previous page based on the server referrer.
 */
function get_back_url_by_ref() {
	if ( ! isset( $_SERVER['HTTP_REFERER'] ) ) {
		return home_url( '/' );
	}

	$referrer = isset( $_SERVER['HTTP_REFERER'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_REFERER'] ) ) : '';
	$host     = isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '';
	if ( strpos( $referrer, $host ) !== false ) {
		return $referrer;
	} else {
		return home_url( '/' );
	}
}
