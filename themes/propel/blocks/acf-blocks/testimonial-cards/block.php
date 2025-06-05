<?php
/**
 * Testimonial-Cards
 *
 * Title:             Testimonial-Cards
 * Description:       Display testimonials post type in a slider with multiple cards per row.
 * Category:          Testimonial
 * Icon:              format-quote
 * Keywords:          testimonial, slider, quote, cards
 * Post Types:        all
 * Multiple:          true
 * Active:            false
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color
 * InnerBlocks:       true
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$section_classes = '';

if ( ! isset( $content ) || ! empty( trim( $content ) ) && 0 !== strpos( trim( $content ), '<div class="block-testimonials' ) ) {
	$section_classes = ' block-testimonial-cards--has-heading-content';
}

$cards_per_row = get_field( 'cards_per_row' );

if ( empty( $cards_per_row ) ) {
	$cards_per_row = '3';
}

$allowed_blocks = e29_text_blocks( 'acf/testimonials' );

$template = array(
	array(
		'core/heading',
		array(
			'level'       => 2,
			'placeholder' => 'Add heading here.',
			'fontSize'    => 't2',
		),
	),
	array(
		'acf/testimonials',
	),
);

$slick_options = array(
	'dots'           => false,
	'arrows'         => true,
	'infinite'       => true,
	'slidesToShow'   => $cards_per_row,
	'slidesToScroll' => 1,
	'pauseOnHover'   => false,
	'speed'          => 600,
	'prevArrow'      => '<div class="slick-prev-arrow-wrapper"><button type="button" class="slick-arrow slick-prev slick-arrow--secondary">Previous</button></div>',
	'nextArrow'      => '<div class="slick-next-arrow-wrapper"><button type="button" class="slick-arrow slick-next slick-arrow--secondary">Next</button></div>',
	'responsive'     => array(
		array(
			'breakpoint' => 992,
			'settings'   => array(
				'slidesToShow' => 2,
			),
		),
		array(
			'breakpoint' => 576,
			'settings'   => array(
				'slidesToShow' => 1,
			),
		),
	),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-testimonial-cards<?php echo esc_attr( $section_classes ); ?><?php echo esc_attr( $content_block->get_block_classes() ); ?>" data-slick="<?php echo esc_attr( wp_json_encode( $slick_options ) ); ?>">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="container block-testimonial-cards__container" />
</section>

<?php
