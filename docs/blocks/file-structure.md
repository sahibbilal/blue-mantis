[⌂ Table of Contents](/docs/README.md) | [← Previous Article](/docs/blocks/README.md) | [Next Article →](/docs/blocks/block-library.md)

# Block File Structure
The following is an overview of the directories and files found in the blocks directory.

* [/themes/propel/blocks/](/themes/propel/blocks/) - the main directory for all blocks, components, and non-global asset source files.
	* [/acf-blocks/BLOCK-NAME/](/themes/propel/blocks/acf-blocks/) - where ACF blocks are created/modified.
		* `block.php` - controls the block's settings and rendering template.
		* `style.scss` (optional) - for custom block styles.
		* `script.js` (optional) - for custom block frontend scripts.
		* `editor.js` (optional) - for custom block editor scripts.
	* [/components/COMPONENT-NAME/](/themes/propel/blocks/components/) - components or SCSS/JS asset source code that need to be used in multiple places on the site but aren't their own Gutenberg blocks.
		* `COMPONENT-NAME.php` (optional) - file that can be included where needed to display the component.
		* `style.scss` (optional) - for custom component styles.
		* `script.js` (optional) - for custom component scripts.
	* [/core-blocks/BLOCK-NAME/](/themes/propel/blocks/core-blocks/) - For adding styles or functionality to existing core Gutenberg blocks.
		* `style.scss` (optional) - for custom block styles.
		* `script.js` (optional) - for custom block frontend scripts.
		* `editor.js` (optional) - for custom block editor scripts.
	* [/templates/TEMPLATE-NAME/](/themes/propel/blocks/templates/) - if the TEMPLATE-NAME directory matches the name of the [current template ↗](https://developer.wordpress.org/themes/basics/template-hierarchy/) then these styles and scripts will be automatically enqueued for that template.
		* `style.scss` (optional) - for custom block styles.
		* `script.js` (optional) - for custom block frontend scripts.