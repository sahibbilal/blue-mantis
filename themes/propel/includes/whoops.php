<?php
/**
 * Enable Whoops error reporting
 *
 * @package Propel
 * @since   2.0.0
 */

// Enable error handling via Whoops if not CLI.
if ( defined( 'ENABLE_WHOOPS' ) && ENABLE_WHOOPS === true && defined( 'WP_ENV' ) && WP_ENV === 'development' ) {
	if ( php_sapi_name() !== 'cli' ) {
		$whoops = new \Whoops\Run();
		$whoops->pushHandler( new \Whoops\Handler\PrettyPageHandler() );
		$whoops->register();
	}
}
