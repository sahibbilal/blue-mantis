<?php
/**
 * The block library archive page.
 *
 * @package Propel
 * @since   2.0.0
 */

get_header();
?>

<section class="block-library__hero">
	<div class="container">
		<h1 class="block-library__title"><?php esc_html_e( 'Block Library', 'propel' ); ?></h2>
	</div>
</section>

<?php echo apply_filters( 'the_content', '<!-- wp:acf/block-library {"id":"block_6239fe88fd70a","name":"acf/block-library","align":"","mode":"preview"} /-->' ); //phpcs:ignore ?>

<?php
get_footer();
