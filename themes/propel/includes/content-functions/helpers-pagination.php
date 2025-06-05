<?php
/**
 * Functions relating to pagination.
 *
 * @package Propel
 * @since   1.0
 */

/**
 * Get Pagination Array
 *
 * Builds an array of page numbers and ellipses to be used for pagination.
 *
 * @param  int $current   Current page number.
 * @param  int $max       Max pages.
 * @param  int $delta     Number of pages to show left/right of the current page.
 * @return array             Array of numbers/ellipses used for building out paginations.
 */
function get_pagination_array( int $current, int $max, int $delta = 1 ) : array {
	$left          = $current - $delta;
	$right         = $current + $delta;
	$last_page_run = 0;

	// Build number range.
	for ( $i = 1; $i <= $max; $i++ ) {
		if ( 1 === $i || $i === $max || $i >= $left && $i <= $right ) {
			$range[] = $i;
		}
	}

	// Build the range with ellipses.
	foreach ( $range as $page ) {
		if ( $last_page_run ) {
			$gap_from_prev = $page - $last_page_run;

			if ( 2 === $gap_from_prev ) {
				// If there's only one number between the gap, just add in the extra number.
				$ellipses_range[] = $last_page_run + 1;
			} elseif ( $gap_from_prev > 2 ) {
				$ellipses_range[] = '&hellip;';
			}
		}

		$ellipses_range[] = $page;
		$last_page_run    = $page;
	}

	return $ellipses_range;
}
