<?php
/**
 * Primary Nav Item
 *
 * Title:             Primary Nav Item
 * Description:       One menu item in the primary navigation menu.
 * Category:          Navigation
 * Icon:              menu
 * Keywords:          navigation, menu, primary, header, nav, item
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

$allowed_blocks = array( 'core/button', 'acf/primary-nav-mega-menu' );

$template = array(
	array(
		'core/button',
		array(
			'className' => 'is-style-text',
		),
	),
	array( 'acf/primary-nav-mega-menu' ),
);

?>

<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-primary-nav-item<?php echo esc_attr( $content_block->get_block_classes() ); ?>" />

<?php
