<?php
/**
 * Tab-Standard
 *
 * Title:             Tab-Standard
 * Description:       A block with tabbed content.
 * Category:          Tab
 * Icon:              icon829-tab
 * Keywords:          tab, tabs, standard
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color
 * InnerBlocks:       true
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = array( 'core/heading', 'core/paragraph', 'acf/tab-standard-tab' );

$template = array(
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
	array( 'acf/tab-standard-tab' ),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-tab-standard<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<div class="container">
		<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-tab-standard__content" />
	</div>
</section>

<?php
