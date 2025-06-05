<?php
/**
 * Tab-Standard-Tab
 *
 * Title:             Tab-Standard-Tab
 * Description:       Tab-Standard tab inner block.
 * Category:          Tab
 * Icon:              icon829-tab
 * Keywords:          tab, tabs, standard
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields:
 * InnerBlocks:       true
 * Parent:            acf/tab-standard
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = array( 'core/button', 'acf/content-section' );

$template = array(
	array(
		'core/button',
		array(
			'className' => 'is-style-tab',
		),
	),
	array(
		'acf/content-section',
	),
);

?>

<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" templateLock="all" class="block-tab-standard-tab<?php echo esc_attr( $content_block->get_block_classes() ); ?>" />

<?php
