<?php
/**
 * CTA-Donate
 *
 * Title:             CTA-Donate
 * Description:       Call to action block with area for donation widget or form.
 * Category:          CTA
 * Icon:              forms
 * Keywords:          cta, call to action, donate, form, contact
 * Post Types:        all
 * Multiple:          true
 * Active:            false
 * CSS Deps:          marketo
 * JS Deps:           marketo-script, marketo
 * Global ACF Fields: scroll_id, background_color
 * InnerBlocks:       true
 * Styles:
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$form_embed_code = get_field( 'form_embed_code' );
$gravity_form    = get_field( 'gravity_form' );

$allowed_blocks = e29_text_blocks();

$template = array(
	array(
		'core/heading',
		array(
			'level'       => 2,
			'placeholder' => 'Add heading here.',
		),
	),
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Add text or additional blocks here.',
		),
	),
);

?>
<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-cta-donate<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<div class="container block-cta-donate__container">
		<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-cta-donate__content" />

		<div class="block-cta-donate__form-wrapper bg-dark">
			<?php if ( ! empty( $form_embed_code ) ) : ?>
				<?php echo $form_embed_code; //phpcs:ignore ?>
			<?php endif; ?>

			<?php if ( ! empty( $gravity_form ) ) : ?>
				<?php echo do_shortcode( '[gravityform ajax="true" id="' . $gravity_form . '" title="false" description="false"]' ); //phpcs:ignore ?>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php
