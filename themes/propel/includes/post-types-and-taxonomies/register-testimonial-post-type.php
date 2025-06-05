<?php
/**
 * Testimonial Post Type.
 *
 * @package Propel
 * @since   2.0.0
 */

if ( get_theme_setting( 'use_testimonal_post_type' ) ) {
	$labels = array(
		'name'                  => __( 'Testimonials', 'propel' ),
		'singular_name'         => __( 'Testimonial', 'propel' ),
		'menu_name'             => __( 'Testimonials', 'propel' ),
		'name_admin_bar'        => __( 'Testimonial', 'propel' ),
		'add_new'               => __( 'Add New', 'propel' ),
		'add_new_item'          => __( 'Add New Testimonial', 'propel' ),
		'new_item'              => __( 'New Testimonial', 'propel' ),
		'edit_item'             => __( 'Edit Testimonial', 'propel' ),
		'view_item'             => __( 'View Testimonial', 'propel' ),
		'all_items'             => __( 'All Testimonials', 'propel' ),
		'search_items'          => __( 'Search Testimonials', 'propel' ),
		'parent_item_colon'     => __( 'Parent Testimonials:', 'propel' ),
		'not_found'             => __( 'No testimonials found.', 'propel' ),
		'not_found_in_trash'    => __( 'No testimonials found in Trash.', 'propel' ),
		'featured_image'        => __( 'Testimonial Cover Image', 'propel' ),
		'archives'              => __( 'Testimonial archives', 'propel' ),
		'insert_into_item'      => __( 'Insert into testimonial', 'propel' ),
		'uploaded_to_this_item' => __( 'Uploaded to this testimonial', 'propel' ),
		'filter_items_list'     => __( 'Filter testimonials list', 'propel' ),
		'items_list_navigation' => __( 'Testimonials list navigation', 'propel' ),
		'items_list'            => __( 'Testimonials list', 'propel' ),
	);

	$args = array(
		'labels'              => $labels,
		'menu_icon'           => 'dashicons-format-chat',
		'public'              => false,
		'has_archive'         => false,
		'publicly_queryable'  => false,
		'show_ui'             => true,
		'exclude_from_search' => true,
		'supports'            => array( 'title', 'thumbnail' ),
		'rewrite'             => array( 'slug' => 'testimonial' ),
	);

	register_post_type( 'testimonial', $args );
}
