<?php
/**
 * Image hooks.
 *
 * @package Propel
 * @since   2.2.0
 */

namespace Propel\ImageHooks;

/**
 * Remove srcset sizes larger than the specified image.
 *
 * @param array  $sources {
 *     One or more arrays of source data to include in the 'srcset'.
 *
 *     @type array $width {
 *         @type string $url        The URL of an image source.
 *         @type string $descriptor The descriptor type used in the image candidate string,
 *                                  either 'w' or 'x'.
 *         @type int    $value      The source width if paired with a 'w' descriptor, or a
 *                                  pixel density value if paired with an 'x' descriptor.
 *     }
 * }
 * @param array  $size_array     {
 *      An array of requested width and height values.
 *
 *     @type int $0 The width in pixels.
 *     @type int $1 The height in pixels.
 * }
 * @param string $image_src     The 'src' of the image.
 * @param array  $image_meta    The image meta data as returned by 'wp_get_attachment_metadata()'.
 * @param int    $attachment_id Image attachment ID or 0.
 */
function limit_image_srcset( $sources, $size_array, $image_src, $image_meta, $attachment_id ) {
	$max_size = $size_array[0];

	foreach ( $sources as $size => $image ) {
		if ( $size > $max_size ) {
			unset( $sources[ $size ] );
		}
	}

	return $sources;
}
add_filter( 'wp_calculate_image_srcset', 'Propel\ImageHooks\limit_image_srcset', 11, 5 );

/**
 * If 829 Smartcrop plugin is used, add position to image style attribute.
 *
 * @param string[]     $attr       Array of attribute values for the image markup, keyed by attribute name.
 *                                 See wp_get_attachment_image().
 * @param WP_Post      $attachment Image attachment post.
 * @param string|int[] $size       Requested image size. Can be any registered image size name, or
 *                                 an array of width and height values in pixels (in that order).
 */
function add_smartcrop_position( $attr, $attachment, $size ) {
	$focus = get_post_meta( $attachment->ID, '_wpsmartcrop_image_focus', true );
	if ( ! empty( $focus ) && ! empty( $focus['top'] && ! empty( $focus['left'] ) ) ) {
		$attr['style'] = 'object-position: ' . $focus['left'] . '% ' . $focus['top'] . '%;';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'Propel\ImageHooks\add_smartcrop_position', 10, 3 );

// Disable image limit to 2560px wide.
add_filter( 'big_image_size_threshold', '__return_false' );
