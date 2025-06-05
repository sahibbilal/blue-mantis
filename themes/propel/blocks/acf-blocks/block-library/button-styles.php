<?php
/**
 * The button styles section for the block library.
 *
 * @package Propel
 * @since   2.2.0
 */

?>

<section class="block-library__buttons">
	<div class="container">
		<h2><?php esc_html_e( 'Button Styles', 'propel' ); ?></h2>
	</div>

	<?php for ( $section_index = 1; $section_index <= 2; $section_index++ ) : ?>
		<?php
		$grid_classes  = '';
		$section_style = __( '(Light)', 'propel' );

		if ( 2 === $section_index ) {
			$grid_classes  = ' bg-dark';
			$section_style = __( '(Dark)', 'propel' );
		}
		?>

		<div class="block-library__buttons-section<?php echo esc_attr( $grid_classes ); ?>">
			<div class="container">
				<h3 class="block-library__buttons-section-title"><?php esc_html_e( 'Primary/Secondary/Tertiary', 'propel' ); ?> <?php echo esc_html( $section_style ); ?></h3>

				<table class="block-library__buttons-table">
					<thead>
						<tr>
							<th><?php esc_html_e( 'Primary Default', 'propel' ); ?></th>
							<th><?php esc_html_e( 'Primary Hover', 'propel' ); ?></th>
							<th><?php esc_html_e( 'Secondary Default', 'propel' ); ?></th>
							<th><?php esc_html_e( 'Secondary Hover', 'propel' ); ?></th>
							<th><?php esc_html_e( 'Tertiary Default', 'propel' ); ?></th>
							<th><?php esc_html_e( 'Tertiary Hover', 'propel' ); ?></th>
						</tr>
					</thead>

					<tbody>
						<?php for ( $row_index = 1; $row_index <= 7; $row_index++ ) : ?>
							<tr>
								<?php for ( $column_index = 1; $column_index <= 6; $column_index++ ) : ?>
									<td>
										<?php
										$button_classes       = '';
										$button_title         = '';
										$button_icon          = '';
										$button_icon_position = '';
										$button_link_classes  = '';

										if ( 1 === $column_index ) {
											$button_title    = __( 'Primary', 'propel' );
											$button_classes .= ' is-style-primary';
										} elseif ( 2 === $column_index ) {
											$button_title         = __( 'Primary', 'propel' );
											$button_classes      .= ' is-style-primary';
											$button_link_classes .= ' hover';
										} elseif ( 3 === $column_index ) {
											$button_title    = __( 'Secondary', 'propel' );
											$button_classes .= ' is-style-secondary';
										} elseif ( 4 === $column_index ) {
											$button_title         = __( 'Secondary', 'propel' );
											$button_classes      .= ' is-style-secondary';
											$button_link_classes .= ' hover';
										} elseif ( 5 === $column_index ) {
											$button_title    = __( 'Tertiary', 'propel' );
											$button_classes .= ' is-style-tertiary';
										} elseif ( 6 === $column_index ) {
											$button_title         = __( 'Tertiary', 'propel' );
											$button_classes      .= ' is-style-tertiary';
											$button_link_classes .= ' hover';
										}

										if ( $row_index > 4 ) {
											$button_classes .= ' wp-block-button--small';
										}

										if ( 2 === $row_index || 6 === $row_index ) {
											$button_icon          = 'icon-triangle-right';
											$button_icon_position = 'right';
										} elseif ( 3 === $row_index || 7 === $row_index ) {
											$button_icon          = 'icon-triangle-left';
											$button_icon_position = 'left';
										} elseif ( 4 === $row_index ) {
											$button_classes      .= ' wp-block-button--hidden-label';
											$button_icon          = 'icon-triangle-right';
											$button_icon_position = 'right';
										}

										if ( $column_index >= 5 && 4 === $row_index ) {
											continue;
										}

										echo wp_kses_post(
											array_to_link(
												array(
													'title' => $button_title,
													'url' => '#',
												),
												$button_classes,
												array(
													'icon' => $button_icon,
													'icon_position' => $button_icon_position,
													'link_classes' => $button_link_classes,
												)
											)
										);
										?>
									</td>
								<?php endfor; ?>
							</tr>
						<?php endfor; ?>
					</tbody>
				</table>
			</div>
		</div>
	<?php endfor; ?>

	<?php for ( $section_index = 1; $section_index <= 2; $section_index++ ) : ?>
		<?php
		$grid_classes  = '';
		$section_style = __( '(Light)', 'propel' );

		if ( 2 === $section_index ) {
			$grid_classes  = ' bg-dark';
			$section_style = __( '(Dark)', 'propel' );
		}
		?>

		<div class="block-library__buttons-section<?php echo esc_attr( $grid_classes ); ?>">
			<div class="container block-library__grid-container">
				<div class="block-library__half-section">
					<h3 class="block-library__buttons-section-title"><?php esc_html_e( 'Slider Arrows', 'propel' ); ?> <?php echo esc_html( $section_style ); ?></h3>

					<table class="block-library__buttons-table">
						<thead>
							<tr>
								<th><?php esc_html_e( 'Primary Default', 'propel' ); ?></th>
								<th><?php esc_html_e( 'Primary Hover', 'propel' ); ?></th>
								<th><?php esc_html_e( 'Secondary Default', 'propel' ); ?></th>
								<th><?php esc_html_e( 'Secondary Hover', 'propel' ); ?></th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td>
									<button type="button" class="slick-prev slick-arrow"><?php esc_html_e( 'Previous', 'propel' ); ?></button>
								</td>
								<td>
									<button type="button" class="slick-prev slick-arrow hover"><?php esc_html_e( 'Previous', 'propel' ); ?></button>
								</td>
								<td>
									<button type="button" class="slick-prev slick-arrow--secondary slick-arrow"><?php esc_html_e( 'Previous', 'propel' ); ?></button>
								</td>
								<td>
									<button type="button" class="slick-prev slick-arrow--secondary slick-arrow hover"><?php esc_html_e( 'Previous', 'propel' ); ?></button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="block-library__half-section">
					<h3 class="block-library__buttons-section-title"><?php esc_html_e( 'Play Buttons', 'propel' ); ?> <?php echo esc_html( $section_style ); ?></h3>

					<table class="block-library__buttons-table">
						<thead>
							<tr>
								<th><?php esc_html_e( 'Primary Default', 'propel' ); ?></th>
								<th><?php esc_html_e( 'Primary Hover', 'propel' ); ?></th>
								<th><?php esc_html_e( 'Secondary Default', 'propel' ); ?></th>
								<th><?php esc_html_e( 'Secondary Hover', 'propel' ); ?></th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td>
									<button type="button" class="c-btn c-btn--play" aria-label="<?php esc_html_e( 'Play', 'propel' ); ?>"></button>
								</td>
								<td>
									<button type="button" class="c-btn c-btn--play hover" aria-label="<?php esc_html_e( 'Play', 'propel' ); ?>"></button>
								</td>
								<td>
									<button type="button" class="c-btn c-btn--secondary c-btn--play" aria-label="<?php esc_html_e( 'Play', 'propel' ); ?>"></button>
								</td>
								<td>
									<button type="button" class="c-btn c-btn--secondary c-btn--play hover" aria-label="<?php esc_html_e( 'Play', 'propel' ); ?>"></button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	<?php endfor; ?>

	<?php for ( $section_index = 1; $section_index <= 2; $section_index++ ) : ?>
		<?php
		$grid_classes  = '';
		$section_style = __( '(Light)', 'propel' );

		if ( 2 === $section_index ) {
			$grid_classes  = ' bg-dark';
			$section_style = __( '(Dark)', 'propel' );
		}
		?>

		<div class="block-library__buttons-section<?php echo esc_attr( $grid_classes ); ?>">
			<div class="container block-library__grid-container">
				<div class="block-library__half-section">
					<h3 class="block-library__buttons-section-title"><?php esc_html_e( 'Close Buttons', 'propel' ); ?> <?php echo esc_html( $section_style ); ?></h3>

					<table class="block-library__buttons-table">
						<thead>
							<tr>
								<th><?php esc_html_e( 'Default', 'propel' ); ?></th>
								<th><?php esc_html_e( 'Hover', 'propel' ); ?></th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td>
									<button type="button" class="c-btn--close" aria-label="<?php esc_html_e( 'Close', 'propel' ); ?>"></button>
								</td>
								<td>
									<button type="button" class="c-btn--close hover" aria-label="<?php esc_html_e( 'Close', 'propel' ); ?>"></button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="block-library__half-section block-library__social-buttons-section">
					<h3 class="block-library__buttons-section-title"><?php esc_html_e( 'Social Buttons', 'propel' ); ?> <?php echo esc_html( $section_style ); ?></h3>

					<table class="block-library__buttons-table">
						<thead>
							<tr>
								<th><?php esc_html_e( 'Default', 'propel' ); ?></th>
								<th><?php esc_html_e( 'Hover', 'propel' ); ?></th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<?php for ( $column_index = 1; $column_index <= 2; $column_index++ ) : ?>
									<td>
										<div class="wp-block-buttons">
											<?php for ( $button_index = 1; $button_index <= 5; $button_index++ ) : ?>
												<?php
												$button_title        = '';
												$button_icon         = '';
												$button_link_classes = '';

												if ( 1 === $button_index ) {
													$button_title = __( 'Visit us on Facebook', 'propel' );
													$button_icon  = 'icon-facebook';
												} elseif ( 2 === $button_index ) {
													$button_title = __( 'Visit us on Instagram', 'propel' );
													$button_icon  = 'icon-instagram';
												} elseif ( 3 === $button_index ) {
													$button_title = __( 'Visit us on LinkedIn', 'propel' );
													$button_icon  = 'icon-linkedin';
												} elseif ( 4 === $button_index ) {
													$button_title = __( 'Visit us on Twitter', 'propel' );
													$button_icon  = 'icon-social-x';
												} elseif ( 5 === $button_index ) {
													$button_title = __( 'Permalink', 'propel' );
													$button_icon  = 'icon-link';
												}

												if ( 2 === $column_index ) {
													$button_link_classes = 'hover';
												}

												echo wp_kses_post(
													array_to_link(
														array(
															'title' => $button_title,
															'url' => '#',
														),
														'is-style-social',
														array(
															'icon' => $button_icon,
															'link_classes' => $button_link_classes,
														)
													)
												);
												?>
											<?php endfor; ?>
										</div>
									</td>
								<?php endfor; ?>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	<?php endfor; ?>
</section>
