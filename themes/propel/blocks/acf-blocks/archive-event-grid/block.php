<?php
/**
 * Archive-Event-Grid
 *
 * Title:             Archive-Event-Grid
 * Description:       Archive of event posts.
 * Category:          Archive
 * Icon:              dashicons-calendar-alt
 * Keywords:          event, archive, posts, grid, 829 filters
 * Post Types:        all
 * Multiple:          false
 * Active:            true
 * CSS Deps:          event-card, pagination, filter-checkbox
 * JS Deps:
 * Global ACF Fields:
 * InnerBlocks:       true
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


$allowed_blocks = e29_text_blocks();

$template = array(
	array(
		'core/heading',
		array(
			'level'       => 2,
			'placeholder' => 'Add heading here.',
		),
	),
);

$exclude_posts = array(11403, 11401);
global $upcoming_events_list;
if ( isset( $upcoming_events_list ) && ! empty( $upcoming_events_list ) ) {
	$exclude_posts = array_merge( $exclude_posts, $upcoming_events_list );
}

?>

<section <?php echo wp_kses_post( $content_block->get_block_id_attr() ); ?>class="acf-block block-archive-event-grid<?php echo esc_attr( $content_block->get_block_classes(array( 'background_color' => 'black' ) ) ); ?>">
	<div class="container">
		<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-archive-event-grid__content bg-black" />

		<?php if ( is_admin() ) : ?>
			<div class="has-t-3-font-size bg-black"><?php esc_html_e( 'Event posts will be displayed here.', 'propel' ); ?></div>
		<?php elseif ( class_exists( 'eight29_filters' ) ) : ?>
			<?php
			// Update the conditional and attributes as needed.
			// Full list of attributes here: https://bitbucket.org/829studios/829-blog-category-filters-react/src/master/.
			echo do_shortcode( //phpcs:ignore
				'[eight29_filters
				post_type="event"
				display_sidebar="' . $display_sidebar . '"
				hide_uncategorized="true" 
				display_reset="false" 
				display_sort="false" 
				display_results="true" 
				display_post_counts="false" 
				posts_per_page="8" 
				posts_per_row="3" 
				display_search="true" 
				taxonomy="' . $this_taxonomy . '"
				term_id="' . $term_id . '"
				exclude_posts="' . implode( ',', $exclude_posts ) .'"
				]'
			);
			?>
		<?php endif; ?>
	</div>
</section>
