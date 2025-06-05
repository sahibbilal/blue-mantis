<?php
/**
 * Accordion-Side-Heading
 *
 * Title:             Accordion-Side-Heading
 * Description:       A section with text content and an accordion.
 * Category:          Accordion
 * Icon:              awards
 * Keywords:          show, hide, content, accordion, section
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

$allowed_blocks = array( 'acf/content', 'acf/accordion' );

$template = array(
	array(
		'acf/content',
	),
	array(
		'acf/accordion',
	),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-accordion-side-heading<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" templateLock="all" class="container block-accordion-side-heading__container" />
</section>

<?php
