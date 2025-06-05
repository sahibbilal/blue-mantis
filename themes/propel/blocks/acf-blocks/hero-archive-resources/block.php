<?php
/**
 * Hero-Archive-Resources
 *
 * Title:             Hero-Archive-Resources
 * Description:       Hero section for use on the resource archive that displays one highlighted post.
 * Category:          Hero
 * Icon:              dashicons-archive
 * Keywords:          resource, archive, hero, featured, highlight
 * Post Types:        all
 * Multiple:          false
 * Active:            true
 * CSS Deps:          resource-card-featured
 * JS Deps:
 * Global ACF Fields: background_image
 * InnerBlocks:       true
 * Styles:
 * Context:
 *
 * @package Propel
 * @since   2.1.1
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$featured_resource = get_field( 'featured_resource' );
$background_image  = get_field( 'background_image' );

if ( empty( $featured_resource ) ) {
	$args = array(
		'post_type'      => 'resource',
		'post_status'    => array( 'publish' ),
		'posts_per_page' => 1,
	);

	$featured_resource = get_posts( $args );

	if ( $featured_resource ) {
		$featured_resource = $featured_resource[0];
	}
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
);

?>

<section <?php echo wp_kses_post( $content_block->get_block_id_attr() ); ?>class="acf-block block-hero-archive-resources<?php echo esc_attr( $content_block->get_block_classes( array( 'background_color' => 'dark' ) ) ); ?>">
	<div class="container">
		<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-hero-archive-resources__content" />

		<?php if ( ! empty( $featured_resource ) ) : ?>
			<?php get_theme_part( '../blocks/components/resource-card-featured/resource-card-featured', array( 'featured_resource' => $featured_resource ) ); ?>
		<?php endif; ?>
	</div>

	<?php if ( ! empty( $background_image ) ) : ?>
		<?php echo wp_kses_post( wp_get_attachment_image( $background_image, 'full-width', '', array( 'class' => 'block-hero-archive-resources__background-image' ) ) ); ?>
	<?php endif; ?>
</section>
