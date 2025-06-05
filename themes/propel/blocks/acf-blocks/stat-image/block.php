<?php
/**
 * Stat-Image
 *
 * Title:             Stat-Image
 * Description:       Block with stats and an image.
 * Category:          Stat
 * Icon:              chart-bar
 * Keywords:          stats, statistics, numbers, data, results, image
 * Post Types:        all
 * Multiple:          true
 * Active:            false
 * CSS Deps
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color, image
 * InnerBlocks:       true
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$image = get_field( 'image' );

$allowed_blocks = e29_text_blocks( array( 'acf/stats' ) );

$template = array(
	array(
		'core/heading',
		array(
			'level'       => 2,
			'placeholder' => 'Add heading here.',
		),
	),
	array(
		'acf/stats',
	),
);

?>
<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-stat-image<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<div class="container">
		<div class="row block-stat-image__row">
			<div class="col-12 col-md-6">
				<?php if ( ! empty( $image ) ) : ?>
					<figure class="block-stat-image__image-wrapper image-wrapper">
						<?php echo wp_kses_post( wp_get_attachment_image( $image, 'square-half' ) ); ?>
					</figure>
				<?php endif; ?>
			</div>

			<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="col-12 col-md-6 col-lg-5" />
		</div>
	</div>
</section>

<?php
