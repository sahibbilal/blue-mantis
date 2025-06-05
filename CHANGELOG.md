# Propel WordPress Framework Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.2] - 2023-5-1

### Changed
- Design system color naming scheme changed to non-color-specific names.

### Added
- Added ability to register post types and taxonomies via the settings.json file, with automatic theme block location registration and display.

## [2.1.8] - 2023-3-1

### Changed
- Allow nested columns blocks (modified render_block filter).

## [2.1.7] - 2023-2-28

### Changed
- Updated stylelintignore file to ignore CSS iconfont template files.
- Added email address to initial Local setup instructions.
- Fixed block library color for #fff white.

## [2.1.6] - 2023-2-27

### Changed
- Removed spinup composer plugin - no longer needed with WPEngine.
- Updated render_block_callback to only render the block when being display as a block preview or on the frontend. Performance improvement to avoid unnecessary loading on API requests in the editor.

## [2.1.5] - 2023-2-24

### Changed
- Updated intermediate_image_sizes hook to work with Perfect Images plugin and not remove image sizes from its REST API endpoint.
- Changed "base" block library category to "core" per discussion with the design team.

## [2.1.4] - 2023-2-23

### Changed
- Disabled the block previews rendered from the block library. Currently too slow when editing the dashboard Eventually needs a different solution.

## [2.1.3] - 2023-2-22

### Changed
- Include templates directory in stylelint rules.
- Added wp-migrate-db-pro-compatibility.php to gitignore file.

## [2.1.2] - 2023-2-13

### Changed
- Updated single.php template to use theme blocks instead of a fixed layout.
- Added Blog Posts-Top and Blog Posts-Bottom theme block locations to display on single layout.
- Moved the share icons and blog post tags into a component rather than global element.
- Changed the white color based on update in Figma.
- Added .cache directory to workspace search ignore.
- Added new theme screenshot.
- Slight adjustment to .editor-styles-wrapper padding to allow clickable space around editor.

## [2.1.1] - 2023-2-13

### Changed
- Fixed incorrect grid gap on side image blocks.
- Updated bullet style on Post-Card component.
- Changed back_link() function to get_back_link().
- Updated eight29-filter-data file to use 829 filters hook to declare data.
- Modified index.php file to use blocks instead of hard-coded archive.
- Made theme-styles a dependency of component styles so they load after the theme styles and can override the default theme styles.
- Only add example data to ACF blocks in the admin area to reduce frontend database calls.
- Only update default options fields if they're different - reduce calls to update_option on the frontend.
- Added function checks to make sure site still works if ACF isn't active.
- Updated some Figma font styles.
- Activate 829 filters plugin on setup.
- Updated docs for multisite and local setup.

### Added
- Added Blog-Archive-Hero block.
- Added Blog-Profile-Hero block.
- Added Blog-Cards-Grid block.
- Added load_theme_block_location_blocks() function in class-theme-core-acf-blocks.php file to make loading Theme Block assets easier.
- Added Blog-Taxonomy-Hero block.
- Added is_theme_block() function to be able to load default content when editing a theme block.
- Added Featured Post Card component block.
- Added set_rest_image_sizes() filter to limit the image sizes loaded in the REST API.
- Added documentation for Block Background Color Properties.
- Slight update to single.php template. Still needs to be updated fully to match Figma.

## [2.1.0] - 2023-2-7

### Changed
- Set all ACF blocks to inactive by default.
- Allow inactive ACF blocks in development environments - with "Inactive" label on block library.
- Don't count inactive blocks on used block page.
- Set default order of block library categories to match Figma.
- Added post_id to all ACF options pages and updated associated fields.

### Added
- Added theme colors block to block library.
- Added full documentation in repo.
- Added gulp docs task to scan documentation files for bad links, spelling, and grammar.
- Added grid() mixin and $grid-gap variable for grids created with CSS grid.
- Added alt-text-selectors mixin for targeting alt text background colors.
- Added gulp docs:header task to scan doc files and automatically add home, next article, and previous article links.

## [2.0.3] - 2023-1-30

### Added
- Added `npm run setup:buddy` task for running initial setup on Buddy that bypasses the Figma task.

## [2.0.2] - 2023-1-27

### Changed
- Updated responsive-values sass function to allow numerical breakpoints for custom values outside of the standard breakpoints.
- Added `rv()` function alias for responsive-values sass function.
- Updated spacing between heading/text blocks and ACF blocks.
- Fixed Content-Side-Image block image size.

## [2.0.1] - 2023-1-25

### Changed
- Apply the_content filter to render_theme_blocks() function instead of do_blocks to allow shortcodes in theme blocks
- Removed unnecessary global 404 page styles that are no longer being used.
- Removed unnecessary page-columns styles that are no longer being used.
- Updated theme version in style.css and package.json files.

## [2.0.0] - 2023-1-24

### Changed

- General updates:
	- Moved `Theme Options` to top of dashboard sidebar.
	- Updated readme file, including setup instructions.
- File/directory structure:
	- Restructured the theme to work with WPEngine (and also be hosting-agnostic)
		- Changed repo root to the `wp-content` folder.
		- Removed env settings - created `wp-confit-sample-dev.php` and `wp-confit-sample-prod.php` with with default settings for `wp-config.php` file to mirror the functionality previously in the .env file.
		- Changed database management to use to wp-cli export and import commands for post data only.
		- Added `npm run setup` task to run all initial setup.
	- Changed theme name, namespaces, text domains, and directories from defaultTheme to propel.
	- Moved ACF Blocks to `blocks` directory (which also includes new components and core blocks directories).
- Build process:
	- Moved all compiled CSS, JS, and iconfont files to singular `dist` directory.
	- Added `styles:selective` task that runs during `gulp watch` to only compile files that have changed (to prevent compiling of every single block every time something changes).
	- Added support for JSX markup.
	- Updated `gulp block:add` task:
		- Updated templates.
		- Added new prompts:
			- Select pre-existing category
			- Parent blocks(s)
			- Does this block have inner blocks?
			- Allow additional inner blocks:
			- Blocks to include in inner block template:
			- Create an ACF field group/JSON file?
			- ACF JSON template:
	- Added fix for infinite iconfont loop.
	- Added fix so CSS/JS gets properly minified when `WP_ENV=production` is set in the `.env` file.
- Enqueueing assets:
	- Only enqueue CSS/JS files if the source file exists (to prevent old compiled files from being loaded).
	- Updated `Theme_Core_ACF_Blocks` class and CSS/JS loading functionality to parse all blocks, reusable blocks, and inner blocks and load their CSS in the header to prevent poor cumulative layout shift scores.
- Editor styles:
	- Updated editor styles to more closely match frontend without the need for separate editor scss files. An optional `editor.scss` file can still be created for blocks that need additional styling in the editor.
	- Wrap editor CSS files with `.editor-styles-wrapper` class via the gulp build rather than using an scss import, to prevent issues with SCSS selectors.
	- Added optional `editor.js` file in all ACF and core blocks for custom editor functionality.
	- Moved all global editor JS functionality into common `editor.js` file rather than separate enqueued files outside of the webpack build.
	- Use JS `registerBlockStyles` function for custom core block styles rather than the PHP function.
	- Added example attribute to acf_register_block_type() settings to generate preview image in editor based on posts that have a title matching the block's title attribute.
- Block library:
	- Changed navigation to dropdowns instead of pills.
	- Use "Category" metadata attribute from block.php files to automatically categorize blocks. Removed category taxonomy for the library block CPT.
	- Added overlay option to display padding/margin on blocks.
	- Added `Edit` button to block library labels.
	- Updated `e29_allowed_block_types_all()` function to use a blacklist rather than a whitelist of disabled blocks to avoid future errors if new blocks are added/change in the core (like when the core/list-item block was added).
	- Only load compiled block assets if their corresponding source file exists (to prevent loading of assets for blocks that no longer exist)
	- Added default images that load on the block library page if files don't exist in the uploads folder.
- Components:
	- Added a `components` directory in the `blocks` directory for reusable non-block code.
	- Converted slider and lightbox files into components.
	- Updated Slick slider to set attributes via data attribute rather than setting the values in the JS file.
	- Updated form styles and moved them into components - with separate styles for Gravity Forms and Hubspot that can be included as CSS Deps within blocks.
- Templates:
	- Added a `templates` directory in the `blocks` directory for template-specific CSS/JS.
	- Automatically enqueue template css/js if the template name matches the directory name.
	- Moved page, search, and post global styles to template styles.
- Code cleanup:
	- Removed all shortcodes except for `[current_year]`.
	- Removed all unused bootstrap files and added used mixins, functions, reboot, and grid system to the theme's scss files.
	- Removed unused composer packages/plugins and updated all packages, plugins, and the WP core to their latest versions.
	- Updated PHP/CSS/JS to fix all PHPCS, Stylelint, and ESLint errors.
	- Fixed improper use of translation sanitization functions.
- CSS:
	- Updated grid system to use responsive clamp values for column gaps.
	- Created `_base-includes.scss` file to make it simpler to include core SCSS functionality across independent scss files. It doesn't generate any CSS itself, but includes:
		- Variables
		- Functions
		- Mixins, including:
			- Font styles
			- Button styles

### Added

- Configuration files
	- Default VSCode workspace and extensions files for easier out-of-the-box setup and linting configuration.
	- Added `theme.json` file to set default Gutenberg settings, including font sizes.
		- Updated block version to Gutenberg API v2.
- General updates
	- Added filter if a page is hidden from search engines via Yoast to make sure its hidden from the WordPress sitewide search.
	- Added `Block Pattern` CPT and functionality.
	- Added `Theme Block` CPT and render_theme_blocks() function for global site blocks (currently just used for 404 page, but could be used for header/footer/navigation in the future).
	- Tested setup and build tasks on a Windows environment and made updates to improve compatibility.
- New features to block system:
	- Global spacing styles for logical spacing between blocks.
	- Added fix to allow spaces between comma-separated block metadata attributes.
	- Allow child blocks to exist as subdirectory within a parent block.
	- Don't add block IDs to ACF blocks if they're not explicitly added to the blocks (since block IDS were removed in ACF 6.0).
	- New metadata attributes:
		- `Global ACF Fields` - Comma-separated list of global ACF fields to automatically assign to this block. Available fields are:
			- Image
			- Scroll ID
			- Background Color (this loads values automatically from the `variables.scss` file)
		- `Default BG Color` - Sets the default value of the background_color Global ACF field.
		- `Styles` - Comma-separated list of block styles to automatically register via the Gutenberg interface.
		- `Context` - Sets the context data to inherit from a parent block. Used when needing to access ACF field data from a parent block. See https://developer.wordpress.org/block-editor/reference-guides/block-api/block-context/
			- Added `get_parent_field()` function to get ACF values from parent block when context is set.
		- `Wrap InnerBlocks` - whether the `<InnerBlocks />` markup is wrapped with a dev on the frontend to match the editor. Uses the `acf/blocks/wrap_frontend_innerblocks` hook. Defaults to true and generally shouldn't be set to false since that renders the block differently on the frontend. Only use in cases where editor styles are customized.
- Incorporated core Gutenberg blocks:
	- Buttons (replaced ACF buttons/button block)
	- Tables (replaced TablePress)
	- Columns (replaced ACF Grid Columns block)
	- HTML
- Added `gulp figma` task to automatically pull font and color styles via the Figma API.
- Developed blocks based on the Propel Design System in Figma:
	- *Note: there are blocks in the Figma design system that still need to be developed. They are not listed here.*
	- Base Blocks
		- Base-Media
	- Hero Blocks
		- Hero-Standard
		- Hero-Centered
		- Hero-Text
		- Hero-Display
		- Hero-Contact
		- Hero-404
	- Text Blocks
		- Text-Centered
		- Text-Lead
		- Text-Column
		- Text-Side-Heading
		- Text-Rows
	- Accordion Blocks
		- Accordion-Centered
		- Accordion-Side-Heading
		- Accordion-Side-Image
	- Tabs Blocks
		- Tabs-Standard
		- Tabs-Side-Image
	- Content Blocks
		- Content-Side-Image
		- Content-Table
	- Stat Blocks
		- Stat-Strip
		- Stat-Simple
		- Stat-Supporting
		- Stat-Image
	- Logo Blocks
		- Logo-Strip
		- Logo-Standard
	- Testimonial Blocks
		- Testimonial-Standard
		- Testimonial-Image
		- Testimonial-Cards
		- Testimonial-Box
	- Icon Blocks
		- Icon-Standard
		- Icon-Horizontal
		- Icon-Image
	- Card Blocks
		- Card-Image-Links
		- Card-Text-Links
		- Card-Standard
		- Card-Stacked
	- CTA Blocks
		- CTA-Standard
		- CTA-Grid
		- CTA-Strip
		- CTA-Form
		- CTA-Donate

## [1.0]

Everything with 1.0 was developed before individual changes were tracked with version numbers. See git repo for more detailed history.