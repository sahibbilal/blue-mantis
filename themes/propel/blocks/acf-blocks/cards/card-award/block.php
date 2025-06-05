<?php
/**
 * Card-Award
 *
 * Title:             Card-Award
 * Description:       Card block for use within parent Cards block.
 * Category:          Card
 * Icon:              screenoptions
 * Keywords:          cards, card, flexible, links, award
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:          sliders
 * JS Deps:           sliders
 * Global ACF Fields: image
 * Parent:            acf/card-awards, acf/card-awards-columns, core/column
 * InnerBlocks:       true
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$image      = get_field( 'image' );
$image_size = 'news-card';


$allowed_blocks = array( 'core/paragraph' );

$template = array(
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Add description here.',
			'fontSize'    => 'body-1',
		),
	),
);

?>

<div class="block-card-award bg-dark">
	<?php if ( ! empty( $image ) ) : ?>
		<figure class="block-card-award__image-wrapper image-wrapper">
			<?php echo wp_kses_post( wp_get_attachment_image( $image, $image_size ) ); ?>
		</figure>
	<?php endif; ?>

	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" templateLock="false" class="block-card-award__content" />
</div>

<?php
