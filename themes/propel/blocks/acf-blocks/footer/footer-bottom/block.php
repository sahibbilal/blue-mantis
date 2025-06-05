<?php
/**
 * Footer Bottom
 *
 * Title:             Footer Bottom
 * Description:       Block for use globally on the site footer.
 * Category:          Base
 * Icon:              info-outline
 * Keywords:          footer, global, address, logo, quick links, newsletter, copyright, social, bottom
 * Post Types:        all
 * Multiple:          false
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields:
 * InnerBlocks:       true
 * Parent:            acf/footer
 * Styles:
 * Context:
 *
 * @package Propel
 * @since   2.0.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = array( 'acf/content' );

$template = array(
	array(
		'acf/content',
		array(),
		array(
			array(
				'core/paragraph',
			),
		),
	),
	array(
		'acf/content',
		array(),
		array(
			array(
				'core/buttons',
				array(),
				array(
					array(
						'core/button',
						array(
							'className'  => 'is-style-social',
							'text'       => 'Connect on LinkedIn',
							'buttonIcon' => 'icon-linkedin',
						),
					),
					array(
						'core/button',
						array(
							'className'  => 'is-style-social',
							'text'       => 'Connect on Instagram',
							'buttonIcon' => 'icon-instagram',
						),
					),
				),
			),
		),
	),
);

?>

<div class="block-footer-bottom">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-footer-bottom__content" templateLock="false" />
</div>
