<?php
/**
 * Author filters.
 *
 * @package Propel
 * @since   2.1.1
 */

namespace Propel\AuthorFilters;

/**
 * Author filters.
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
