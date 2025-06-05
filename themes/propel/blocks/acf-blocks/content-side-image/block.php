<?php
/**
 * Content-Side-Image
 *
 * Title:             Content-Side-Image
 * Description:       A block with an image and custom content.
 * Category:          Content
 * Icon:              icon829-content-side-image
 * Keywords:          image, content, WYSIWYG
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color, image, video
 * InnerBlocks:       true
 * Styles:            Default, Gradient
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$image              = get_field( 'image' );
$image_alignment    = get_field( 'image_alignment' );
$image_aspect_ratio = get_field( 'image_aspect_ratio' ) ?: 'default';
$video              = get_field( 'video' );
$blue_mantis_logo   = get_field( 'blue_mantis_logo' );
$image_class        = 'block-content-side-image__image-wrapper';
$image_size         = 'col-6';


if ( empty( $image_alignment ) ) {
	$image_alignment = 'right';
}

if ( 'square' === $image_aspect_ratio ) {
	$image_size   = 'col-6-square';
	$image_class .= ' block-content-side-image__image-wrapper--square';

}

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
	),
	array(
		'core/buttons',
		array(),
		array(
			array(
				'core/button',
				array(
					'className' => 'is-style-tertiary',
				),
			),
		),
	),
);

$block_classes = $content_block->get_block_classes();

if ( false !== strpos( $block_classes, 'is-style-gradient' ) ) {
	$block_classes  = preg_replace( '/bg-[^ ]*/m', '', $block_classes );
	$block_classes .= ' bg-dark';
	$block_classes  = str_replace( '  ', ' ', $block_classes );
	$image_size     = 'half-width';
}
?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-content-side-image block-content-side-image--<?php echo esc_attr( $image_alignment ); ?><?php echo esc_attr( $block_classes ); ?>">
	<div class="container block-content-side-image__container">
		<div class="block-content-side-image__image-col">
			<?php if ( ! empty( $blue_mantis_logo ) ) : ?>
				<figure class="block-content-side-image__image-wrapper block-content-side-image__image-wrapper--logo" aria-label="<?php esc_html_e( 'Blue Mantis Logo', 'propel' ); ?>"></figure>
			<?php elseif ( ! empty( $image ) ) : ?>
				<figure class="<?php echo esc_attr( $image_class ); ?>">
					<?php echo wp_kses_post( wp_get_attachment_image( $image, $image_size, '', array( 'class' => 'block-content-side-image__image' ) ) ); ?>

					<?php if ( ! empty( $video ) ) : ?>
						<a href="#" aria-label="<?php esc_html_e( 'Watch Video', 'propel' ); ?>" data-video-url="<?php echo esc_url( $video ); ?>" class="block-content-side-image__video-button"><span class="c-btn c-btn--play"></span></a>
					<?php endif; ?>
				</figure>
			<?php endif; ?>
		</div>

		<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-content-side-image__content-col" />
	</div>
</section>

<?php
