<?php
/**
 * Card-Text-Link
 *
 * Title:             Card-Text-Link
 * Description:       Card block for use within parent Cards block.
 * Category:          Card
 * Icon:              screenoptions
 * Keywords:          cards, card, flexible, links, text
 * Post Types:        all
 * Multiple:          true
 * Active:            false
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields:
 * Parent:            acf/cards
 * InnerBlocks:       true
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = array( 'core/button' );

$template = array(
	array(
		'core/button',
		array(
			'className'  => 'is-style-tertiary',
			'buttonIcon' => 'icon-triangle-right',
		),
	),
);

?>

<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" templateLock="all" class="block-card-text-link" />

<?php
