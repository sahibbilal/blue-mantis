<?php
/**
 * News post card component.
 *
 * @package Propel
 * @since   2.1.1
 */

?>

<?php if ( ! empty( $card_post ) ) : ?>
	<?php
	$permalink     = get_the_permalink( $card_post );
	$news_category = get_yoast_primary_term( 'news_category', $card_post->ID, array( 'return' => 'term' ) );
	$redirect      = get_field( 'redirect_url', $card_post->ID );

	if ( ! isset( $show_image ) || false !== $show_image ) {
		$image_id = get_post_thumbnail_id( $card_post );
	}
	?>

	<a 
		class="news-card" 
		<? if( ! empty( $redirect ) && ! is_internal_link( $redirect ) ) : ?>
			href="<?php echo esc_url( $redirect ); ?>"
			target="_blank"
		<? else : ?>
			href="<?php echo esc_url( $permalink ); ?>"
		<? endif; ?>
		>

		<div class="news-card__content">
			<div class="news-card__date"><span class="news-card__month"><?php echo esc_html( get_the_date( 'M', $card_post ) ); ?></span><span class="news-card__day"><?php echo esc_html( get_the_date( 'j', $card_post ) ); ?></span></div>

			<?php if ( ! empty( $news_category ) ) : ?>
				<div class="news-card__category"><?php echo wp_kses_post( $news_category->name ); ?></div>
			<?php endif; ?>

			<h3 class="news-card__title"><?php echo esc_html( $card_post->post_title ); ?></h3>

			<?php if ( ! empty( $card_post->post_excerpt ) && ( ! isset( $show_excerpt ) || false !== $show_excerpt ) ) : ?>
				<div class="news-card__excerpt"><?php echo wp_kses_post( $card_post->post_excerpt ); ?></div>
			<?php endif; ?>

			<div class="wp-block-button is-style-tertiary wp-block-button--small wp-block-button--icon-right">
				<div class="wp-block-button__link"><?php esc_html_e( 'Read More', 'propel' ); ?></div>
			</div>
		</div>

		<?php if ( ! empty( $image_id ) ) : ?>
			<figure class="news-card__image-wrapper image-wrapper">
				<?php echo wp_kses_post( wp_get_attachment_image( $image_id, 'news-card', '', array( 'class' => 'news-card__image' ) ) ); ?>
			</figure>
		<?php endif; ?>
	</a>
<?php endif; ?>
