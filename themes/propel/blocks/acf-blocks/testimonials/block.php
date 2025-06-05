<?php
/**
 * Testimonials
 *
 * Title:             Testimonials
 * Description:       The inner block wrapper for testimonial blocks.
 * Category:          Testimonial
 * Icon:              format-quote
 * Keywords:          testimonial, slider, quote
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:          sliders
 * JS Deps:           sliders
 * InnerBlocks:       true
 * Styles:
 * Parent:            acf/testimonial-standard, acf/testimonial-image, acf/testimonial-cards, acf/testimonial-box
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = array( 'acf/testimonial' );

$template = array(
	array(
		'acf/testimonial',
	),
);

?>

<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-testimonials component-slider" />

<?php
