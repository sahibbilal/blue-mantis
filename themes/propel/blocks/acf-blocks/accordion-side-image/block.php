<?php
/**
 * Accordion-Side-Image
 *
 * Title:             Accordion-Side-Image
 * Description:       Accordion with side images.
 * Category:          Accordion
 * Icon:              awards
 * Keywords:          accordion, side, image
 * Post Types:        all
 * Multiple:          true
 * Active:            false
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color
 * InnerBlocks:       true
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = e29_text_blocks( 'acf/accordion' );

$template = array(
	array(
		'core/heading',
		array(
			'level'       => 2,
			'placeholder' => 'Add heading here.',
		),
	),
	array(
		'acf/accordion',
	),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-accordion-side-image<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<div class="container">
		<div class="block-accordion-side-image__row">
			<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-accordion-side-image__content" />

			<div class="block-accordion-side-image__spacer"><div class="block-accordion-side-image__spacer-inner"></div></div>
		</div>
	</div>
</section>

<?php
