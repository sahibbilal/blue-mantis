<?php
/**
 * Icon-Cards
 *
 * Title:             Icon-Cards
 * Description:       The inner block wrapper for Icon-Card blocks.
 * Category:          Icon
 * Icon:              marker
 * Keywords:          icon, card, content
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

$cards_per_row = get_field( 'cards_per_row' );

if ( empty( $cards_per_row ) ) {
	$cards_per_row = '3';
}

$allowed_blocks = array( 'acf/icon-card' );

?>

<div class="block-icon-cards acf-inline-block block-icon-cards--<?php echo esc_attr( $cards_per_row ); ?>" style="--cardsPerRow: <?php echo esc_attr( $cards_per_row ); ?>;">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" class="block-icon-cards__grid" />
</div>

<?php
