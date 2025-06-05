<?php
/**
 * Hero-404
 *
 * Title:             Hero-404
 * Description:       Hero block for use on the 404 page.
 * Category:          Hero
 * Icon:              warning
 * Keywords:          hero, centered, 404
 * Post Types:        theme_block, library_block
 * Multiple:          false
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

$allowed_blocks = e29_text_blocks();

$template = array(
	array(
		'core/heading',
		array(
			'level'     => 1,
			'content'   => '404 Error',
			'fontSize'  => 't6',
			'textAlign' => 'center',
		),
	),
	array(
		'core/heading',
		array(
			'level'     => 1,
			'content'   => 'Oops, we can’t seem to find the page you are looking for',
			'fontSize'  => 't1',
			'textAlign' => 'center',
		),
	),
	array(
		'core/buttons',
		array(
			'layout' => array(
				'justifyContent' => 'center',
			),
		),
		array(
			array(
				'core/button',
				array(
					'className' => 'is-style-tertiary',
					'text'      => 'Go To Homepage',
					'url'       => home_url(),
				),
			),
			array(
				'core/button',
				array(
					'className' => 'is-style-tertiary',
				),
			),
		),
	),
);

?>
<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-hero-404<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="content-wrapper" />
</section>

<?php
