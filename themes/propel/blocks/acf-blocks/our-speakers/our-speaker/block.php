<?php
/**
 * Our-Speaker
 *
 * Title:             Our-Speaker
 * Description:       The inner card block for the Our-Speakers block.
 * Category:          Card
 * Icon:              dashicons-groups
 * Keywords:          people, team, leader, department, speaker, speakers
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields:
 * Parent:            acf/speakers-list
 * InnerBlocks:       true
 *
 * @package Propel
 * @since   2.1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$person              = get_field( 'person' );
$custom_card_content = get_field( 'custom_card_content' );

if ( ! empty( $custom_card_content ) ) {
	$name               = get_field( 'name' );
	$job_title          = get_field( 'job_title' );
	$team_or_department = get_field( 'team_or_department' );
	$image              = get_field( 'image' );
	$linkedin_url       = get_field( 'linkedin_url' );
}

if ( ! empty( $person ) ) {
	if ( empty( $name ) || empty( $custom_card_content ) ) {
		$name = get_the_title( $person );
	}

	if ( empty( $job_title ) || empty( $custom_card_content ) ) {
		$job_title = get_field( 'job_title', $person );
	}

	if ( empty( $team_or_department ) || empty( $custom_card_content ) ) {
		$team_or_department = get_field( 'team_or_department', $person );
	}

	if ( empty( $image ) || empty( $custom_card_content ) ) {
		$image = get_post_thumbnail_id( $person );
	}

	if ( empty( $linkedin_url ) || empty( $custom_card_content ) ) {
		$linkedin_url = get_field( 'linkedin_url', $person );
	}
}

if ( empty( $image ) ) {
	$image = get_field( 'placeholder_image', 'general' );
}

$allowed_blocks = array( 'core/paragraph' );

$template = array(
	'core/paragraph',
	array(
		'placeholder' => 'Add text or additional blocks here.',
	),
);

?>

<div class="block-our-speaker">
	<div class="block-our-speaker__image-wrapper image-wrapper">
		<?php if ( ! empty( $image ) ) : ?>
			<?php echo wp_kses_post( wp_get_attachment_image( $image, 'person', '', array( 'class' => 'block-our-speaker__image' ) ) ); ?>
		<?php endif; ?>
	</div>
	
	<div class="block-our-speaker_content-wrapper">
	<?php if ( ! empty( $name ) ) : ?>
		<h3 class="block-our-speaker__name"><?php echo wp_kses_post( $name ); ?></h3>
	<?php endif; ?>

	<?php if ( ! empty( $job_title ) || ! empty( $team_or_department ) ) : ?>
		<div class="block-our-speaker__meta">
			<?php if ( ! empty( $job_title ) ) : ?>
				<span><?php echo wp_kses_post( $job_title ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $team_or_department ) ) : ?>
				<span><?php echo wp_kses_post( $team_or_department ); ?></span>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $linkedin_url ) && ! empty( $name ) ) : ?>
		<a href="<?php echo esc_url( $linkedin_url ); ?>" target="_blank" class="block-our-speaker__linkedin-url" aria-label="<?php echo esc_html( sprintf( __( 'View %s on LinkedIn', 'propel' ), $name ) ); ?>"></a>
	<?php endif; ?>
	</div>
</div>

<?php
