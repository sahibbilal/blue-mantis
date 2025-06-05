<?php
/**
 * Logos
 *
 * Title:             Logos
 * Description:       Inner block row of logos.
 * Category:          Logo
 * Icon:              screenoptions
 * Keywords:          logo, logos, brands, partners
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Styles:
 * Parent:            acf/logo-standard, acf/logo-strip
 * Global ACF Fields:
 * Mode:              preview
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$logos                 = get_field( 'logos' );
$logos_per_row_mobile  = get_field( 'logos_per_row_mobile' );
$logos_per_row_tablet  = get_field( 'logos_per_row_tablet' );
$logos_per_row_desktop = get_field( 'logos_per_row_desktop' );

if ( empty( $logos_per_row_mobile ) ) {
	$logos_per_row_mobile = 2;
}

if ( empty( $logos_per_row_tablet ) ) {
	$logos_per_row_tablet = 3;
}

if ( empty( $logos_per_row_desktop ) ) {
	$logos_per_row_desktop = 6;
}

$block_style = '--logoWidthMobile: ' . 100 / $logos_per_row_mobile . '%; --logoWidthTablet: ' . 100 / $logos_per_row_tablet . '%; --logoWidthDesktop: ' . 100 / $logos_per_row_desktop . '%;';

if ( ( empty( $logos ) || 1 === count( $logos ) ) && is_block_library() ) {
	$logos = array(
		'logo-placeholder',
		'logo-placeholder',
		'logo-placeholder',
		'logo-placeholder',
		'logo-placeholder',
		'logo-placeholder',
	);
}

?>

<div class="block-logos row" style="<?php echo esc_html( $block_style ); ?>">
	<?php if ( ! empty( $logos ) ) : ?>
		<?php foreach ( $logos as $logo ) : ?>
			<div class="block-logos__logo-wrapper col-12">
				<figure class="block-logos__logo">
					<?php echo wp_kses_post( wp_get_attachment_image( $logo, 'full', '', array() ) ); ?>
				</figure>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>

<?php
