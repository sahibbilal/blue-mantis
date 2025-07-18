<?php
/**
 * Text-Columns
 *
 * Title:             Text-Columns
 * Description:       Block with centered heading and adjustable columns of text.
 * Category:          Text
 * Icon:              text
 * Keywords:          info, heading, paragraph, button, content, section, column, columns, grid, text
 * Post Types:        all
 * Multiple:          true
 * Active:            true
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

$allowed_blocks = e29_text_blocks( array( 'core/columns' ) );

$template = array(
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Add pre-heading here.',
			'fontSize'    => 'overline',
			'align'       => 'center',
		),
	),
	array(
		'core/heading',
		array(
			'level'       => 2,
			'placeholder' => 'Add heading here.',
			'textAlign'   => 'center',
		),
	),
	array(
		'core/columns',
		array(
			'horizontalAlignment' => 'justify-content-center',
		),
		array(
			array(
				'core/column',
				array(
					'width' => '41.6666666667%',
				),
				array(
					array(
						'core/heading',
						array(
							'level'       => 3,
							'placeholder' => 'Add heading here.',
							'fontSize'    => 't4',
						),
					),
					array(
						'core/paragraph',
						array(
							'placeholder' => 'Add text or additional blocks here.',
							'fontSize'    => 'body-2',
						),
					),
				),
			),
			array(
				'core/column',
				array(
					'width' => '41.6666666667%',
				),
				array(
					array(
						'core/heading',
						array(
							'level'       => 3,
							'placeholder' => 'Add heading here.',
							'fontSize'    => 't4',
						),
					),
					array(
						'core/paragraph',
						array(
							'placeholder' => 'Add text or additional blocks here.',
							'fontSize'    => 'body-2',
						),
					),
				),
			),
		),
	),
	array(
		'core/columns',
		array(
			'horizontalAlignment' => 'justify-content-center',
		),
		array(
			array(
				'core/column',
				array(
					'width' => '41.6666666667%',
				),
				array(
					array(
						'core/heading',
						array(
							'level'       => 3,
							'placeholder' => 'Add heading here.',
							'fontSize'    => 't4',
						),
					),
					array(
						'core/paragraph',
						array(
							'placeholder' => 'Add text or additional blocks here.',
							'fontSize'    => 'body-2',
						),
					),
				),
			),
			array(
				'core/column',
				array(
					'width' => '41.6666666667%',
				),
				array(
					array(
						'core/heading',
						array(
							'level'       => 3,
							'placeholder' => 'Add heading here.',
							'fontSize'    => 't4',
						),
					),
					array(
						'core/paragraph',
						array(
							'placeholder' => 'Add text or additional blocks here.',
							'fontSize'    => 'body-2',
						),
					),
				),
			),
		),
	),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-text-columns<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="container" />
</section>

<?php
