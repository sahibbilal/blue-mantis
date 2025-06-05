<?php
/**
 * Footer copyright.
 *
 * @package Propel
 * @since   1.0
 */

if ( function_exists( 'get_field' ) ) {
	$f_address   = get_field( 'address', 'footer' ) ?? '';
	$f_copyright = get_field( 'copyright', 'footer' ) ?? '';
}

?>

<div class="main-footer__copyright">
	<ul class="caption">

		<li>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
			<?php
			if ( ! empty( $f_copyright ) ) {
				echo wp_kses_post( ' ' . $f_copyright ); }
			?>
		</li>

		<?php
		if ( function_exists( 'get_field' ) && get_field( 'terms_of_service', 'footer' ) ) {
			$ts_url = get_page_by_title( 'Terms of Service' ) ?? '';
			if ( $ts_url ) {
				$ts_url = $ts_url->ID ?? '';
				?>
				<li>
					<a href="<?php echo esc_url( get_permalink( $ts_url ) ); ?>">Terms of Service</a>
				</li>
				<?php
			}
		}
		?>

		<?php if ( function_exists( 'get_field' ) && get_field( 'privacy_policy', 'footer' ) ) { ?>
			<li>
				<?php $pp_url = get_privacy_policy_url() ?? '#'; ?>
				<a href="<?php echo esc_url( $pp_url ); ?>">Privacy Policy</a>
			</li>
		<?php } ?>

		<li>
			<a href="<?php echo esc_url( home_url() ); ?>">Home</a>
		</li>

		<li>
			<a href="https://829llc.com/" target="_blank">Website by 829</a>
		</li>
	</ul>
</div>
