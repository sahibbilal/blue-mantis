<?php
/**
 * Functions and hooks for the theme blocks.
 *
 * @package Propel
 * @since   2.2.0
 */

defined( 'ABSPATH' ) || die();

/**
 * Class managing the theme blocks post type.
 */
class Theme_Core_Theme_Blocks extends Theme_Core_Component {
	/**
	 * An array of theme block locations with post type locations added.
	 *
	 * @var array
	 */
	public $theme_block_locations;

	/**
	 * Add support for thumbnails and register all images sizes
	 * added in the settings file.
	 */
	protected function init() {
		if ( isset( $this->settings->theme_block_locations ) ) {
			add_action( 'init', array( $this, 'register_theme_block_post_type' ) );
			add_filter( 'wpseo_sitemap_exclude_post_type', array( $this, 'exclude_from_sitemap' ), 10, 2 );
			add_action( 'acf/init', array( $this, 'add_theme_block_fieldgroup' ), 10, 2 );
			add_filter( 'manage_theme_block_posts_columns', array( $this, 'add_location_column' ) );
			add_action( 'manage_theme_block_posts_custom_column', array( $this, 'add_location_column_values' ), 10, 2 );
		}
	}

	/**
	 * Register Theme Blocks post type.
	 */
	public function register_theme_block_post_type() {
		$labels = array(
			'name'                  => __( 'Theme Blocks', 'propel' ),
			'singular_name'         => __( 'Theme Block', 'propel' ),
			'menu_name'             => __( 'Theme Blocks', 'propel' ),
			'name_admin_bar'        => __( 'Theme Blocks', 'propel' ),
			'add_new'               => __( 'Add New', 'propel' ),
			'add_new_item'          => __( 'Add New Theme Block', 'propel' ),
			'new_item'              => __( 'New Theme Block', 'propel' ),
			'edit_item'             => __( 'Edit Theme Block', 'propel' ),
			'view_item'             => __( 'View Theme Block', 'propel' ),
			'all_items'             => __( 'All Theme Blocks', 'propel' ),
			'search_items'          => __( 'Search Theme Blocks', 'propel' ),
			'parent_item_colon'     => __( 'Parent Theme Blocks:', 'propel' ),
			'not_found'             => __( 'No theme blocks found.', 'propel' ),
			'not_found_in_trash'    => __( 'No theme blocks found in Trash.', 'propel' ),
			'featured_image'        => __( 'Theme Block Cover Image', 'propel' ),
			'archives'              => __( 'Theme Blocks archives', 'propel' ),
			'insert_into_item'      => __( 'Insert into theme block', 'propel' ),
			'uploaded_to_this_item' => __( 'Uploaded to this theme block', 'propel' ),
			'filter_items_list'     => __( 'Filter theme blocks list', 'propel' ),
			'items_list_navigation' => __( 'Theme Blocks list navigation', 'propel' ),
			'items_list'            => __( 'Theme Blocks list', 'propel' ),
		);

		register_post_type(
			'theme_block',
			array(
				'label'               => __( 'Theme Blocks', 'propel' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'revisions', 'editor', 'author' ),
				'taxonomies'          => array(),
				'public'              => false,
				'show_ui'             => true,
				'publicly_queryable'  => false,
				'exclude_from_search' => true,
				'menu_icon'           => 'dashicons-admin-generic',
				'has_archive'         => false,
				'show_in_rest'        => true,
				'menu_position'       => 2,
			)
		);
	}

	/**
	 * Exclude theme blocks from sitemap.
	 *
	 * @param bool   $exclude   Default false.
	 * @param string $post_type Post type name.
	 */
	public function exclude_from_sitemap( $exclude, $post_type ) {
		if ( 'theme_block' === $post_type ) {
			return true;
		}

		return $exclude;
	}

	/**
	 * Add ACF fields to theme blocks to add location option.
	 */
	public function add_theme_block_fieldgroup() {
		if ( empty( $this->settings->theme_block_locations ) ) {
			return;
		}

		$this->theme_block_locations = (array) $this->settings->theme_block_locations;

		if ( ! empty( $this->settings->post_types ) ) {
			foreach ( $this->settings->post_types as $post_type_slug => $post_type_args ) {
				if ( ! empty( $post_type_args->singular ) ) {
					$theme_block_location_name = $post_type_args->singular;
				} elseif ( ! empty( $post_type_args->plural ) ) {
					$theme_block_location_name = $post_type_args->plural;
				} else {
					$theme_block_location_name = $post_type_slug;
				}

				if ( ! empty( $post_type_args->plural ) ) {
					$theme_block_location_label = $post_type_args->plural;
				} elseif ( ! empty( $post_type_args->singular ) ) {
					$theme_block_location_label = $post_type_args->singular;
				} else {
					$theme_block_location_label = $post_type_slug;
				}

				$this->theme_block_locations[ $post_type_slug . '_label' ]  = '<span>' . $theme_block_location_label . '</span>';
				$this->theme_block_locations[ $post_type_slug . '_top' ]    = __( $theme_block_location_name . ' - Top', 'propel' );
				$this->theme_block_locations[ $post_type_slug . '_bottom' ] = __( $theme_block_location_name . ' - Bottom', 'propel' );

				if ( ! empty( $post_type_args->taxonomies ) ) {
					foreach ( $post_type_args->taxonomies as $taxonomy_slug => $taxonomy_args ) {
						if ( ! empty( $taxonomy_args->singular ) ) {
							$theme_block_location_name = $taxonomy_args->singular;
						} elseif ( ! empty( $taxonomy_args->plural ) ) {
							$theme_block_location_name = $taxonomy_args->plural;
						} else {
							$theme_block_location_name = $taxonomy_slug;
						}

						$this->theme_block_locations[ $taxonomy_slug ] = $theme_block_location_name;
					}
				}

				if ( ! empty( $post_type_args->theme_block_locations ) ) {
					$this->theme_block_locations = array_merge( $this->theme_block_locations, (array) $post_type_args->theme_block_locations );
				}

				acf_add_local_field_group(
					array(
						'key'                   => $post_type_slug . '_options',
						'title'                 => sprintf( __( '%s Settings', 'propel' ), $theme_block_location_label ),
						'fields'                => array(
							array(
								'key'               => $post_type_slug . '_archive',
								'label'             => sprintf( __( '%s Archive', 'propel' ), $theme_block_location_label ),
								'name'              => $post_type_slug . '_archive',
								'aria-label'        => '',
								'type'              => 'post_object',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '50',
									'class' => '',
									'id'    => '',
								),
								'post_type'         => array(
									'page',
								),
								'taxonomy'          => '',
								'return_format'     => 'id',
								'multiple'          => 0,
								'allow_null'        => 1,
								'ui'                => 0,
							),
						),
						'location'              => array(
							array(
								array(
									'param'    => 'options_page',
									'operator' => '==',
									'value'    => 'acf-options-' . $post_type_slug,
								),
							),
						),
						'menu_order'            => 0,
						'position'              => 'normal',
						'style'                 => 'default',
						'label_placement'       => 'top',
						'instruction_placement' => 'label',
						'hide_on_screen'        => '',
						'active'                => true,
						'description'           => '',
						'show_in_rest'          => 0,
					)
				);
			}
		}

		acf_add_local_field_group(
			array(
				'key'                   => 'theme_block_options',
				'title'                 => 'Block Options',
				'fields'                => array(
					array(
						'key'               => 'theme_block_display_location',
						'label'             => 'Display Location',
						'name'              => 'display_location',
						'aria-label'        => '',
						'type'              => 'checkbox',
						'instructions'      => __( 'Select the area of the theme where this block should be displayed.', 'propel' ),
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'choices'           => $this->theme_block_locations,
						'default_value'     => array(),
						'return_format'     => 'value',
						'ui'                => 0,
						'ajax'              => 0,
						'placeholder'       => '',
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'theme_block',
						),
					),
				),
				'menu_order'            => 0,
				'position'              => 'side',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => '',
				'active'                => true,
				'description'           => '',
				'show_in_rest'          => 0,
			)
		);
	}

	/**
	 * Add display location column to theme block dashboard page.
	 *
	 * @param string[] $post_columns An associative array of column headings.
	 */
	public function add_location_column( $post_columns ) {
		$post_columns['theme_block_display_location'] = __( 'Display Location(s)', 'propel' );

		return $post_columns;
	}

	/**
	 * Add display location values to theme block dashboard posts.
	 *
	 * @param string $column_name The name of the column to display.
	 * @param int    $post_id    The current post ID.
	 */
	public function add_location_column_values( $column_name, $post_id ) {
		if ( 'theme_block_display_location' === $column_name ) {
			$theme_block_display_location = get_post_meta( $post_id, 'display_location', true );

			if ( ! empty( $theme_block_display_location ) && ! empty( $this->theme_block_locations ) ) {
				foreach ( $theme_block_display_location as $display_location_slug ) {
					if ( ! empty( $this->theme_block_locations[ $display_location_slug ] ) ) {
						echo wp_kses_post( '<div>' . $this->theme_block_locations[ $display_location_slug ] . '</div>' );
					}
				}
			}
		}
	}
}
