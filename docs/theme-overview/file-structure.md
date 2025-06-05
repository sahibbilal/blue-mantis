[⌂ Table of Contents](/docs/README.md) | [← Previous Article](/docs/theme-overview/README.md) | [Next Article →](/docs/theme-overview/theme-settings.md)

# Theme File Structure
The following is an overview of the essential directories and files of the Propel theme.

* [/](/) - the main repo directory. This should be the WordPress `/wp-content/` directory.
	* [propel.code-workspace](/propel.code-workspace) - the VSCode workspace file that contains the linting settings, plugin recommendations, multi-root directory rules, search exclusion rules, and any other project-specific rules for VSCode. The name will be changed on each project per the [Local Setup](/docs/setup/local-setup.md) instructions.
	* [wp-config-sample-dev.php](/wp-config-sample-dev.php) - the sample wp-config.php data used during [Local Setup](/docs/setup/local-setup.md).
	* [wp-config-sample-dev.php](/wp-config-sample-prod.php) - the sample wp-config.php data used during setup of production sites.
* [/themes/propel/](/themes/propel/) - the main theme directory. All gulp, npm, and composer terminal commands should be run from this directory.
	* [/acf-json/](/themes/propel/acf-json/) - this contains [ACF Local JSON files ↗](https://www.advancedcustomfields.com/resources/local-json/) that get updated automatically when ACF field groups are updated from the dashboard.
	* [/blocks/](/themes/propel/blocks/) - the main directory for all blocks, components, and non-global asset source files. The file structure for this directory is [documented here](/docs/blocks/file-structure.md).
	* [/core/](/themes/propel/core/) - most of the files in this directory should never be changed, since they provide the foundational functionality for the theme. With one exception:
		* [/components/class-theme-core-acf-blocks.php](/themes/propel/core/components/class-theme-core-acf-blocks.php) - the `load_global_blocks()` function in this file occasionally needs to be updated when adding new [Theme Block](/docs/blocks/theme-blocks.md) locations.
	* [/css/](/themes/propel/css/) - the primary directory for any global CSS source files. [Use global styles sparingly](/docs/best-practices/global-vs-block-assets.md).
		* [/base-includes/](/themes/propel/css/__base-includes) - the directory for the base includes.
			* [_variables.scss](/themes/propel/css/__base-includes/_variables.scss) - file uses for setting theme [variables](/docs/css/variables.md).
			* [_button-styles.scss](/themes/propel/css/__base-includes/_button-styles.scss) - file used for setting [button styles](/docs/css/global-styles/buttons.md).
			* [_font-styles.scss](/themes/propel/css/__base-includes/_font-styles.scss) - file used for setting custom [font styles](/docs/css/global-styles/fonts.md).
		* [_base-includes.scss](/themes/propel/css/_base-includes.scss) - this file and all the SCSS files it imports should only be used for sass variables, functions, mixins, and should generate no actual CSS of its own. This file is included in any `style.scss`, `editor.scss` file or any other file that compiles to its own css.
		* [admin.scss](/themes/propel/css/admin.scss) - styles loading on every page of the WordPress dashboard.
		* [editor.scss](/themes/propel/css/editor.scss) - styles loaded within the Gutenberg editor.
		* [styles.scss](/themes/propel/css/styles.scss) - styles loaded on all pages on the frontend.  [Use global styles sparingly](/docs/best-practices/global-vs-block-assets.md).
	* [/custom-menus/](/themes/propel/custom-menus/) - this is an old menu system that will soon be deprecated. Feel free either adapt or delete and create your own menu until the new menu system is released.
	* `/dist/` - all CSS, JS, and font assets are compiled to this folder. Should be deployed but not be tracked in the repo.
	* [/images/](/themes/propel/images/) - a folder for any images or graphics used within the theme. Note: this is primarily for SVG graphics. Any raster (jpg, png, etc.) images should typically be added via the media library and not here, to avoid images without a properly generated srcset tag.
		* [/icons/](/themes/propel/images/icons/) - Icon SVG files added here will automatically be compiled into the font icon set and associated SCSS variables. Note: make sure SVG markup doesn't contain any strokes, clipping paths, masks, or oddeven color rules. A single path is ideal.
	* [/includes/](/themes/propel/includes/) - any custom PHP functionality is added to this folder instead of the functions.php file. All files added to this directory get included automatically.
		* [/acf/](/themes/propel/includes/acf/) - a directory for ACF functions and hooks.
			* [acf-defaults.php](/themes/propel/includes/acf/acf-defaults.php) - this file can be used to hard-code default values for fields or dynamically create field values.
		* [/content-functions/](/themes/propel/includes/content-functions/) - this contains various helper functions used throughout the theme.
		* [/content-hooks/](/themes/propel/includes/content-hooks/) - this contains any WordPress action or filter hooks needed.
		* [/custom-nav-menus/](/themes/propel/includes/custom-nav-menus/) - this is an old menu system that will soon be deprecated. Feel free to either adapt or delete and create your own menu until the new menu system is released.
		* [/gravity-forms/](/themes/propel/includes/gravity-forms/) - a directory for Gravity Forms functions and hooks.
		* [/post-types-and-taxonomies/](/themes/propel/includes/post-types-and-taxonomies/) - all Custom Post Type (CPT) functionality is included here.
			* [post-taxonomies.php](/themes/propel/includes/post-types-and-taxonomies/post-taxonomies.php) - this is where CPT taxonomies are registered.
			* [post-types.php](/themes/propel/includes/post-types-and-taxonomies/post-types.php) - this is where Custom Post Types are registered.
	* [/js/](/themes/propel/js/) - the primary directory for any global CSS source files. [Use global styles sparingly](/docs/best-practices/global-vs-block-assets.md).
		* [/__init/controller.js](/themes/propel/js/__init/controller.js) - this is the primary [Controller file](/docs/js/controllers.md) for the global scripts.
		* [editor.js](/themes/propel/js/editor.js) - for custom block editor scripts.
		* [script.js](/themes/propel/js/script.js) - for global frontend scripts.
	* `/node_modules/` - the NPM package directory. Should not be tracked in the repo or deployed.
	* [/parts/](/themes/propel/parts/) - Will likely be deprecated at some point in favor of the [components](/themes/propel/blocks/components/) directory. Can be used for PHP files included elsewhere.
	* [/tasks/](/themes/propel/tasks/) - contains all the gulp tasks.
	* `/vendor/` - the Composer package directory. Should not be tracked in the repo or deployed.
	* [functions.php](/themes/propel/functions.php) - Do not edit. Any functionality typically added to this file should be instead added to the [/includes/](/themes/propel/includes/) directory.
	* [settings.json](/themes/propel/settings.json) - This file is used to register various [theme settings](/docs/theme-overview/theme-settings.md).
	* [theme.json](/themes/propel/theme.json) - Core [WordPress theme.json ↗](https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-json/) file used to set global styles. For most projects, this won't need to be modified.
