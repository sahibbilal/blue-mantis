<?php
/**
 * Stat-Strip
 *
 * Title:             Stat-Strip
 * Description:       Block with row of stats.
 * Category:          Stat
 * Icon:              chart-bar
 * Keywords:          stats, statistics, numbers, data, results, strip
 * Post Types:        all
 * Multiple:          true
 * Active:            false
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color
 * InnerBlocks:       true
 * Styles:
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = array( 'acf/stats' );

$template = array(
	array( 'acf/stats' ),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-stat-strip<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="container block-stat-strip__container" />
</section>

<?php
