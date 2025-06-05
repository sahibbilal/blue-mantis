<?php
/**
 * Returns all posts by Post Type
 *
 * @package Propel
 * @since   1.0
 */

/**
 * Returns all posts by Post Type
 *
 * @param string $post_type The post type name.
 * @return object           List of posts.
 */
function get_custom_posts( $post_type = '' ) {
	$args = array(
		'post_type'      => $post_type,
		'posts_per_page' => -1,
		'order'          => 'ASC',
		'order_by'       => 'menu_order',
	);

	$query = new WP_Query( $args );

	return $query;
}
