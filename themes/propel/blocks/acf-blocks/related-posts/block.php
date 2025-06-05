<?php
/**
 * Related-Posts
 *
 * Title:             Related-Posts
 * Description:       Block displaying post cards.
 * Category:          Archive
 * Icon:              admin-post
 * Keywords:          blog, post, card, related, news, resource, event
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color
 * InnerBlocks:       true
 * Default BG Color:  neutral-98
 * Styles:
 * Context:
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$post_types = get_field( 'post_types' );

$allowed_blocks         = array( 'core/heading', 'core/buttons' );
$args['posts_per_page'] = 3;
$grid_classes           = '';

if ( ! empty( $post_types ) ) :

	if ( in_array( 'post', $post_types, true ) ) {
		$show_featured_post = get_field( 'show_featured_post' );

		if ( ! empty( $show_featured_post ) ) {
			$grid_classes  = ' block-related-posts__post-grid--featured';
			$featured_post = get_field( 'featured_post' );

			if ( empty( $featured_post ) ) {
				$args['posts_per_page'] = 4;
			} else {
				$args['post__not_in'] = array( $featured_post->ID );
			}
		}
	}

	$card_posts = get_block_related_posts( $args );

	$template = array(
		array(
			'core/heading',
			array(
				'level'       => 2,
				'placeholder' => 'Add heading here.',
				'fontSize'    => 't2',
			),
		),
		array(
			'core/buttons',
			array(),
			array(
				array(
					'core/button',
					array(
						'className'  => 'is-style-tertiary',
						'buttonIcon' => 'icon-triangle-right',
					),
				),
			),
		),
	);

	?>

	<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-related-posts<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
		<div class="container">
			<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" templateLock="all" class="block-related-posts__top" />

			<?php if ( ! empty( $card_posts ) ) : ?>
				<div class="block-related-posts__post-grid<?php echo esc_attr( $grid_classes ); ?>">
					<?php
					if ( ! empty( $show_featured_post ) ) {
						if ( empty( $featured_post ) && ! empty( $card_posts[0] ) ) {
							$featured_post = $card_posts[0];

							unset( $card_posts[0] );
						}

						if ( ! empty( $featured_post ) ) {
							get_theme_part(
								'../blocks/components/post-card/post-card',
								array(
									'card_post'  => $featured_post,
									'image_size' => 'col-8',
								)
							);
						}
					}
					?>

					<?php
					foreach ( $card_posts as $card_post ) {
						if ( ! empty( $card_post ) && ! empty( $card_post->post_type ) && file_exists( get_stylesheet_directory() . '/blocks/components/' . $card_post->post_type . '-card/' . $card_post->post_type . '-card.php' ) ) {
							wp_enqueue_style( $card_post->post_type . '-card' );

							$card_args = array();

							if ( 'event' === $card_post->post_type || 'news' === $card_post->post_type || ! empty( $show_featured_post ) ) {
								$card_args['show_image'] = false;
							}

							if ( 'news' === $card_post->post_type ) {
								$card_args['show_excerpt'] = false;
							}

							get_theme_part( '../blocks/components/' . $card_post->post_type . '-card/' . $card_post->post_type . '-card', array_merge( array( 'card_post' => $card_post ), $card_args ) );
						}
					}
					?>
				</div>
			<?php endif; ?>
		</div>
	</section>

<?php endif;
