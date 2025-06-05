<?php
/**
 * Display theme blocks assigned to a specific location.
 *
 * @package Propel
 * @since   2.0.1
 */

/**
 * Display theme blocks assigned to a specific location.
 *
 * @param string $display_location   Load blocks assigned to this location.
 *
 * Make sure to update the load_global_blocks() function in the propel/includes/core/components/class-theme-core-acf-blocks.php file so that the blocks get loaded into the global $blocks variable (otherwise the CSS/JS won't load).
 */
function render_theme_blocks( $display_location ) {
	$args = array(
		'post_type'      => 'theme_block',
		'post_status'    => array( 'publish' ),
		'posts_per_page' => -1,
		'order'          => 'ASC',
		'orderby'        => 'menu_order',
		'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
			array(
				'key'     => 'display_location',
				'value'   => '"' . $display_location . '"',
				'compare' => 'LIKE',
			),
		),
	);

	$theme_block_posts = get_posts( $args );

	if ( ! empty( $theme_block_posts ) ) {
		$theme_block_content = '';

		foreach ( $theme_block_posts as $theme_block_post ) {
			if ( ! empty( $theme_block_post->post_content ) ) {
				$theme_block_content .= $theme_block_post->post_content;
			}
		}

		echo apply_filters( 'the_content', $theme_block_content ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
