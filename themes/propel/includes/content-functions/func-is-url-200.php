<?php
/**
 * Determine if a url will return a 200 response.
 *
 * @package Propel
 * @since   1.0
 */

/**
 * Determine if a url will return a 200 response.
 *
 * @param string $url The url in question.
 */
function is_url_200( $url ) {
	stream_context_set_default(
		array(
			'ssl' => array(
				'verify_peer'      => false,
				'verify_peer_name' => false,
			),
		)
	);

	$headers = get_headers( $url, 1 );

	if ( strpos( $headers[0], '200' ) === false ) {
		return false;
	} else {
		return true;
	}
}
