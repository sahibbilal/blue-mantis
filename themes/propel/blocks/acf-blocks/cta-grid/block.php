<?php
/**
 * CTA-Grid
 *
 * Title:             CTA-Grid
 * Description:       Call to action block contained within the grid.
 * Category:          CTA
 * Icon:              icon829-cta
 * Keywords:          cta, call to action, grid, button, container
 * Post Types:        all
 * Multiple:          true
 * Active:            false
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color
 * InnerBlocks:       true
 * Default BG Color:  neutral-98
 * Styles:            Wide, Narrow
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$background_color = get_field( 'background_color' );

if ( empty( $background_color ) ) {
	$background_color = 'neutral-98';
}

$allowed_blocks = e29_text_blocks();

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
		'core/paragraph',
		array(
			'placeholder' => 'Add text or additional blocks here.',
			'align'       => 'center',
		),
	),
	array(
		'core/buttons',
		array(
			'layout' => array(
				'justifyContent' => 'center',
			),
		),
	),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-cta-grid<?php echo esc_attr( $content_block->get_block_classes( array( 'background_color' => 'transparent ' ) ) ); ?>">
	<div class="container">
		<div class="row">
			<div class="col-12 block-cta-grid__col">
				<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-cta-grid__content bg-<?php echo esc_attr( $background_color ); ?>" />
			</div>
		</div>
	</div>
</section>

<?php
