<?php
/**
 * Gets an event date.
 *
 * @package Propel
 * @since   2.0.0
 */

/**
 * Gets an event date.
 *
 * @param array $post_ID    The post ID.
 * @param array $args {
 *    Optional arguments.
 *
 *     @type string   $day_format           The format for the day. If start/end on the same day, the end doesn't render.
 *     @type string   $time_format          The format for the time.
 *     @type string   $day_time_separator   The separator between the day and the time.
 *     @type string   $date_separator       The separator between the dates.
 *     @type int|bool $start                Whether to display the start date.
 *                                          Accepts 1|true or 0|false. Default 1|true.
 *     @type int|bool $end                  Whether to display the end date.
 *                                          Accepts 1|true or 0|false. Default 1|true.
 * }
 *
 * @return string The date of the event.
 */
function e29_get_event_date( $post_ID = null, $args = array() ) {
	$defaults = array(
		'day_format'         => 'F j, Y',
		'time_format'        => 'g:ia',
		'day_time_separator' => ', ',
		'date_separator'     => ' - ',
		'start'              => true,
		'end'                => true,
		'timezone'           => 'EST',
	);

	$args = wp_parse_args( $args, $defaults );

	if ( empty( $post_ID ) ) {
		$post_ID = get_the_ID();
	}

	$output = '';

	$start_date = get_field( 'start_date', $post_ID );

	if ( ! empty( $start_date ) ) {
		$start      = $start_date;
		$start_time = get_field( 'start_time', $post_ID );
		$end_date   = get_field( 'end_date', $post_ID );

		if ( ! empty( $start_time ) ) {
			$start .= ' ' . $start_time;
		}

		if ( ! empty( $end_date ) ) {
			$end      = $end_date;
			$end_time = get_field( 'end_time', $post_ID );

			if ( ! empty( $end_time ) ) {
				$end .= ' ' . $end_time;
			}
		}

		if ( true === $args['start'] ) {
			$output .= date_i18n( $args['day_format'] . $args['day_time_separator'] . $args['time_format'], strtotime( $start ) );
		}

		if ( ! empty( $end ) && true === $args['end'] ) {
			if ( true === $args['start'] ) {
				$output .= $args['date_separator'];
			}

			$output .= date_i18n( $args['day_format'] . $args['day_time_separator'] . $args['time_format'], strtotime( $end ) );

			if ( $start_date === $end_date ) {
				$output = str_replace( $args['date_separator'] . date_i18n( $args['day_format'] . $args['day_time_separator'], strtotime( $end ) ), $args['date_separator'], $output );
			}
		}

		if ( ! empty( trim( $output ) ) ) {
			$output .= ' ' . $args['timezone'];
		}
	}

	return $output;
}
