<?php
/**
 * Hero-Archive-Blog
 *
 * Title:             Hero-Archive-Blog
 * Description:       Hero section for use on the blog archive that displays one highlighted post.
 * Category:          Hero
 * Icon:              admin-post
 * Keywords:          blog, archive, hero, featured, highlight
 * Post Types:        all
 * Multiple:          false
 * Active:            true
 * CSS Deps:          post-card-featured
 * JS Deps:
 * Global ACF Fields:
 * InnerBlocks:       true
 * Styles:
 * Context:
 *
 * @package Propel
 * @since   2.1.1
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$featured_post = get_field( 'featured_post' );

if ( empty( $featured_post ) ) {
	$args = array(
		'post_type'      => 'post',
		'post_status'    => array( 'publish' ),
		'posts_per_page' => 1,
	);

	$featured_post = get_posts( $args );

	if ( $featured_post ) {
		$featured_post = $featured_post[0];
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

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-hero-archive-blog<?php echo esc_attr( $content_block->get_block_classes( array( 'background_color' => 'dark' ) ) ); ?>">
	<div class="container block-hero-archive-blog__container">
		<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-hero-archive-blog__content" />

		<?php if ( ! empty( $featured_post ) ) : ?>
			<?php get_theme_part( '../blocks/components/post-card-featured/post-card-featured', array( 'featured_post' => $featured_post ) ); ?>
		<?php endif; ?>
	</div>
</section>
