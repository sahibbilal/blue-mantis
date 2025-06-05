<?php
/**
 * Functions related to using the Loop.
 *
 * @package Propel
 * @since   1.0
 */

/**
 * Returns current post number. Must be used inside the loop.
 *
 * @return int|bool Post number or false if number is not found.
 */
function get_post_num() {
	$query = new WP_Query(
		array(
			'post_type'      => get_post_type(),
			'order'          => 'ASC',
			'posts_per_page' => -1,
		)
	);
	$posts = $query->posts;

	foreach ( $posts as $index => $post ) {
		if ( get_the_ID() === $post->ID ) {
			return $index + 1;
		}
	}

	return false;
}

/**
 * Returns first post ID. Must be used inside the loop
 *
 * @return int|bool Post ID or false if it's not found
 */
function get_first_post_id() {
	$query = new WP_Query(
		array(
			'post_type'      => get_post_type(),
			'posts_per_page' => 1,
			'order'          => 'ASC',
			'order_by'       => 'menu_order',
		)
	);
	$posts = $query->posts;
	if ( $posts ) {
		return $posts[0]->ID;
	}
	return false;
}

/**
 * Returns last post ID. Must be used inside the loop
 *
 * @return int|bool Post ID or false if it's not found
 */
function get_last_post_id() {
	$query = new WP_Query(
		array(
			'post_type'      => get_post_type(),
			'posts_per_page' => -1,
			'order'          => 'ASC',
			'order_by'       => 'menu_order',
		)
	);
	$posts = $query->posts;
	if ( $posts ) {
		return $posts[ count( $posts ) - 1 ]->ID;
	}
	return false;
}
