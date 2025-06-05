<?php
/**
 * Hero-Post
 *
 * Title:             Hero-Post
 * Description:       Hero section for use on single blog posts.
 * Category:          Hero
 * Icon:              admin-post
 * Keywords:          blog, posts, profile, hero
 * Post Types:        all
 * Multiple:          false
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: background_image
 * InnerBlocks:       false
 * Mode:              preview
 * Styles:            Default, Full Background Image
 * Context:
 *
 * @package Propel
 * @since   2.1.2
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$background_image = get_field( 'background_image' );
$hero_button      = get_field( 'hero_button', get_the_ID() );

$block_classes = $content_block->get_block_classes( array( 'background_color' => 'dark' ) );

global $post;

if ( ! empty( $post ) ) {
	if ( is_block_library() || is_theme_block() ) {
		$primary_term      = __( 'Category', 'propel' );
		$author_name       = __( 'Firstname Lastname', 'propel' );
		$post->post_title  = __( 'Blog post title goes right here across two lines', 'propel' );
		$featured_image_id = 1;
	} else {
		$post_taxonomy = 'category';

		if ( 'news' === $post->post_type ) {
			$post_taxonomy = 'news_category';
		} elseif ( 'resource' === $post->post_type ) {
			$post_taxonomy = 'resource_type';
		} elseif ( 'event' === $post->post_type ) {
			$post_taxonomy = 'event_type';
		}

		$primary_term = get_yoast_primary_term( $post_taxonomy, $post->ID );

		$author_name = get_old_or_current_author_name( $post );

		$featured_image_id = get_post_thumbnail_id( $post );
	}

	if ( false !== strpos( $block_classes, 'is-style-full-background-image' ) ) {
		if ( ! empty( $featured_image_id ) ) {
			$background_image  = $featured_image_id;
			$featured_image_id = '';
		} else {
			$block_classes = str_replace( 'is-style-full-background-image', '', $block_classes );
		}
	}

	if ( 'event' === get_post_type() ) {
		$postDate = '';
	    if ( ! get_field( 'on_demand', $post->ID ) ) {
			$timezone = get_field( 'timezone', $post->ID );
		    $postDate = e29_get_event_date( $post->ID, array( 'day_format' => 'F j', 'timezone' => $timezone ) );
	    }
	} else {
		$postDate = get_the_date( 'F j, Y', $post );
	}

	if ( ! empty( $featured_image_id ) ) {
		$block_classes .= ' block-hero-post--featured-image';
	}
	
	$custom_bg_image = get_field( 'custom_background_image', get_the_ID() );
	do_action( 'qm/info', 'ID = ' . get_the_ID() . ', custom_bg_image = ' . $custom_bg_image . ', background_image = ' . $background_image . '' );
	if ( ! empty( $custom_bg_image ) ) {
		$background_image = $custom_bg_image;
	}
}

?>

<section <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-hero-post<?php echo esc_attr( $block_classes ); ?>">
	<?php if ( ! empty( $post ) ) : ?>
		<?php echo wp_kses_post( get_back_link() ); ?>

		<div class="container">
			<div class="row block-hero-post__row">
				<div class="col-12 col-md-10 col-lg-8">
					<?php if ( ! empty( $primary_term ) ) : ?>
						<div class="block-hero-post__primary-term">
							<?php echo wp_kses_post( $primary_term ); ?>
						</div>
					<?php endif; ?>

					<h1 class="block-hero-post__title"><?php echo esc_html( $post->post_title ); ?></h1>
					<?php if ( 'news' != $post->post_type ) : ?>
					<div class="block-hero-post__meta">
						<?php if ( 'resource' === get_post_type() ) : ?>
							<span><?php echo get_yoast_primary_term( 'resource_topic', $post->ID ); ?></span>
						<?php else : ?>
							<?php if ( ! empty( $author_name ) && 'event' !== get_post_type() ) : ?>
								<span><?php echo esc_html( __( sprintf( 'By %s', $author_name ), 'propel' ) ); ?></span>
							<?php endif; ?>

							<span><?php echo esc_html( $postDate ); ?></span>
						<?php endif; ?>
					</div>
					<?php endif; ?>
					<?php if ( ! empty( $hero_button ) ) : ?>
						<div class="wp-block-button">
							<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $hero_button['url'] ); ?>" target="<?php echo esc_attr( $hero_button['target'] ? $hero_button['target'] : '_self' ); ?>">
								<?php echo esc_html( $hero_button['title'] ); ?>
							</a>
						</div>
					<?php endif; ?>
				</div>

				<?php if ( ! empty( $featured_image_id ) && 'event' !== get_post_type() && 'resource' !== get_post_type() ) : ?>
					<div class="col-12">
						<figure class="block-hero-post__image-wrapper">
							<?php echo wp_kses_post( wp_get_attachment_image( $featured_image_id, 'col-12', '', array( 'class' => 'block-hero-post__image' ) ) ); ?>
						</figure>
					</div>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $background_image ) ) : ?>
		<?php echo wp_kses_post( wp_get_attachment_image( $background_image, 'full-width', '', array( 'class' => 'block-hero-post__background-image' ) ) ); ?>
	<?php endif; ?>
</section>
