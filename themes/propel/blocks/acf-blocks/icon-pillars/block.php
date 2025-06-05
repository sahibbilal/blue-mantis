<?php
/**
 * Icon-Pillars
 *
 * Title:             Icon-Pillars
 * Description:       A block with flexible icon content and title.
 * Category:          Icon
 * Icon:              marker
 * Keywords:          icon, content, pillars
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

$allowed_blocks = array( 'acf/icon-pillar', 'acf/icon-pillar' );

$template = array(
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
		'acf/icon-pillar-contents',
	),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-icon-pillars<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="container block-icon-pillars__contents" />
</section>

<?php
