<?php
/**
 * The button parial.
 *
 * @package Propel
 * @since   1.0
 */

$default_classes = '';
$button          = isset( $button ) ? $button : null;
$class           = isset( $class ) ? $default_classes . ' ' . $class : $default_classes;

if ( ! empty( $button ) ) {
	?>
	<a class="<?php echo esc_attr( $class ); ?>" href="<?php echo esc_url( $button['url'] ); ?>" <?php echo ! empty( $button['target'] ) ? 'target="' . esc_attr( $button['target'] ) . '"' : ''; ?>><?php echo esc_html( $button['title'] ); ?></a>
	<?php
}
