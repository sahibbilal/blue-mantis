<?php
/**
 * Single post content.
 *
 * @package Propel
 * @since   2.0
 */

global $post;

?>

<?php render_theme_blocks( $post->post_type . '_top' ); ?>

<?php if ( ! empty( $post->post_type ) && 'news' === $post->post_type ) : ?>
	<section class="news-post-wrapper acf-block bg-transparent">
		<div class="news-post-wrapper__container container">
			<div class="news-post-wrapper__content">
<?php endif; ?>

				<?php default_content(); ?>

<?php if ( ! empty( $post->post_type ) && 'news' === $post->post_type ) : ?>
			</div>

			<div class="news-post-wrapper__footer">
				<?php render_theme_blocks( 'news_footer' ); ?>
			</div>

			<aside class="news-post-wrapper__sidebar">
				<?php render_theme_blocks( 'news_sidebar' ); ?>
			</aside>
		</div>
	</section>
<?php endif; ?>

<?php render_theme_blocks( $post->post_type . '_bottom' ); ?>
