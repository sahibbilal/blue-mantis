<?php
/**
 * Filter rendered block output.
 *
 * @package Propel
 * @since   1.0
 */

namespace Propel\RenderBlock;

/**
 * Filter rendered block output.
 *
 * @param string $block_content The block content about to be appended.
 * @param array  $block         The full block, including name and attributes.
 */
function render_block( $block_content, $block ) {
	if ( ! is_admin() ) {
		if ( 'core/html' === $block['blockName'] ) {
			$block_content = str_replace( '<iframe', '<div class="iframe-wrapper"><iframe', $block_content );
			$block_content = str_replace( '</iframe>', '</iframe></div>', $block_content );

			$content  = '<div class="wp-block-html">';
			$content .= $block_content;
			$content .= '</div>';

			return $content;
		} elseif ( 'core/heading' === $block['blockName'] ) {
			if ( 1 === preg_match( '/^<[^>]*><\/[^>]*>$/mU', trim( $block_content ) ) ) {
				return;
			}
		} elseif ( 'core/paragraph' === $block['blockName'] ) {
			if ( 1 === preg_match( '/^<[^>]*><\/[^>]*>$/mU', trim( $block_content ) ) ) {
				return;
			}
		} elseif ( 'core/columns' === $block['blockName'] ) {
			$block_content = '<section class="wp-block-columns-wrapper">' . $block_content . '</section>';
			$block_content = str_replace( 'wp-block-columns ', 'wp-block-columns row ', $block_content );
			$block_content = str_replace( 'wp-block-columns"', 'wp-block-columns row"', $block_content );
		} elseif ( 'core/column' === $block['blockName'] ) {
			$block_content = str_replace( 'wp-block-column ', 'wp-block-column col-12 ', $block_content );
			$block_content = str_replace( 'wp-block-column"', 'wp-block-column col-12"', $block_content );
		} elseif ( 'core/list' === $block['blockName'] ) {
			$block_content = str_replace( '<ul class="', '<ul class="wp-block-list ', $block_content );
			$block_content = str_replace( '<ol class="', '<ol class="wp-block-list ', $block_content );
			$block_content = str_replace( '<ul>', '<ul class="wp-block-list">', $block_content );
			$block_content = str_replace( '<ol>', '<ol class="wp-block-list">', $block_content );
			$block_content = str_replace( '<li class="', '<li class="wp-block-list-item ', $block_content );
			$block_content = str_replace( '<li>', '<li class="wp-block-list-item">', $block_content );
		} elseif ( 'core/button' === $block['blockName'] ) {
			if ( ! empty( $block['attrs'] ) && ! empty( $block['attrs']['videoUrl'] ) ) {
				$block_content = str_replace( '<a', '<a data-video-url="' . esc_url( $block['attrs']['videoUrl'] ) . '"', $block_content );
			}

			if ( false !== strpos( $block_content, 'is-style-accordion' ) || false !== strpos( $block_content, 'is-style-tab' ) || false === strpos( $block_content, 'href' ) ) {
				$block_content = str_replace( '<a', '<button type="button"', $block_content );
				$block_content = str_replace( '</a>', '</button>', $block_content );
			}
		} elseif ( 'core/buttons' === $block['blockName'] ) {
			if ( false !== strpos( $block_content, 'is-style-tertiary' ) && 1 !== preg_match( '/is-style-(?!tertiary)/m', $block_content ) ) {
				$block_content = str_replace( 'wp-block-buttons', 'wp-block-buttons wp-block-buttons--tertiary-wrapper', $block_content );
			}
		} elseif ( 'core/quote' === $block['blockName'] ) {
			if ( false !== strpos( $block_content, '|' ) ) {
				preg_match( '/<cite>.*<\/cite>/m', $block_content, $citation_match );

				if ( ! empty( $citation_match[0] ) ) {
					$citation = $citation_match[0];
					$citation = str_replace( '| ', '|', $citation );
					$citation = str_replace( ' |', '|', $citation );
					$citation = str_replace( '|', '<span class="wp-block-quote__citation-divider">|</span>', $citation );

					$block_content = str_replace( $citation_match[0], $citation, $block_content );
				}
			}
		}
	}

	return $block_content;
}
add_filter( 'render_block', 'Propel\RenderBlock\render_block', 10, 2 );
