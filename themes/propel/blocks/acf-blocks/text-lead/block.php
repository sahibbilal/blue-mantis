<?php
/**
 * Text-Lead
 *
 * Title:             Text-Lead
 * Description:       Block with centered text.
 * Category:          Text
 * Icon:              text
 * Keywords:          info, intro, heading, paragraph, button, content, section, text
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

$allowed_blocks = e29_text_blocks();

$template = array(
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Add pre-heading here.',
			'fontSize'    => 'overline',
			'align'       => 'center',
			'className'   => 'is-style-wide',
		),
	),
	array(
		'core/heading',
		array(
			'level'       => 2,
			'placeholder' => 'Add heading here.',
			'fontSize'    => 'lead-1',
			'textAlign'   => 'center',
			'className'   => 'is-style-wide',
		),
	),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-text-lead<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="content-wrapper" />
</section>

<?php
