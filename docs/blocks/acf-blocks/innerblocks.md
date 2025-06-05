[⌂ Table of Contents](/docs/README.md) | [← Previous Article](/docs/blocks/acf-blocks/block-settings.md) | [Next Article →](/docs/blocks/components.md)

# InnerBlocks
The WordPress editor by default has an element called [InnnerBlocks ↗](https://developer.wordpress.org/block-editor/how-to-guides/block-tutorial/nested-blocks-inner-blocks/) which allows nesting additional blocks inside another block. These can also be added to ACF blocks.

## Adding InnerBlocks
InnerBlocks are added with the `<InnerBlocks />` element in the `block.php` file. This element has several attributes that can be added:

* `allowedBlocks` (array) - an array of blocks that can be used as InnerBlocks.
* `template` (array) - a default arrangement of InnerBlocks added when the parent block is first added in the editor.
* `class` (string) - the class to use for the wrapper `div`. Defaults to `acf-innerblocks-container`.
* `templateLock` (string) - can be set to `all` to lock the `template` settings to prevent removal of moving of the InnerBlocks or `false` to allow movement/removal.

## Default Text Blocks
When setting the `allowBlocks` attribute, the [e29_text_blocks()](/themes/propel/includes/gutenberg-block-editor/allow-only-certain-core-blocks.php) function can be used to generate an array of the standard allowed text blocks. Additional blocks can be added to this function as an array.

## Multiple InnerBlocks
The `<InnerBlocks />` can only be used once within an ACF block. If multiple areas with InnerBlocks are needed, multiple wrapper elements can be added to the template and then the template can be locked.

The [Content Block](/themes/propel/blocks/acf-blocks/content/block.php) is particularly useful here. It's a block that allows for the standard text blocks from the [e29_text_blocks()](/themes/propel/includes/gutenberg-block-editor/allow-only-certain-core-blocks.php) function.

For example, here is a block that contains two standard text block sections, each that have their own InnerBlocks element. The InnerBlocks element is locked, so this block will always have 2 blocks with separate InnerBlocks sections that can be positioned and styled separately.

```
$allowed_blocks = array( 'acf/content' );

$template = array(
	array(
		'acf/content',
	),
	array(
		'acf/content',
	),
);

<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" templateLock="all" />
```
