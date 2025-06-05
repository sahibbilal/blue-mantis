<?php
/**
 * Register API and Licenses Keys set in .env
 *
 * @package Propel
 * @since   1.0
 */

/**
 * Register Google API Key for ACF
 *
 * @return void
 */
function acf_google_api_init() {
	if ( ! defined( 'GOOGLE_API_KEY' ) ) {
		return;
	}

	global $google_api_key;
	acf_update_setting( 'google_api_key', GOOGLE_API_KEY );
}
add_action( 'acf/init', 'acf_google_api_init' );
