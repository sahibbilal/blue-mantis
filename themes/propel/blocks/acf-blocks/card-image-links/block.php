<?php
/**
 * Card-Image-Links
 *
 * Title:             Card-Image-Links
 * Description:       A row of cards with images.
 * Category:          Card
 * Icon:              screenoptions
 * Keywords:          cards, card, links, image
 * Post Types:        all
 * Multiple:          true
 * Active:            false
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color
 * InnerBlocks:       true
 * Styles:
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = e29_text_blocks( array( 'acf/cards' ) );

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
		'acf/cards',
		array(),
		array(
			array(
				'acf/card-image',
			),
		),
	),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-card-image-links<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="container block-card-image-links__container" />
</section>

<?php
