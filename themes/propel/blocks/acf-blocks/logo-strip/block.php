<?php
/**
 * Logo-Strip
 *
 * Title:             Logo-Strip
 * Description:       Block with row of logos.
 * Category:          Logo
 * Icon:              ellipsis
 * Keywords:          logo, logos, brands, partners, strip
 * Post Types:        all
 * Multiple:          true
 * Active:            false
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color
 * InnerBlocks:       true
 * Mode:              preview
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = array( 'acf/logos' );

$template = array(
	array(
		'acf/logos',
	),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="block-logo-strip<?php echo wp_kses_post( $content_block->get_block_classes() ); ?>">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="container" />
</section>

<?php
