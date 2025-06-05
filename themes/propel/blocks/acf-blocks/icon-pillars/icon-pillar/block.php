<?php
/**
 * Icon-Pillar
 *
 * Title:             Icon-Pillar
 * Description:       Icon content block for use within parent icon block.
 * Category:          Icon
 * Icon:              marker
 * Keywords:          icon, content, pillar
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields:
 * Parent:            acf/icon-pillars-contents
 * InnerBlocks:       true
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = array( 'core/button', 'core/paragraph', 'acf/icon' );

$template = array(
	array(
		'acf/icon',
	),
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Add text here.',
		),
	),
	array(
		'core/button',
		array(
			'className' => '',
		),
	),
);

?>
<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-icon-pillar" />

<?php
