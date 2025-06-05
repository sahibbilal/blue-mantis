<?php
/**
 * Footer
 *
 * Title:             Footer
 * Description:       Block for use globally on the site footer.
 * Category:          Base
 * Icon:              info-outline
 * Keywords:          footer, global, address, logo, quick links, newsletter, copyright, social
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:          marketo
 * JS Deps:           marketo-script, marketo
 * Global ACF Fields:
 * InnerBlocks:       true
 * Styles:
 * Context:
 *
 * @package Propel
 * @since   2.0.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = array( 'acf/footer-top', 'acf/footer-bottom' );

$template = array(
	array( 'acf/footer-top' ),
	array( 'acf/footer-bottom' ),
);

?>

<section <?php echo wp_kses_post( $content_block->get_block_id_attr() ); ?>class="block-footer<?php echo esc_attr( $content_block->get_block_classes( array( 'background_color' => 'dark' ) ) ); ?>">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="container block-footer__container" />
</section>

<?php
