<?php
/**
 * Featured event post card component.
 *
 * @package Propel
 * @since   2.1.1
 */

?>

<?php
if ( ! empty( $featured_event ) ) :
	;
	?>
	<?php
	$read_time  = get_read_time( $featured_event->ID );
	$event_type = get_yoast_primary_term( 'event_type', $featured_event->ID, array( 'return' => 'term' ) );
	$video_url  = get_field( 'video_url', $featured_event->ID );
	?>

	<article class="event-card-featured">
		<div class="event-card-featured__content">
			<div class="event-card-featured__type">
				<?php if ( ! empty( $event_type ) ) : ?>
					<?php echo wp_kses_post( $event_type->name ); ?>
				<? else : ?>
					Featured Event
				<?php endif; ?>
			</div>

			<h3 class="event-card-featured__title"><a href="<?php echo esc_url( get_the_permalink( $featured_event ) ); ?>" class="event-card-featured__link"><?php echo esc_html( $featured_event->post_title ); ?></a></h3>

			<?php if ( ! empty( $featured_event->post_excerpt ) ) : ?>
				<p class="event-card-featured__excerpt has-body-2-font-size"><?php echo wp_kses_post( $featured_event->post_excerpt ); ?></p>
			<?php endif; ?>			
			<div class="wp-block-buttons">
				<?php if ( isset ( $custom_cta_button_url ) && isset ( $custom_cta_button_title ) && isset ( $custom_cta_button_target ) ) : ?>
					<div class="wp-block-button is-style-primary wp-block-buton--icon-right">
						<a href="<?php echo esc_url( $custom_cta_button_url ); ?>" target="<?php echo esc_attr( $custom_cta_button_target ); ?>" class="wp-block-button__link"><?php esc_html_e( $custom_cta_button_title, 'propel' ); ?></a>
					</div>
				<?php else : ?>
					<?php if ( ! empty( $event_type ) && 'webinar' === $event_type->slug ) : ?>
						<div class="wp-block-button is-style-primary wp-block-buton--icon-right">
							<a href="<?php echo esc_url( get_the_permalink( $featured_event ) ); ?>" class="wp-block-button__link"><?php esc_html_e( 'Watch Now', 'propel' ); ?></a>
						</div>
					<?php else : ?>
						<div class="wp-block-button is-style-secondary">
							<a href="<?php echo esc_url( get_the_permalink( $featured_event ) ); ?>" class="wp-block-button__link"><?php esc_html_e( 'View Details', 'propel' ); ?></a>
						</div>
					<?php endif; ?>
				<?php endif; ?>		
			</div>
		</div>

					<?php if ( has_post_thumbnail( $featured_event ) ) : ?>
			<a href="<?php echo esc_url( get_the_permalink( $featured_event ) ); ?>" class="event-card-featured__image-wrapper image-wrapper">
						<?php echo wp_kses_post( get_the_post_thumbnail( $featured_event, 'blog-post-6', array( 'class' => 'event-card-featured__image' ) ) ); ?>

						<?php if ( ! empty( $video_url ) ) : ?>
					<span class="c-btn c-btn--play event-card-featured__image-wrapper-button"></span>
				<?php endif; ?>
			</a>
		<?php endif; ?>
	</article>
<?php endif; ?>
