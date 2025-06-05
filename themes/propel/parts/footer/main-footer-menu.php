<?php
/**
 * Footer menu.
 *
 * @package Propel
 * @since   1.0
 */

?>

<div class="main-footer__menu">
	<?php
	if ( function_exists( 'get_field' ) ) {
		$f_col_one_title = get_field( 'col_one_title', 'footer' ) ?? '';
	}

	if ( ! empty( $f_col_one_title ) ) {
		?>
		<h6 class="overline">
			<?php echo wp_kses_post( $f_col_one_title ); ?>
		</h6>
		<?php
	}

	wp_nav_menu(
		array(
			'theme_location' => 'footer_nav',
			'container'      => false,
			'depth'          => 1,
		)
	);
	?>
</div>
