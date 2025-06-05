<?php
/**
 * Primary Nav
 *
 * Title:             Primary Nav
 * Description:       The block containing site's primary navigation menu.
 * Category:          Navigation
 * Icon:              menu
 * Keywords:          navigation, menu, primary, header, nav
 * Post Types:        theme_block
 * Multiple:          false
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields:
 * InnerBlocks:       true
 * Styles:
 * Context:
 *
 * @package Propel
 * @since   2.0.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$allowed_blocks = array( 'acf/primary-nav-item' );

$template = array(
	array( 'acf/primary-nav-item' ),
);

?>

<div class="block-primary-nav">


	<div class="block-primary-nav__search block-primary-nav-item">
		<div class="wp-block-button is-style-text"><button class="block-primary-nav__search-button wp-block-button__link wp-element-button" type="button" aria-label="<?php esc_attr_e( 'Search', 'propel' ); ?>"></button></div>

		<div class="block-primary-nav-mega-menu">
			<div class="block-primary-nav-mega-menu__inner">
				<div class="block-primary-nav-mega-menu__content">
					<form action="/" method="GET">
						<div class="search-field">
							<input
								type="search"
								class="search-field__input"
								name="s"
								placeholder="<?php esc_html_e( 'Search this website', 'propel' ); ?>"
								aria-label="<?php esc_html_e( 'Search input', 'propel' ); ?>"
								value="<?php echo esc_html( get_search_query() ); ?>"
							/>

							<button class="search-field__submit" type="submit" aria-label="<?php esc_html_e( 'Search this website', 'propel' ); ?>"></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<button class="block-primary-nav__hamburger" type="button" aria-label="<?php esc_attr_e( 'Open Menu', 'propel' ); ?>"><span></span><span></span><span></span></button>

	<div class="block-primary-nav__menu">
		<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-primary-nav__menu-content" />
	</div>
</div>

<?php
