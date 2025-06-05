<?php
/**
 * Display the deafult content.
 *
 * @package Propel
 * @since   1.0
 */

/**
 * Display the deafult content.
 */
function default_content() {
	if ( has_blocks() ) : ?>
		<?php the_content(); ?>
	<?php else : ?>
		<?php
		global $post;
		wp_enqueue_style( 'core-list' );
		$default_content_classes = ' bg-transparent';

		if ( ! empty( $post->post_type ) && 'post' === $post->post_type ) {
			$default_content_classes = ' bg-black';
		}
		?>

		<div class="default-content acf-block acf-inline-block<?php echo esc_html( $default_content_classes ); ?>">
			<?php the_content(); ?>
		</div>
		<?php
	endif;
}
