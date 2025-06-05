<?php
/**
 * Footer form.
 *
 * @package Propel
 * @since   1.0
 */

if ( function_exists( 'get_field' ) ) {
	$footer_signup = get_field( 'signup', 'footer' ) ?? '';
	$f_form_title  = get_field( 'form_title', 'footer' ) ?? '';
}

if ( ! empty( $footer_signup ) ) :
	?>
	<div class="main-footer__form">

		<?php if ( $f_form_title ) { ?>
			<h6 class="overline">
				<?php echo esc_html( $f_form_title ); ?>
			</h6>
		<?php } ?>

		<?php echo $footer_signup; //phpcs:ignore ?>

	</div>
	<?php
endif;
