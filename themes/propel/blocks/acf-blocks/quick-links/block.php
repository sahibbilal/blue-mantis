<?php
/**
 * Quick Links
 *
 * Title:             Quick Links
 * Description:       Thin block with customizable links.
 * Category:          Base
 * Icon:              admin-links
 * Keywords:          quick, link, links, strip
 * Post Types:        all
 * Multiple:          true
 * Active:            false
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$section_title   = get_field( 'title' );
$automatic_links = get_field( 'automatic_links' );
$quick_links     = get_field( 'quick_links' );

if ( empty( $quick_links ) ) {
	$quick_links = array();
}

if ( ! empty( $automatic_links ) ) {
	global $blocks;

	if ( ! empty( $blocks ) ) {
		foreach ( $blocks as $this_block ) {
			if ( ! empty( $this_block['attrs'] ) && ! empty( $this_block['attrs']['data'] ) && ! empty( $this_block['attrs']['data']['quick_link_title'] ) ) {
				if ( ! empty( $this_block['attrs']['data']['scroll_id'] ) ) {
					$url = '#' . $this_block['attrs']['data']['scroll_id'];
				} else {
					$url = '#' . sanitize_title( $this_block['attrs']['data']['quick_link_title'] );
				}

				$quick_links[] = array(
					'link' => array(
						'title' => $this_block['attrs']['data']['quick_link_title'],
						'url'   => $url,
					),
				);
			}
		}
	}
}

?>

<nav <?php echo esc_html( $content_block->get_block_id_attr() ); ?>class="acf-block block-quick-links<?php echo esc_attr( $content_block->get_block_classes() ); ?>">
	<div class="container block-quick-links__container">
		<?php if ( ! empty( $section_title ) ) : ?>
			<h2 class="block-quick-links__title"><?php echo wp_kses_post( $section_title ); ?> –</h2>
		<?php endif; ?>

		<?php if ( ! empty( $quick_links ) ) : ?>
			<ul class="block-quick-links__links">
				<?php foreach ( $quick_links as $quick_link ) : ?>
					<?php if ( ! empty( $quick_link['link'] ) ) : ?>
						<li class="block-quick-links__link-wrapper">
							<?php echo wp_kses_post( array_to_link( $quick_link['link'], 'block-quick-links__link', array() ) ); ?>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		<?php elseif ( ! empty( $automatic_links ) && is_admin() ) : ?>
			<?php esc_html_e( 'Automatic links will appear here on the frontend.', 'propel' ); ?>
		<?php endif; ?>
	</div>
</nav>

<?php
