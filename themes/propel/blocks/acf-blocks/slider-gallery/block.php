<?php
/**
 * Block with image gallery
 *
 * Title:             Slider Gallery
 * Description:       Display multiple images in a slideshow format.
 * Category:          Media
 * Icon:              images-alt
 * Keywords:          image, slider
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:          sliders, lightbox
 * JS Deps:           sliders, lightbox
 * Global ACF Fields: scroll_id, background_color
 *
 * @package Propel
 * @since   1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$gallery         = '';
$gallery_id      = get_field( 'gallery' );
$gallery_type    = get_field( 'gallery_type' );
$flexible_widths = get_field( 'flexible_widths' );
$flexible_class  = $flexible_widths ? 'flexible' : 'hard';

$is_fluid = get_field( 'fluid' );
if ( $flexible_widths ) {
	$is_fluid = true;
}

if ( ! empty( $gallery_id ) ) {
	$gallery        = get_field( 'gallery_slides', $gallery_id );
	$gallery_length = ! empty( $gallery ) ? count( $gallery ) : 0;
}

if ( ! empty( $gallery ) ) :
	?>
	<section <?php echo wp_kses_post( $content_block->get_block_id_attr() ); ?>class="acf-block block-slider-gallery <?php echo esc_attr( $gallery_type . " block-slider-gallery--$flexible_class" ); ?><?php echo esc_attr( $content_block->get_block_classes() ); ?>">
		<?php if ( 'lightbox-gallery' === $gallery_type ) : ?>
			<div class="container  component-lightbox">
				<div class="lightbox-gallery__thumbnails-wrapper">
					<div class="row">
						<?php for ( $i = 0; $i < $gallery_length; $i++ ) : ?>
							<div class="col-6 col-md-4 lightbox-gallery__single-col">
								<a href="<?php echo '#' . esc_attr( $i ); ?>" class="lightbox-gallery__single-image-wrapper image-wrapper  component-lightbox__open">
									<?php echo wp_get_attachment_image( $gallery[ $i ]['image'], 'slider-gallery-small' ); ?>
								</a>
							</div>
						<?php endfor; ?>
					</div>
				</div>

				<div class="component-lightbox__container" aria-hidden="true">
					<button class="component-lightbox__close c-btn c-btn--close" aria-label="<?php esc_html_e( 'Close Video', 'propel' ); ?>"></button>
					<?php include 'inc/gallery-slider.php'; ?>
				</div>
			</div>

			<?php
		else :
			include 'inc/gallery-slider.php';
		endif;
		?>
	</section>
	<?php
endif;
