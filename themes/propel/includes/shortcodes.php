<?php
/**
 * Theme shortcodes
 *
 * Please follow the same format for registering new shortcodes.
 *
 * @package Propel
 * @since   2.0.0
 */

namespace Propel\Shortcodes;

/**
 * Current year shortcode.
 *
 * @param array $atts The shortcodes attributes.
 */
function current_year( $atts ) {
	return gmdate( 'Y' );
}
add_shortcode( 'current_year', 'Propel\Shortcodes\current_year' );

/**
 * Displays a Marketo Form.
 *
 * @param array $atts The shortcodes attributes.
 */
function marketo_form( $atts ) {
	$atts = shortcode_atts(
		array(
			'id'                => null,
			'thank_you_url'     => '',
			'thank_you_message' => '',
		),
		$atts,
		'marketo_form'
	);

	if ( ! empty( $atts['thank_you_url'] ) ) {
		$additional_atts = ' data-thank-you-url="' . $atts['thank_you_url'] . '"';
	} elseif ( ! empty( $atts['thank_you_message'] ) ) {
		$additional_atts = ' data-thank-you-message="' . $atts['thank_you_message'] . '"';
	} else {
		$additional_atts = '';
	}

	if ( ! empty( $atts['id'] ) ) {
		$content = '<form id="mktoForm_' . $atts['id'] . '" class="marketo-form" data-id="' . $atts['id'] . '"' . $additional_atts . '></form>';
	} else {
		$content = __( 'Marketo Form ID not set.', 'propel' );
	}

	return $content;
}
add_shortcode( 'marketo_form', 'Propel\Shortcodes\marketo_form' );
