<?php
/**
 * Media-Standard
 *
 * Title:             Media-Standard
 * Description:       Block with images or video.
 * Category:          Media
 * Icon:              format-image
 * Keywords:          image, images, composition, collage, media
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color
 * InnerBlocks:       true
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = array( 'core/image', 'core/embed' );

?>

<section id="<?php echo esc_attr( $content_block->get_block_id() ); ?>" class="acf-block block-media-standard<?php echo wp_kses_post( $content_block->get_block_classes() ); ?>">
	<div class="container">
		<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" class="row block-media-standard__row" />
	</div>
</section>

<?php
