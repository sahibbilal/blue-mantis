<?php
/**
 * Icon-Heading
 *
 * Title:             Icon-Heading
 * Description:       An icon next to a heading.
 * Category:          Base
 * Icon:              marker
 * Keywords:          icon, heading
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields:
 * InnerBlocks:       true
 * Parent:
 *
 * @package Propel
 * @since   2.0.0
 */

$template = array(
	array(
		'acf/icon',
	),
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Add text or additional blocks here.',
			'fontSize'    => 'overline',
		),
	),
);

$allowed_blocks = array( 'acf/icon', 'core/heading' );

$content_block = new Content_Block_Gutenberg( $block, $context );

?>
<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" templateLock="all" class="block-icon-heading" />
<?php
