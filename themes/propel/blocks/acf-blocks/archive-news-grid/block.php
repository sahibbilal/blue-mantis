<?php
/**
 * Archive-News-Grid
 *
 * Title:             Archive-News-Grid
 * Description:       Archive of news posts.
 * Category:          Archive
 * Icon:              dashicons-format-aside
 * Keywords:          news, archive, posts, grid, 829 filters
 * Post Types:        all
 * Multiple:          false
 * Active:            true
 * CSS Deps:          news-card, pagination, filter-checkbox
 * JS Deps:
 * Global ACF Fields:
 * InnerBlocks:       false
 * Mode:              preview
 * Styles:
 * Context:
 *
 * @package Propel
 * @since   2.1.1
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$tax_conditions  = is_tax() || is_category();
$this_taxonomy   = $tax_conditions ? get_queried_object()->taxonomy : '';
$term_id         = $tax_conditions ? get_queried_object()->term_id : '';
$display_sidebar = $tax_conditions ? 'false' : 'top';

?>

<section <?php echo wp_kses_post( $content_block->get_block_id_attr() ); ?>class="acf-block block-archive-news-grid<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<div class="container">
		<?php if ( is_admin() ) : ?>
			<div class="has-t-3-font-size"><?php esc_html_e( 'News posts will be displayed here.', 'propel' ); ?></div>
		<?php elseif ( class_exists( 'eight29_filters' ) ) : ?>
			<?php
			// Update the conditional and attributes as needed.
			// Full list of attributes here: https://bitbucket.org/829studios/829-blog-category-filters-react/src/master/.
			echo str_replace(
				'class="eight29-filters"',
				'id="eight29-filters" class="eight29-filters" data-activepage="' . get_query_var( 'activepage' ) . '"',
				do_shortcode( //phpcs:ignore
					'[eight29_filters
					post_type="news"
					display_sidebar="' . $display_sidebar . '"
					hide_uncategorized="true" 
					display_reset="false" 
					display_sort="false" 
					display_results="false" 
					display_post_counts="false" 
					posts_per_page="8" 
					posts_per_row="1" 
					display_search="true" 
					taxonomy="' . $this_taxonomy . '"
					term_id="' . $term_id . '"
					mobile_style="modal"
					pagination_style="links"
					]'
				)
			);
			?>
		<?php endif; ?>
	</div>
</section>
