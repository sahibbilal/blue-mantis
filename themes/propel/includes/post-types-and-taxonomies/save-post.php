<?php
/**
 * Hooks for updating data when saving posts
 *
 * @package Propel
 * @since   1.0
 */

namespace Propel\SavePost;

/**
 * Assign year taxonomy term corresponding to posts published date on save.
 *
 * @param int     $post_ID Post ID.
 * @param WP_Post $post    Post object.
 * @param bool    $update  Whether this is an existing post being updated.
 *
 * @return void
 */
function add_year_taxonomy( $post_ID, $post, $update ) {
	$year       = get_the_date( 'Y', $post );
	$post_terms = wp_get_post_terms( $post_ID, 'news_year' );

	if ( empty( $post_terms ) || $year !== $post_terms[0]->name && '1970' !== $year ) {
		$term = get_term_by( 'name', $year, 'news_year', ARRAY_A );

		if ( empty( $term ) ) {
			$term = wp_insert_term( $year, 'news_year' );
		}

		if ( ! empty( $term ) && ! is_wp_error( $term ) ) {
			wp_set_post_terms( $post_ID, $term['term_id'], 'news_year', false );
		}
	}
}
add_action( 'save_post_news', 'Propel\SavePost\add_year_taxonomy', 10, 3 );
