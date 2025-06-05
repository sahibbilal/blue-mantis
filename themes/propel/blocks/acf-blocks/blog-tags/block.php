<?php
/**
 * Blog-Tags
 *
 * Title:             Blog-Tags
 * Description:       Tag and social media link section for use on blog post footer.
 * Category:          Archive
 * Icon:              admin-post
 * Keywords:          blog, posts, profile, tag, tags, social, media
 * Post Types:        all
 * Multiple:          false
 * Active:            true
 * CSS Deps:          share-icons
 * JS Deps:           add-to-any
 * Global ACF Fields: background_color
 * InnerBlocks:       false
 * Mode:              preview
 * Styles:
 * Context:
 *
 * @package Propel
 * @since   2.1.2
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

global $post;

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-blog-tags<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<?php if ( ! empty( $post ) ) : ?>
		<?php
		if ( is_block_library() || is_theme_block() ) {
			$tags = array();

			for ( $i = 1; $i <= 4; $i++ ) {
				$fake_term           = new stdClass();
				$fake_term->name     = sprintf( 'Tag %s', $i );
				$fake_term->term_id  = 1;
				$fake_term->slug     = sprintf( 'tag-%s', $i );
				$fake_term->taxonomy = 'post_tag';
				$tags[]              = $fake_term;
			}
		} elseif ( ! empty( $post->post_type ) ) {
			$tags = wp_get_post_terms( $post->ID, $post->post_type . '_tag' );
		}
		?>

		<div class="container block-blog-tags__container">
			<div class="block-blog-tags__tag-col">
				<?php if ( ! empty( $tags ) ) : ?>
					<div class="block-blog-tags__tags-title"><?php esc_html_e( 'Tags', 'propel' ); ?></div>

					<div class="block-blog-tags__tags">
						<?php foreach ( $tags as $item ) : ?>
							<a class="block-blog-tags__tag" href="<?php echo esc_url( get_tag_link( $item ) ); ?>"><?php echo esc_html( $item->name ); ?></a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>

			<div class="block-blog-tags__social-col">
				<div class="block-blog-tags__tags-title"><?php esc_html_e( 'Share', 'propel' ); ?></div>

				<?php get_theme_part( '../blocks/components/share-icons/share-icons' ); ?>
			</div>
		</div>
	<?php endif; ?>
</section>
