<?php
/**
 * Accordion-Centered
 *
 * Title:             Accordion-Centered
 * Description:       A section with text content and an accordion.
 * Category:          Accordion
 * Icon:              awards
 * Keywords:          show, hide, content, accordion, section, centered
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color
 * InnerBlocks:       true
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = e29_text_blocks( array( 'acf/accordion' ) );

$template = array(
	array(
		'core/heading',
		array(
			'level'       => 2,
			'placeholder' => 'Add heading here.',
			'fontSize'    => 't2',
			'textAlign'   => 'center',
		),
	),
	array(
		'acf/accordion',
	),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-accordion-centered<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-accordion-centered__content-wrapper content-wrapper" />
</section>

<?php
