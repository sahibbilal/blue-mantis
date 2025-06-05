<?php
/**
 * Hero-Campaign
 *
 * Title:             Hero-Campaign
 * Description:       Hero section with side contact form.
 * Category:          Hero
 * Icon:              cover-image
 * Keywords:          hero, contact, form, campaign
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

$background_image = get_field( 'background_image' );

$allowed_blocks = array( 'acf/content' );

$template = array(
	array(
		'acf/content',
		array(
			'className' => 'bg-dark',
		),
		array(
			array(
				'core/paragraph',
				array(
					'placeholder' => 'Add pre-heading here.',
					'fontSize'    => 't6',
				),
			),
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
		),
	),
	array(
		'acf/content',
		array(),
		array(
			array(
				'core/heading',
				array(
					'level'       => 2,
					'placeholder' => 'Add heading here.',
					'fontSize'    => 't3',
				),
			),
			array(
				'acf/marketo-form',
			),
		),
	),
);

?>
<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-hero-campaign<?php echo esc_attr( $content_block->get_block_classes( array( 'background_color' => 'none ' ) ) ); ?>">
	<div class="container">
		<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-hero-campaign__content" />
	</div>

	<?php if ( ! empty( $background_image ) ) : ?>
		<?php echo wp_kses_post( wp_get_attachment_image( $background_image, 'full-width', '', array( 'class' => 'block-hero-campaign__background-image' ) ) ); ?>
	<?php endif; ?>
</section>

<?php
