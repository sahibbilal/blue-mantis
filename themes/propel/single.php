<?php
/**
 * The single post page template.
 *
 * @package Propel
 * @since   2.2.0
 */

get_header();
the_post();

?>

<article class="content-wrapper">
	<?php get_theme_part( 'single/single' ); ?>
</article>

<?php
get_footer();
