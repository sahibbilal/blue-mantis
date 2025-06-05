<?php
/**
 * Cards-Awards
 *
 * Title:             Cards-Awards
 * Description:       A block that displays Awards Card blocks.
 * Category:          Card
 * Icon:              screenoptions
 * Keywords:          cards, card, links, awards
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * InnerBlocks:       true
 * Styles:
 * Parent:
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = e29_text_blocks( array( 'acf/awards' ) );

$template = array(
	array(
		'core/heading',
		array(
			'level'       => 2,
			'placeholder' => 'Add heading here.',
			'fontSize'    => 't2',
		),
	),
	array(
		'core/button',
		array(
			'className'  => 'is-style-tertiary',
			'buttonIcon' => 'icon-triangle-right',
		),
	),
	array(
		'acf/awards',
	),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-card-awards<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="container block-card-awards__container" />
</section>

<?php
