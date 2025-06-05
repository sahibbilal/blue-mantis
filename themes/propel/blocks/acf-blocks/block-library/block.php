<?php
/**
 * Block Library
 *
 * Title:             Block Library
 * Description:       Displays all block library blocks with sortable interface..
 * Category:          Base
 * Icon:              block-default
 * Keywords:          block, library, stylesheet
 * Post Types:        none
 * Multiple:          false
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color
 * Mode:              preview
 *
 * @package Propel
 * @since   2.2.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$section_classes = '';

$args = array(
	'post_type'      => 'library_block',
	'post_status'    => array( 'publish' ),
	'posts_per_page' => -1,
	'order'          => 'ASC',
	'orderby'        => 'title',
);

$block_types          = acf_get_block_types();
$block_categories     = get_block_categories( false );
$all_block_categories = array();

if ( ! empty( $block_categories ) ) {
	foreach ( $block_categories as $block_category ) {
		if ( ! empty( $block_category['slug'] ) && ! empty( $block_category['title'] ) ) {
			$all_block_categories[ $block_category['slug'] ] = $block_category['title'];
		}
	}
}

$block_posts = get_posts( $args );

if ( ! empty( $block_posts ) ) : ?>
	<?php
	$filter_data = array(
		'core'         => array(),
		'hero'         => array(),
		'text'         => array(),
		'accordion'    => array(),
		'tab'          => array(),
		'media'        => array(),
		'content'      => array(),
		'stat'         => array(),
		'logo'         => array(),
		'testimonials' => array(),
		'icon'         => array(),
		'card'         => array(),
		'cta'          => array(),
	);
	$block_data  = array();

	foreach ( $block_posts as $block_post ) {
		$assign_to_core_category = true;
		$visibility              = 'hidden';

		if ( ! empty( $block_post->post_content ) ) {
			if ( empty( $_GET ) || ( ! empty( $_GET[ $block_post->ID ] ) && 'v' === $_GET[ $block_post->ID ] ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended
				$visibility       = 'visible';
				$section_classes .= ' visible-' . $block_post->ID;
			}

			if ( false !== strpos( $block_post->post_content, 'acf/' ) && ! empty( $block_types ) ) {
				$this_post_blocks = e29_parse_reusable_blocks( parse_blocks( $block_post->post_content ) );

				foreach ( $this_post_blocks as $this_post_block ) {
					if ( ! empty( $this_post_block['blockName'] ) && 'acf/content-section' === $this_post_block['blockName'] ) {
						$this_post_blocks = e29_parse_inner_blocks( $this_post_blocks );
						break;
					}
				}

				$this_post_block_keys = array_map(
					function( $this_block ) {
						if ( ! empty( $this_block['blockName'] ) ) {
							return $this_block['blockName'];
						}
					},
					$this_post_blocks
				);

				if ( ! empty( $this_post_block_keys ) ) {
					foreach ( $this_post_block_keys as $block_key ) {
						if ( 'acf/content-section' === $block_key || 'core/spacer' === $block_key ) {
							continue;
						}

						if ( ! empty( $block_types[ $block_key ] ) && ! empty( $block_types[ $block_key ]['category'] ) ) {
							$category = $block_types[ $block_key ]['category'];

							if ( 'etn-blocks' === $category ) {
								$category = 'uncategorized';
							}

							$block_data[ $block_post->ID ] = array(
								'post' => $block_post,
							);

							$filter_data[ $category ][ $block_post->ID ] = array(
								'post' => $block_post,
							);

							if (
								! isset( $block_data[ $block_post->ID ]['active'] ) &&
								(
									! isset( $block_types[ $block_key ]['active'] ) ||
									(
										true !== $block_types[ $block_key ]['active'] &&
										'true' !== $block_types[ $block_key ]['active']
									)
								)
							) {
								$block_data[ $block_post->ID ]['active']               = false;
								$filter_data[ $category ][ $block_post->ID ]['active'] = false;
							} else {
								$block_data[ $block_post->ID ]['active'] = true;
							}

							$filter_data[ $category ][ $block_post->ID ]['visibility'] = $visibility;

							$assign_to_core_category = false;
						} elseif ( false === strpos( $block_key, 'acf/' ) && false !== strpos( $block_post->post_title, 'Core' ) ) {
							$assign_to_core_category = true;
						} else {
							$assign_to_core_category = false;
						}
					}
				}
			} elseif ( false !== strpos( $block_post->post_content, 'wp:table' ) ) {
				$block_data[ $block_post->ID ] = array(
					'post' => $block_post,
				);

				$filter_data['content'][ $block_post->ID ] = array(
					'post' => $block_post,
				);

				$filter_data['content'][ $block_post->ID ]['visibility'] = $visibility;

				$assign_to_core_category = false;
			}
		}

		if ( true === $assign_to_core_category ) {
			$block_data[ $block_post->ID ] = array(
				'post' => $block_post,
			);

			$filter_data['core'][ $block_post->ID ] = array(
				'post' => $block_post,
			);

			$filter_data['core'][ $block_post->ID ]['visibility'] = $visibility;
		}
	}

	$hover_label_button_classes = '';
	$overlays_button_classes    = '';
	$qa_overlays_button_classes = '';
	$colors_button_classes      = '';
	$buttons_button_classes     = '';
	$qa_opacity                 = 50;

	if ( ! empty( $_GET['hide-hover-labels'] ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$hover_label_button_classes = ' active';
		$section_classes           .= ' hide-hover-labels';
	}

	if ( ! empty( $_GET['show-overlays'] ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$overlays_button_classes = ' active';
		$section_classes        .= ' show-overlays';
	}

	if ( ! empty( $_GET['show-qa-overlays'] ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$qa_overlays_button_classes = ' active';
		$section_classes           .= ' show-qa-overlays';
	}

	if ( ! empty( $_GET['qa-opacity'] ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$qa_opacity = intval( wp_unslash( $_GET['qa-opacity'] ) ); //phpcs:ignore WordPress.Security.NonceVerification.Recommended
	}

	if ( ! empty( $_GET['hide-colors'] ) || 1 === count( $_GET ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$colors_button_classes = ' active';
		$section_classes      .= ' hide-colors';
	}

	if ( ! empty( $_GET['hide-buttons'] ) || 1 === count( $_GET ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$buttons_button_classes = ' active';
		$section_classes       .= ' hide-buttons';
	}

	if ( ! empty( $_GET['qa'] ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$qa_block = sanitize_text_field( wp_unslash( $_GET['qa'] ) ); //phpcs:ignore WordPress.Security.NonceVerification.Recommended
	}
	?>

	<?php if ( ! empty( $block_data ) ) : ?>
		<?php
		ksort( $block_data );

		if ( ! empty( $qa_block ) ) {
			$block_data = array_filter(
				$block_data,
				function( $this_block_data ) use ( $qa_block ) {
					if ( ! empty( $this_block_data['post'] ) && $qa_block === $this_block_data['post']->post_title ) {
						return true;
					}
				}
			);
		}
		?>

		<?php if ( empty( $qa_block ) ) : ?>
			<section class="block-library<?php echo esc_attr( $section_classes ); ?><?php echo esc_attr( $content_block->get_block_classes() ); ?>">
				<style>
					<?php foreach ( $block_data as $this_block_data ) : ?>
						.block-library:not(.visible-<?php echo esc_attr( $this_block_data['post']->ID ); ?>) ~ .content-wrapper > *[data-block-id^="<?php echo esc_attr( $this_block_data['post']->ID ); ?>-"] {
							display: none !important;
						}
					<?php endforeach; ?>
				</style>

				<ul class="block-library__nav">
					<?php foreach ( $filter_data as $block_category_slug => $block_category ) : ?>
						<?php if ( ! empty( $block_category ) ) : ?>
							<?php
							if ( isset( $all_block_categories[ $block_category_slug ] ) ) {
								$block_category_name = $all_block_categories[ $block_category_slug ];
							} else {
								$block_category_name = $block_category_slug;
							}
							?>

							<li class="block-library__dropdown-wrapper">
								<button type="button" class="block-library__nav-heading-button">
									<?php echo esc_html( ucfirst( $block_category_name ) ); ?>
								</button>

								<div class="block-library__dropdown">
									<div class="block-library__container container">
										<button type="button" class="block-library__toggle-button block-library__show-all" data-category="<?php echo esc_attr( $block_category_slug ); ?>"><?php esc_html_e( '(Show All)', 'propel' ); ?></button>

										<button type="button" class="block-library__toggle-button block-library__hide-all" data-category="<?php echo esc_attr( $block_category_slug ); ?>"><?php esc_html_e( '(Hide All)', 'propel' ); ?></button>

										<ul class="block-library__nav-sub-menu" data-category="<?php echo esc_attr( $block_category_slug ); ?>">
											<?php foreach ( $block_category as $this_block_data ) : ?>
												<li class="block-library__nav-item">
													<?php if ( ! empty( $this_block_data['post'] ) ) : ?>
														<?php
														$input_atts = '';

														if ( ! empty( $this_block_data['visibility'] ) && 'visible' === $this_block_data['visibility'] ) {
															$input_atts .= ' checked';
														}

														$post_label_title = $this_block_data['post']->post_title;

														if ( isset( $this_block_data['active'] ) && false === $this_block_data['active'] ) {
															$post_label_title .= ' <span class="block-library__inactive-title-label">' . __( '(inactive)', 'prope' ) . '</span>';
														}
														?>

														<input class="block-library__input" type="checkbox" id="block-library-input__<?php echo esc_attr( $block_category_slug ); ?>__<?php echo esc_attr( $this_block_data['post']->ID ); ?>" value="<?php echo esc_html( $this_block_data['post']->ID ); ?>" name="<?php echo esc_html( $this_block_data['post']->ID ); ?>"<?php echo wp_kses_post( $input_atts ); ?>>
														<label class="block-library__label checkbox-label" for="block-library-input__<?php echo esc_attr( $block_category_slug ); ?>__<?php echo esc_attr( $this_block_data['post']->ID ); ?>"><?php echo wp_kses_post( $post_label_title ); ?></label>
													<?php endif; ?>
												</li>
											<?php endforeach; ?>
										</ul>
									</div>
								</div>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>

				<div class="block-library__toggle-buttons">
					<button type="button" class="block-library__toggle-button block-library__show-all" data-category="all"><?php esc_html_e( 'Show All (S)', 'propel' ); ?></button>

					<button type="button" class="block-library__toggle-button block-library__hide-all" data-category="all"><?php esc_html_e( 'Hide All (H)', 'propel' ); ?></button>

					<button type="button" class="block-library__hover-labels-toggle-button<?php echo esc_attr( $hover_label_button_classes ); ?>" data-category="<?php echo esc_attr( $block_category_slug ); ?>"><span><?php esc_html_e( 'Hide Hover Labels (L)', 'propel' ); ?></span><span><?php esc_html_e( 'Show Hover Labels (L)', 'propel' ); ?></span></button>

					<button type="button" class="block-library__overlays-toggle-button<?php echo esc_attr( $overlays_button_classes ); ?>"><span><?php esc_html_e( 'Show Overlays (O)', 'propel' ); ?></span><span><?php esc_html_e( 'Hide Overlays (O)', 'propel' ); ?></span></button>

					<button type="button" class="block-library__colors-toggle-button<?php echo esc_attr( $colors_button_classes ); ?>"><span><?php esc_html_e( 'Hide Colors (C)', 'propel' ); ?></span><span><?php esc_html_e( 'Show Colors (C)', 'propel' ); ?></span></button>

					<button type="button" class="block-library__buttons-toggle-button<?php echo esc_attr( $buttons_button_classes ); ?>"><span><?php esc_html_e( 'Hide Buttons (B)', 'propel' ); ?></span><span><?php esc_html_e( 'Show Buttons (B)', 'propel' ); ?></span></button>

					<div class="block-library__qa-overlays-toggle-button-wrapper">
						<button type="button" class="block-library__qa-overlays-toggle-button<?php echo esc_attr( $qa_overlays_button_classes ); ?>"><span><?php esc_html_e( 'Show QA Overlays (Q)', 'propel' ); ?></span><span><?php esc_html_e( 'Hide QA Overlays (Q) (+/-/#)', 'propel' ); ?></span></button>

						<input type="range" min="1" max="100" value="<?php echo esc_attr( $qa_opacity ); ?>" class="block-library__qa-opacity-slider"  aria-label="<?php esc_html_e( 'Change overlay opacity.', 'propel' ); ?>">

						<button type="button" class="block-library__qa-opacity-reset" aria-label="<?php esc_html_e( 'Reset overlay opacity.', 'propel' ); ?>"><span class="icon icon-reset"></span></button>
					</div>

					<button type="button" class="block-library__reset-order-button<?php echo esc_attr( $hover_label_button_classes ); ?>"><?php esc_html_e( 'Reset Order (R)', 'propel' ); ?></button>
				</div>
			</section>

			<?php get_theme_part( '../blocks/acf-blocks/block-library/color-styles' ); ?>
			<?php get_theme_part( '../blocks/acf-blocks/block-library/button-styles' ); ?>
		<?php endif; ?>

		<main class="block-library__content-wrapper content-wrapper">
			<?php foreach ( $block_data as $this_block_data ) : ?>
				<?php if ( ! empty( $this_block_data['post'] ) ) : ?>
					<?php
					if ( is_int( $this_block_data['post']->ID ) ) {
						global $post;
						setup_postdata( $this_block_data['post'] );
					}
					?>

					<?php if ( empty( $qa_block ) ) : ?>
						<div class="block-library__section-placeholder" data-block-id="<?php echo esc_attr( $this_block_data['post']->ID ); ?>" data-block-title="<?php echo esc_html( $this_block_data['post']->post_title ); ?>"></div>
					<?php endif; ?>

					<?php echo apply_filters( 'the_content', $this_block_data['post']->post_content ); //phpcs:ignore ?>
				<?php endif; ?>
			<?php endforeach; ?>
		</main>
	<?php endif; ?>
<?php endif; ?>
