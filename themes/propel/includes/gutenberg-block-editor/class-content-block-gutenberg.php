<?php
/**
 * The Content Block Class.
 *
 * @package Propel
 * @since   2.1.0
 */

/**
 * Content Block Gutenberg
 *
 * A class for easily retrieving information related to our various content sections now powered by Gutenberg ACF blocks.
 */
class Content_Block_Gutenberg {
	/**
	 * The block data.
	 *
	 * @var array
	 */
	private $block;

	/**
	 * The block context.
	 *
	 * @var array
	 */
	private $context;

	/**
	 * Constructor.
	 *
	 * Sets up the block.
	 *
	 * @param array $block   The block data.
	 * @param array $context The block context.
	 */
	public function __construct( $block, $context = array() ) {
		$this->block   = $block;
		$this->context = $context;
	}

	/**
	 * Get Block ID.
	 *
	 * @return string ID friendly title.
	 */
	public function get_block_id() : string {
		$scroll_id = get_field( 'scroll_id' );
		$block_id  = ! empty( $scroll_id ) ? sanitize_title( $scroll_id ) : '';

		return $block_id;
	}

	/**
	 * Get Block ID with attribute definition.
	 *
	 * @return string ID friendly title.
	 */
	public function get_block_id_attr() : string {
		$block_id  = self::get_block_id();
		$attribute = '';

		if ( ! empty( $block_id ) ) {
			$attribute = 'id="' . $block_id . '" ';
		}

		return $attribute;
	}

	/**
	 * Get Block classes.
	 *
	 * @param array $args {
	 *    Optional arguments.
	 *
	 *     @type string   $background_color   Background color to override ACF field value.
	 *
	 * @return string background classes.
	 */
	public function get_block_classes( $args = array() ) : string {
		$output = '';

		if ( ! empty( $args['background_color'] ) ) {
			$background_color = $args['background_color'];
		} else {
			$background_color = get_field( 'background_color' );
		}

		if ( ! isset( $args['background_color'] ) || ( null !== $args['background_color'] && false !== $args['background_color'] ) ) {
			if ( ! empty( $background_color ) ) {
				$output = ' bg-' . $background_color;
			} else {
				$output = ' bg-transparent';
			}
		}

		if ( ! empty( $this->block['className'] ) ) {
			$output .= ' ' . $this->block['className'];
		}

		if ( ! is_admin() ) {
			if ( empty( $this->block['active'] ) || ( true !== $this->block['active'] && 'true' !== $this->block['active'] ) ) {
				$output .= ' block-inactive';
			}
		}

		return $output;
	}

	/**
	 * Get bootstrap column classes from an array of breakpoints.
	 *
	 * @param array $sizes    Sizes to get classes for.
	 * @param array $defaults The default sizes.
	 *
	 * @return string column classes.
	 */
	public function get_column_classes( array $sizes, array $defaults = array() ) : string {
		$classes = array_map(
			function( $viewport, $size ) use ( $defaults ) {
				if ( empty( $size ) && isset( $defaults[ $viewport ] ) ) {
					$size = $defaults[ $viewport ];
				}

				if ( 'mobile' === $viewport ) {
					$viewport = 'sm';
				} elseif ( 'tablet' === $viewport ) {
					$viewport = 'md';
				} elseif ( 'desktop' === $viewport ) {
					$viewport = 'lg';
				}

				return "col-$viewport-$size";
			},
			array_keys( $sizes ),
			$sizes
		);

		return 'col-12 ' . implode( ' ', $classes );
	}

	/**
	 * Get bootstrap column classes from an array of breakpoints.
	 *
	 * @param string $field_name    The ACF field name.
	 * @param string $parent_block  The parent block name. Can contain acf/ prefix.
	 *
	 * @return string column classes.
	 */
	public function get_parent_field( $field_name, $parent_block ) {
		$parent_block = str_replace( 'acf/', '', $parent_block );
		$value        = '';

		if ( ! empty( $this->context ) && ! empty( $this->context[ $parent_block ] ) && ! empty( $this->context[ $parent_block ][ $field_name ] ) ) {
			$value = $this->context[ $parent_block ][ $field_name ];
		}

		return $value;
	}
}
