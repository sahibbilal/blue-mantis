<?php
/**
 * Primary Nav Link
 *
 * Title:             Primary Nav Link
 * Description:       One menu link in the primary navigation menu.
 * Category:          Navigation
 * Icon:              menu
 * Keywords:          navigation, menu, primary, header, nav, link
 * Post Types:        theme_block
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields:
 * InnerBlocks:       true
 * Parent:            acf/primary-nav-menu
 * Styles:            Align Left, Align Right
 * Context:
 *
 * @package Propel
 * @since   2.0.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = array( 'core/button', 'core/paragraph', 'acf/icon' );

$template = array(
	array(
		'acf/icon',
	),
	array(
		'core/button',
		array(
			'className' => 'is-style-text',
		),
	),
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Add text or additional blocks here.',
		),
	),
);

?>

<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-primary-nav-link<?php echo esc_attr( $content_block->get_block_classes() ); ?>" />

<?php
