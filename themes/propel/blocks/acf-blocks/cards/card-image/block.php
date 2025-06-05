<?php
/**
 * Card-Image
 *
 * Title:             Card-Image
 * Description:       Card block for use within parent Cards block.
 * Category:          Card
 * Icon:              screenoptions
 * Keywords:          cards, card, flexible, links, image
 * Post Types:        all
 * Multiple:          true
 * Active:            false
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: image
 * Parent:            acf/cards
 * InnerBlocks:       true
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$image         = get_field( 'image' );
$cards_per_row = $content_block->get_parent_field( 'cards_per_row', 'acf/cards' );
$image_size    = 'card-image-link-4';

if ( empty( $cards_per_row ) ) {
	$cards_per_row = '3';
}

if ( '2' === $cards_per_row ) {
	$image_size = 'card-image-link-6';
} elseif ( '4' === $cards_per_row ) {
	$image_size = 'card-image-link-3';
}

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

<div class="block-card-image">
	<?php if ( ! empty( $image ) ) : ?>
		<figure class="block-card-image__image-wrapper image-wrapper">
			<?php echo wp_kses_post( wp_get_attachment_image( $image, $image_size ) ); ?>
		</figure>
	<?php endif; ?>

	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" templateLock="all" class="block-card-image__content" />
</div>

<?php
