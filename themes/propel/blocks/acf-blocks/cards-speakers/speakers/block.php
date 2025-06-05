<?php
/**
 * Speakers
 *
 * Title:             Speakers
 * Description:       The inner card wrapper for the Cards-Speakers block.
 * Category:          Card
 * Icon:              dashicons-groups
 * Keywords:          people, team, leader, department, speaker, speakers
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:          sliders
 * JS Deps:           sliders
 * Global ACF Fields:
 * Parent:            acf/cards-speakers
 * InnerBlocks:       true
 * Wrap InnerBlocks:  false
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = e29_text_blocks( 'acf/card-speaker' );

$template = array(
	array(
		'acf/card-speaker',
	),
	array(
		'acf/card-speaker',
	),
	array(
		'acf/card-speaker',
	),
	array(
		'acf/card-speaker',
	),
);

$number_of_speakers = substr_count( htmlentities( $content ), '&lt;div class=&quot;block-card-speaker&quot;&gt;' );

$slick_options = array(
	'dots'            => true,
	'pageCount'       => true,
	'arrows'          => true,
	'infinite'        => true,
	'slidesToShow'    => $number_of_speakers >= 4 ? 4 : $number_of_speakers,
	'slidesToScroll'  => $number_of_speakers >= 4 ? 4 : $number_of_speakers,
	'pauseOnHover'    => false,
	'speed'           => 600,
	'variableWidth'   => false,
	'prevArrow'       => '<button type="button" class="slick-prev slick-arrow--secondary">Previous</button>',
	'nextArrow'       => '<button type="button" class="slick-next slick-arrow--secondary">Next</button>',
	'customCallbacks' => true,
	'responsive'      => array(
		array(
			'breakpoint' => 992,
			'settings'   => array(
				'slidesToShow'   => $number_of_speakers >= 3 ? 3 : $number_of_speakers,
				'slidesToScroll' => $number_of_speakers >= 3 ? 3 : $number_of_speakers,
			),
		),
		array(
			'breakpoint' => 680,
			'settings'   => array(
				'slidesToShow'   => $number_of_speakers >= 2 ? 2 : $number_of_speakers,
				'slidesToScroll' => $number_of_speakers >= 2 ? 2 : $number_of_speakers,
			),
		),
		array(
			'breakpoint' => 460,
			'settings'   => array(
				'slidesToShow'   => 1,
				'slidesToScroll' => 1,
			),
		),
	),
);

$block_speakers_class = '';

switch ( $number_of_speakers ) {
	case 1:
		$block_speakers_class = 'block-speakers__single';
		break;
	case 2:
		$block_speakers_class = 'block-speakers__double';
		break;
	case 3:
		$block_speakers_class = 'block-speakers__triple';
		break;
};

?>

<div class="block-speakers component-slider <?php echo esc_attr( $block_speakers_class ); ?>" data-slick="<?php echo esc_attr( wp_json_encode( $slick_options ) ); ?>">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-speakers__content" />
</div>

<?php
