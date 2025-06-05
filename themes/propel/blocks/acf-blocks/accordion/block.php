<?php
/**
 * Accordion
 *
 * Title:             Accordion
 * Description:       Inline accordion block.
 * Category:          Accordion
 * Icon:              awards
 * Keywords:          show, hide, content, accordion
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color
 * InnerBlocks:       true
 * Styles:            Multiple Open, Single Open
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = array( 'acf/accordion-item' );

$template = array(
	array( 'acf/accordion-item' ),
);

?>

<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" templateLock="false" class="acf-block bg-transparent block-accordion<?php echo esc_attr( $content_block->get_block_classes() ); ?>" />

<?php
