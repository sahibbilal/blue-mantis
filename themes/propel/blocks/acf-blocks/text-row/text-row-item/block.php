<?php
/**
 * Text-Row Item
 *
 * Title:             Text-Row Item
 * Description:       Inner block for use with text-row block.
 * Category:          Text
 * Icon:              text
 * Keywords:          info, list, heading, paragraph, item
 * Post Types:        all
 * Multiple:          true
 * Active:            false
 * CSS Deps:
 * JS Deps:
 * InnerBlocks:       true
 * Parent:            acf/text-row
 * Styles:
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = array();

$allowed_blocks = array( 'acf/content' );

$template = array(
	array(
		'acf/content',
		array(),
		array(
			array(
				'core/heading',
				array(
					'level'       => 2,
					'placeholder' => 'Add heading here.',
					'fontSize'    => 't3',
				),
			),
		),
	),
	array(
		'acf/content',
	),
);

?>

<div class="block-text-row-item">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-text-row-item__content" templateLock="all" />
</div>

<?php
