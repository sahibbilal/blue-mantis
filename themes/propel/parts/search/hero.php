<?php
/**
 * The search page hero.
 *
 * @package Propel
 * @since   1.0
 */

$args = wp_parse_args(
	$args,
	array(
		'search_query' => '',
		'found_posts'  => 0,
	)
);

wp_enqueue_style( 'pagination' );
?>

<div class="search-hero bg-dark">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-10 mx-auto">
				<form action="/" method="GET" id="search-form">

					<?php if ( function_exists( 'wpes_use_autocomplete' ) && wpes_use_autocomplete() ) : ?>

						<div
							id="wpes-autocomplete"
							data-name="s"
							data-query="<?php echo esc_attr( $args['search_query'] ); ?>"
						></div>

					<?php else : ?>

						<div class="search-field">
							<input
								type="search"
								class="search-field__input"
								name="s"
								placeholder="Search"
								aria-label="Term to search"
								value="<?php echo esc_html( $args['search_query'] ); ?>"
							/>

							<button class="search-field__submit" type="submit" aria-label="<?php esc_html_e( 'Search this website', 'propel' ); ?>"></button>
						</div>

					<?php endif; ?>

				</form>

				<?php if ( ! empty( $args['search_query'] ) ) : ?>
					<p class="search-hero__results">
						<?php echo esc_html( $args['found_posts'] ); ?> results for "<?php echo esc_html( $args['search_query'] ); ?>"
					</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
