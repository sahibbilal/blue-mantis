<?php
/**
 * CTA-Standard
 *
 * Title:             CTA-Standard
 * Description:       Call to action block.
 * Category:          CTA
 * Icon:              icon829-cta
 * Keywords:          cta, call to action, standard, button, banner
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_image
 * InnerBlocks:       true
 * Default BG Color:  neutral-98
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = e29_text_blocks();

$template      = array(
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
$bg            = get_field( 'background_image' );
$block_classes = 'acf-block block-cta-standard' . esc_attr( $content_block->get_block_classes() );

if ( $bg ) {
	$block_classes  = preg_replace( '/bg-[^ ]*/m', '', $block_classes );
	$block_classes .= ' bg-dark';
	$block_classes  = str_replace( '  ', ' ', $block_classes );
}
?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="<?php echo esc_attr( $block_classes ); ?>">
	<div class="container">
		<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-cta-standard__content" />
	</div>

	<?php if ( $bg ) : ?>
		<div class="block-cta-standard__background-image">
			<?php echo wp_kses_post( wp_get_attachment_image( $bg, 'full-width-block' ) ); ?>
		</div>
	<?php endif; ?>
</section>

<?php
