<?php
/**
 * Modifications for `wp_kses()` functionality.
 *
 * @package Propel
 * @since   1.0
 */

/**
 * Set the allowed HTML for `wp_kses()` by context type.
 *
 * @param array|string $context Context to judge allowed tags by.
 * @param string       $context_type Context name.
 */
function allowed_html_by_context( $context, $context_type ) {
	if ( 'main-header-nav' === $context_type ) {
		$context['div']  = array(
			'class' => true,
		);
		$context['ul']   = array(
			'id'    => true,
			'class' => true,
		);
		$context['li']   = array(
			'id'    => true,
			'class' => true,
		);
		$context['span'] = array(
			'class' => true,
		);
	}

	if ( 'post' === $context_type ) {
		$context['svg']   = array(
			'class'           => true,
			'aria-hidden'     => true,
			'aria-labelledby' => true,
			'role'            => true,
			'xmlns'           => true,
			'width'           => true,
			'height'          => true,
			'viewbox'         => true,
		);
		$context['g']     = array(
			'fill' => true,
		);
		$context['title'] = array(
			'title' => true,
		);
		$context['path']  = array(
			'd'    => true,
			'fill' => true,
		);
	}

	if ( 'inline-style' === $context_type ) {
		$context = array(
			'style' => array(),
		);
	}

	if ( 'button' === $context_type ) {
		$context = array(
			'span' => array(
				'class' => true,
			),
		);
	}

	if ( isset( $context['img'] ) && ! isset( $context['img']['srcset'] ) ) {
		$context['img'] = array_merge( $context['img'], array( 'srcset' => true ) );
	}

	return $context;
}
add_filter( 'wp_kses_allowed_html', 'allowed_html_by_context', 10, 2 );
