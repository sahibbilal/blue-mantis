<?php
/**
 * ACF Hooks & Filters
 *
 * @package Propel
 * @since   2.0.0
 */

namespace Propel\AcfHooks;

/**
 * Tell ACF to use wp_block as a post type.
 *
 * @param array $post_types    Array of allowed post types.
 */
function acf_get_post_types( $post_types ) {
	$post_types[] = 'wp_block';

	return $post_types;
}
add_filter( 'acf/get_post_types', 'Propel\AcfHooks\acf_get_post_types', PHP_INT_MAX );

/**
 * Removes Custom Fields from WP Admin Menu
 *
 * @return void
 */
function remove_acf_menu() {
	if ( defined( 'DISALLOW_ACF_MENU' ) && DISALLOW_ACF_MENU === true ) :
		remove_menu_page( 'edit.php?post_type=acf-field-group' );
	endif;
}
add_action( 'admin_menu', 'Propel\AcfHooks\remove_acf_menu' );

/**
 * Disable tabs when editing field groups.
 */
add_filter( 'acf/field_group/disable_field_settings_tabs', '__return_true' );
