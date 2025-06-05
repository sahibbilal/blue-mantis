<?php
/**
 * Card-Awards-Columns
 *
 * Title:             Card-Awards-Columns
 * Description:       Block with centered heading and adjustable columns of Awards Card blocks.
 * Category:          Card
 * Icon:              screenoptions
 * Keywords:          cards, card, links, awards
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color
 * InnerBlocks:       true
 * Styles:
 * Default BG Color:  neutral-98
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = e29_text_blocks( array( 'acf/cards' ) );

$template = array(
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Add pre-heading here.',
			'fontSize'    => 'overline',
			'align'       => 'center',
		),
	),
	array(
		'core/heading',
		array(
			'level'       => 2,
			'placeholder' => 'Add heading here.',
			'fontSize'    => 't2',
			'textAlign'   => 'center',
		),
	),
	array(
		'acf/cards',
		array(),
		array(
			array(
				'acf/card-award',
			),
		),
	),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-card-awards-columns<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="container block-card-awards-columns__container" />
</section>

<?php
