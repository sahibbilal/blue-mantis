<?php
/**
 * Resource post card component.
 *
 * @package Propel
 * @since   2.1.1
 */

?>

<?php if ( ! empty( $card_post ) ) : ?>
	<?php
	$permalink      = get_the_permalink( $card_post );
	$image_id       = get_post_thumbnail_id( $card_post );
	$resource_type  = get_yoast_primary_term( 'resource_type', $card_post->ID, array( 'return' => 'term' ) );
	$resource_topic = get_yoast_primary_term( 'resource_topic', $card_post->ID, array( 'return' => 'term' ) );
	$redirect       = get_field( 'redirect_url' );
	?>
	
	<a 
		class="resource-card" 
		<?php if(!empty($redirect)) : ?>
			href="<?php echo esc_url( $redirect ); ?>"
			target="_blank"
		<?php else : ?>
			href="<?php echo esc_url( $permalink ); ?>"
		<?php endif; ?>
	>
		<figure class="resource-card__image-wrapper image-wrapper">
			<?php
			if ( $image_id ) :
				echo wp_kses_post( wp_get_attachment_image( $image_id, 'news-card', '', array( 'class' => 'resource-card__image' ) ) );
			else:
				?>
				<img loading="lazy" alt="Blue Mantis Logo." class="resource-card__image" src="<?php echo the_images_url() . 'blue-mantis-default-image.png'; ?>">
			<?php endif; ?>
		</figure>

		<div class="resource-card__meta">
			<?php if ( ! empty( $resource_topic ) ) : ?>
				<div class="resource-card__topic"><?php echo wp_kses_post( $resource_topic->name ); ?></div>
			<?php endif; ?>
			
			<?php if ( ! empty( $resource_type ) ) : ?>
				<?php
				$icon        = get_field( 'icon', $resource_type );
				$icon_markup = '';

				if ( ! empty( $icon ) ) {
					$icon_markup = '<span class="icon ' . $icon . '"></span>';
				}
				?>

				<div class="resource-card__type"><?php echo wp_kses_post( $icon_markup ); ?><?php echo wp_kses_post( $resource_type->name ); ?></div>
			<?php endif; ?>
		</div>

		<h3 class="resource-card__title"><?php echo esc_html( $card_post->post_title ); ?></h3>
	</a>
<?php endif; ?>
