<?php
/**
 * Theme functions
 *
 * @package Propel
 * @since   1.0
 *
 * This file prepares all functionality except theme templates. It automatically
 * includes php files used by theme, therefore no code should be added here.
 * Each piece of functionality should be added as a separate file in the `includes`
 * folder, and it will be automatically included and available in the theme.
 */

/*
 * Initialize the theme core
 */
require_once 'core/init.php';

/*
 * Include the widgets
 * ---------------------------------------------------------------------------------------
 *
 * We only include the files placed directly in the widgets folder. It is the widgets'
 * responsibility to include their own includes and manage their assets.
 *
 */
recursive_include( get_template_directory() . '/widgets', 0 );
