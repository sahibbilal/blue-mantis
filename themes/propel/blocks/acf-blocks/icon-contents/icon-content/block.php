<?php
/**
 * Icon-Content
 *
 * Title:             Icon-Content
 * Description:       Icon content block for use within parent icon block.
 * Category:          Icon
 * Icon:              marker
 * Keywords:          icon, content
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields:
 * Parent:            acf/icon-contents
 * InnerBlocks:       true
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = array( 'core/heading', 'core/paragraph', 'core/button', 'acf/icon' );

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
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Add text or additional blocks here.',
		),
	),
	array(
		'core/button',
		array(
			'className'  => 'is-style-tertiary',
			'buttonIcon' => 'icon-triangle-right',
		),
	),
);

?>

<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-icon-content" />

<?php
