<?php
/**
 * Icon-Card
 *
 * Title:             Icon-Card
 * Description:       Icon card block for use within parent icon block.
 * Category:          Icon
 * Icon:              marker
 * Keywords:          icon, content, card
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields:
 * Parent:            acf/icon-cards
 * InnerBlocks:       true
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = array( 'core/heading', 'acf/icon' );

$template = array(
	array(
		'acf/icon',
	),
	array(
		'core/heading',
		array(
			'level'       => 3,
			'placeholder' => 'Add heading here.',
		),
	),
);

?>

<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" templateLock="all" class="block-icon-card" />

<?php
