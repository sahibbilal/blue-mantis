<?php
/**
 * Icon-Side-Grid
 *
 * Title:             Icon-Side-Grid
 * Description:       A block with flexible icon content blocks and a side heading.
 * Category:          Icon
 * Icon:              marker
 * Keywords:          icon, content, side, heading
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color
 * InnerBlocks:       true
 * Styles:
 * Default BG Color:
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = array( 'acf/content', 'acf/icon-contents' );

$template = array(
	array(
		'acf/content',
	),
	array(
		'acf/icon-contents',
	),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-icon-side-grid<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" templateLock="all" class="container block-icon-side-grid__container" />
</section>

<?php
