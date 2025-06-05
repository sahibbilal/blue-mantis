<?php
/**
 * Hook Block
 *
 * Title:             Hook (Anchor)
 * Description:       An anchor attached to a link to the content on the same page.
 * Category:          Base
 * Icon:              icon829-hook
 * Keywords:          hook, anchor, navigation
 * Post Types:        all
 * Multiple:          true
 * Active:            true
 * CSS Deps:
 * JS Deps:
 * Global ACF Fields: scroll_id, background_color
 *
 * @package Propel
 * @since   1.0
 */

$content_block = new Content_Block_Gutenberg( $block, $context );

$main_block_class = 'block-hook';

$block_hook = get_field( 'anchor' ) ? get_field( 'anchor' ) : 'hook_missing';

if ( ! empty( $block_hook ) ) :
	?>
	<div id="<?php echo esc_attr( $block_hook ); ?>" class="<?php echo esc_attr( $main_block_class ); ?>">
		<?php
		if ( is_admin() ) {
			echo wp_kses_post( '<p><i>Hook: ' . $block_hook . ' (only displays in admin)</i></p>' );
		}
		?>
	</div>
	<?php
endif;
