<?php
/**
 * Event post card component.
 *
 * @package Propel
 * @since   2.1.1
 */

?>

<?php if ( ! empty( $card_post ) ) : ?>
	<?php
	$permalink   = get_the_permalink( $card_post );
	$event_type  = get_yoast_primary_term( 'event_type', $card_post->ID, array( 'return' => 'term' ) );
	$event_topic = get_yoast_primary_term( 'event_topic', $card_post->ID, array( 'return' => 'term' ) );
	$timezone    = get_field( 'timezone', $card_post->ID );
	$event_date  = e29_get_event_date( $card_post->ID, array( 'day_format' => 'F j', 'timezone' => $timezone ) );
	$on_demand   = get_field( 'on_demand', $card_post->ID );
	$video_url   = get_field( 'video_url', $card_post->ID );

	$button_text = __( 'Read More', 'propel' );

	if ( ! empty( $video_url ) ) {
		$button_text = __( 'Watch Now', 'propel' );
	}

	if ( ! empty( $event_type ) ) {
		$event_card_button_text = get_field( 'event_card_button_text', $event_type );

		if ( ! empty( $event_card_button_text ) ) {
			$button_text = $event_card_button_text;
		}
	}

	if ( ! isset( $show_image ) || false !== $show_image ) {
		$image_id = get_post_thumbnail_id( $card_post );

		if ( empty( $image_id ) ) {
			$image_id = get_field( 'placeholder_image', 'general' );
		}
	}
	?>

	<a class="event-card" href="<?php echo esc_url( $permalink ); ?>">
		<div class="event-card__content">
			<?php if ( ! empty( $event_type ) || ! empty( $event_topic ) ) : ?>
				<div class="event-card__meta">
					<?php if ( ! empty( $event_type ) ) : ?>
						<span><?php echo wp_kses_post( $event_type->name ); ?></span>
					<?php endif; ?>

					<?php if ( ! empty( $event_topic ) ) : ?>
						<span><?php echo wp_kses_post( $event_topic->name ); ?></span>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<h3 class="event-card__title"><?php echo esc_html( $card_post->post_title ); ?></h3>

			<?php if ( ! empty( $on_demand ) ) : ?>
				<div class="event-card__date">
					<span class="icon icon-virtual"></span>

					<?php esc_html_e( 'On Demand', 'propel' ); ?>
				</div>
			<?php else : ?>
				<div class="event-card__date">
					<span class="icon icon-time"></span>

					<?php echo esc_html( $event_date ); ?>
				</div>
			<?php endif; ?>

			<div class="wp-block-button is-style-tertiary wp-block-button--small wp-block-button--icon-right">
				<div class="wp-block-button__link"><?php echo esc_html( $button_text ); ?></div>
			</div>
		</div>

		<?php if ( ! empty( $image_id ) ) : ?>
			<figure class="event-card__image-wrapper image-wrapper">
				<?php echo wp_kses_post( wp_get_attachment_image( $image_id, 'event-card', '', array( 'class' => 'event-card__image' ) ) ); ?>
			</figure>
		<?php endif; ?>
	</a>
<?php endif; ?>
