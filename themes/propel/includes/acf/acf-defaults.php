<?php
/**
 * ACF default field options.
 *
 * @package Propel
 * @since   2.2.0
 */

namespace Propel\AcfDefaults;

/**
 * Load post types field options.
 *
 * @param array $field       ACF field array.
 */
function post_types( $field ) {
	$field['choices'] = array(
		'post'     => __( 'Posts', 'propel' ),
		'news'     => __( 'News', 'propel' ),
		'resource' => __( 'Resources', 'propel' ),
		'event'    => __( 'Events', 'propel' ),
	);

	return $field;
}
add_filter( 'acf/load_field/name=post_types', 'Propel\AcfDefaults\post_types' );
add_filter( 'acf/load_field/name=archive_link_post_type', 'Propel\AcfDefaults\post_types' );

/**
 * Load terms field options.
 *
 * @param array $field       ACF field array.
 */
function terms( $field ) {
	$field['choices'] = array();

	if ( editing_field_group() ) {
		return $field;
	}

	$taxonomies = get_taxonomies( array( 'public' => true ), 'objects' );

	if ( ! is_wp_error( $taxonomies ) && ! empty( $taxonomies ) ) {
		foreach ( $taxonomies as $taxonomy ) {
			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy->name,
					'hide_empty' => false,
				),
			);

			if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
				$field['choices'][ $taxonomy->name . '_label' ] = '<span>' . $taxonomy->label . '</span>';

				foreach ( $terms as $term ) {
					$field['choices'][ $taxonomy->name . '&&' . $term->term_id ] = $term->name;
				}
			}
		}
	}

	return $field;
}
add_filter( 'acf/load_field/name=terms', 'Propel\AcfDefaults\terms' );

/**
 * Alignment field options.
 *
 * @param array $field       ACF field array.
 */
function alignment( $field ) {
	$field['choices'] = array(
		'start'  => 'Left',
		'center' => 'Center',
		'end'    => 'Right',
	);

	$field['default'] = 'start';

	return $field;
}
add_filter( 'acf/load_field/name=alignment', 'Propel\AcfDefaults\alignment' );

/**
 * Load taxonomies field options.
 *
 * @param array $field       ACF field array.
 */
function taxonomies( $field ) {
	$field['choices'] = array();

	if ( editing_field_group() ) {
		return $field;
	}

	$taxonomies = get_taxonomies( array( 'public' => true ), 'objects' );

	if ( ! is_wp_error( $taxonomies ) && ! empty( $taxonomies ) ) {
		foreach ( $taxonomies as $taxonomy ) {
			$field['choices'][ $taxonomy->name ] = $taxonomy->label;
		}
	}

	return $field;
}
add_filter( 'acf/load_field/name=taxonomies', 'Propel\AcfDefaults\taxonomies' );

/**
 * Returns true if currently editing a field group.
 */
function editing_field_group() {
	if ( function_exists( 'get_current_screen' ) ) {
		$current_screen = get_current_screen();

		if ( ! empty( $current_screen ) && 'acf-field-group' === $current_screen->id ) {
			return true;
		}
	}
}

/**
 * Load gravity forms.
 *
 * @param array $field       ACF field array.
 */
function gravity_form( $field ) {
	$field['choices'] = array();

	if ( ! class_exists( '\GFAPI' ) ) {
		return $field;
	}

	$forms = \GFAPI::get_forms();

	foreach ( $forms as $form ) {
		if ( ! empty( $form['id'] ) && ! empty( $form['title'] ) ) {
			$field['choices'][ $form['id'] ] = $form['title'];
		}
	}

	return $field;
}
add_filter( 'acf/load_field/name=gravity_form', 'Propel\AcfDefaults\gravity_form' );
