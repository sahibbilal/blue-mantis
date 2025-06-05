<?php
/**
 * Functions and hooks for the block library.
 *
 * @package Propel
 * @since   2.1.1
 */

namespace Propel\BlockLibrary;

/**
 * Register Block Library post type.
 */
function library_block() {
	$labels = array(
		'name'                  => __( 'Block Library', 'propel' ),
		'singular_name'         => __( 'Library Block', 'propel' ),
		'menu_name'             => __( 'Block Library', 'propel' ),
		'name_admin_bar'        => __( 'Block Library', 'propel' ),
		'add_new'               => __( 'Add New', 'propel' ),
		'add_new_item'          => __( 'Add New Library Block', 'propel' ),
		'new_item'              => __( 'New Library Block', 'propel' ),
		'edit_item'             => __( 'Edit Library Block', 'propel' ),
		'view_item'             => __( 'View Library Block', 'propel' ),
		'all_items'             => __( 'All Library Blocks', 'propel' ),
		'search_items'          => __( 'Search Block Library', 'propel' ),
		'parent_item_colon'     => __( 'Parent Block Library:', 'propel' ),
		'not_found'             => __( 'No library blocks found.', 'propel' ),
		'not_found_in_trash'    => __( 'No library blocks found in Trash.', 'propel' ),
		'featured_image'        => __( 'Library Block Cover Image', 'propel' ),
		'archives'              => __( 'Block library archives', 'propel' ),
		'insert_into_item'      => __( 'Insert into library block', 'propel' ),
		'uploaded_to_this_item' => __( 'Uploaded to this library block', 'propel' ),
		'filter_items_list'     => __( 'Filter block library list', 'propel' ),
		'items_list_navigation' => __( 'Block library list navigation', 'propel' ),
		'items_list'            => __( 'Block library list', 'propel' ),
	);

	register_post_type(
		'library_block',
		array(
			'label'               => __( 'Block Library', 'propel' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'revisions', 'editor' ),
			'taxonomies'          => array(),
			'public'              => true,
			'show_ui'             => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => true,
			'menu_icon'           => 'dashicons-block-default',
			'has_archive'         => true,
			'show_in_rest'        => true,
			'rewrite'             => array(
				'with_front' => false,
				'slug'       => 'block-library',
			),
		)
	);
}
add_action( 'init', 'Propel\BlockLibrary\library_block' );

/**
 * Exclude library blocks from sitemap.
 *
 * @param bool   $exclude   Default false.
 * @param string $post_type Post type name.
 */
function exclude_from_sitemap( $exclude, $post_type ) {
	if ( 'library_block' === $post_type ) {
		return true;
	}

	return $exclude;
}
add_filter( 'wpseo_sitemap_exclude_post_type', 'Propel\BlockLibrary\exclude_from_sitemap', 10, 2 );

/**
 * Create custom post type links pointing back to the archive.
 *
 * @param string  $post_link The post's permalink.
 * @param WP_Post $post      The post in question.
 * @param bool    $leavename Whether to keep the post name.
 * @param bool    $sample    Is it a sample permalink.
 */
function post_type_link( $post_link, $post, $leavename, $sample ) {
	if ( ! is_a( $post, 'WP_Post' ) ) {
		return $permalink;
	}

	if ( 'library_block' === $post->post_type ) {
		$post_link = get_post_type_archive_link( 'library_block' );
		$content   = get_the_content( null, false, $post->ID );

		if ( ! empty( $content ) ) {
			$post_link = add_query_arg( $post->ID, 'v', $post_link );
		}
	}

	return $post_link;
}
add_filter( 'post_type_link', 'Propel\BlockLibrary\post_type_link', 10, 4 );

/**
 * Redirect single library blocks to block library archive.
 */
function redirect_single_library_blocks() {
	if ( is_singular( 'library_block' ) ) {
		$post_link = get_post_type_archive_link( 'library_block' );
		wp_safe_redirect( $post_link );
		exit;
	}
}
add_action( 'wp', 'Propel\BlockLibrary\redirect_single_library_blocks', 10, 4 );

/**
 * For the block library, ignore the order set by the post type order plugin so they order alphabetically.
 *
 * @param bool     $ignore Whether to ignore the plugin order.
 * @param string   $order_by      The orderby parameter.
 * @param WP_Query $query  The query object.
 */
function ignore_post_type_order( $ignore, $order_by, $query ) {
	if ( is_post_type_archive( 'library_block' ) ) {
		$ignore = true;
	}

	return $ignore;
}
add_filter( 'pto/posts_orderby/ignore', 'Propel\BlockLibrary\ignore_post_type_order', 10, 3 );

/**
 * On the block library page, use default image for any images that are missing.
 *
 * @param array|false  $image         {
 *     Array of image data, or boolean false if no image is available.
 *
 *     @type string $0 Image source URL.
 *     @type int    $1 Image width in pixels.
 *     @type int    $2 Image height in pixels.
 *     @type bool   $3 Whether the image is a resized image.
 * }
 * @param int          $attachment_id Image attachment ID.
 * @param string|int[] $size          Requested image size. Can be any registered image size name, or
 *                                    an array of width and height values in pixels (in that order).
 * @param bool         $icon          Whether the image should be treated as an icon.
 */
function use_default_image_if_missing( $image, $attachment_id, $size, $icon ) {
	if ( is_block_library() || 'placeholder' === $attachment_id ) {
		if ( 'logo-placeholder' === $attachment_id ) {
			$image = array(
				get_stylesheet_directory_uri() . '/images/block-library-logo-placeholder.svg',
				144,
				24,
				false,
			);
		} elseif ( empty( $image ) || 'placeholder' === $attachment_id ) {
			$image = array(
				get_stylesheet_directory_uri() . '/images/block-library-placeholder.png',
				640,
				640,
				false,
			);
		} else {
			$image_path = wp_get_original_image_path( $attachment_id );

			if ( false === $image_path || ! file_exists( $image_path ) ) {
				$placeholder_url = get_stylesheet_directory_uri() . '/images/block-library-placeholder.png';

				if ( false !== strpos( $image[0], 'default-image-logo' ) ) {
					$placeholder_url = get_stylesheet_directory_uri() . '/images/block-library-logo-placeholder.svg';
				}

				$image[0] = $placeholder_url;
			}
		}
	}

	return $image;
}
add_filter( 'wp_get_attachment_image_src', 'Propel\BlockLibrary\use_default_image_if_missing', 10, 4 );

/**
 * Filter rendered block output to add placeholder image on block library page.
 *
 * @param string $block_content The block content about to be appended.
 * @param array  $block         The full block, including name and attributes.
 */
function render_block( $block_content, $block ) {
	global $wp_query;

	if ( is_post_type_archive( 'library_block' ) ) {
		if ( 'core/image' === $block['blockName'] && ! empty( $block['attrs'] ) && ! empty( $block['attrs']['id'] ) ) {
			$image_path = wp_get_original_image_path( $block['attrs']['id'] );

			if ( false === $image_path || ! file_exists( $image_path ) ) {
				$block_content = preg_replace( '/(?<=src=").*?(?=")/m', get_stylesheet_directory_uri() . '/images/block-library-placeholder.png', $block_content );
			}
		}
	}

	return $block_content;
}
add_filter( 'render_block', 'Propel\BlockLibrary\render_block', 10, 2 );

/**
 * Retrieves the post thumbnail ID.
 *
 * @param int|WP_Post $post Optional. Post ID or WP_Post object. Default is global `$post`.
 * @return int|false Post thumbnail ID (which can be 0 if the thumbnail is not set),
 *                   or false if the post does not exist.
 */
function add_default_placeholder_image( $post ) {
	if ( is_block_library() && empty( $post ) ) {
		$post = 1;
	}

	return $post;
}
add_filter( 'post_thumbnail_id', 'Propel\BlockLibrary\add_default_placeholder_image', 10, 2 );
