<?php
/**
 * Widgets.
 *
 * This component adds additional functionality for the widgets.
 * It registers the widget areas added in the settings and allows the use
 * of shortcodes in the widget contents.
 *
 * @package Propel
 * @since   1.0
 */

defined( 'ABSPATH' ) || die();

/**
 * Class handing widgets and widgetized areas.
 */
class Theme_Core_Widgets extends Theme_Core_Component {

	/**
	 * Kicks off this class' functionality.
	 */
	protected function init() {
		$this->register_widget_areas();
		$this->shortcodize_widgets();
	}

	/**
	 * Register all widget areas added in the settings file.
	 */
	private function register_widget_areas() {
		if ( ! isset( $this->settings->theme_widgets_init ) ) {
			return;
		}

		foreach ( $this->settings->theme_widgets_init as $area ) {
			$this->register_widget_area( $area );
		}
	}

	/**
	 * Register a single widget area based on the settings from the settings file.
	 *
	 * @param array $area Widget are settings.
	 */
	private function register_widget_area( $area ) {
		$area_args = array();

		foreach ( $area as $key => $value ) {
			$area_args[ $key ] = $value;
		}

		if ( ! array_key_exists( 'before_widget', $area_args ) || ! array_key_exists( 'after_widget', $area_args ) ) {
			$area_args['before_widget'] = '<div id="%1$s" class="widget %2$s">';
			$area_args['after_widget']  = '</div>';
		}

		if ( ! array_key_exists( 'before_title', $area_args ) || ! array_key_exists( 'after_title', $area_args ) ) {
			$area_args['before_title'] = '<h3 class="widget-title">';
			$area_args['after_title']  = '</h3>';
		}

		register_sidebar( $area_args );
	}

	/**
	 * Make it possible to use shortcodes in widgets.
	 */
	private function shortcodize_widgets() {
		add_filter( 'widget_text', 'do_shortcode' );
	}
}
