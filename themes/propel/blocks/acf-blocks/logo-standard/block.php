<?php
/**
 * Logo-Standard
 *
 * Title:             Logo-Standard
 * Description:       Block with logos.
 * Category:          Logo
 * Icon:              screenoptions
 * Keywords:          logo, logos, brands, partners
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

$allowed_blocks = e29_text_blocks( array( 'acf/logos' ) );

$template = array(
	array(
		'core/heading',
		array(
			'level'       => 2,
			'placeholder' => 'Add heading here.',
			'textAlign'   => 'center',
		),
	),
	array(
		'acf/logos',
	),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-logo-standard<?php echo wp_kses_post( $content_block->get_block_classes() ); ?>">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="container" />
</section>

<?php
