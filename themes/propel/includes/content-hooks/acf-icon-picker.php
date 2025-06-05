<?php
/**
 * Hooks for use with the ACF Icon Picker plugin.
 *
 * @package Propel
 * @since   2.0.0
 */

add_filter(
	'acf/icon-picker-path',
	function() {
		return get_template_directory() . '/dist/iconfont.css';
	},
	100
);

add_filter(
	'acf/icon-picker-uri',
	function() {
		return get_template_directory_uri() . '/dist/iconfont.css';
	},
	100
);
