<?php
/**
 * Stats
 *
 * Title:             Stats
 * Description:       Block with stats and descriptions.
 * Category:          Stat
 * Icon:              chart-bar
 * Keywords:          stats, statistics, numbers, data, results
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields:
 * InnerBlocks:       true
 * Parent:            acf/stat-strip, acf/stat-simple, acf/stat-supporting, acf/stat-image, core/column
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$block_id = $content_block->get_block_id();

$allowed_blocks = array( 'acf/stat' );

$template = array(
	array(
		'acf/stat',
	),
);

?>

<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-stats row" />

<?php
