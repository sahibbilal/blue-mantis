<?php
/**
 * The search result partial.
 *
 * @package Propel
 * @since   1.0
 */

$args = wp_parse_args(
	$args,
	array(
		'subtitle' => '',
		'title'    => '',
		'url'      => '',
		'content'  => '',
		'img'      => '',
	)
);
?>

<?php if ( ( 'resource' === get_post_type() || 'news' === get_post_type() ) && ( ! is_internal_link( $args['url'] ) || is_document_link( $args['url'] ) ) ) : ?>
	<a class="search-result" href="<?php echo esc_url( $args['url'] ); ?>" target="_blank">
<?php else : ?>
	<a class="search-result" href="<?php echo esc_url( $args['url'] ); ?>">
<?php endif; ?>
	<div class="search-result__text">
		<?php if ( ! empty( $args['url'] ) ) : ?>
			<div class="search-result__url"><?php echo esc_html( $args['url'] ); ?></div>
		<?php endif; ?>

		<h2 class="search-result__title">
			<?php echo wp_kses_post( $args['title'] ); ?>
		</h2>

		<?php if ( ! empty( $args['content'] ) ) : ?>
			<div class="search-result__excerpt"><?php echo wp_kses_post( $args['content'] ); ?></div>
		<?php endif; ?>
	</div>

	<?php if ( ! empty( $args['img'] ) ) : ?>
		<figure class="search-result__image-wrapper image-wrapper">
			<?php echo wp_kses_post( $args['img'] ); ?>
		</figure>
	<?php endif; ?>
</a>
