<?php
/**
 * Hidden events functionality.
 *
 * @package Propel
 * @since   2.0.0
 */


/**
 * Update Query to exclude hidden events.
 * Skip if on single post page.
 *
 * @param WP_Query $query The query object.
 * @return void
 */
function setup_hidden_events( $query ) {
	if ( ! $query->is_single() ) {

		$excluded_posts = $query->get( 'post__not_in' );
		$to_exclude = get_option( 'hidden_events', [] );
		if ( ! empty( $to_exclude ) ) {
			$query->set( 'post__not_in', array_merge( $excluded_posts, $to_exclude ) );
		}
	}		
}
add_action('pre_get_posts', 'setup_hidden_events');

/**
 * Update list of hidden events. Store it options.
 * Runs upon event save.
 *
 * @param int $post_id The ID of the post.
 * @param WP_Post $post The post object.
 * @param bool $update The update flag.
 * @return void
 */
function update_hidden_events_option( $post_id, $post, $update ) {

    if ( $post->post_type !== 'event' ) {
		return;
	}
	
	$is_hidden = get_field( 'is_hidden', $post_id ) ?? false;
	$hidden_events = get_option( 'hidden_events', [] );
	
	if ( $is_hidden && ! in_array( $post_id, $hidden_events, true ) ) {
		$hidden_events[] = $post_id;
		update_option( 'hidden_events', $hidden_events );
	}

	if ( ! $is_hidden && in_array( $post_id, $hidden_events ) ) {
		$hidden_events = array_diff( $hidden_events, [ $post_id ] );
		update_option( 'hidden_events', $hidden_events, true );
	}
}
add_action( 'save_post', 'update_hidden_events_option', 10, 3 );
