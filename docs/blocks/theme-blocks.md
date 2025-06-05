[⌂ Table of Contents](/docs/README.md) | [← Previous Article](/docs/blocks/block-patterns.md) | [Next Article →](/docs/css/README.md)

# Theme Blocks
Theme Blocks are a custom post type that can be used when content created within the Gutenberg editor needs to be displayed somewhere where the editor is normally not used.

Theme Blocks are created like any other post. The one difference is there is a `Display Location` option in the sidebar where these blocks are assigned a corresponding location.

## Displaying Theme Blocks
To display theme blocks, the [render_theme_blocks()](/themes/propel/includes/content-functions/func-render-theme-blocks.php) is used. This function accepts a parameter that specifies the `Display Location`. Any of the Theme Block posts that are assigned to this location will then be displayed.

## Display Locations
Similarly to standard WordPress navigation menu locations, Display Locations can be added via the `theme_block_locations` setting in the [Theme Settings (settings.json file)](/docs/theme-overview/theme-settings.md).

If new locations are added and the `render_theme_blocks()` function is used, make sure to update the `load_global_blocks()` function in the [class-theme-core-acf-blocks.php](/themes/propel/core/components/class-theme-core-acf-blocks.php) file so that the blocks get loaded into the global $blocks variable. This variable controls what CSS/JS files are loaded on the page, so this is important to make sure the Theme Blocks are accounted for and have their CSS/JS display accordingly.
