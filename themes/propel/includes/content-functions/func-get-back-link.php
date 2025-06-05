<?php
/**
 * Displays the back link.
 *
 * @package Propel
 * @since   2.2.0
 */

/**
 * Displays the back link.
 *
 * @param string $post_id    The post ID.
 * @param string $title      An optional custom post title text.
 * @param string $permalink  An optional custom post link.
 */
function get_back_link( $post_id = null, $title = null, $permalink = null ) {
	if ( null === $post_id ) {
		$post_id = get_the_ID();
	}

	$back_button_link = get_field( 'back_button_link' );

	if ( ! empty( $back_button_link ) ) {
		if ( ! empty( $back_button_link['title'] ) ) {
			$title = $back_button_link['title'];
		}

		if ( ! empty( $back_button_link['url'] ) ) {
			$permalink = $back_button_link['url'];
		}
	} else {
		$parent_id = wp_get_post_parent_id( $post_id );
	}

	if ( ! empty( $parent_id ) ) {
		if ( empty( $title ) ) {
			$title = get_the_title( $parent_id );
		}

		if ( empty( $permalink ) ) {
			$permalink = get_the_permalink( $parent_id );
		}
	}

	if ( is_tag() || is_category() || is_singular( 'post' ) ) {
		if ( empty( $title ) ) {
			$title = __( 'All Blog Posts', 'propel' );
		}

		$permalink = get_the_permalink( get_option( 'page_for_posts' ) );
	} elseif ( is_tax() || is_singular() ) {
		$this_post_type = get_post_type();

		if ( ! empty( $this_post_type ) ) {
			$post_type_archive = get_field( $this_post_type . '_archive', $this_post_type );

			if ( ! empty( $post_type_archive ) ) {
				$permalink = get_the_permalink( $post_type_archive );

				if ( empty( $title ) ) {
					$title = sprintf( __( 'All %s', 'propel' ), get_the_title( $post_type_archive ) );
				}
			}
		}
	}

	if ( is_block_library() ) {
		if ( empty( $title ) ) {
			$title = __( 'Back', 'propel' );
		}

		$permalink = home_url();
	}

	if ( ! empty( $title ) && ! empty( $permalink ) ) {
		return '<div class="c-btn--back__wrapper">' . array_to_link(
			array(
				'url'   => $permalink,
				'title' => $title,
			),
			'is-style-tertiary wp-block-button--small',
			array(
				'icon'          => 'icon-triangle-left',
				'icon_position' => 'left',
			)
		) . '</div>';
	}
}
