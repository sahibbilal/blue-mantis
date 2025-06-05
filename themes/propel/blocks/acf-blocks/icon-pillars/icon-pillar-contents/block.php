<?php
/**
 * Icon-Pillar-Contents
 *
 * Title:             Icon-Pillar-Contents
 * Description:       Wrapper for icon pillar blocks for use within parent icon pillars.
 * Category:          Icon
 * Icon:              marker
 * Keywords:          icon, content, pillar
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields:
 * Parent:            acf/icon-pillars
 * InnerBlocks:       true
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = array( 'acf/icon-pillar' );

$template = array(
	array(
		'acf/icon-pillar',
	),
);

?>
<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-icon-pillars__container" />

<?php
