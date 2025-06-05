<?php
/**
 * Featured blog post card component.
 *
 * @package Propel
 * @since   2.1.1
 */

?>

<?php if ( ! empty( $featured_post ) ) : ?>
	<?php
	$read_time    = get_read_time( $featured_post->ID );
	$primary_term = get_yoast_primary_term( 'category', $featured_post->ID );
	$author_name  = get_old_or_current_author_name( $featured_post );
	?>

	<article class="post-card-featured">
		<?php echo wp_kses_post( get_the_post_thumbnail( $featured_post, 'full-width', array( 'class' => 'post-card-featured__image' ) ) ); ?>

		<?php if ( ! empty( $read_time ) || ! empty( $primary_term ) ) : ?>
			<div class="post-card-featured__meta">
				<?php if ( ! empty( $primary_term ) ) : ?>
					<span class="post-card-featured__primary-term"><?php echo wp_kses_post( $primary_term ); ?></span>
				<?php endif; ?>

				<?php if ( ! empty( $read_time ) ) : ?>
					<span><?php echo wp_kses_post( $read_time ); ?></span>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<h3 class="post-card-featured__title"><a href="<?php echo esc_url( get_the_permalink( $featured_post ) ); ?>" class="post-card-featured__link"><?php echo esc_html( $featured_post->post_title ); ?></a></h3>

		<?php if ( ! empty( $featured_post->post_excerpt ) ) : ?>
			<p class="post-card-featured__excerpt has-body-2-font-size"><?php echo wp_kses_post( $featured_post->post_excerpt ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $author_name ) ) : ?>
			<div class="post-card-featured__author"><?php echo esc_html( __( sprintf( 'By %s', $author_name ), 'propel' ) ); ?></div>
		<?php endif; ?>

		<div class="wp-block-button is-style-secondary">
			<a href="<?php echo esc_url( get_the_permalink( $featured_post ) ); ?>" class="wp-block-button__link"><?php esc_html_e( 'Read More', 'propel' ); ?></a>
		</div>
	</article>
<?php endif; ?>
