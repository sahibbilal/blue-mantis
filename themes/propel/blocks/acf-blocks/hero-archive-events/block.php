<?php
/**
 * Hero-Archive-Events
 *
 * Title:             Hero-Archive-Events
 * Description:       Hero section for use on the event archive that displays one highlighted post.
 * Category:          Hero
 * Icon:              dashicons-calendar-alt
 * Keywords:          event, archive, hero, featured, highlight
 * Post Types:        all
 * Multiple:          false
 * Active:            true
 * CSS Deps:          sliders, event-card-featured, event-card, core-buttons
 * JS Deps:           sliders
 * Global ACF Fields: background_image
 * InnerBlocks:       true
 * Styles:
 * Context:
 *
 * @package Propel
 * @since   2.1.1
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$featured_event          = get_field( 'featured_event' );
$background_image        = get_field( 'background_image' );
$display_upcoming_events = get_field( 'display_upcoming_events' );
$custom_cta_button       = get_field( 'custom_cta_button' );

if ( empty( $featured_event ) ) {
	$args = array(
		'post_type'      => 'event',
		'post_status'    => array( 'publish' ),
		'posts_per_page' => 1,
	);

	$featured_event = get_posts( $args );

	if ( $featured_event ) {
		$featured_event = $featured_event[0];
	}
}

if ( ! empty( $display_upcoming_events ) ) {
	$upcoming_events = get_field( 'upcoming_events' );

	if ( empty( $upcoming_events ) ) {
		$args = array(
			'post_type'      => 'event',
			'post_status'    => array( 'publish' ),
			'posts_per_page' => 6,
		);

		if ( ! empty( $featured_event ) ) {
			$args['post__not_in'] = array( $featured_event->ID );
		}

		$upcoming_events = get_posts( $args );
	}
	global $upcoming_events_list;
	$upcoming_events_list = array_column( $upcoming_events, 'ID' );
}

$allowed_blocks = e29_text_blocks();

$template = array(
	array(
		'core/heading',
		array(
			'level'       => 1,
			'placeholder' => 'Add heading here.',
		),
	),
);

$slick_options = array(
	'dots'            => true,
	'pageCount'       => true,
	'arrows'          => true,
	'infinite'        => true,
	'slidesToShow'    => 3,
	'slidesToScroll'  => 3,
	'pauseOnHover'    => false,
	'speed'           => 600,
	'variableWidth'   => false,
	'prevArrow'       => '<button type="button" class="slick-prev slick-arrow--secondary">Previous</button>',
	'nextArrow'       => '<button type="button" class="slick-next slick-arrow--secondary">Next</button>',
	'customCallbacks' => true,
	'responsive'      => array(
		array(
			'breakpoint' => 992,
			'settings'   => array(
				'slidesToShow'   => 2,
				'slidesToScroll' => 2,
			),
		),
		array(
			'breakpoint' => 576,
			'settings'   => array(
				'slidesToShow'   => 1,
				'slidesToScroll' => 1,
			),
		),
	),
);

?>

<section <?php echo wp_kses_post( $content_block->get_block_id_attr() ); ?>class="acf-block block-hero-archive-events<?php echo esc_attr( $content_block->get_block_classes( array( 'background_color' => 'dark' ) ) ); ?>">
	<div class="container block-hero-archive-events__container">
		<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-hero-archive-events__content" />

		<?php if ( ! empty( $featured_event ) ) :
			$event_card_featured_parameters = array( 'featured_event' => $featured_event );

			if ( $custom_cta_button ) {
				$event_card_featured_parameters['custom_cta_button_url']    = $custom_cta_button['url']; 
				$event_card_featured_parameters['custom_cta_button_title']  = $custom_cta_button['title']; 
				$event_card_featured_parameters['custom_cta_button_target'] = $custom_cta_button['target'] ? $custom_cta_button['target'] : '_self'; 
			}

			get_theme_part( '../blocks/components/event-card-featured/event-card-featured', $event_card_featured_parameters );
		endif; ?>

		<?php if ( ! empty( $upcoming_events ) ) : ?>
			<h2 class="block-hero-archive-events__upcoming-events-title"><?php esc_html_e( 'Upcoming Events', 'propel' ); ?></h2>

			<div class="block-hero-archive-events__slider component-slider" data-slick="<?php echo esc_attr( wp_json_encode( $slick_options ) ); ?>">
				<?php if ( ! empty( $upcoming_events ) ) : ?>
					<?php foreach ( $upcoming_events as $upcoming_event ) : ?>
						<?php
						if ( 'publish' === get_post_status( $upcoming_event->ID ) ) {
							get_theme_part(
								'../blocks/components/event-card/event-card',
								array(
									'card_post'  => $upcoming_event,
									'show_image' => true,
								)
							);
						}
						?>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( ! empty( $background_image ) ) : ?>
		<?php echo wp_kses_post( wp_get_attachment_image( $background_image, 'full-width', '', array( 'class' => 'block-hero-archive-events__background-image' ) ) ); ?>
	<?php endif; ?>
</section>
