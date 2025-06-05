[⌂ Table of Contents](/docs/README.md) | [← Previous Article](/docs/blocks/acf-blocks/innerblocks.md) | [Next Article →](/docs/blocks/core-blocks.md)

# Components
Most of the content on a site is created with [ACF Blocks](/docs/blocks/acf-blocks/README.md), but occasionally there will be elements that are used across multiple places on the site but don't exist as their own unique block. These can be created as components and are used to reduce code duplication.

Components can be reusable PHP, SCSS, or JS, and the file structure is similar to ACF blocks. However, a component can also exist purely as SCSS or JS and doesn't always need a php file.

## Reusable Component PHP
An example of a component with reusable PHP is the [Post Card](/themes/propel/blocks/components/post-card/post-card.php) component. This is a card block to display blog posts. It can be reused in multiple places using the `get_theme_part()` function. For example, given an array of post objects:

```
<?php
if ( ! empty( $blog_posts ) ) {
	foreach ( $blog_posts as $blog_post ) {
		get_theme_part( '../blocks/components/post-card/post-card', array( 'blog_post' => $blog_post ) );
	}
}
?>
```

## Reusable Component SCSS/JS
Alternatively, an example of a component used just for CSS styles is the [Gravity Forms component](/themes/propel/blocks/components/gravity-forms/style.scss). This generates and registers a style using the directory name that can be added to ACF Blocks as a CSS dependency with the [Block Settings](/docs/blocks/acf-blocks/block-settings.md). Then any block that needs this style will automatically load it along with the block's styles.

The same can be done with JavaScript. See the [sliders component](/themes/propel/blocks/components/sliders/) component for a good example of this.

Loading styles and scripts in this way allows to only be loaded when they're actually being used rather than adding them globally and creating unused CSS/JS.