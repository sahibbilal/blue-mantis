<?php
/**
 * Content Section
 *
 * Title:             Content Section
 * Description:       A stylelized block with inner blocks.
 * Category:          Base
 * Icon:              align-wide
 * Keywords:          content, section, innerblocks
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color
 * InnerBlocks:       true
 * Mode:              preview
 *
 * @package Propel
 * @since   2.1.0
 */

$template = array(
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Add text or additional blocks here.',
		),
	),
);

$allowed_blocks = e29_text_blocks( array( 'acf/icon-side-grid', 'core/table' ) );

$content_block = new Content_Block_Gutenberg( $block, $context );

?>
<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-content-section<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" templateLock="false" class="block-content-section__content content-wrapper" />
</section>
<?php
