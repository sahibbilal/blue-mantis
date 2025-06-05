<?php
/**
 * Add to the main body class.
 *
 * @package Propel
 * @since   2.0.0
 */

add_filter(
	'body_class',
	function( $classes ) {
		global $blocks;

		if ( is_search() ) {
			$classes[] = 'page-has-alt-nav';
		}

		if ( ! empty( $blocks ) ) {
			$blocks_with_alt_nav = array(
				'acf/hero-homepage',
				'acf/hero-archive-news',
				'acf/hero-archive-blog',
				'acf/hero-archive-resources',
				'acf/hero-archive-events',
				'acf/hero-taxonomy',
				'acf/hero-post',
				'acf/hero-text',
				'acf/hero-standard',
			);

			foreach ( $blocks as $block ) {
				if ( ! empty( $block ) && ! empty( $block['blockName'] ) && 'acf/primary-nav' !== $block['blockName'] ) {
					$first_block = $block['blockName'];
					break;
				}
			}

			if ( ! empty( $first_block ) && in_array( $first_block, $blocks_with_alt_nav, true ) ) {
				$classes[] = 'page-has-alt-nav';
			}

			foreach ( $blocks as $block ) {
				if ( ! empty( $block['blockName'] ) ) {
					if ( 'acf/quick-links' === $block['blockName'] ) {
						$classes[] = 'has-quick-links';
					}
				}
			}
		}

		return $classes;
	}
);
