<?php
/**
 * Theme Scripts and Styles.
 *
 * This component enqueues all the scripts and styles used by the theme.
 *
 * @package Propel
 * @since   2.1.1
 */

defined( 'ABSPATH' ) || die();

/**
 * Class handing general enqueueing of scripts and styles.
 */
class Theme_Core_Scripts extends Theme_Core_Component {
	/**
	 * Enqueue all scripts and styles registered in settings.
	 */
	protected function init() {
		add_action(
			'wp_enqueue_scripts',
			function () {
				$this->enqueue_built_in_scripts();
				$this->enqueue_theme_scripts();
				$this->enqueue_theme_styles();
				$this->register_theme_component_and_template_styles();
				$this->register_theme_component_and_template_scripts();
				$this->register_core_block_styles();
				$this->register_core_block_scripts();
			}
		);

		add_action(
			'enqueue_block_editor_assets',
			function () {
				$this->register_theme_component_and_template_styles( true, true );
				$this->register_core_block_styles( true, true );
				$this->enqueue_admin_scripts();
				$this->enqueue_admin_styles();
				$this->enqueue_editor_styles_and_scripts();
			},
			1
		);

		add_action(
			'admin_head',
			function () {
				$this->enqueue_admin_styles();
			}
		);

		add_theme_support( 'editor-font-sizes', array() );
		add_filter( 'should_load_separate_core_block_assets', '__return_true' );

		$this->localize_script();
	}

	/**
	 * Enqueue the scripts build into WordPress Core. By default the function includes
	 * just jQuery and script handling comment replies, but it also handles additional
	 * scripts that can be defined in the theme configuration file.
	 */
	protected function enqueue_built_in_scripts() {
		wp_enqueue_script( 'jquery' );

		if ( is_singular() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		$additional_scripts = $this->settings->enqueue_built_in_scripts;
		if ( ! is_array( $additional_scripts ) || empty( $additional_scripts ) ) {
			return;
		}

		foreach ( $additional_scripts as $script ) {
			wp_enqueue_script( $script );
		}
	}

	/**
	 * Enqueue scripts defined by the developer in theme settings file.
	 */
	protected function enqueue_theme_scripts() {
		if ( ! $this->settings ) {
			return;
		}

		if ( false === $this->settings->enqueue_scripts && false === $this->settings->register_scripts ) {
			return;
		}

		if ( false !== $this->settings->enqueue_scripts ) {
			foreach ( $this->settings->enqueue_scripts as $handle => $script ) {
				$params = array(
					'src'          => '',
					'dependencies' => array(),
					'version'      => null,
					'in_footer'    => true,
				);

				if ( is_object( $script ) ) {
					$params = wp_parse_args( (array) $script, $params );
				} else {
					$params['src'] = $script;
				}

				if ( empty( $params['src'] ) ) {
					continue;
				}

				if ( 'filemtime' === $params['version'] ) {
					$path = $this->get_script_path( $params['src'] );

					if ( file_exists( $path ) ) {
						$params['version'] = filemtime( $path );
					}
				}

				wp_enqueue_script(
					$handle,
					$this->get_script_url( $params['src'] ),
					$params['dependencies'],
					$params['version'],
					$params['in_footer']
				);
			}
		}

		if ( false !== $this->settings->register_scripts ) {
			foreach ( $this->settings->register_scripts as $handle => $script ) {
				$params = array(
					'src'          => '',
					'dependencies' => array(),
					'version'      => null,
					'in_footer'    => true,
				);

				if ( is_object( $script ) ) {
					$params = wp_parse_args( (array) $script, $params );
				} else {
					$params['src'] = $script;
				}

				if ( empty( $params['src'] ) ) {
					continue;
				}

				if ( 'filemtime' === $params['version'] ) {
					$path = $this->get_script_path( $params['src'] );

					if ( file_exists( $path ) ) {
						$params['version'] = filemtime( $path );
					}
				}

				wp_register_script(
					$handle,
					$this->get_script_url( $params['src'] ),
					$params['dependencies'],
					$params['version'],
					$params['in_footer']
				);
			}
		}
	}

	/**
	 * Enqueue styles defined by the user in theme settings file.
	 */
	protected function enqueue_theme_styles() {
		if ( ! $this->settings ) {
			return;
		}

		if ( false === $this->settings->enqueue_styles && false === $this->settings->register_styles ) {
			return;
		}

		if ( false !== $this->settings->enqueue_styles ) {
			foreach ( $this->settings->enqueue_styles as $handle => $style ) {
				$params = array(
					'src'          => '',
					'dependencies' => array(),
					'version'      => null,
					'media'        => 'all',
				);

				if ( is_object( $style ) ) {
					$params = wp_parse_args( (array) $style, $params );
				} else {
					$params['src'] = $style;
				}

				if ( empty( $params['src'] ) ) {
					continue;
				}

				if ( 'filemtime' === $params['version'] ) {
					$path = $this->get_script_path( $params['src'] );

					if ( file_exists( $path ) ) {
						$params['version'] = filemtime( $path );
					}
				}

				wp_enqueue_style(
					$handle,
					$this->get_script_url( $params['src'] ),
					$params['dependencies'],
					$params['version'],
					$params['media']
				);
			}
		}

		if ( false !== $this->settings->register_styles ) {
			foreach ( $this->settings->register_styles as $handle => $style ) {
				$params = array(
					'src'          => '',
					'dependencies' => array(),
					'version'      => null,
					'media'        => 'all',
				);

				if ( is_object( $style ) ) {
					$params = wp_parse_args( (array) $style, $params );
				} else {
					$params['src'] = $style;
				}

				if ( empty( $params['src'] ) ) {
					continue;
				}

				if ( 'filemtime' === $params['version'] ) {
					$path = $this->get_script_path( $params['src'] );

					if ( file_exists( $path ) ) {
						$params['version'] = filemtime( $path );
					}
				}

				wp_register_style(
					$handle,
					$this->get_script_url( $params['src'] ),
					$params['dependencies'],
					$params['version'],
					$params['media']
				);
			}
		}
	}

	/**
	 * Enqueue component and template styles. Template styles matching the current template name will be automatically enqueued.
	 *
	 * @param bool $enqueue_styles   Whether to also enqueue the styles.
	 * @param bool $editor_styles    Whether to use the editor styles.
	 */
	protected function register_theme_component_and_template_styles( $enqueue_styles = false, $editor_styles = false ) {
		global $template;

		$css_source_files = array_merge( glob( get_template_directory() . '/blocks/components/**/*.scss' ), glob( get_template_directory() . '/blocks/templates/**/*.scss' ) );

		if ( ! empty( $css_source_files ) ) {
			foreach ( $css_source_files as $css_source_file ) {
				$css_file = str_replace( '/style.scss', '.css', $css_source_file );
				$css_file = str_replace( '/blocks/', '/dist/', $css_file );

				if ( true === $editor_styles ) {
					$css_file = str_replace( '.css', '-editor-styles.css', $css_file );
				}

				if ( file_exists( $css_file ) ) {
					preg_match( '/(?<=components\/).*?(?=.css)/', $css_file, $matches );

					if ( ! empty( $matches[0] ) ) {
						$directory = 'components';
					} else {
						$directory = 'templates';
						preg_match( '/(?<=templates\/).*?(?=.css)/', $css_file, $matches );
					}

					if ( ! empty( $matches[0] ) ) {
						wp_register_style(
							$matches[0],
							get_template_directory_uri() . '/dist/' . $directory . '/' . $matches[0] . '.css',
							array( 'theme-styles' ),
							filemtime( $css_file )
						);

						if ( true === $enqueue_styles || ( 'templates' === $directory && ! empty( $template ) && basename( $template ) === $matches[0] . '.php' ) ) {
							wp_enqueue_style( $matches[0] );
						}
					}
				}
			}
		}
	}

	/**
	 * Enqueue component and template scripts. Template scripts matching the current template name will be automatically enqueued.
	 */
	protected function register_theme_component_and_template_scripts() {
		global $template;

		$js_files = array_merge( glob( get_template_directory() . '/blocks/components/**/script.js' ), glob( get_template_directory() . '/blocks/templates/**/script.js' ) );

		if ( ! empty( $js_files ) ) {
			foreach ( $js_files as $js_file ) {
				preg_match( '/(?<=components\/).*(?=\/)/U', $js_file, $matches );

				if ( ! empty( $matches[0] ) ) {
					$directory = 'components';
				} else {
					$directory = 'templates';
					preg_match( '/(?<=templates\/).*(?=\/)/U', $js_file, $matches );
				}

				if ( ! empty( $matches[0] ) ) {
					$main_js_directory = get_template_directory() . '/dist/' . $directory . '/' . $matches[0] . '.js';
					$main_js           = get_template_directory_uri() . '/dist/' . $directory . '/' . $matches[0] . '.js';

					if ( file_exists( $main_js_directory ) && ! is_admin() ) {
						wp_register_script( $matches[0], $main_js, array(), filemtime( $main_js_directory ), true );
					}

					if ( 'templates' === $directory && ! empty( $template ) && basename( $template ) === $matches[0] . '.php' ) {
						wp_enqueue_script( $matches[0] );
					}
				}
			}
		}
	}

	/**
	 * Enqueue core block styles.
	 *
	 * @param bool $enqueue_styles   Whether to also enqueue the styles.
	 * @param bool $editor_styles    Whether to use the editor styles.
	 */
	protected function register_core_block_styles( $enqueue_styles = false, $editor_styles = false ) {
		$core_block_css_source_files = glob( get_template_directory() . '/blocks/core-blocks/**/*.scss' );

		if ( ! empty( $core_block_css_source_files ) ) {
			foreach ( $core_block_css_source_files as $css_source_file ) {

				$css_file = str_replace( '/style.scss', '.css', $css_source_file );
				$css_file = str_replace( '/editor.scss', '-editor.css', $css_file );
				$css_file = str_replace( '/blocks/', '/dist/', $css_file );

				if ( true === $editor_styles && false === strpos( $css_file, 'editor' ) ) {
					$css_file = str_replace( '.css', '-editor-styles.css', $css_file );
				}

				if ( file_exists( $css_file ) ) {
					preg_match( '/(?<=core-blocks\/).*?(?=.css)/', $css_file, $matches );

					if ( ! empty( $matches[0] ) ) {
						wp_register_style(
							'core-' . $matches[0],
							get_template_directory_uri() . '/dist/core-blocks/' . $matches[0] . '.css',
							array(),
							filemtime( $css_file )
						);

						if ( true === $enqueue_styles ) {
							wp_enqueue_style( 'core-' . $matches[0] );
						}
					}
				}
			}
		}
	}

	/**
	 * Enqueue core block scripts.
	 */
	protected function register_core_block_scripts() {
		$core_block_js_source_files = glob( get_template_directory() . '/blocks/core-blocks/**/script.js' );

		if ( ! empty( $core_block_js_source_files ) ) {
			foreach ( $core_block_js_source_files as $js_source_file ) {
				$js_file = str_replace( '/script.js', '.js', $js_source_file );
				$js_file = str_replace( '/blocks/', '/dist/', $js_file );

				if ( file_exists( $js_file ) ) {
					preg_match( '/(?<=core-blocks\/).*?(?=.js)/', $js_file, $matches );

					if ( ! empty( $matches[0] ) ) {
						wp_register_script(
							'core-' . $matches[0],
							get_template_directory_uri() . '/dist/core-blocks/' . $matches[0] . '.js',
							array(),
							filemtime( $js_file ),
							true
						);
					}
				}
			}
		}
	}

	/**
	 * Enqueue admin scripts defined by the developer in theme settings file.
	 */
	protected function enqueue_admin_scripts() {
		if ( ! $this->settings ) {
			return;
		}

		if ( false === $this->settings->enqueue_admin_scripts ) {
			return;
		}

		foreach ( $this->settings->enqueue_admin_scripts as $handle => $script ) {
			$params = array(
				'src'          => '',
				'dependencies' => array(),
				'version'      => false,
				'in_footer'    => true,
			);

			if ( is_object( $script ) ) {
				$params = wp_parse_args( (array) $script, $params );
			} else {
				$params['src'] = $script;
			}

			if ( empty( $params['src'] ) ) {
				continue;
			}

			wp_enqueue_script(
				$handle,
				$this->get_script_url( $params['src'] ),
				$params['dependencies'],
				$params['version'],
				$params['in_footer']
			);
		}
	}

	/**
	 * Enqueue admin styles defined by the user in theme settings file.
	 */
	protected function enqueue_admin_styles() {
		if ( ! $this->settings ) {
			return;
		}

		if ( false === $this->settings->enqueue_admin_styles ) {
			return;
		}

		foreach ( $this->settings->enqueue_admin_styles as $handle => $style ) {
			$params = array(
				'src'          => '',
				'dependencies' => array(),
				'version'      => false,
				'media'        => 'all',
			);

			if ( is_object( $style ) ) {
				$params = wp_parse_args( (array) $style, $params );
			} else {
				$params['src'] = $style;
			}

			if ( empty( $params['src'] ) ) {
				continue;
			}

			wp_enqueue_style(
				$handle,
				$this->get_script_url( $params['src'] ),
				$params['dependencies'],
				$params['version'],
				$params['media']
			);
		}
	}

	/**
	 * Enqueue editor styles.
	 */
	protected function enqueue_editor_styles_and_scripts() {
		wp_deregister_style( 'wp-reset-editor-styles' );

		if ( file_exists( get_template_directory() . '/dist/styles-editor-styles.css' ) ) {
			wp_enqueue_style(
				'theme-styles',
				get_template_directory_uri() . '/dist/styles-editor-styles.css',
				array(),
				filemtime( get_template_directory() . '/dist/styles-editor-styles.css' )
			);
		}

		if ( file_exists( get_template_directory() . '/dist/editor.css' ) ) {
			wp_enqueue_style(
				'wp-reset-editor-styles',
				get_template_directory_uri() . '/dist/editor.css',
				array(),
				filemtime( get_template_directory() . '/dist/editor.css' )
			);
		}

		if ( file_exists( get_template_directory() . '/dist/editor.js' ) ) {
			wp_enqueue_script(
				'editor-scripts',
				get_template_directory_uri() . '/dist/editor.js',
				array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor' ),
				filemtime( get_template_directory() . '/dist/editor.js' ),
				true
			);
		}

		if ( class_exists( 'acf_field_icon_picker' ) ) {
			$icon_picker = new acf_field_icon_picker();

			if ( file_exists( $icon_picker->icon_font ) ) {
				$icon_css = file_get_contents( $icon_picker->icon_font ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents

				if ( ! empty( $icon_css ) ) {
					$icon_data = array();

					if ( preg_match_all( '/\.([a-zA-Z-]+)[:]{1,2}before ?{\n?.*?content: ?"(.*?)"/m', $icon_css, $matches, PREG_SET_ORDER ) ) {
						if ( ! empty( $matches ) ) {
							foreach ( $matches as $match ) {
								if ( ! empty( $match[1] ) && ! empty( $match[2] ) ) {
									$icon_array = explode( '-', $match[1] );
									array_shift( $icon_array );
									$icon_array = array_map( 'ucfirst', $icon_array );
									$icon_text  = implode( ' ', $icon_array );

									$icon_data[] = array(
										'value' => $match[1],
										'code'  => str_replace( '\\', '', $match[2] ),
										'name'  => $icon_text,
									);
								}
							}
						}
					}

					wp_localize_script(
						'editor-scripts',
						'iconpicker',
						array(
							'icons' => $icon_data,
						)
					);
				}
			}
		}

		wp_localize_script(
			'editor-scripts',
			'propel',
			array(
				'siteUrl'       => home_url(),
				'templateUrl'   => get_template_directory_uri(),
				'stylesheetUrl' => get_stylesheet_directory_uri(),
			)
		);

		$core_block_editor_source_files = glob( get_template_directory() . '/blocks/**/**/editor.js' );

		if ( ! empty( $core_block_editor_source_files ) ) {
			foreach ( $core_block_editor_source_files as $core_block_editor_source_file ) {
				$core_block_editor_file = str_replace( '/editor.js', '-editor.js', $core_block_editor_source_file );
				$core_block_editor_file = str_replace( '/blocks/', '/dist/', $core_block_editor_file );

				if ( file_exists( $core_block_editor_file ) ) {
					$file_info = pathinfo( $core_block_editor_file );
					preg_match( '/(?<=dist\/).*(?=' . $file_info['filename'] . ')/m', $core_block_editor_file, $matches );

					if ( ! empty( $matches[0] ) && file_exists( $core_block_editor_file ) ) {
						$main_js = get_template_directory_uri() . '/dist/' . $matches[0] . $file_info['basename'];

						wp_enqueue_script( $file_info['filename'], $main_js, array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor' ), filemtime( $core_block_editor_file ), true );
					}
				}
			}
		}
	}

	/**
	 * Pass basic information about the theme and WP installation to the JS.
	 */
	protected function localize_script() {
		JS::add(
			array(
				'siteUrl'       => home_url(),
				'templateUrl'   => get_template_directory_uri(),
				'stylesheetUrl' => get_stylesheet_directory_uri(),
				'ajaxUrl'       => site_url() . '/wp-admin/admin-ajax.php',
				'editPostsLink' => wp_json_encode(
					add_query_arg(
						array(
							'post'   => 'POSTID',
							'action' => 'edit',
						),
						get_admin_url( null, 'post.php' )
					)
				),
			)
		);

		add_action(
			'wp_enqueue_scripts',
			function () {
				JS::localize( 'WP' );
			},
			99
		);
	}

	/*
	 * Helpers
	 * ---------------------------------------------------------------------------------------
	 */

	/**
	 * Convert the script source provided into full URL. If the source is already a full
	 * URL, it will not be modified. Otherwise the source will be added to the theme
	 * URL (script is relative to the theme root).
	 *
	 * @param string $src Script source to convert.
	 *
	 * @return string Full URL to the script.
	 */
	protected function get_script_url( $src ) {
		if ( preg_match( '@\/\/@', $src ) ) {
			return $src;
		}

		return get_template_directory_uri() . '/' . $src;
	}

	/**
	 * Get the path to the script if not an external file.
	 *
	 * @param string $src The relative path to the script.
	 */
	protected function get_script_path( $src ) {
		if ( preg_match( '@\/\/@', $src ) ) {
			return $src;
		}

		return get_template_directory() . '/' . $src;
	}
}
