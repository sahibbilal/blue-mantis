<?php
/**
 * Determine whether currently editing a theme block.
 *
 * @package Propel
 * @since   2.1.1
 */

/**
 * Determine whether currently editing a theme block.
 *
 * @return boolean  Whether or not the current screen is a theme block.
 */
function is_theme_block() {
	// phpcs:disable WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
	if (
		is_admin() &&
		(
			! empty( $_GET['action'] ) &&
			! empty( $_GET['post'] ) &&
			'edit' === sanitize_text_field(
				wp_unslash( $_GET['action'] )
			)
		) ||
		(
			wp_doing_ajax() &&
			! empty( $_POST['post_id'] )
		)
	) {
		if ( wp_doing_ajax() ) {
			$post_id = intval( wp_unslash( $_POST['post_id'] ) );
		} else {
			$post_id = intval( wp_unslash( $_GET['post'] ) );
		}

		if ( ! empty( $post_id ) && 'theme_block' === get_post_type( $post_id ) ) {
			return true;
		}
	}
	// phpcs:enable WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
}
