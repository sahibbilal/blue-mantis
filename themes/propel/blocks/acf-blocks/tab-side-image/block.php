<?php
/**
 * Tab-Side-Image
 *
 * Title:             Tab-Side-Image
 * Description:       A block with tabbed content and a side image.
 * Category:          Tab
 * Icon:              icon829-tab
 * Keywords:          tab, tabs, side, image
 * Post Types:        all
 * Multiple:          true
 * Active:            false
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color
 * InnerBlocks:       true
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = e29_text_blocks( 'acf/tab-side-image-tab' );

$template = array(
	array(
		'core/heading',
		array(
			'level'       => 2,
			'placeholder' => 'Add heading here.',
		),
	),
	array(
		'acf/tab-side-image-tab',
	),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-tab-side-image<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<div class="container">
		<div class="block-tab-side-image__row">
			<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-tab-side-image__content" />

			<div class="block-tab-side-image__spacer"><div class="block-tab-side-image__spacer-inner"></div></div>
		</div>
	</div>
</section>

<?php
