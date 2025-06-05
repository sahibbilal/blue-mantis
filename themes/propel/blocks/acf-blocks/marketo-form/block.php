<?php
/**
 * Marketo Form
 *
 * Title:             Marketo Form
 * Description:       Embed a Marketo Form.
 * Category:          Base
 * Icon:              forms
 * Keywords:          marketo, form, lead, submit
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:          marketo
 * JS Deps:           marketo-script, marketo
 * Global ACF Fields:
 * InnerBlocks:       false
 * Parent:
 * Context:
 * Mode:              preview
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$marketo_form_id   = get_field( 'marketo_form_id' );
$thank_you_message = get_field( 'thank_you_message' );
$thank_you_url     = get_field( 'thank_you_url' );

$form_attributes = '';

if ( ! empty( $thank_you_message ) ) {
	$form_attributes .= ' data-thank-you-message="' . htmlspecialchars( $thank_you_message ) . '"';
}

if ( ! empty( $thank_you_url ) ) {
	$form_attributes .= ' data-thank-you-url="' . $thank_you_url . '"';
}

?>

<?php if ( ! empty( $marketo_form_id ) ) : ?>
	<?php if ( is_admin() ) : ?>
		<p><?php esc_html_e( 'Marketo form will display here.', 'propel' ); ?></p>
	<?php else : ?>
		<form id="mktoForm_<?php echo esc_attr( $marketo_form_id ); ?>" class="marketo-form" data-id="<?php echo esc_attr( $marketo_form_id ); ?>"<?php echo wp_kses_post( $form_attributes ); ?>></form>
	<?php endif; ?>
<?php else : ?>
	<p><?php esc_html_e( 'Marketo form ID missing.', 'propel' ); ?></p>
<?php endif; ?>
