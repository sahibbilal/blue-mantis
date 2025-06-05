<?php
/**
 * Primary Nav Column
 *
 * Title:             Primary Nav Column
 * Description:       A column of links in the primary nav mega menu.
 * Category:          Navigation
 * Icon:              menu
 * Keywords:          navigation, menu, primary, header, nav, item, mega, megamenu, column, links
 * Post Types:        theme_block
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields:
 * InnerBlocks:       true
 * Parent:            acf/primary-nav-mega-menu
 * Styles:
 * Context:
 *
 * @package Propel
 * @since   2.0.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = array( 'acf/primary-nav-link', 'core/heading', 'core/button' );

$template = array(
	array(
		'core/heading',
		array(
			'level'       => 2,
			'placeholder' => 'Add heading here.',
			'fontSize'    => 'overline',
		),
	),
	array(
		'acf/primary-nav-link',
	),
	array(
		'core/button',
		array(
			'className'  => 'is-style-tertiary',
			'buttonIcon' => 'icon-triangle-right',
		),
	),
);

?>

<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-primary-nav-column" />

<?php
