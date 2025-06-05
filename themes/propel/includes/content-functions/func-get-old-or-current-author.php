<?php
/**
 * Get the old author name or the current author name.
 *
 * @package Propel
 * @since   1.0
 */

/**
 * Get the old author name or the current author name.
 *
 * @param int|object $current_post The current post object or ID.
 */
function get_old_or_current_author_name( $current_post ) {
	if ( ! is_object( $current_post ) ) {
		$current_post = get_post( $current_post );
	}

	if ( ! ( $current_post instanceof WP_Post ) ) {
		return '';
	}

	$author_name = get_field( 'old_author', $current_post );

	if ( empty( $author_name ) && ! empty( $current_post->post_author ) ) {
		$author_name = get_the_author_meta( 'display_name', $current_post->post_author );
	}

	if ( 'wpdev' === $author_name ) {
		$author_name = '';
	}

	return $author_name;
}
