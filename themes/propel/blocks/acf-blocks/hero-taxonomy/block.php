<?php
/**
 * Hero-Taxonomy
 *
 * Title:             Hero-Taxonomy
 * Description:       Hero section for use on the taxonomy archives.
 * Category:          Hero
 * Icon:              cover-image
 * Keywords:          archive, taxonomy hero, blog, resource, news, post
 * Post Types:        all
 * Multiple:          false
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: background_image
 * InnerBlocks:       false
 * Mode:              preview
 * Styles:
 * Context:
 *
 * @package Propel
 * @since   2.1.1
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$block_classes = $content_block->get_block_classes( array( 'background_color' => 'dark' ) );

$background_image = get_field( 'background_image' );

$hero_taxonomy    = '';
$hero_title       = '';
$hero_description = '';

$load_default_content = is_block_library();

if ( empty( $load_default_content ) ) {
	$load_default_content = is_theme_block();
}

if ( is_tax() || is_category() || $load_default_content ) {
	if ( $load_default_content ) {
		$all_terms = get_terms(
			array(
				'taxonomy' => 'category',
				'number'   => 1,
			)
		);

		if ( ! empty( $all_terms ) && ! is_wp_error( $all_terms ) && is_array( $all_terms ) ) {
			$term_object = array_values( $all_terms )[0];
		}
	} else {
		$term_object = get_queried_object();
	}

	if ( ! empty( $term_object ) && ! empty( $term_object->name ) && ! empty( $term_object->taxonomy ) && ! empty( $term_object->term_id ) ) {
		$hero_title       = $term_object->name;
		$hero_description = $term_object->description;

		$term_taxonomy = get_taxonomy( $term_object->taxonomy );

		if ( ! is_wp_error( $term_taxonomy ) && ! empty( $term_taxonomy->labels ) && ! empty( $term_taxonomy->labels->singular_name ) ) {
			$hero_taxonomy = $term_taxonomy->labels->singular_name;

			if ( ! empty( $term_taxonomy->object_type ) ) {
				foreach ( $term_taxonomy->object_type as $assigned_post_type ) {
					$hero_taxonomy = str_ireplace( $assigned_post_type . ' ', '', $hero_taxonomy );
				}
			}
		}
	}
}

if ( ! empty( $background_image ) ) {
	$block_classes .= ' block-hero-taxonomy--background-image';
}

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-hero-taxonomy<?php echo esc_attr( $block_classes ); ?>">
	<?php echo wp_kses_post( get_back_link() ); ?>

	<div class="container block-hero-taxonomy__container">
		<div class="block-hero-taxonomy__content">
			<?php if ( ! empty( $hero_taxonomy ) ) : ?>
				<p class="has-t-6-font-size"><?php echo esc_html( $hero_taxonomy ); ?></p>
			<?php endif; ?>

			<?php if ( ! empty( $hero_title ) ) : ?>
				<h1 class="block-hero-taxonomy__title"><?php echo esc_html( $hero_title ); ?></h1>
			<?php endif; ?>

			<?php if ( ! empty( $hero_description ) ) : ?>
				<p class="block-hero-taxonomy__description"><?php echo esc_html( $hero_description ); ?></p>
			<?php endif; ?>
		</div>
	</div>

	<?php if ( ! empty( $background_image ) ) : ?>
		<?php echo wp_kses_post( wp_get_attachment_image( $background_image, 'full-width', '', array( 'class' => 'block-hero-taxonomy__background-image' ) ) ); ?>
	<?php endif; ?>
</section>
