<?php
/**
 * The static page template.
 *
 * @package Propel
 * @since   2.0.0
 */

get_header();
the_post();
?>

<main class="content-wrapper">
	<?php default_content(); ?>
</main>

<?php
get_footer();
