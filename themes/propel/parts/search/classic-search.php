<?php
/**
 * The classic search partial.
 *
 * @package Propel
 * @since   1.0
 */

global $wp_query;

$search_query = get_search_query();
$current_page = get_query_var( 'paged' ) ? (int) get_query_var( 'paged' ) : 1;

get_template_part(
	'parts/search/hero',
	null,
	array(
		'search_query' => $search_query,
		'found_posts'  => $wp_query->found_posts,
	)
);
?>

<main class="content container bg-dark search-results__wrapper">
	<div class="row">
		<div class="col-12 col-md-10 mx-auto">
			<div class="search-results">
				<?php if ( have_posts() ) : ?>
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part(
							'parts/search/result',
							null,
							array(
								'img'     => wp_get_attachment_image( get_post_thumbnail_id(), 'thumbnail' ),
								'title'   => get_the_title(),
								'content' => get_the_excerpt(),
								'url'     => get_permalink(),
							)
						);
					endwhile;
					?>
				<?php else : ?>
					<?php render_theme_blocks( 'search_no_results' ); ?>
				<?php endif; ?>
			</div>

			<nav class="search-pagination">
				<?php
				if ( $wp_query->max_num_pages > 1 ) {
					get_template_part(
						'parts/global/pagination',
						null,
						array(
							'current_page'  => $current_page,
							'max_num_pages' => $wp_query->max_num_pages,
						)
					);
				}
				?>
			</nav>
		</div>
	</div>
</main>
