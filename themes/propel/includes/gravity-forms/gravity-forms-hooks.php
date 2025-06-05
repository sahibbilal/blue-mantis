<?php
/**
 * Gravity Forms filter/action hooks
 *
 * @package Propel
 * @since   2.0.0
 */

namespace Propel\GravityFormsHooks;

/**
 * Filters the next, previous and submit buttons.
 * Replaces the forms <input> buttons with <button> while maintaining attributes from original <input>.
 *
 * @param string $button Contains the <input> tag to be filtered.
 * @param object $form Contains all the properties of the current form.
 *
 * @return string The filtered button.
 */
function input_to_button( $button, $form ) {
	$dom = new \DOMDocument();
	$dom->loadHTML( '<?xml encoding="utf-8" ?>' . $button );
	$input      = $dom->getElementsByTagName( 'input' )->item( 0 );
	$new_button = $dom->createElement( 'button' );
	$new_button->appendChild( $dom->createTextNode( $input->getAttribute( 'value' ) ) );
	$input->removeAttribute( 'value' );

	foreach ( $input->attributes as $attribute ) {
		$new_button->setAttribute( $attribute->name, $attribute->value );
	}

	$new_button->setAttribute( 'class', 'gform_button c-btn c-btn--primary' );

	$input->parentNode->replaceChild( $new_button, $input ); // phpcs:ignore

	return $dom->saveHtml( $new_button );
}
add_filter( 'gform_next_button', 'Propel\GravityFormsHooks\input_to_button', 10, 2 );
add_filter( 'gform_previous_button', 'Propel\GravityFormsHooks\input_to_button', 10, 2 );
add_filter( 'gform_submit_button', 'Propel\GravityFormsHooks\input_to_button', 10, 2 );


/**
 * Adds custom classes to gravity forms fields.
 *
 * @param string   $classes Contains current field classes.
 * @param GF_Field $field Contains the field object.
 * @param object   $form Contains all the properties of the current form.
 */
function add_field_classes( $classes, $field, $form ) {
	$classes .= ' gfield_type_' . $field->type;

	return $classes;
}
add_filter( 'gform_field_css_class', 'Propel\GravityFormsHooks\add_field_classes', 10, 3 );

/**
 * Filters the field content.
 *
 * @since 2.1.2.14 Added form and field ID modifiers.
 *
 * @param string $content    The field content.
 * @param array  $field      The Field Object.
 * @param string $value      The field value.
 * @param int    $entry_id   The entry ID.
 * @param int    $form_id    The form ID.
 */
function filter_field_content( $content, $field, $value, $entry_id, $form_id ) {
	if ( 'fileupload' === $field->type ) {
		$content = str_replace( '</label>', '<div class="c-btn c-btn--secondary c-btn--small">' . __( 'Choose File', 'propel' ) . '</div></label>', $content );
	}

	return $content;
}
add_filter( 'gform_field_content', 'Propel\GravityFormsHooks\filter_field_content', 10, 5 );

/**
 * Don't load the default Gravity Forms CSS. Using our own.
 *
 * @param mixed  $value  Value of the option. If stored serialized, it will be
 *                       unserialized prior to being returned.
 * @param string $option Option name.
 */
function disable_css( $value, $option ) {
	return '1';
}
add_filter( 'option_rg_gforms_disable_css', 'Propel\GravityFormsHooks\disable_css', 10, 2 );
add_filter( 'default_option_rg_gforms_disable_css', 'Propel\GravityFormsHooks\disable_css', 10, 2 );

/**
 * Always use the HTML5 output for Gravity Forms.
 *
 * @param mixed  $value  Value of the option. If stored serialized, it will be
 *                       unserialized prior to being returned.
 * @param string $option Option name.
 */
function enable_html5( $value, $option ) {
	return '1';
}
add_filter( 'option_rg_gforms_enable_html5', 'Propel\GravityFormsHooks\enable_html5', 10, 2 );
add_filter( 'default_rg_gforms_enable_html5', 'Propel\GravityFormsHooks\enable_html5', 10, 2 );
