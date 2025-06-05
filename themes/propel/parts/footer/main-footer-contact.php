<?php
/**
 * Footer menu.
 *
 * @package Propel
 * @since   1.0
 */

if ( function_exists( 'get_field' ) ) {
	$f_col_two_links = get_field( 'col_two_links', 'footer' ) ?? '';
}

if ( ! empty( $f_col_two_links ) ) :
	?>
	<div class="main-footer__contact">
		<?php
		$f_col_two_title = get_field( 'col_two_title', 'footer' ) ?? '';

		if ( ! empty( $f_col_two_title ) ) {
			?>
			<h6 class="overline">
				<?php echo wp_kses_post( $f_col_two_title ); ?>
			</h6>
			<?php
		}
		foreach ( $f_col_two_links as $f_col_two_link ) {
			$f_col_two_link = $f_col_two_link['link'] ?? '';
			if ( $f_col_two_link ) {
				$fct_link_url    = $f_col_two_link['url'] ?? '';
				$fct_link_title  = $f_col_two_link['title'] ?? '';
				$fct_link_target = $f_col_two_link['target'] ? $f_col_two_link['target'] : '_self';
				?>
				<a class="main-footer__menu-item" href="<?php echo esc_url( $fct_link_url ); ?>" target="<?php echo esc_attr( $fct_link_target ); ?>">
					<?php echo esc_html( $fct_link_title ); ?>
				</a>
				<?php
			}
		}
		?>
	</div>
	<?php
endif;
