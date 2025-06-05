<?php
/**
 * Featured image related functionality.
 *
 * @package Propel
 * @since   2.0.0
 */

 namespace Propel\FeaturedImage;

/**
 * Set the default featured image based on the post's category term.
 * Overrides _thumbnail_id meta key.
 *
 * @see default_post_metadata hook
 * 
 * @param mixed  $value    The value to return if conditions are not met.
 * @param int    $post_id  The ID of the post.
 * @param string $meta_key The meta key to check.
 * @param bool   $single   Whether to return a single value.
 *
 * @return mixed The default featured image or the original value.
 */
function set_default_featured_image_by_taxonomy( $value, $post_id, $meta_key, $single ) {

    if ( $meta_key !== '_thumbnail_id' || ! empty( $value ) || is_admin() ) {
        return $value;
    }

    if ( 'resource' !== get_post_type( $post_id ) ) {
        return $value;
    }

	$primary_term = get_yoast_primary_term( 'resource_topic', $post_id, array( 'return' => 'term_id' ) );

	if ( empty( $primary_term ) ) {
		return $value;
	}

	$default_category_image = get_field( 'category_default_featured_image', 'category' . '_' . $primary_term );
	if ( ! empty( $default_category_image ) ) {
		return $default_category_image;
	}

    return $value;
}
add_filter( 'default_post_metadata', 'Propel\FeaturedImage\set_default_featured_image_by_taxonomy', 100, 4 );