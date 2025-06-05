<?php
/**
 * The pagination partial.
 *
 * @package Propel
 * @since   1.0
 */

$args = wp_parse_args(
	$args,
	array(
		'current_page'  => 0,
		'max_num_pages' => 1,
		'base_url'      => get_home_url( null, '/search/' . rawurlencode( get_search_query() ) ),
		'page_prefix'   => '/page/',
	)
);

if ( $args['max_num_pages'] > 1 ) :
	$current_page  = (int) $args['current_page'];
	$max_num_pages = (int) $args['max_num_pages'];

	$pagination_range = get_pagination_array( $current_page, $max_num_pages );
	?>

	<ul class="pagination">
		<li class="pagination__list">
			<ul>
				<?php
				foreach ( $pagination_range as $page_number ) {
					if ( is_numeric( $page_number ) ) {
						$href    = 1 === $page_number ? $args['base_url'] : $args['base_url'] . $args['page_prefix'] . $page_number;
						$current = $page_number === $current_page ? ' current-page' : '';
						?>

						<li>
							<a class="pagination__item<?php echo esc_attr( $current ); ?>" href="<?php echo esc_url( $href ); ?>"><?php echo esc_html( $page_number ); ?></a>
						</li>

						<?php
					} else { // Ellipses.
						?>

						<li class="pagination__item pagination__item--ellipses">
							<span class="pagination__item-inner"><?php echo esc_html( $page_number ); ?></span>
						</li>

						<?php
					}
				}
				?>
			</ul>
		</li>
	</ul>

	<?php
endif;
