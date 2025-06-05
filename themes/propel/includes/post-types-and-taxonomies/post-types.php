<?php
/**
 * Register theme post types
 *
 * Post types should always support revisions.
 * Please follow the same format for registering new post types.
 *
 * Reference: https://developer.wordpress.org/reference/functions/register_post_type/
 * Dashicons for menu_icon: https://developer.wordpress.org/resource/dashicons/
 *
 * @package Propel
 * @since   1.0
 */

namespace Propel\PostTypes;

/**
 * Register all post types set in the settings.json file.
 */
function register_post_types() {
	$post_types = get_theme_setting( 'post_types' );

	if ( empty( $post_types ) ) {
		return;
	}

	foreach ( $post_types as $post_type_slug => $post_type_args ) {
		$post_type_args = wp_parse_args(
			$post_type_args,
			array(
				'singular'   => $post_type_slug,
				'plural'     => $post_type_slug,
				'taxonomies' => array(),
				'args'       => array(),
			)
		);

		$post_type_args['args'] = wp_parse_args(
			$post_type_args['args'],
			array(
				'supports'      => array( 'title', 'revisions', 'author', 'editor', 'excerpt', 'thumbnail' ),
				'taxonomies'    => array_keys( $post_type_args['taxonomies'] ),
				'public'        => true,
				'has_archive'   => false,
				'show_in_rest'  => true,
				'menu_position' => 5,
				'rewrite'       => array(),
			)
		);

		$post_type_args['args']['rewrite'] = wp_parse_args(
			$post_type_args['args']['rewrite'],
			array(
				'with_front' => false,
			)
		);

		$args = array_merge(
			array(
				'label'  => __( $post_type_args['plural'], 'propel' ),
				'labels' => get_labels(
					$post_type_args['singular'],
					$post_type_args['plural']
				),
			),
			$post_type_args['args']
		);

		register_post_type( $post_type_slug, $args );
	}
}
add_action( 'init', 'Propel\PostTypes\register_post_types' );

/**
 * Get post type labels
 *
 * @param  string $singular  Singular name for the post type.
 * @param  string $plural    Plural name for the post type.
 * @param  string $menu_name Name the post type will appear as in the admin sidebar.
 * @return array             Lables for registering a post type.
 */
function get_labels( string $singular, string $plural = '', string $menu_name = '' ) : array {
	if ( empty( $plural ) ) {
		$plural = $singular . 's';
	}

	if ( empty( $menu_name ) ) {
		$menu_name = $plural;
	}

	return array(
		'name'                  => _x( $plural, 'Post Type General Name', 'propel' ),
		'singular_name'         => _x( $singular, 'Post Type Singular Name', 'propel' ),
		'menu_name'             => __( $menu_name, 'propel' ),
		'name_admin_bar'        => __( $singular, 'propel' ),
		'archives'              => __( $singular . ' Archives', 'propel' ),
		'attributes'            => __( $singular . ' Attributes', 'propel' ),
		'parent_item_colon'     => __( 'Parent ' . $singular, 'propel' ),
		'all_items'             => __( 'All ' . $plural, 'propel' ),
		'add_new_item'          => __( 'Add New ' . $singular, 'propel' ),
		'add_new'               => __( 'Add New', 'propel' ),
		'new_item'              => __( 'New ' . $singular, 'propel' ),
		'edit_item'             => __( 'Edit ' . $singular, 'propel' ),
		'update_item'           => __( 'Update ' . $singular, 'propel' ),
		'view_item'             => __( 'View ' . $singular, 'propel' ),
		'view_items'            => __( 'View ' . $plural, 'propel' ),
		'search_items'          => __( 'Search ' . $singular, 'propel' ),
		'not_found'             => __( 'Not found', 'propel' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'propel' ),
		'featured_image'        => __( 'Featured Image', 'propel' ),
		'set_featured_image'    => __( 'Set featured image', 'propel' ),
		'remove_featured_image' => __( 'Remove featured image', 'propel' ),
		'use_featured_image'    => __( 'Use as featured image', 'propel' ),
		'insert_into_item'      => __( 'Insert into ' . strtolower( $singular ), 'propel' ),
		'uploaded_to_this_item' => __( 'Uploaded to this ' . strtolower( $singular ), 'propel' ),
		'items_list'            => __( $plural . ' list', 'propel' ),
		'items_list_navigation' => __( $plural . ' list navigation', 'propel' ),
		'filter_items_list'     => __( 'Filter ' . strtolower( $plural ) . ' list', 'propel' ),
	);
}

/**
 * Register block patterns post type.
 */
function block_pattern() {
	register_post_type(
		'block_pattern',
		array(
			'label'               => __( 'Block Pattern', 'propel' ),
			'labels'              => get_labels( 'Block Pattern', 'Block Patterns' ),
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
add_action( 'init', 'Propel\PostTypes\block_pattern' );

/**
 * Register Gallery post type.
 */
function gallery() {
	register_post_type(
		'gallery',
		array(
			'label'               => __( 'Gallery', 'propel' ),
			'labels'              => get_labels( 'Gallery', 'Galleries' ),
			'supports'            => array( 'title', 'revisions' ),
			'taxonomies'          => array(),
			'public'              => false,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'exclude_from_search' => true,
			'menu_icon'           => 'dashicons-format-gallery',
			'has_archive'         => false,
		)
	);
}
add_action( 'init', 'Propel\PostTypes\gallery' );

/**
 * Set the default gutenberg blocks for blog posts.
 */
function set_post_template() {
	$post_type_object = get_post_type_object( 'post' );

	$post_type_object->template = array(
		array(
			'acf/content-section',
			array(
				'data' => array(
					'acf_block_background_color_content-section' => 'black',
				),
			),
		),
	);
}
add_action( 'init', 'Propel\PostTypes\set_post_template' );
