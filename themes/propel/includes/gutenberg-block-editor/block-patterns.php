<?php
/**
 * Functions and hooks for block patterns.
 *
 * @package Propel
 * @since   1.0
 */

namespace Propel\BlockPatterns;

use function Propel\PostTypes\get_labels as get_labels;

/**
 * Register Block Library post type.
 */
function block_pattern() {
	register_post_type(
		'block_pattern',
		array(
			'label'               => __( 'Block Pattern', 'propel' ),
			'labels'              => get_labels( 'Block Pattern' ),
			'supports'            => array( 'title', 'revisions', 'author', 'editor' ),
			'taxonomies'          => array(),
			'public'              => false,
			'show_ui'             => true,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_in_rest'        => true,
			'menu_icon'           => 'dashicons-align-wide',
			'has_archive'         => false,
		)
	);
}
add_action( 'init', 'Propel\BlockPatterns\block_pattern' );
