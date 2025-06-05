<?php
/**
 * Icon-Image
 *
 * Title:             Icon-Image
 * Description:       A block with flexible icon content blocks and a side image.
 * Category:          Icon
 * Icon:              marker
 * Keywords:          icon, content, image, side
 * Post Types:        all
 * Multiple:          true
 * Active:            false
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color, image
 * InnerBlocks:       true
 * Styles:            7/12 Image Column, 5/12 Image Column
 * Default BG Color:
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$image      = get_field( 'image' );
$image_size = 'col-7';

if ( ! empty( $block['className'] ) && false !== strpos( $block['className'], '5-12-image-column' ) ) {
	$image_size = 'col-5';
}

$allowed_blocks = e29_text_blocks( array( 'acf/icon-contents' ) );

$template = array(
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
		'core/paragraph',
		array(
			'placeholder' => 'Add text or additional blocks here.',
			'align'       => 'center',
		),
	),
	array(
		'acf/icon-contents',
		array(
			'data' => array(
				'field_6398a0e3cbb8f' => '1',
			),
		),
		array(
			array(
				'acf/icon-content',
			),
		),
	),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-icon-image<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<div class="container block-icon-image__container">
		<div class="block-icon-image__image-col">
			<?php if ( ! empty( $image ) ) : ?>
				<figure class="block-icon-image__image-wrapper image-wrapper">
					<?php echo wp_kses_post( wp_get_attachment_image( $image, $image_size ) ); ?>
				</figure>
			<?php endif; ?>
		</div>

		<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-icon-image__content-col" />
	</div>
</section>

<?php
