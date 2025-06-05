<?php
/**
 * Testimonial
 *
 * Title:             Testimonial
 * Description:       Testimonial block for use within parent testimonials block.
 * Category:          Testimonial
 * Icon:              format-quote
 * Keywords:          testimonial, slider, quote
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields:
 * Parent:            acf/testimonials
 * InnerBlocks:       true
 * Wrap InnerBlocks:  false
 * Context:           acf/testimonial-standard, acf/testimonial-image, acf/testimonial-cards, acf/testimonial-box
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$testimonial                = get_field( 'testimonial' );
$custom_testimonial_content = get_field( 'custom_testimonial_content' );

if ( ! empty( $custom_testimonial_content ) ) {
	$name        = get_field( 'name' );
	$label       = get_field( 'label' );
	$logo        = get_field( 'logo' );
	$image       = get_field( 'image' );
	$button_link = get_field( 'button_link' );
}

if ( ! empty( $testimonial ) ) {
	$quote = get_field( 'quote', $testimonial );

	if ( ! empty( $name ) || empty( $custom_testimonial_content ) ) {
		$name = get_the_title( $testimonial );
	}

	if ( ! empty( $label ) || empty( $custom_testimonial_content ) ) {
		$label = get_field( 'label', $testimonial );
	}

	if ( ! empty( $logo ) || empty( $custom_testimonial_content ) ) {
		$logo = get_field( 'logo', $testimonial );
	}

	if ( ! empty( $image ) || empty( $custom_testimonial_content ) ) {
		$image = get_post_thumbnail_id( $testimonial );
	}
}

$allowed_blocks = array( 'core/paragraph' );

$template = array(
	'core/paragraph',
	array(
		'placeholder' => 'Add text or additional blocks here.',
	),
);

?>

<div class="block-testimonial">
	<?php if ( ! empty( $image ) && ( empty( $context ) || ! empty( $context['testimonial-image'] ) ) ) : ?>
		<div class="block-testimonial__image-col">
			<div class="block-testimonial__image-wrapper image-wrapper">
				<?php echo wp_kses_post( wp_get_attachment_image( $image, 'col-5-square', '', array( 'class' => 'block-testimonial__image' ) ) ); ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="block-testimonial__content-col">
		<?php if ( empty( $context ) || empty( $context['testimonial-cards'] ) ) : ?>
			<div class="block-testimonial__quote-icon"></div>
		<?php endif; ?>

		<blockquote class="block-testimonial__content">
			<?php if ( ! empty( $quote ) ) : ?>
				<?php echo wp_kses_post( $quote ); ?>
			<?php elseif ( ! empty( $custom_testimonial_content ) ) : ?>
				<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" />
			<?php endif; ?>
		</blockquote>

		<figcaption class="block-testimonial__slide-footer-content">
			<?php if ( ! empty( $name ) ) : ?>
				<div class="block-testimonial__slide-footer-name"><?php echo wp_kses_post( $name ); ?></div>
			<?php endif; ?>

			<?php if ( ! empty( $label ) ) : ?>
				<cite class="block-testimonial__slide-footer-label">
					<?php echo wp_kses_post( $label ); ?>
				</cite>
			<?php endif; ?>

			<?php if ( ! empty( $logo ) ) : ?>
				<?php echo wp_kses_post( wp_get_attachment_image( $logo, 'logo-block', '', array( 'class' => 'block-testimonial__logo' ) ) ); ?>
			<?php endif; ?>
		</figcaption>

		<?php if ( ! empty( $button_link ) ) : ?>
			<?php echo wp_kses_post( array_to_link( $button_link, 'is-style-secondary block-testimonial__button', array( 'icon' => 'icon-triangle-right' ) ) ); ?>
		<?php endif; ?>
	</div>
</div>

<?php
