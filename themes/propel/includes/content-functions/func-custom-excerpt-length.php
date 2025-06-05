<?php
/**
 * Cuts string to given number of characters.
 *
 * @package Propel
 * @since   1.0
 */

/**
 * Cuts string to given number of characters.
 *
 * @param int    $charlength Number of characters.
 * @param string $string     The excerpt.
 * @return string Reduced string
 */
function custom_excerpt_length( $charlength, $string ) {

	if ( mb_strlen( $string ) > $charlength ) {
		$subex   = mb_substr( $string, 0, $charlength );
		$exwords = explode( ' ', $subex );
		$excut   = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );

		if ( $excut < 0 ) {
			$string = mb_substr( $subex, 0, $excut );
		} else {
			$string = $subex;
		}

		return $string . ' (...)';

	} else {

		return $string;

	}
}
