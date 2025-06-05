<?php
/**
 * Modify Yoast functionality.
 *
 * @package Propel
 * @since   2.0.0
 */

namespace Propel\Yoast;

/**
 * Don't include noindex posts from the WordPress search

 * @param object $query    WordPress query object.
 */
function exclude_noindex_posts_from_search( $query ) {
	if ( class_exists( 'WPSEO_Options' ) && $query->is_main_query() && $query->is_search() && ! is_admin() ) {
		$meta_query            = isset( $query->meta_query ) ? $query->meta_query : array();
		$meta_query['noindex'] = array(
			'key'     => '_yoast_wpseo_meta-robots-noindex',
			'value'   => 1,
			'compare' => 'NOT EXISTS',
		);

		$query->set( 'meta_query', $meta_query );
	}
}
add_action( 'pre_get_posts', 'Propel\Yoast\exclude_noindex_posts_from_search' );

/**
 * Move Yoast SEO to the bottom of the screen.
 */
function yoast_to_bottom() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'Propel\Yoast\yoast_to_bottom' );

/**
 * Function for `wpseo_twitter_image` filter-hook.
 * 
 * @param string                 $twitter_image Image URL string.
 * @param Indexable_Presentation $presentation  The presentation of an indexable.
 *
 * @return string
 */
function twitter_image_filter( $twitter_image, $presentation ){

	$featured_image_url = get_the_post_thumbnail_url();
	if ( ! empty( $featured_image_url ) ) {
		$twitter_image = $featured_image_url;
	}
	
	return $twitter_image;
}
add_filter( 'wpseo_twitter_image', 'Propel\Yoast\twitter_image_filter', 10, 2 );
add_filter( 'wpseo_opengraph_image', 'Propel\Yoast\twitter_image_filter', 10, 2 );



function modify_thumbnail_url( $data, $post ) {
	$featured_image_url = get_the_post_thumbnail_url( $post->ID );
	if ( ! empty( $featured_image_url ) ) {
		$data['thumbnail_url'] = $featured_image_url;
	}
    return $data;
}
add_filter('oembed_response_data', 'Propel\Yoast\modify_thumbnail_url', 10, 2);