<?php
/**
 * Hero-Archive-News
 *
 * Title:             Hero-Archive-News
 * Description:       Hero with two columns of text for use on the news archive page.
 * Category:          Hero
 * Icon:              dashicons-format-aside
 * Keywords:          hero, content, columns, text
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_image
 * InnerBlocks:       true
 * Styles:
 *
 * @package Propel
 * @since   2.1.1
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$background_image = get_field( 'background_image' );

$allowed_blocks = array( 'acf/content' );

$template = array(
	array(
		'acf/content',
		array(),
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
				),
			),
		),
	),
	array(
		'acf/content',
		array(),
		array(
			array(
				'core/paragraph',
				array(
					'placeholder' => 'Add text or additional blocks here.',
				),
			),
			array(
				'core/buttons',
				array(),
				array(
					array(
						'core/button',
						array(
							'className' => 'is-style-primary',
						),
					),
					array(
						'core/button',
						array(
							'className' => 'is-style-secondary',
						),
					),
				),
			),
		),
	),
);

?>

<section <?php echo wp_kses_post( $content_block->get_block_id_attr() ); ?>class="acf-block block-hero-archive-news<?php echo esc_attr( $content_block->get_block_classes( array( 'background_color' => 'dark' ) ) ); ?>">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="container block-hero-archive-news__container" />

	<?php if ( ! empty( $background_image ) ) : ?>
		<?php echo wp_kses_post( wp_get_attachment_image( $background_image, 'full-width', '', array( 'class' => 'block-hero-archive-news__background-image' ) ) ); ?>
	<?php endif; ?>
</section>

<?php
