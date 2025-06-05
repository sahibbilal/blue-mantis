<?php
/**
 * Alert bar.
 *
 * @package Propel
 * @since   1.0
 */

if ( function_exists( 'get_field' ) ) {
	$alerts = get_field( 'alerts', 'header' );
}

$current_date = gmdate( 'YmdHi' );
$i            = 0;
?>

<?php if ( ! empty( $alerts ) ) : ?>
	<div id="e29-alert-bar" class="alert-bar">
		<?php foreach ( $alerts as $alert ) : ?>
			<?php
				$message    = $alert['message'];
				$bg_color   = $alert['bg_color'];
				$schedule   = $alert['schedule'];
				$start_date = $alert['start_date'];
				$end_date   = $alert['end_date'];
			?>

			<?php if ( ! $schedule || ( $current_date > $start_date && $current_date < $end_date ) ) : ?>
				<?php $i++; ?>
				<div id="alter-bar-<?php echo esc_attr( $i ); ?>" class="alert-bar__item viewed" data-current-date="<?php echo esc_attr( $current_date ); ?>" data-start-date="<?php echo esc_attr( $start_date ); ?>" data-end-date="<?php echo esc_attr( $end_date ); ?>"	
				<?php if ( $bg_color ) : ?>
					style="--alert-bg-color: <?php echo esc_attr( $bg_color ); ?>;"
				<?php endif; ?>
				>
					<div class="container">
						<div class="row">
							<div class="col-12">
								<div class="alert-bar__content">
									<div class="alert-bar__message">
										<?php echo wp_kses_post( $message ); ?>
									</div>

									<button class="alert-bar__close">
										<span class="sr-only">Close alert.</span>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
