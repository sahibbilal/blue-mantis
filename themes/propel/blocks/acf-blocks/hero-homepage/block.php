<?php
/**
 * Hero-Homepage
 *
 * Title:             Hero-Homepage
 * Description:       Hero with background image.
 * Category:          Hero
 * Icon:              cover-image
 * Keywords:          hero, display, image, homepage
 * Post Types:        all
 * Multiple:          false
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color, image
 * InnerBlocks:       true
 * Styles:
 * Default BG Color:  dark
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$image                = get_field( 'image' );
$background_video_url = get_field( 'background_video_url' );

if ( empty( $image ) ) {
	$image = get_post_thumbnail_id();
}

$allowed_blocks = e29_text_blocks();

$template = array(
	array(
		'core/heading',
		array(
			'level'       => 1,
			'placeholder' => 'Add heading here.',
		),
	),
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
					'className' => 'is-style-secondary',
				),
			),
		),
	),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-hero-homepage<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<?php if ( ! empty( $image ) ) : ?>
		<?php echo wp_kses_post( wp_get_attachment_image( $image, 'full-width', '', array( 'class' => 'block-hero-homepage__image' ) ) ); ?>
	<?php endif; ?>

	<?php if ( ! empty( $background_video_url ) ) : ?>
		<div class="block-hero-homepage__video-wrapper">
			<div class="iframe-wrapper" data-vimeo-url="<?php echo esc_url( $background_video_url ); ?>" data-vimeo-width="640" data-vimeo-background="true" data-vimeo-autoplay="true" data-vimeo-loop="true" data-vimeo-defer></div>
		</div>
	<?php endif; ?>

	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="container block-hero-homepage__container" />
</section>

<?php
