<?php
/**
 * <%= title %>
 *
 * Title:             <%= title %>
 * Description:       <%= description %>
 * Category:          <% if ("undefined" !== typeof(newCategory)) { %><%= newCategory %><% } else { %><%= category %><% } %>
 * Icon:              <%= icon %>
 * Keywords:          <%= keywords %>
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:<% if (parentBlocks) { %>
 * Parent:            <%= parentBlocks %><% } %><% if (true === innerBlocks) { %>
 * InnerBlocks:       true<% } %>
 * Styles:
 * Context:
 *
 * @package Propel
 * @since   2.1.1
 */

$content_block = new Content_Block_Gutenberg( $block, $context );
<% if (true === innerBlocks) { %>
$allowed_blocks = <% if (true === defaultTextBlocks) { %>e29_text_blocks<% } else { %>array<% } %>(<% if (allowedInnerBlocks) { %> <%= allowedInnerBlocks %> <% } %>);

<% if (templateBlocks) { %>$template = array(<% _(templateBlocks).each(function(templateBlock) { %><% if ('Heading' === templateBlock) { %>
	array(
		'core/heading',
		array(
			'level'       => 2,
			'placeholder' => 'Add heading here.',
		),
	),<% } else if ('Paragraph' === templateBlock) { %>
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Add text or additional blocks here.',
		),
	),<% } else if ('Buttons' === templateBlock) { %>
	array( 'core/buttons', ),<% } else { %>
	array( 'acf/<%= templateBlock %>' ),<% } %><% }) %>
);<% } else { %>$template = array();<% } %>
<% } %>
?>

<div class="block-<%= directory %>">
<% if (true === innerBlocks) { %>	<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" class="block-<%= directory %>__content" /><% } %>
</div>
