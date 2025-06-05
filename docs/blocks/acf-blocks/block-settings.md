[⌂ Table of Contents](/docs/README.md) | [← Previous Article](/docs/blocks/acf-blocks/README.md) | [Next Article →](/docs/blocks/acf-blocks/innerblocks.md)

# Block Settings
All ACF Blocks begin with file comments that control the settings used when registering that block type.

## Required Settings
 * `Title` (readable text) - The display title for the block. The block directory should be the slug version of this.
 * `Description` (readable text) - A description of the block for reference in the editor.
 * `Category` (readable text) - The display text for the block category in the editor and on the Block Library archive. Block library posts will automatically be categorized based on this.
 * `Icon` (slug) - A [WordPress dashicon ↗](https://developer.wordpress.org/resource/dashicons/) that represents the block.
 * `Keywords` (CSV) - comma-separated list of descriptive word(s) to allow searching by keyword in the editor.
 * `Active` (boolean) - a true or false value whether the block is available in the [Block Library](/docs/blocks/block-library.md). Should be set to `true` if the block is available.

## Frequently Used Optional Settings
 * `Post Types` (CSV) - comma-separated list of post type slugs to limit the block to usage only in certain post types. Leave blank to allow usage everywhere.
 * `Multiple` (boolean) - whether a block can be added multiple times within a single post. Set to `true` to allow multiple instances.
 * `CSS Deps` (CSV) - comma-separated list of CSS style handles registered with [wp_enqueue_style ↗](https://developer.wordpress.org/reference/functions/wp_enqueue_style/). These will be automatically loaded when the current block's styles are loaded. Requires a `style.scss` file. InnerBlock styles do not need to be added.
 * `JS Deps` (CSV) - comma-separated list of CSS script handles registered with [wp_enqueue_script ↗](https://developer.wordpress.org/reference/functions/wp_enqueue_script/). These will be automatically loaded when the current block's scripts are loaded. Requires a `script.js` file. InnerBlock scripts do not need to be added.
 * `Global ACF Fields` (CSV) - comma-separated list to automatically add some commonly-used ACF fields to the block (all optional):
	* `image` - an ACF image field.
	* `scroll_id` - a Scroll ID that gets added as the block's ID via the `$content_block->get_block_id_attr()` function.
	* `background_color` - a background color class that gets added to the block's classes via the `$content_block->get_block_classes()` function. Controls spacing between blocks of the same or different background colors. If used, make sure alternate background colors still display with appropriate font colors. Options are automatically generated from `$background-colors` variable in the [_variables.scss file](/themes/propel/css/__base-includes/_variables.scss).
 * `InnerBlocks` (boolean) - whether the block contains [InnerBlocks](/docs/blocks/acf-blocks/innerblocks.md). Set to `true` to enable InnerBlocks.
 * `Parent` (CSV) - comma-separated list of post type slugs to limit the block to usage only as an InnerBlock of other blocks. Leave blank to allow usage everywhere.
 * `Styles` (CSV) - comma-separated list of readable names to automatically register Gutenberg [Block Styles ↗](https://developer.wordpress.org/block-editor/reference-guides/block-api/block-styles/) for the current block. This option appears in the sidebar and adds a style slug to the block. Used for style variations of the same block.

## Additional Optional Settings

 * `Mode` (string) - the ACF display mode for the block. Available settings are:
	* `preview` (default and recommended) - displays the rendered block preview with ACF fields in the sidebar. This is the best option for most blocks, especially for blocks with InnerBlocks.
	* `auto` - displays the preview when not editing the block, and the ACF fields when the block is selected. Not recommended for blocks with InnerBlocks.
	* `edit` - always displays the ACF fields and doesn't display the rendered block. Not recommended.
 * `Default BG Color` (string) - when the `background_color` setting is used, sets a default initial value for the ACF field.
 * `Context` (CSV) - specifies a custom [context ↗](https://developer.wordpress.org/block-editor/reference-guides/block-api/block-context/) for the current block. Used to access ACF field data from parent blocks.
 * `Wrap InnerBlocks` (boolean) - By default, the InnerBlocks element is wrapped with a `div` and given a class name. This element is required by the editor to ensure the frontend matches the editor and styles are applied consistently. However, occasionally this element needs to be removed, and this option can be set to `false` which will disable this wrapper on the frontend. Use sparingly.
