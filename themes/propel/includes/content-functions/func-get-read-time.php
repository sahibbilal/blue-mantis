<?php
/**
 * Gets read time of a post.
 *
 * @package Propel
 * @since   2.0.0
 */

/**
 * Gets read time of a post.
 *
 * @param array $post_ID    The post ID.
 * @return string The read time of the post
 */
function get_read_time( $post_ID = null ) {
	if ( empty( $post_ID ) ) {
		$post_ID = get_the_ID();
	}

	$read_time = get_post_meta( $post_ID, 'estimated_read_time', true );

	if ( ! empty( $read_time ) ) {
		return sprintf( __( '%s min read', 'propel' ), $read_time );
	}
}
