<?php
/**
 * Card-Partner
 *
 * Title:             Card-Partner
 * Description:       Card block for use within parent Cards block.
 * Category:          Card
 * Icon:              screenoptions
 * Keywords:          cards, card, flexible, links, partner
 * Post Types:        all
 * Multiple:          true
 * Active:            true
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

$image              = get_field( 'image' );
$partner_link       = get_field('card_partner_link');
$partner_link_class = "";
$cards_per_row = $content_block->get_parent_field( 'cards_per_row', 'acf/cards' );
$image_size    = 'card-image-link-4';

if ( empty( $cards_per_row ) ) {
	$cards_per_row = '3';
}

if ( ! empty( $partner_link ) ) {
	$partner_link_class = 'partner-has-link';
}

if ( '2' === $cards_per_row ) {
	$image_size = 'card-image-link-6';
} elseif ( '4' === $cards_per_row ) {
	$image_size = 'card-image-link-3';
}

$allowed_blocks = array( 'core/button' );

$template = array(
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Add Partner name here.',
			'fontSize'    => 'title-1',
			// 'align'       => 'left',
		),
	),
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Add Partner description here.',
			'fontSize'    => 'subtitle-2',
			// 'align'       => 'center',
		),
	),
);

?>

<div class="block-card-partner<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<?php if ( ! empty( $partner_link ) ) : ?>
		<a href="<?php echo esc_url( $partner_link ); ?>" class="block-card-partner__link">
	<?php endif; ?>
	<?php if ( ! empty( $image ) ) : ?>
		<figure class="block-card-partner__image-wrapper image-wrapper">
			<?php echo wp_kses_post( wp_get_attachment_image( $image, $image_size ) ); ?>
		</figure>
		<?php endif; ?>
		
		<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-card-partner__content <?php echo esc_attr( $partner_link_class ); ?>" />
		
		<?php if ( ! empty( $partner_link ) ) : ?>
		</a>
		<?php endif; ?>
</div>

<?php
