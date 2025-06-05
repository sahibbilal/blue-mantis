<?php
/**
 * Featured resource post card component.
 *
 * @package Propel
 * @since   2.1.1
 */

?>

<?php if ( ! empty( $featured_resource ) ) : ?>
	<?php
	$read_time      = get_read_time( $featured_resource->ID );
	$resource_type  = get_yoast_primary_term( 'resource_type', $featured_resource->ID, array( 'return' => 'term' ) );
	$resource_topic = get_yoast_primary_term( 'resource_topic', $featured_resource->ID, array( 'return' => 'term' ) );
	$video_url      = get_field( 'video_url', $featured_resource->ID );
	?>

	<article class="resource-card-featured">
		<div class="resource-card-featured__content">
			<?php if ( ! empty( $resource_type ) || ! empty( $resource_topic ) ) : ?>
				<div class="resource-card-featured__meta">
					<?php if ( ! empty( $resource_type ) ) : ?>
						<?php
						$icon        = get_field( 'icon', $resource_type );
						$icon_markup = '';

						if ( ! empty( $icon ) ) {
							$icon_markup = '<span class="icon ' . $icon . '"></span>';
						}
						?>

						<span class="resource-card-featured__type"><?php echo wp_kses_post( $icon_markup ); ?><?php echo wp_kses_post( $resource_type->name ); ?></span>
					<?php endif; ?>

					<?php if ( ! empty( $resource_topic ) ) : ?>
						<span class="resource-card-featured__topic"><?php echo wp_kses_post( $resource_topic->name ); ?></span>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<h3 class="resource-card-featured__title"><a href="<?php echo esc_url( get_the_permalink( $featured_resource ) ); ?>" class="resource-card-featured__link"><?php echo esc_html( $featured_resource->post_title ); ?></a></h3>

			<?php if ( ! empty( $featured_resource->post_excerpt ) ) : ?>
				<p class="resource-card-featured__excerpt has-body-2-font-size"><?php echo wp_kses_post( $featured_resource->post_excerpt ); ?></p>
			<?php endif; ?>

			<div class="wp-block-button is-style-secondary">
				<a href="<?php echo esc_url( get_the_permalink( $featured_resource ) ); ?>" class="wp-block-button__link"><?php esc_html_e( 'Read More', 'propel' ); ?></a>
			</div>
		</div>

		<?php if ( has_post_thumbnail( $featured_resource ) ) : ?>
			<a href="<?php echo esc_url( get_the_permalink( $featured_resource ) ); ?>" class="resource-card-featured__image-wrapper image-wrapper">
				<?php echo wp_kses_post( get_the_post_thumbnail( $featured_resource, 'blog-post-6', array( 'class' => 'resource-card-featured__image' ) ) ); ?>

				<?php if ( ! empty( $video_url ) ) : ?>
					<span class="c-btn c-btn--play resource-card-featured__image-wrapper-button"></span>
				<?php endif; ?>
			</a>
		<?php endif; ?>
	</article>
<?php endif; ?>
