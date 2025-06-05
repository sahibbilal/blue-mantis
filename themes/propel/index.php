<?php
/**
 * The main template file.
 *
 * @package Propel
 * @since   2.2.0
 */

get_header();
?>

<main class="content-wrapper">
	<?php
	if ( is_home() ) {
		$blog_page_id = get_option( 'page_for_posts' );

		echo apply_filters( 'the_content', get_the_content( null, false, $blog_page_id ) ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} elseif ( is_tax() || is_category() || is_tag() ) {
		$queried_object = get_queried_object();

		if ( ! empty( $queried_object->taxonomy ) ) {
			render_theme_blocks( $queried_object->taxonomy );
		}
	}
	?>
</main>

<?php
get_footer();
