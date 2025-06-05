<?php
/**
 * Cards-Speakers
 *
 * Title:             Our-Speakers
 * Description:       A block that displays cards from the people post type or custom people cards.
 * Category:          Card
 * Icon:              dashicons-groups
 * Keywords:          people, team, leader, department, speaker, speakers
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * InnerBlocks:       true
 * Styles:
 * Parent:
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = e29_text_blocks( 'acf/speakers-list' );

$template = array(
	array(
		'core/heading',
		array(
			'level'       => 2,
			'placeholder' => 'Add heading here.',
		),
	),
	array(
		'acf/speakers-list',
	),
);

$title_class = '';

$center_block_title = get_field( 'center_block_title' );
if ( $center_block_title ) {
	$title_class = ' block-our-speakers__title-centered';
}

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-our-speakers<?php echo esc_attr( $content_block->get_block_classes() ); echo esc_attr( $title_class ); ?>">
<div class="container block-our-speakers__container">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-our-speakers__wrapper" />
</div>
</section>

<?php
