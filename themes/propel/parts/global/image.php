<?php
/**
 * The image partial.
 *
 * @package Propel
 * @since   1.0
 */

ksort( $sizes );

$image        = isset( $image ) ? $image : null;
$class        = isset( $class ) ? $class : '';
$sizes        = isset( $sizes ) && is_array( $sizes ) ? $sizes : null;
$default_size = ! empty( $sizes ) ? end( $sizes ) : null;
$lazyload     = isset( $lazyload ) ? $lazyload : false;

if ( ! empty( $image ) && ! empty( $sizes ) ) {
	?>
	<figure <?php echo ! empty( $class ) ? 'class="' . esc_attr( $class ) . '"' : ''; ?>>
	<picture>
		<?php foreach ( $sizes as $width => $size ) { ?>
		<source <?php echo $lazyload ? 'class="no-lazyload" ' : ''; ?>srcset="<?php echo isset( $image['sizes'][ $size ] ) ? esc_url( $image['sizes'][ $size ] ) : esc_url( $image['sizes']['large'] ); ?>" media="(min-width: <?php echo intval( $width ); ?>px)">
		<?php } ?>
		<img <?php echo $lazyload ? 'class="no-lazyload" ' : ''; ?>src="<?php echo isset( $image['sizes'][ $default_size ] ) ? esc_url( $image['sizes'][ $default_size ] ) : esc_url( $image['sizes']['large'] ); ?>" alt="<?php echo esc_html( $image['alt'] ); ?>">
	</picture>
	<?php if ( isset( $image['caption'] ) && ! empty( $image['caption'] ) ) { ?>
		<figcaption><?php echo esc_html( $image['caption'] ); ?></figcaption>
	<?php } ?>
	</figure>
	<?php
}
