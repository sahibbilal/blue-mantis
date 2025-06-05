<?php
/**
 * Accordion Item
 *
 * Title:             Accordion Item
 * Description:       Accordion item inner block.
 * Category:          Accordion
 * Icon:              icon829-image-accordion
 * Keywords:          show, hide, content, accordion
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: image
 * InnerBlocks:       true
 * Parent:            acf/accordion
 * Styles:            Closed, Open
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$image = get_field( 'image' );

$allowed_blocks = array( 'core/button', 'acf/content' );

$template = array(
	array(
		'core/button',
		array(
			'className' => 'is-style-accordion',
		),
	),
	array(
		'acf/content',
	),
);

?>

<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" templateLock="all" class="block-accordion-item<?php echo esc_attr( $content_block->get_block_classes() ); ?>" />

<?php if ( ! empty( $image ) ) : ?>
	<figure class="block-accordion-item__figure">
		<div class="block-accordion-item__image-wrapper image-wrapper">
			<?php echo wp_kses_post( wp_get_attachment_image( $image, 'col-6-square' ) ); ?>
		</div>
	</figure>
<?php endif; ?>

<?php
