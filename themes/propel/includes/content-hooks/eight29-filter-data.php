<?php
/**
 * Filters for the 829 Filters plugin.
 *
 * @package Propel
 * @since   2.1.1
 */

namespace Propel\Eight29Filters;

/**
 * Set the filter post data.
 *
 * @param array $data       The filter data.
 */
function set_post_data( $data ) {
	$data = array(
		'post'     => array(
			'category' => array(
				'label'       => __( 'Categories', 'propel' ),
				'type'        => 'checkbox',
				'collapsible' => true,
			),
		),
		'resource' => array(
			'resource_type'  => array(
				'label'       => __( 'Types', 'propel' ),
				'type'        => 'checkbox',
				'collapsible' => true,
			),
			'resource_topic' => array(
				'label'       => __( 'Topics', 'propel' ),
				'type'        => 'checkbox',
				'collapsible' => true,
			),
		),
		'event'    => array(
			'event_topic' => array(
				'label'       => __( 'Topics', 'propel' ),
				'type'        => 'checkbox',
				'collapsible' => true,
			),
		),
		'news'     => array(
			'news_year'     => array(
				'label'       => __( 'Years', 'propel' ),
				'type'        => 'checkbox',
				'collapsible' => true,
			),
			'news_category' => array(
				'label'       => __( 'Types', 'propel' ),
				'type'        => 'checkbox',
				'collapsible' => true,
			),
		),
	);

	return $data;
}
add_filter( 'eight29_filters/set_post_data', 'Propel\Eight29Filters\set_post_data' );

/**
 * Set the images sizes loaded by the 829 Filters plugin.
 *
 * @param string[] $default_sizes An array of intermediate image size names.
 */
function set_rest_image_sizes( $default_sizes ) {
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST && ( ! isset( $_SERVER['REQUEST_URI'] ) || false === strpos( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), 'wp-retina-2x' ) ) ) {
		$default_sizes = array( 'eight29_post_thumb', 'card-image-link-4' );
	}

	return $default_sizes;
}
add_filter( 'intermediate_image_sizes', 'Propel\Eight29Filters\set_rest_image_sizes' );

/**
 * Register the card field for post types with a card component.
 */
function register_rest_card_field() {
	$args = array(
		'public' => true,
	);

	$post_types = get_post_types( $args, 'names' );

	if ( ! empty( $post_types ) ) {
		$post_types_with_cards = array_filter(
			$post_types,
			function( $post_type ) {
				if ( file_exists( get_template_directory() . '/blocks/components/' . $post_type . '-card/' . $post_type . '-card.php' ) ) {
					return $post_type;
				}
			},
		);

		if ( ! empty( $post_types_with_cards ) ) {
			register_rest_field(
				$post_types_with_cards,
				'card',
				array(
					'get_callback' => 'Propel\Eight29Filters\render_card',
				)
			);
		}
	}
}
add_action( 'rest_api_init', 'Propel\Eight29Filters\register_rest_card_field' );

/**
 * Load the card component file.
 *
 * @param  array $object         Post array.
 */
function render_card( $object ) {
	if ( empty( $object['id'] ) ) {
		return;
	}

	$card_post = get_post( $object['id'] );

	if ( empty( $card_post ) || empty( $card_post->post_type ) || ! file_exists( get_template_directory() . '/blocks/components/' . $card_post->post_type . '-card/' . $card_post->post_type . '-card.php' ) ) {
		return;
	}

	ob_start();
	get_theme_part( '../blocks/components/' . $card_post->post_type . '-card/' . $card_post->post_type . '-card', array( 'card_post' => $card_post ) );
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

/**
 * Register rest fields.
 */
function register_rest_fields() {
	register_rest_field(
		array( 'news' ),
		'news_year',
		array(
			'get_callback' => 'Propel\Eight29Filters\get_news_year',
		)
	);
}
//add_action( 'rest_api_init', 'Propel\Eight29Filters\register_rest_fields' );

/**
 * Get the news year.
 *
 * @param  array $object         Post array.
 */
function get_news_year( $object ) {
	if ( empty( $object['id'] ) ) {
		return;
	}

	return get_the_date( 'Y', $object['id'] );
}

/**
 * Fragments route callback.
 *
 * @param   array $data   Global data added to the 829 filters plugin.
 */
function set_global_data( $data ) {
	ob_start();
	render_theme_blocks( 'search_no_results' );
	$content = ob_get_contents();
	ob_end_clean();

	$data['noResults'] = $content;

	return $data;
}
add_filter( 'eight29_filters/set_global_data', 'Propel\Eight29Filters\set_global_data' );

/**
 * Hide terms with no posts assigned to them.
 *
 * @param array    $args       An array of get_terms() arguments.
 * @param string[] $taxonomies An array of taxonomy names.
 */
function hide_empty_terms( $args, $taxonomies ) {
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( ! empty( $_GET['context'] ) || ( ! empty( $_GET['_locale'] ) && 'user' === $_GET['_locale'] ) ) {
			return $args;
		}
	}

	if ( ! is_admin() && defined( 'REST_REQUEST' ) && !in_array("resource_topic", $args['taxonomy']) && !in_array("resource_type", $args['taxonomy'])) {
		$args['hide_empty'] = true;
	} 

	if ( ! empty( $args['taxonomy'] ) && ! empty( array_intersect( $args['taxonomy'], array( 'news_year' ) ) ) ) {
		$args['order'] = 'DESC';
	}

	return $args;
}
add_filter( 'get_terms_args', 'Propel\Eight29Filters\hide_empty_terms', 999, 2 );

/**
 * Sets custom endpoint data.
 *
 * @param array $data       The filter data.
 * @param array $object     The post data.
 */
function set_endpoint_data( $data, $object ) {
	if ( isset( $object['type'] ) && ! empty( $object['id'] ) ) {
		if ( 'post' === $object['type'] ) {
			$data['author_name'] = get_old_or_current_author_name( $object['id'] );
		} elseif('news' === $object['type']) {
			$data['news_year'] = get_the_date( 'Y', $object['id'] );
		}
	}

	return $data;
}
add_filter( 'eight29_filters/custom_endpoint_details', 'Propel\Eight29Filters\set_endpoint_data', 99999, 2 );
