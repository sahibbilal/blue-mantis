<?php
/**
 * Blog post card component.
 *
 * @package Propel
 * @since   2.1.1
 */

?>

<?php if ( ! empty( $card_post ) ) : ?>
	<?php
	$read_time    = get_read_time( $card_post->ID );
	$primary_term = get_yoast_primary_term( 'category', $card_post->ID );
	$author_name  = get_old_or_current_author_name( $card_post );

	if ( ! isset( $show_image ) || false !== $show_image ) {
		$image_id = get_post_thumbnail_id( $card_post );

		if ( empty( $image_size ) ) {
			$image_size = 'card-image-link-4';
		}

		if ( empty( $image_id ) ) {
			$image_id = get_field( 'placeholder_image', 'general' );
		}
	}
	?>

	<a href="<?php echo esc_url( get_the_permalink( $card_post ) ); ?>" class="post-card">
		<?php if ( ! isset( $show_image ) || false !== $show_image ) : ?>
			<figure class="post-card__image-wrapper image-wrapper">
				<?php if ( ! empty( $image_id ) ) : ?>
					<?php echo wp_kses_post( wp_get_attachment_image( $image_id, $image_size, '', array( 'class' => 'post-card__image' ) ) ); ?>
				<?php endif; ?>
			</figure>
		<?php endif; ?>

		<div class="post-card__content">
			<?php if ( ! empty( $read_time ) || ! empty( $primary_term ) ) : ?>
				<div class="post-card__meta">
					<?php if ( ! empty( $primary_term ) ) : ?>
						<span class="post-card__category"><?php echo wp_kses_post( $primary_term ); ?></span>
					<?php endif; ?>

					<?php if ( ! empty( $read_time ) ) : ?>
						<span class="post-card__read-time"><?php echo wp_kses_post( $read_time ); ?></span>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<h3 class="post-card__title"><?php echo esc_html( $card_post->post_title ); ?></h3>

			<?php if ( ! empty( $author_name ) ) : ?>
				<div class="post-card__author"><?php echo esc_html( __( sprintf( 'By %s', $author_name ), 'propel' ) ); ?></div>
			<?php endif; ?>
		</div>
	</a>
<?php endif; ?>
