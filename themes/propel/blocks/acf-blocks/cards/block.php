<?php
/**
 * Cards
 *
 * Title:             Cards
 * Description:       The inner block wrapper for card blocks.
 * Category:          Card
 * Icon:              screenoptions
 * Keywords:          cards, card, links
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * InnerBlocks:       true
 * Styles:
 * Parent:            acf/card-standard, acf/card-stacked, acf/card-image-links, acf/card-text-links, acf/card-partners
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$cards_per_row = get_field( 'cards_per_row' );

if ( empty( $cards_per_row ) ) {
	$cards_per_row = '3';
}

$allowed_blocks = array( 'acf/card', 'acf/card-image', 'acf/card-partner', 'acf/card-text-link', 'acf/card-award' );

$template = array(
	array(
		'core/heading',
		array(
			'level'       => 3,
			'placeholder' => 'Add heading here.',
			'fontSize'    => 't3',
			'textAlign'   => 'center',
		),
	),
	array(
		'acf/card',
	),
);
?>

<div class="block-cards acf-inline-block block-cards--<?php echo esc_attr( $cards_per_row ); ?>" style="--cardsPerRow: <?php echo esc_attr( $cards_per_row ); ?>;">
	<div class="wp-block-button wp-block-button--load-more is-style-secondary">
		<button type="button" class="wp-block-button__link">Load More</button>
		<button type="button" class="wp-block-button__link wp-block-button__link--less">Show Less</button>
	</div>

	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-cards__grid" />
</div>

<?php
