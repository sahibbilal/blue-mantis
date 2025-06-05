<?php
/**
 * ACF Integration.
 *
 * This component adds ACF options pages.
 *
 * @package Propel
 * @since   2.2.0
 */

defined( 'ABSPATH' ) || die();

/**
 * Class handing this themes custom ACF functionality.
 */
class Theme_Core_ACF extends Theme_Core_Component {

	/**
	 * Kicks off this class' functionality.
	 */
	protected function init() {
		$this->add_acf_pages();
	}

	/**
	 * Register the ACF option pages defined in settings file.
	 * This function also checks if the option pages settings are enabled, and that ACF is
	 * installed and enabled in the first place.
	 */
	private function add_acf_pages() {
		if (
			! isset( $this->settings->acf_options ) || // There are no ACF settings.
			true !== $this->settings->acf_options->init || // ACF is disabled in settings.
			! function_exists( 'acf_add_options_page' )    // ACF is not installed.
		) {
			return;
		}

		// Create options page.
		acf_add_options_page(
			array(
				'page_title' => $this->settings->acf_options->page_title,
				'menu_title' => $this->settings->acf_options->menu_title,
				'menu_slug'  => $this->settings->acf_options->menu_slug,
				'position'   => '2',
			)
		);

		if ( ! empty( $this->settings->post_types ) ) {
			foreach ( $this->settings->post_types as $post_type_slug => $post_type_args ) {
				if ( ! empty( $post_type_args->plural ) ) {
					$post_type_title = $post_type_args->plural;
				} elseif ( ! empty( $post_type_args->singular ) ) {
					$post_type_title = $post_type_args->singular;
				} else {
					$post_type_title = $post_type_slug;
				}

				$this->settings->acf_options->subpages->{$post_type_slug} = new stdClass();

				$this->settings->acf_options->subpages->{$post_type_slug}->page_title = sprintf( __( '%s Settings', 'propel' ), $post_type_title );
				$this->settings->acf_options->subpages->{$post_type_slug}->menu_title = $post_type_title;
				$this->settings->acf_options->subpages->{$post_type_slug}->post_id    = $post_type_slug;
			}
		}

		// Create all options subpages.
		if ( isset( $this->settings->acf_options->subpages ) ) {
			$subpages = (array) $this->settings->acf_options->subpages;

			ksort( $subpages );

			foreach ( $subpages as $subpage ) {
				if ( isset( $subpage->parent_slug ) ) {
					$parent_slug = $subpage->parent_slug;
				} else {
					$parent_slug = $this->settings->acf_options->menu_slug;
				}

				if ( isset( $subpage->post_id ) ) {
					$subpage_post_id = $subpage->post_id;
					$menu_slug       = 'acf-options-' . $subpage->post_id;
				} else {
					$subpage_post_id = 'options';
					$menu_slug       = false;
				}

				acf_add_options_sub_page(
					array(
						'page_title'  => $subpage->page_title,
						'menu_title'  => $subpage->menu_title,
						'parent_slug' => $parent_slug,
						'post_id'     => $subpage_post_id,
						'menu_slug'   => $menu_slug,
					)
				);
			}
		}
	}
}
