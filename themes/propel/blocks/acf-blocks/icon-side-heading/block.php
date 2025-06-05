<?php
/**
 * Icon-Side-Heading
 *
 * Title:             Icon-Side-Heading
 * Description:       A block with flexible icon content blocks and a side heading.
 * Category:          Icon
 * Icon:              marker
 * Keywords:          icon, content, side, heading
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color, background_image
 * InnerBlocks:       true
 * Styles:
 * Default BG Color:
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$background_image = get_field( 'background_image' );

$allowed_blocks = array( 'acf/content', 'acf/icon-contents' );

$template = array(
	array(
		'acf/content',
		array(
			'className' => 'bg-dark',
		),
	),
	array(
		'acf/icon-contents',
	),
);

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-icon-side-heading<?php echo esc_attr( $content_block->get_block_classes( array( 'background_color' => 'none' ) ) ); ?>">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" templateLock="all" class="container block-icon-side-heading__container" />

	<?php if ( ! empty( $background_image ) ) : ?>
		<?php echo wp_kses_post( wp_get_attachment_image( $background_image, 'full-width', '', array( 'class' => 'block-icon-side-heading__background-image' ) ) ); ?>
	<?php endif; ?>
</section>

<?php
