<?php
/**
 * Slider Gallery block - slider partial
 *
 * @package Propel
 * @since   2.0.0
 */

$captions_modifier = false;
if ( ! $flexible_widths ) {
	foreach ( $gallery as $slide ) {
		if ( ! empty( $slide['caption'] ) ) {
			$captions_modifier = ' gallery-slider--has-captions';
			break;
		}
	}
}

$slick_options = array(
	'dots'           => false,
	'arrows'         => true,
	'infinite'       => true,
	'slidesToShow'   => 1,
	'slidesToScroll' => 1,
	'pauseOnHover'   => false,
	'speed'          => 600,
	'prevArrow'      => '<button type="button" class="slick-prev slick-arrow--color-alt">Previous</button>',
	'nextArrow'      => '<button type="button" class="slick-next slick-arrow--color-alt">Next</button>',
);

if ( $is_fluid ) {
	$slick_options = array_merge(
		$slick_options,
		array(
			'centerMode'    => true,
			'variableWidth' => true,
		)
	);
}
?>

<div class="gallery-slider
<?php
echo $is_fluid ? ' gallery-slider--fluid' : '';
echo esc_attr( $captions_modifier );
?>
">
	<div class="container<?php echo $is_fluid ? '-fluid-slider' : ''; ?>">
		<div class="gallery-slider__slider<?php echo $is_fluid ? '-fluid' : ''; ?>  component-slider" data-slick="<?php echo esc_attr( wp_json_encode( $slick_options ) ); ?>">
			<?php
			foreach ( $gallery as $slide ) {
				$image_size    = $flexible_widths ? 'slider-image-flexible' : 'slider-image-hard';
				$slide_img     = wp_get_attachment_image( $slide['image'], $image_size );
				$slide_caption = $slide['caption'];

				if ( ! empty( $slide_img ) ) :
					?>
					<div class="gallery-slider__single-slide">
						<figure class="gallery-slider__image">
							<div class="gallery-slider__image-container">
								<?php echo wp_kses_post( $slide_img ); ?>
							</div>
							<?php if ( ! empty( $slide_caption ) && ! $flexible_widths ) : ?>
								<figcaption class="gallery-slider__caption"><?php echo esc_html( $slide_caption ); ?></figcaption>
							<?php endif; ?>
						</figure>
					</div>
					<?php
				endif;
			}
			?>
		</div>
	</div>
</div>
