<?php
/**
 * Text-Row
 *
 * Title:             Text-Row
 * Description:       Block with rows with a heading and text.
 * Category:          Text
 * Icon:              text
 * Keywords:          info, list, heading, paragraph, row
 * Post Types:        all
 * Multiple:          true
 * Active:            false
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color
 * InnerBlocks:       true
 * Styles:
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = array( 'acf/text-row-item' );

$template = array(
	array( 'acf/text-row-item' ),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-text-row<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="container block-text-row__container" />
</section>

<?php
