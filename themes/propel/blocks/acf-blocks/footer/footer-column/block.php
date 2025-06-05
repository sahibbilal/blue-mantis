<?php
/**
 * Footer Column
 *
 * Title:             Footer Column
 * Description:       A column block for the Footer-Top section.
 * Category:          Base
 * Icon:              info-outline
 * Keywords:          footer, top, column, content
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:          marketo
 * JS Deps:           marketo-script, marketo
 * Global ACF Fields:
 * InnerBlocks:       true
 * Parent:            acf/footer-top
 *
 * @package Propel
 * @since   2.1.0
 */

$column_width_mobile  = get_field( 'column_width_mobile' );
$column_width_tablet  = get_field( 'column_width_tablet' );
$column_width_desktop = get_field( 'column_width_desktop' );
$order_mobile         = get_field( 'order_mobile' );
$order_tablet         = get_field( 'order_tablet' );
$spacer_column        = get_field( 'spacer_column' );
$logo                 = get_field( 'logo' );
$block_classes        = '';

if ( ! isset( $column_width_mobile ) ) {
	$column_width_mobile = 12;
} else {
	$column_width_mobile = intval( $column_width_mobile );
}

if ( ! isset( $column_width_tablet ) ) {
	$column_width_tablet = 6;
} else {
	$column_width_tablet = intval( $column_width_tablet );
}

if ( ! isset( $column_width_desktop ) ) {
	$column_width_desktop = 3;
} else {
	$column_width_desktop = intval( $column_width_desktop );
}

if ( ! isset( $order_mobile ) ) {
	$order_mobile = 'initial';
} else {
	$order_mobile = $order_mobile;
}

if ( ! isset( $order_tablet ) ) {
	$order_tablet = 'initial';
} else {
	$order_tablet = $order_tablet;
}

$template = array(
	array(
		'core/heading',
		array(
			'level'       => 2,
			'placeholder' => 'Add heading here.',
			'fontSize'    => 'overline',
		),
	),
	array(
		'core/button',
		array(
			'className' => 'is-style-text',
		),
	),
);

if ( ! empty( $spacer_column ) ) {
	$template = array();

	if ( 12 === $column_width_mobile ) {
		$block_classes .= ' block-footer-column--mobile-border';
	} elseif ( 0 === $column_width_mobile ) {
		$block_classes .= ' block-footer-column--mobile-hidden';
	}

	if ( 12 === $column_width_tablet ) {
		$block_classes .= ' block-footer-column--tablet-border';
	} elseif ( 0 === $column_width_tablet ) {
		$block_classes .= ' block-footer-column--tablet-hidden';
	}

	if ( 12 === $column_width_desktop ) {
		$block_classes .= ' block-footer-column--desktop-border';
	} elseif ( 0 === $column_width_desktop ) {
		$block_classes .= ' block-footer-column--desktop-hidden';
	}
}

$allowed_blocks = e29_text_blocks( array( 'gravityforms/form' ) );

$content_block = new Content_Block_Gutenberg( $block, $context );

?>
<div class="block-footer-column<?php echo esc_attr( $block_classes ); ?>" style="--columnWidthMobile: <?php echo esc_html( $column_width_mobile ); ?>; --columnWidthTablet: <?php echo esc_html( $column_width_tablet ); ?>; --columnWidthDesktop: <?php echo esc_html( $column_width_desktop ); ?>; --orderMobile: <?php echo esc_html( $order_mobile ); ?>; --orderTablet: <?php echo esc_html( $order_tablet ); ?>;">
	<?php if ( empty( $spacer_column ) ) : ?>
		<?php if ( ! empty( $logo ) ) : ?>
			<a href="<?php echo esc_url( home_url() ); ?>" class="block-footer-column__logo-link"><?php echo wp_kses_post( wp_get_attachment_image( $logo, 'main-logo', '', array( 'class' => 'block-footer-column__logo' ) ) ); ?></a>
		<?php endif; ?>

		<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" templateLock="false" class="block-footer-column__content" />
	<?php endif; ?>
</div>
<?php
