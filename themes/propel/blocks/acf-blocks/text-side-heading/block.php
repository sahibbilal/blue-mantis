<?php
/**
 * Text-Side-Heading
 *
 * Title:             Text-Side-Heading
 * Description:       Text block with side heading column.
 * Category:          Text
 * Icon:              text
 * Keywords:          info, heading, paragraph, button, content, section, column, text
 * Post Types:        all
 * Multiple:          true
 * Active:            false
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
						'core/paragraph',
						array(
							'placeholder' => 'Add pre-heading here.',
							'fontSize'    => 'overline',
						),
					),
					array(
						'core/heading',
						array(
							'level'       => 2,
							'placeholder' => 'Add heading here.',
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
					array(
						'core/paragraph',
						array(
							'placeholder' => 'Add text or additional blocks here.',
						),
					),
				),
			),
		),
	),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-text-side-heading<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="container" />
</section>

<?php
