<?php
/**
 * Primary Nav Mega Menu
 *
 * Title:             Primary Nav Mega Menu
 * Description:       The mega menu dropdown in the primary nav.
 * Category:          Navigation
 * Icon:              menu
 * Keywords:          navigation, menu, primary, header, nav, item, mega, megamenu
 * Post Types:        theme_block
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields:
 * InnerBlocks:       true
 * Parent:            acf/primary-nav-item
 * Styles:            Default, Simple
 * Context:
 *
 * @package Propel
 * @since   2.0.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = array( 'acf/primary-nav-column', 'acf/primary-nav-featured-post' );

$template = array(
	array( 'acf/primary-nav-column' ),
);

?>


<div class="block-primary-nav-mega-menu<?php echo esc_attr( $content_block->get_block_classes() ); ?>"> 
	<div class="block-primary-nav-mega-menu__inner">
		<button class="block-primary-nav-mega-menu__back-button c-btn c-btn--tertiary c-btn--icon" aria-label="<?php esc_attr_e( 'Back', 'propel' ); ?>"><span class="icon icon-triangle-left"></span></button>

		<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-primary-nav-mega-menu__content" />
	</div>
</div>

<?php
