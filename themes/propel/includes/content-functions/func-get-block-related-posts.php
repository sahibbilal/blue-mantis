<?php
/**
 * Get the post objects for a related posts block.
 *
 * @package Propel
 * @since   2.0.0
 */

/**
 * Get the post objects for a related posts block.
 *
 * @param array $args {
 *    Optional arguments.
 *
 *     @type int      $posts_per_page          The number of posts to return.
 *     @type int      $post__not_in            Array of post IDS to not include in the query.
 * }
 *
 * @return  array   An array of post objects.
 */
function get_block_related_posts( $args = array() ) {
	$related_posts  = array();
	$post_selection = get_field( 'post_selection' );
	$post_order     = get_field( 'post_order' );
	$terms          = get_field( 'terms' );
	$taxonomies     = get_field( 'taxonomies' );
	$manual         = get_field( 'manual' );

	$defaults = array(
		'posts_per_page' => 3,
		'post__not_in'   => array(),
	);

	$args = wp_parse_args( $args, $defaults );

	if ( ! empty( $post_selection ) ) {
		$args = array(
			'posts_per_page' => $args['posts_per_page'],
			'post__not_in'   => $args['post__not_in'],
			'post_status'    => array( 'publish' ),
		);

		if ( ! empty( $post_order ) ) {
			$args['orderby'] = $post_order;
		} else {
			$args['orderby'] = 'rand';
		}

		if ( is_singular() ) {
			$args['post__not_in'] = array( get_the_ID() );
			$args['post_type']    = get_post_type();
		}

		if ( 'automatic' === $post_selection ) {
			$terms      = get_field( 'terms' );
			$post_types = get_field( 'post_types' );

			if ( ! empty( $post_types ) ) {
				$args['post_type'] = $post_types;
			} else {
				$args['post_type'] = get_post_types( array( 'public' => true ) );
			}

			if ( ! empty( $terms ) ) {
				$taxonomy_data = array();

				foreach ( $terms as $this_term ) {
					$term_data = explode( '&&', $this_term );

					if ( ! empty( $term_data[0] ) && ! empty( $term_data[1] ) ) {
						if ( empty( $taxonomy_data[ $term_data[0] ] ) ) {
							$taxonomy_data[ $term_data[0] ] = array();
						}

						$taxonomy_data[ $term_data[0] ][] = $term_data[1];
					}
				}

				if ( ! empty( $taxonomy_data ) ) {
					// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
					$args['tax_query'] = array( 'relation' => 'OR' );

					foreach ( $taxonomy_data as $this_taxonomy => $this_terms ) {
						$args['tax_query'][] = array(
							'taxonomy' => $this_taxonomy,
							'field'    => 'term_id',
							'terms'    => $this_terms,
						);
					}
				}
			}

			$related_posts = get_posts( $args );
		} elseif ( 'primary_term' === $post_selection ) {
			$taxonomies = get_field( 'taxonomies' );

			if ( ! empty( $taxonomies ) && is_singular() ) {

				// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				$args['tax_query'] = array( 'relation' => 'OR' );

				foreach ( $taxonomies as $this_taxonomy ) {
					$primary_term = get_yoast_primary_term( $this_taxonomy, null, array( 'return' => 'term_id' ) );

					if ( ! empty( $primary_term ) ) {
						$args['tax_query'][] = array(
							'taxonomy' => $this_taxonomy,
							'field'    => 'term_id',
							'terms'    => $primary_term,
						);
					}
				}
			}

			$related_posts = get_posts( $args );
		} elseif ( 'manual' === $post_selection ) {
			if ( is_array( $manual ) && ! empty( $manual ) && is_object( $manual[0] ) ) {
				$related_posts = $manual;
			}
		}
	}

	return $related_posts;
}
