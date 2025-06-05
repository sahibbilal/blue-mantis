<?php
/**
 * Register Block Patterns
 *
 * @package Propel
 * @since   2.0.0
 */

/**
 * Register Block Pattern Category.
 */
if ( function_exists( 'register_block_pattern_category' ) ) {
	register_block_pattern_category(
		'propel',
		array( 'label' => esc_html__( 'Block Patterns', 'propel' ) )
	);
}

if ( function_exists( 'register_block_pattern' ) ) {
	$home_url = get_home_url();

	$args = array(
		'post_type'      => 'block_pattern',
		'posts_per_page' => -1,
	);

	$block_patterns = get_posts( $args );

	if ( ! empty( $block_patterns ) ) {
		foreach ( $block_patterns as $block_pattern ) {
			register_block_pattern(
				'propel/' . $block_pattern->post_name,
				array(
					'title'      => $block_pattern->post_title,
					'categories' => array( 'propel' ),
					'content'    => $block_pattern->post_content,
				)
			);
		}
	}
}
