<?php
/**
 * Main footer branding.
 *
 * @package Propel
 * @since   1.0
 */

?>

<div class="main-footer__branding">
	<?php
	if ( function_exists( 'get_field' ) ) {
		$f_logo = get_field( 'logo', 'footer' ) ?? '';
	}

	if ( ! empty( $f_logo ) ) :
		?>
		<div class="main-footer__logo">
			<?php
			if ( is_front_page() ) {
				?>
				<img class="style-svg" alt="<?php bloginfo( 'name' ); ?>" src="<?php echo esc_url( $f_logo ); ?>" />
				<?php
			} else {
				?>
				<a href="<?php echo esc_url( home_url() ); ?>" class="footer__logo" aria-label="return to the homepage">
					<img class="style-svg" alt="<?php bloginfo( 'name' ); ?>" src="<?php echo esc_url( $f_logo ); ?>" />
				</a>
				<?php
			}
			?>
		</div>
		<?php
	endif;
	?>

	<?php
	if ( function_exists( 'have_rows' ) && have_rows( 'footer_social', 'footer' ) ) :
		?>
		<div class="main-footer__social">
			<?php
			while ( have_rows( 'footer_social', 'footer' ) ) :
				the_row();

				$s_icon = get_sub_field( 'icon' ) ?? '';
				$s_link = get_sub_field( 'link' ) ?? '';

				if ( $s_link ) {
					$link_url   = $s_link['url'] ?? '';
					$link_title = $s_link['title'] ?? '';
					?>
						<a class="main-footer__social-link" href="<?php echo esc_url( $link_url ); ?>" target="_blank" aria-label="<?php echo esc_html( $link_title ); ?>">
						<?php echo wp_kses_post( '<i class="' . $s_icon . '"></i>' ); ?>
						</a>
						<?php
				}
				endwhile;
			?>
		</div>
		<?php
	endif;
	?>

</div>
