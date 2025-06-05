<?php
/**
 * Register theme taxonomies
 *
 * Please follow the same format for registering new taxonomies.
 *
 * Reference: https://developer.wordpress.org/reference/functions/register_taxonomy/
 *
 * @package Propel
 * @since   1.0
 */

namespace Propel\Taxonomies;

/**
 * Register all taxonomies set in the settings.json file.
 */
function register_taxonomies() {
	$post_types = get_theme_setting( 'post_types' );

	if ( empty( $post_types ) ) {
		return;
	}

	foreach ( $post_types as $post_type_slug => $post_type_args ) {
		if ( empty( $post_type_args['taxonomies'] ) ) {
			continue;
		}

		foreach ( $post_type_args['taxonomies'] as $taxonomy_slug => $taxonomy_args ) {
			$taxonomy_args = wp_parse_args(
				$taxonomy_args,
				array(
					'singular' => $taxonomy_slug,
					'plural'   => $taxonomy_slug,
					'args'     => array(),
				)
			);

			$taxonomy_args['args'] = wp_parse_args(
				$taxonomy_args['args'],
				array(
					'labels'            => get_labels(
						$taxonomy_args['singular'],
						$taxonomy_args['plural']
					),
					'hierarchical'      => true,
					'public'            => true,
					'show_ui'           => true,
					'show_admin_column' => true,
					'show_in_rest'      => true,
					'rewrite'           => array(),
				)
			);

			$taxonomy_args['args']['rewrite'] = wp_parse_args(
				$taxonomy_args['args']['rewrite'],
				array(
					'with_front' => false,
				)
			);

			$args = array_merge(
				array(
					'label'  => __( $taxonomy_args['plural'], 'propel' ),
					'labels' => get_labels(
						$taxonomy_args['singular'],
						$taxonomy_args['plural']
					),
				),
				$taxonomy_args['args']
			);

			register_taxonomy( $taxonomy_slug, array( $post_type_slug ), $args );
		}
	}
}
add_action( 'init', 'Propel\Taxonomies\register_taxonomies' );

/**
 * Get taxonomy labels
 *
 * @param  string $singular  Singular name for the taxonomy.
 * @param  string $plural    Plural name for the taxonomy.
 * @param  string $menu_name Name the taxonomy will appear as in the admin sidebar.
 * @return array             Lables for registering a taxonomy.
 */
function get_labels( string $singular, string $plural = '', string $menu_name = '' ) : array {
	if ( empty( $plural ) ) {
		$plural = $singular . 's';
	}

	if ( empty( $menu_name ) ) {
		$menu_name = $plural;
	}

	return array(
		'name'                       => _x( $plural, 'Taxonomy General Name', 'propel' ),
		'singular_name'              => _x( $singular, 'Taxonomy Singular Name', 'propel' ),
		'menu_name'                  => __( $menu_name, 'propel' ),
		'all_items'                  => __( 'All ' . $plural, 'propel' ),
		'parent_item'                => __( 'Parent ' . $singular, 'propel' ),
		'parent_item_colon'          => __( 'Parent ' . $singular . ':', 'propel' ),
		'new_item_name'              => __( 'New ' . $singular . ' Name', 'propel' ),
		'add_new_item'               => __( 'Add New ' . $singular, 'propel' ),
		'edit_item'                  => __( 'Edit ' . $singular, 'propel' ),
		'update_item'                => __( 'Update ' . $singular, 'propel' ),
		'view_item'                  => __( 'View ' . $singular, 'propel' ),
		'separate_items_with_commas' => __( 'Separate ' . strtolower( $plural ) . ' with commas', 'propel' ),
		'add_or_remove_items'        => __( 'Add or remove ' . strtolower( $plural ), 'propel' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'propel' ),
		'popular_items'              => __( 'Popular ' . $plural, 'propel' ),
		'search_items'               => __( 'Search ' . $plural, 'propel' ),
		'not_found'                  => __( 'Not Found', 'propel' ),
		'no_terms'                   => __( 'No ' . strtolower( $plural ), 'propel' ),
		'items_list'                 => __( $plural . ' list', 'propel' ),
		'items_list_navigation'      => __( $plural . ' list navigation', 'propel' ),
	);
}
