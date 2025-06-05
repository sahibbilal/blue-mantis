<?php
/**
 * Testimonial-Box
 *
 * Title:             Testimonial-Box
 * Description:       Display testimonials post type in a slider within the grid.
 * Category:          Testimonial
 * Icon:              format-quote
 * Keywords:          testimonial, slider, quote
 * Post Types:        all
 * Multiple:          true
 * Active:            false
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color
 * InnerBlocks:       true
 * Default BG Color:  neutral-98
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$background_color = get_field( 'background_color' );

if ( empty( $background_color ) ) {
	$background_color = 'neutral-98';
}

$allowed_blocks = e29_text_blocks( 'acf/testimonials' );

$template = array(
	array(
		'acf/testimonials',
	),
);

$slick_options = array(
	'dots'           => false,
	'arrows'         => true,
	'infinite'       => true,
	'slidesToShow'   => 1,
	'slidesToScroll' => 1,
	'pauseOnHover'   => false,
	'speed'          => 600,
	'prevArrow'      => '<button type="button" class="slick-prev slick-arrow--secondary">Previous</button>',
	'nextArrow'      => '<button type="button" class="slick-next slick-arrow--secondary">Next</button>',
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-testimonial-box<?php echo esc_attr( $content_block->get_block_classes( ( array( 'background_color' => 'transparent ' ) ) ) ); ?>" data-slick="<?php echo esc_attr( wp_json_encode( $slick_options ) ); ?>">
	<div class="container">
		<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-testimonial-box__content bg-<?php echo esc_attr( $background_color ); ?>"" />
	</div>
</section>

<?php
