<?php
/**
 * Hero-Centered
 *
 * Title:             Hero-Centered
 * Description:       Hero with centered text and optional image.
 * Category:          Hero
 * Icon:              cover-image
 * Keywords:          hero, centered, image
 * Post Types:        all
 * Multiple:          false
 * Active:            false
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color, image
 * InnerBlocks:       true
 *
 * @package Propel
 * @since   2.1.1
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$section_classes = '';
$image           = get_field( 'image' );

if ( empty( $image ) ) {
	$image = get_post_thumbnail_id();
}

$allowed_blocks = e29_text_blocks();

if ( ! empty( $image ) ) {
	$section_classes = ' block-hero-centered--has-image';
}

$template = array(
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Add pre-heading here.',
			'fontSize'    => 'overline',
		),
	),
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
);

?>
<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-hero-centered<?php echo esc_attr( $section_classes ); ?><?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<?php echo wp_kses_post( get_back_link() ); ?>

	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="content-wrapper" />

	<?php if ( ! empty( $image ) ) : ?>
		<figure class="block-hero-centered__image"> 
			<div class="block-hero-centered__image-wrapper">
				<?php echo wp_kses_post( wp_get_attachment_image( $image, 'col-12' ) ); ?>
			</div>
		</figure>
	<?php endif; ?>
</section>

<?php
