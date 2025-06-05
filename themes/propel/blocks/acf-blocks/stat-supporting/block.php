<?php
/**
 * Stat-Supporting
 *
 * Title:             Stat-Supporting
 * Description:       Block with text and stat columns.
 * Category:          Stat
 * Icon:              chart-bar
 * Keywords:          stats, statistics, numbers, data, results, supporting
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color
 * InnerBlocks:       true
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = e29_text_blocks();

$template = array(
	array(
		'core/columns',
		array(),
		array(
			array(
				'core/column',
				array(
					'width' => '41.6666667%',
				),
				array(
					array(
						'core/heading',
						array(
							'level'       => 2,
							'placeholder' => 'Add heading here.',
						),
					),
					array(
						'core/paragraph',
						array(
							'placeholder' => 'Add text or additional blocks here.',
						),
					),
					array(
						'core/button',
						array(
							'className' => 'is-style-tertiary',
						),
					),
				),
			),
			array(
				'core/column',
				array(
					'width' => '50%',
				),
				array(
					array( 'acf/stats' ),
				),
			),
		),
	),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-stat-supporting<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="container" />
</section>

<?php
