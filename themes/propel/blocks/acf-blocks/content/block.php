<?php
/**
 * Content
 *
 * Title:             Content
 * Description:       An inline content wrapper for use as an innerblock.
 * Category:          Base
 * Icon:              align-wide
 * Keywords:          content, section, innerblocks
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields:
 * InnerBlocks:       true
 * Parent:
 * Context:
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$template = array(
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Add text or additional blocks here.',
		),
	),
);

$block_classes = $content_block->get_block_classes();

if ( ' bg-transparent' === $block_classes ) {
	$block_classes = '';
}

$allowed_blocks = e29_text_blocks();

?>
<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" templateLock="false" class="block-content<?php echo esc_attr( $block_classes ); ?>" />
<?php
