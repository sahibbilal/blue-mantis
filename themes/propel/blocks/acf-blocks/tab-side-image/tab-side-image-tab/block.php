<?php
/**
 * Tab-Side-Image-Tab
 *
 * Title:             Tab-Side-Image-Tab
 * Description:       Tab-Side-Image tab inner block.
 * Category:          Tab
 * Icon:              icon829-tab
 * Keywords:          tab, tabs, side, image
 * Post Types:        all
 * Multiple:          true
 * Active:            false
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: image
 * InnerBlocks:       true
 * Parent:            acf/tab-side-image
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
			'className' => 'is-style-tab',
		),
	),
	array(
		'acf/content',
	),
);

?>

<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" templateLock="all" class="block-tab-side-image-tab<?php echo esc_attr( $content_block->get_block_classes() ); ?>" />

<?php if ( ! empty( $image ) ) : ?>
	<figure class="block-tab-side-image-tab__figure">
		<div class="block-tab-side-image-tab__image-wrapper image-wrapper">
			<?php echo wp_kses_post( wp_get_attachment_image( $image, 'tab-side-image' ) ); ?>
		</div>
	</figure>
<?php endif; ?>

<?php
