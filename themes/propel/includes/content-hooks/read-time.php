<?php
/**
 * Calculate the post read time and save it as a custom meta value.
 *
 * @package Propel
 * @since   2.1.1
 */

namespace Propel\ReadTime;

/**
 * Calculate the post read time and save it as a custom meta value.
 *
 * @param int     $post_ID Post ID.
 * @param WP_Post $post    Post object.
 * @param bool    $update  Whether this is an existing post being updated.
 */
function calculate_read_time( $post_ID, $post, $update ) {
	if ( 'post' === $post->post_type ) {
		$pattern = '/<!--.*?-->/U';
		$content = get_the_content( null, false, $post_ID );
		$content = esc_html( preg_replace( $pattern, '', $content ) );

		$word_count = str_word_count( $content );

		$words_per_minute = 225;
		$minutes          = ceil( $word_count / $words_per_minute );

		update_post_meta( $post_ID, 'estimated_read_time', $minutes );
	}
}
add_action( 'save_post', 'Propel\ReadTime\calculate_read_time', 10, 3 );
