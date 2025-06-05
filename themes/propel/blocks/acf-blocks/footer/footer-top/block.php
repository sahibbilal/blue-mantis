<?php
/**
 * Footer Top
 *
 * Title:             Footer Top
 * Description:       Block for use globally on the site footer.
 * Category:          Base
 * Icon:              info-outline
 * Keywords:          footer, global, address, logo, quick links, newsletter, copyright, social, top
 * Post Types:        all
 * Multiple:          false
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields:
 * InnerBlocks:       true
 * Parent:            acf/footer
 * Styles:
 * Context:
 *
 * @package Propel
 * @since   2.0.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = array( 'acf/footer-column' );

$template = array(
	array( 'acf/footer-column' ),
	array( 'acf/footer-column' ),
	array( 'acf/footer-column' ),
	array( 'acf/footer-column' ),
);

?>

<div class="block-footer-top">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-footer-top__content" templateLock="false" />
</div>
