[⌂ Table of Contents](/docs/README.md) | [← Previous Article](/docs/theme-overview/file-structure.md) | [Next Article →](/docs/theme-overview/theme-options.md)

# Theme Settings (settings.json file)
The [settings.json](/themes/propel/settings.json) file is used to set a number of project settings. The file must be in proper json format, otherwise it will cause a PHP error and the site won't load (the one exception is that comments between `/*` and `*/` can be added). These are the most commonly updated settings:

## acf_options
These settings are used to add custom [ACF options pages ↗](https://www.advancedcustomfields.com/resources/options-page/). Settings should be given a custom `post_id` to use as the second parameter in the ACF [get_field() ↗](https://www.advancedcustomfields.com/resources/get_field/) function.

## theme_block_locations
New Theme Blocks locations can be registered here. Read more about how to use [Theme Blocks here](/docs/blocks/theme-blocks.md).

## register_styles, register_scripts
These settings can be used to register frontend styles and scripts. Registered styles aren't automatically loaded on the frontend - they just become available for use as a dependency elsewhere (such as with block [CSS Deps and JS Deps](/docs/blocks/acf-blocks/block-settings.md)).

## enqueue_styles, enqueue_scripts, enqueue_admin_styles
These settings are used to register and automatically load styles on every page of the site. ***`enqueue_styles` and `enqueue_admin_styles` should be updated with the correct font styles for every project.***

## register_nav_menus
Registers navigation menu [locations ↗](https://developer.wordpress.org/reference/functions/register_nav_menus/).

## thumbnails
Registers new image sizes. See [best practices for image sizes here](/docs/best-practices/images.md).