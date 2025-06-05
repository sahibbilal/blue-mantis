<?php
/**
 * The Header for theme.
 *
 * Displays all of the <head> section and page header
 *
 * @package Propel
 * @since   2.2.0
 */

get_theme_part( 'html-head' );

$main_logo_light = get_field( 'main_logo_light', 'general' );
$main_logo_dark  = get_field( 'main_logo_dark', 'general' );
?>

<body <?php body_class(); ?>>
	<div id="page">
		<div id="top"></div>

		<?php get_theme_part( 'header/header-alert-bar' ); ?>

		<header class="main-header">
			<div class="container main-header__container">
				<?php if ( ! empty( $main_logo_light ) && ! empty( $main_logo_dark ) ) : ?>
					<a href="<?php echo esc_url( home_url() ); ?>" class="main-header__logo"><?php echo wp_kses_post( wp_get_attachment_image( $main_logo_light, 'main-logo', '', array( 'class' => 'main-header__logo-light' ) ) ); ?><?php echo wp_kses_post( wp_get_attachment_image( $main_logo_dark, 'main-logo', '', array( 'class' => 'main-header__logo-dark' ) ) ); ?></a>
				<?php endif; ?>

				<?php render_theme_blocks( 'primary_navigation' ); ?>
			</div>
		</header>
