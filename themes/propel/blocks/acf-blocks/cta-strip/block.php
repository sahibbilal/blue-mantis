<?php
/**
 * CTA-Strip
 *
 * Title:             CTA-Strip
 * Description:       Simple call to action block.
 * Category:          CTA
 * Icon:              icon829-cta
 * Keywords:          cta, call to action, strip, button
 * Post Types:        all
 * Multiple:          true
 * Active:            false
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color
 * InnerBlocks:       true
 * Default BG Color:  neutral-98
 * Styles:            In Grid, Full Width
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$background_color = get_field( 'background_color' );

if ( empty( $background_color ) ) {
	$background_color = 'neutral-98';
}

$allowed_blocks = array( 'acf/content', 'core/button' );

$template = array(
	array(
		'acf/content',
		array(),
		array(
			array(
				'core/heading',
				array(
					'level'       => 2,
					'placeholder' => 'Add heading here.',
				),
			),
		),
	),
	array(
		'core/button',
	),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-cta-strip<?php echo esc_attr( $content_block->get_block_classes( array( 'background_color' => 'transparent' ) ) ); ?>">
	<div class="container block-cta-strip__container">
		<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-cta-strip__content bg-<?php echo esc_attr( $background_color ); ?>" />
	</div>
</section>

<?php
