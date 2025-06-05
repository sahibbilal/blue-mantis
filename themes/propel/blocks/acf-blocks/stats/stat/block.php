<?php
/**
 * Stat
 *
 * Title:             Stat
 * Description:       Stat items inner block.
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
 * Parent:            acf/stats
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$block_id = $content_block->get_block_id();

$allowed_blocks = e29_text_blocks();

$template = array(
	array(
		'core/paragraph',
		array(
			'placeholder' => '100%',
		),
	),
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Stat description',
		),
	),
);

?>

<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" templateLock="all" class="block-stat col-12" />

<?php
