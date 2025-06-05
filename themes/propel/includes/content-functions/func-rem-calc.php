<?php
/**
 * Get the rem value of a number of pixels.
 *
 * @package Propel
 * @since   1.0
 */

/**
 * Get the rem value of a number of pixels.
 *
 * @param int|string $value The pixels to be converted to rems.
 */
function rem_calc( $value ) {
	return intval( $value ) / 16 . 'rem';
}
