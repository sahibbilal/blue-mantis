<?php
/**
 * Hero-Standard
 *
 * Title:             Hero-Standard
 * Description:       Hero with two columns - content plus an image.
 * Category:          Hero
 * Icon:              align-pull-right
 * Keywords:          hero, content, image, columns
 * Post Types:        all
 * Multiple:          false
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, image
 * InnerBlocks:       true
 *
 * @package Propel
 * @since   2.1.1
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$image           = get_field( 'image' );
$image_alignment = get_field( 'image_alignment' );

if ( empty( $image_alignment ) ) {
	$image_alignment = 'right';
}

if ( empty( $image ) ) {
	$image = get_post_thumbnail_id();
}

$allowed_blocks = e29_text_blocks();

$template = array(
	array(
		'acf/icon-heading',
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
	array( 'core/buttons' ),
);
$back_link_wrapper_class = '';
if(get_back_link()) {
	$back_link_wrapper_class = 'block-hero-standard--back-link';
} 

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-hero-standard <?php echo esc_attr($back_link_wrapper_class); ?> block-hero-standard--<?php echo esc_attr( $image_alignment ); ?><?php echo esc_attr( $content_block->get_block_classes( array( 'background_color' => 'dark' ) ) ); ?>">
	<?php echo wp_kses_post( get_back_link() ); ?>

	<div class="container block-hero-standard__container">
		<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-hero-standard__content" />

		<?php if ( ! empty( $image ) ) : ?>
			<?php echo wp_kses_post( wp_get_attachment_image( $image, 'half-width-square', '', array( 'class' => 'block-hero-standard__image' ) ) ); ?>
		<?php endif; ?>
	</div>
</section>

<?php
