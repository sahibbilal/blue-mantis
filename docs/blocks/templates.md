[⌂ Table of Contents](/docs/README.md) | [← Previous Article](/docs/blocks/core-blocks.md) | [Next Article →](/docs/blocks/reusable-blocks.md)

# Templates
The [/themes/propel/blocks/templates/](/themes/propel/blocks/templates/) directory can be used to add custom styles or scripts that get loaded only on specific templates to help reduce the number of global styles.

If the name of the template directory matches the name of [current template ↗](https://developer.wordpress.org/themes/basics/template-hierarchy/), then these styles and scripts will be automatically enqueued for that template.

For example, the [/themes/propel/blocks/templates/search/style.scss](/themes/propel/blocks/templates/search/style.scss) file generates CSS that automatically gets loaded when the [search.php](/themes/propel/single.php) template is loaded.