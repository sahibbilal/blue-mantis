<?php
/**
 * Functions.
 *
 * This file defines all functions that are intended to be used by developers,
 * and therefore are not hidden behind a class for simplicity.
 *
 * @package Propel
 * @since   2.0.0
 */

/**
 * Recursively include all files from specified directory (and it's subdirectories).
 *
 * @param string $dir       Directory to include all files from.
 * @param int    $max_depth Maximum depth allowed.
 * @param int    $depth     Number of levels below specified directory current recursive call is on.
 */
function recursive_include( $dir, $max_depth = 5, $depth = 0 ) {
	if ( $depth > $max_depth ) {
		return;
	}

	$scan = glob( $dir . DIRECTORY_SEPARATOR . '*' );
	foreach ( $scan as $path ) {
		if ( preg_match( '/\.php$/', $path ) ) {
			include_once $path;
		} elseif ( is_dir( $path ) ) {
			recursive_include( $path, $max_depth, $depth + 1 );
		}
	}
}

function is_internal_link( $url ) {
	$site_url = get_site_url();
	$url_domain = parse_url( $url, PHP_URL_HOST );
	$site_domain = parse_url( $site_url, PHP_URL_HOST );

	if ( $url_domain === $site_domain ) {
		return true;
	} else {
		return false;
	}
}

function is_document_link( $url ) {
	$file_path = parse_url($url, PHP_URL_PATH);
	$file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path;

	if ( file_exists( $file_path ) ) {
		$file_info = wp_check_filetype($file_path);

		if ( $file_info && isset( $file_info['ext'] ) ) {
			$ext = $file_info['ext'];
			
			$allowed_extensions = array('pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx');

			if (in_array($ext, $allowed_extensions)) {
				return true;
			}
		}
	}

	return false;
}

add_filter(
	'post_type_link',
	function( $permalink, $post ) {
		if ( ! is_a( $post, 'WP_Post' ) ) {
			return $permalink;
		}

		if ( 'resource' === $post->post_type || 'news' === $post->post_type ) {
			$redirect_url = get_field( 'redirect_url', $post->ID );

			if ( ! empty( $redirect_url ) ) {
				return $redirect_url;
			}
		}

		return $permalink;
	},
	PHP_INT_MAX,
	2
);