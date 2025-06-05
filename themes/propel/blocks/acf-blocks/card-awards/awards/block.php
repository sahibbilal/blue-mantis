<?php
/**
 * Awards
 *
 * Title:             Awards
 * Description:       The inner card wrapper for the Cards-Awards block.
 * Category:          Card
 * Icon:              dashicons-groups
 * Keywords:          cards, card, links, awards
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:          sliders
 * JS Deps:           sliders
 * Global ACF Fields:
 * Parent:            acf/card-awards
 * InnerBlocks:       true
 * Wrap InnerBlocks:  false
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = array( 'acf/card-award' );

$template = array(
	array(
		'acf/card-award',
	),
	array(
		'acf/card-award',
	),
	array(
		'acf/card-award',
	),
	array(
		'acf/card-award',
	),
);

$slick_options = array(
	'dots'            => false,
	'pageCount'       => false,
	'arrows'          => false,
	'infinite'        => true,
	'slidesToShow'    => 4,
	'slidesToScroll'  => 4,
	'pauseOnHover'    => false,
	'speed'           => 2000,
	'variableWidth'   => false,
	'autoplay'        => true,
	'prevArrow'       => '<button type="button" class="slick-prev slick-arrow--secondary">Previous</button>',
	'nextArrow'       => '<button type="button" class="slick-next slick-arrow--secondary">Next</button>',
	'customCallbacks' => true,
	'responsive'      => array(
		array(
			'breakpoint' => 992,
			'settings'   => array(
				'slidesToShow'   => 2,
				'slidesToScroll' => 2,
			),
		),
		array(
			'breakpoint' => 576,
			'settings'   => array(
				'slidesToShow'   => 1,
				'slidesToScroll' => 1,
			),
		),
	),
);

?>

<div class="block-awards component-slider" data-slick="<?php echo esc_attr( wp_json_encode( $slick_options ) ); ?>">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-speakers__content" />
</div>

<?php
