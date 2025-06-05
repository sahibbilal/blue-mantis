<?php
/**
 * Primary Nav Featured Post
 *
 * Title:             Primary Nav Featured Post
 * Description:       A block with a featured post in the primary nav mega menu.
 * Category:          Navigation
 * Icon:              menu
 * Keywords:          navigation, menu, primary, header, nav, item, mega, megamenu, page, image, post
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

$featured_post = get_field( 'featured_post' );

$allowed_blocks = array( 'core/heading' );

$template = array(
	array(
		'core/heading',
		array(
			'level'       => 2,
			'placeholder' => 'Add heading here.',
			'fontSize'    => 'overline',
		),
	),
);

?>

<div class="block-primary-nav-featured-post">
	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-primary-nav-featured-post__content" />

	<?php
	if ( ! empty( $featured_post ) && ! empty( $featured_post->post_type ) && file_exists( get_stylesheet_directory() . '/blocks/components/' . $featured_post->post_type . '-card/' . $featured_post->post_type . '-card.php' ) ) {
		wp_enqueue_style( $featured_post->post_type . '-card' );

		$card_args = array();

		if ( 'event' === $featured_post->post_type || 'news' === $featured_post->post_type ) {
			$card_args['show_image'] = false;
		}

		if ( 'news' === $featured_post->post_type ) {
			$card_args['show_excerpt'] = false;
		}

		get_theme_part( '../blocks/components/' . $featured_post->post_type . '-card/' . $featured_post->post_type . '-card', array_merge( array( 'card_post' => $featured_post ), $card_args ) );
	}
	?>
</div>

<?php
