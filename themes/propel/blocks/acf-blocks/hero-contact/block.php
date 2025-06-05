<?php
/**
 * Hero-Contact
 *
 * Title:             Hero-Contact
 * Description:       Hero section with side contact form.
 * Category:          Hero
 * Icon:              cover-image
 * Keywords:          hero, contact, form
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:          marketo
 * JS Deps:           marketo-script, marketo
 * Global ACF Fields: scroll_id, background_image
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
			'level'       => 1,
			'placeholder' => 'Add heading here.',
			'fontSize'    => 't1',
		),
	),
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Add text or additional blocks here.',
		),
	),
	array(
		'core/heading',
		array(
			'level'    => 2,
			'content'  => 'Office',
			'fontSize' => 't6',
		),
	),
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Add address here.',
		),
	),
	array(
		'core/heading',
		array(
			'level'    => 2,
			'content'  => 'Phone',
			'fontSize' => 't6',
		),
	),
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Add phone number here.',
		),
	),
	array(
		'core/heading',
		array(
			'level'    => 2,
			'content'  => 'Connect',
			'fontSize' => 't6',
		),
	),
	array(
		'core/buttons',
		array(),
		array(
			array(
				'core/button',
				array(
					'className'  => 'is-style-social',
					'text'       => 'Connect on LinkedIn',
					'buttonIcon' => 'icon-linkedin',
				),
			),
			array(
				'core/button',
				array(
					'className'  => 'is-style-social',
					'text'       => 'Connect on Instagram',
					'buttonIcon' => 'icon-instagram',
				),
			),
		),
	),
);

?>
<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-hero-contact<?php echo esc_attr( $content_block->get_block_classes( array( 'background_color' => 'none ' ) ) ); ?>">
	<div class="container block-hero-contact__container">
		<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-hero-contact__content bg-dark" />

		<div class="block-hero-contact__form-wrapper">
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
