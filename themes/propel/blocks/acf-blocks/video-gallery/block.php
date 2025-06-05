<?php
/**
 * Block with image gallery
 *
 * Title:             Video Gallery
 * Description:       Organize multiple videos.
 * Category:          Base
 * Icon:              video-alt3
 * Keywords:          video, gallery
 * Post Types:        all
 * Multiple:          true
 * Active:            false
 * CSS Deps:          sliders, lightbox
 * JS Deps:           sliders, lightbox
 * Global ACF Fields: scroll_id, background_color
 *
 * @package Propel
 * @since   1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$videos = get_field( 'videos' );

if ( ! empty( $videos ) ) :
	?>
	<section <?php echo wp_kses_post( $content_block->get_block_id_attr() ); ?>class="acf-block block-video-gallery<?php echo esc_attr( $content_block->get_block_classes() ); ?>  component-lightbox">
		<div class="container">
			<div class="row">
				<?php
				foreach ( $videos as $video ) :
					$width  = ! empty( $video['width'] ) ? $video['width'] : 16;
					$height = ! empty( $video['height'] ) ? $video['height'] : 9;
					$ratio  = $height / $width * 100;
					?>
					<div class="col-12 col-sm-6 col-md-4">
						<div 
							class="video-gallery__card  component-lightbox__open" 
							data-embed-url="<?php echo esc_attr( $video['video_embed_url'] ); ?>" 
							data-ratio="<?php echo esc_attr( $ratio ); ?>"
							data-id="<?php echo esc_attr( get_row_index() ); ?>"
						>
							<div class="video-gallery__card-thumb">
								<?php echo wp_get_attachment_image( $video['image'], 'medium' ); ?>
								<button class="c-btn--play"><div class="sr-only">Open video</div></button>
							</div>
							<?php if ( ! empty( $video['title'] ) ) : ?>
								<div class="video-gallery__card-title"><?php echo esc_html( $video['title'] ); ?></div>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="component-lightbox__container" aria-hidden="true">
			<button class="component-lightbox__close c-btn c-btn--close" aria-label="<?php esc_html_e( 'Close Video', 'propel' ); ?>"></button>
			<div class="container">
				<div class="component-lightbox__iframe">
					<iframe frameborder="0" allowfullscreen></iframe>
				</div>
			</div>
		</div>
	</section>
	<?php
endif;
