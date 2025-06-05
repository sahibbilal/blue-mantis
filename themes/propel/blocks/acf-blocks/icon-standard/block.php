<?php
/**
 * Icon-Standard
 *
 * Title:             Icon-Standard
 * Description:       A block with flexible icon content blocks.
 * Category:          Icon
 * Icon:              marker
 * Keywords:          icon, content, standard
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color
 * InnerBlocks:       true
 * Styles:
 * Default BG Color:
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = e29_text_blocks( array( 'acf/icon-contents', 'acf/icon-cards' ) );

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
			'fontSize'    => 't2',
			'textAlign'   => 'center',
		),
	),
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Add text or additional blocks here.',
			'align'       => 'center',
		),
	),
	array(
		'acf/icon-contents',
		array(),
		array(
			array(
				'acf/icon-content',
			),
		),
	),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-icon-standard<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="container block-icon-standard__container" />
</section>

<?php
