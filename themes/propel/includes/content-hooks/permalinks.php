<?php
/**
 * Filters for the 829 Filters plugin.
 *
 * @package Propel
 * @since   2.1.1
 */

namespace Propel\Permalinks;

/*
 * Redirect blog pagination.
 */
function custom_rewrite_rules( $rules ) {
	$new_rules = array(
		'blog/page/?([0-9]{1,})/?$' => 'index.php?page_id=4405&activepage=$matches[1]',
		'resources/page/?([0-9]{1,})/?$' => 'index.php?page_id=4510&activepage=$matches[1]',
		'news/page/?([0-9]{1,})/?$' => 'index.php?page_id=4509&activepage=$matches[1]',
	);

	return array_merge( $new_rules, $rules );
}
add_filter( 'rewrite_rules_array', 'Propel\Permalinks\custom_rewrite_rules', 99999 );

/*
 * Adding custom query variable to be passed to 829 filters plugin.
 */
function custom_query_vars( $query_vars ) {
	$query_vars[] = 'activepage';

	return $query_vars;
}
add_filter( 'query_vars', 'Propel\Permalinks\custom_query_vars' );

/*
 * Establish redirects of pages if pagination number exceeds number of pages for blog posts and resources / news archive pages
 */
function redirect_excessive_pagination_number() {

	$active_page = get_query_var( 'activepage', false );
	$post_type = get_query_var( 'post_type', 'post' );
	
	if ( $active_page ) {
		global $wp_query;
		$max_pages = intval($wp_query->max_num_pages);
		$current_page = intval($active_page);
	
		if ($current_page > $max_pages && $max_pages !== 0) {
			if ($post_type === 'resource') {
				wp_redirect(home_url('/resources/'));
			} else if ($post_type === 'news') {
				wp_redirect(home_url('/news/'));
			} else {
				wp_redirect(home_url('/blog/'));
			}
			exit;
		}
	}
}
add_action('template_redirect', 'Propel\Permalinks\redirect_excessive_pagination_number');

/*
 * Changing canonical links for blog posts and resources / news archive pages
 */
function custom_change_canonical_url( $canonical ) {
	$active_page = get_query_var( 'activepage', false );
	$post_type = get_query_var( 'post_type', 'post' );

	if ( $active_page ) {
		$custom_canonical = '';

		$base_url = get_bloginfo('url');

		// Generate the canonical URL based on the active page
		if ( '4510' == get_the_ID() ) {
			$custom_canonical = trailingslashit($base_url) . 'resources/page/' . $active_page . '/';
		} else if ( '4509' == get_the_ID() ) {
				$custom_canonical = trailingslashit($base_url) . 'news/page/' . $active_page . '/';
		} else if ( '4405' == get_the_ID() ) {
			$custom_canonical = trailingslashit($base_url) . 'blog/page/' . $active_page . '/';
		}

		if ( '' !== $custom_canonical ) {
			return $custom_canonical;
		}
	}

	return $canonical;
}
add_filter( 'wpseo_canonical', 'Propel\Permalinks\custom_change_canonical_url', 10, 2 );

/*
 * Change rel next link for blog posts and resources archive pages
 */

function custom_change_next_link( $link ) {
	$active_page = get_query_var( 'activepage', false );
	$post_type = get_query_var( 'post_type', 'post' );

	if ( ! $active_page && '4405' != get_the_ID()  ) {
		return $link;
	}

	global $wp_query;

	if ( intval( $active_page ) >= intval( $wp_query->max_num_pages ) ) {
		return '';
	}

	$base_url = get_bloginfo('url');
	
	$next_link = '<link rel="next" href="' . trailingslashit($base_url) . 'blog/page/' . ( intval( $active_page ) + 1) . '/" />';

	return $next_link;

}
add_filter( 'wpseo_next_rel_link', 'Propel\Permalinks\custom_change_next_link', 10, 2 );

/** 
 * Add rel next link for resources /news page with 829 Filters
 */

function custom_next_link_resources() {
	$active_page = get_query_var( 'activepage', false );
	$post_id = get_the_ID();

	$resource_next_link = '';

	
	if ( ! $active_page &&  ! in_array( $post_id, [ '4510', '4509' ] )  ) {
		return;
	}

	if ( '4510' == get_the_ID() ) {
		$post_type = 'resource';
	} else if ( '4509' == get_the_ID() ) {
		$post_type = 'news';
	} else {
		return;
	}
	
	$resource_query = new \WP_Query( array(
		'post_type' => $post_type,
		'posts_per_page' => 12,
	) );

	$resource_max_num_pages = $resource_query->max_num_pages;
	
	if ( intval( $active_page ) >= intval( $resource_max_num_pages ) ) {
		return;
	}
	
	$base_url = get_bloginfo('url');
	
	$resource_next_link = '<link rel="next" href="' . trailingslashit($base_url) . $post_type . '/page/' . ( intval( $active_page ) + 1) . '/" />';
	
	echo $resource_next_link . "\n";
}
add_action( 'wp_head', 'Propel\Permalinks\custom_next_link_resources' );
