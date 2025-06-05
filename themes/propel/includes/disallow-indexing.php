<?php
/**
 * Disallow indexing of your site on non-production environments.
 *
 * @package Propel
 * @since   2.0.0
 */

if ( defined( 'DISALLOW_INDEXING' ) && DISALLOW_INDEXING !== false ) {
	add_action( 'pre_option_blog_public', '__return_zero' );
}
