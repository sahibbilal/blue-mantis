<?php
/**
 * Gated-Post-Form
 *
 * Title:             Gated-Post-Form
 * Description:       Content with a side form for gated content.
 * Category:          Content
 * Icon:              cover-image
 * Keywords:          content, gated, form
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:          marketo
 * JS Deps:           marketo-script, marketo
 * Global ACF Fields: scroll_id, background_color
 * InnerBlocks:       true
 * Styles:
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$form_embed_code = get_field( 'form_embed_code' );

$allowed_blocks = array( 'acf/content' );

$template = array(
	array(
		'acf/content',
		array(),
		array(
			array(
				'core/heading',
				array(
					'level'       => 2,
					'placeholder' => 'Add heading here.',
					'fontSize'    => 'lead-2',
				),
			),
			array(
				'core/paragraph',
				array(
					'placeholder' => 'Add text or additional blocks here.',
				),
			),
		),
	),
	array(
		'acf/content',
		array(),
		array(
			array(
				'core/heading',
				array(
					'level'       => 3,
					'placeholder' => 'Add heading here.',
				),
			),
			array(
				'acf/marketo-form',
			),
		),
	),
);

?>
<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-gated-post-form<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<div class="container">
		<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-gated-post-form__content" />
	</div>
</section>

<?php
