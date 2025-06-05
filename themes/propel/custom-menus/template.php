<?php
/**
 * Menu Item Template: Menu Template
 *
 * @package Propel
 * @since   1.0
 */

$this_post_id = $p->ID;
?>

<a href="<?php the_field( 'menu_link', $this_post_id ); ?>"><?php echo esc_html( get_the_title( $this_post_id ) ); ?></a>
<?php if ( have_rows( 'mega_menu_columns', $this_post_id ) ) : ?>
	<div class="mega-menu-wrapper"><!-- Mega menu wrapper -->
		<div class="container"><!-- Mega menu container -->
			<div class="row"><!-- Mega menu row -->
			<?php
			while ( have_rows( 'mega_menu_columns', $this_post_id ) ) :
				the_row();
				$col_class = 'col-sm-3';
				$width     = get_sub_field( 'width' );
				if ( $width ) {
					$col_class = 'col-sm-' . $width;
				}
				?>
				<div class="<?php echo esc_attr( $col_class ); ?>"><!-- Mega menu column -->
				<?php if ( 'mmc_wp_menu' === get_row_layout() ) : ?>
						<?php the_sub_field( 'mm_wp_menu' ); ?>
					<?php elseif ( 'mmc_wp_content' === get_row_layout() ) : ?>
						<?php the_sub_field( 'mm_wp_content' ); ?>
					<?php endif; ?>
				</div><!-- End of mega menu column -->
			<?php endwhile; ?>
			</div><!-- End of mega menu row -->
		</div><!-- End of mega menu container -->
	</div><!-- End of mega menu wrapper -->
	<?php
endif;
