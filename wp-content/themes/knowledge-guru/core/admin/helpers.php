<?php

/**
 * Get the list of available post listing layouts
 *
 * @return array List of available options
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_post_layouts' ) ) :
	function kbg_get_post_layouts( $filter = array(), $exclude = array() ) {

		$layouts = kbg_get_post_layouts_map();

		if ( ! empty( $filter ) ) {
			foreach ( $layouts as $id => $layout ) {
				foreach ( $filter as $what => $value ) {
					if ( ( isset( $layout[ $what ] ) && $layout[ $what ] == $value ) || ( ! isset( $layout[ $what ] ) && $value == false ) ) {
						continue;
					}

					unset( $layouts[ $id ] );
				}
			}
		}

		if ( ! empty( $exclude ) ) {
			foreach ( $layouts as $id => $layout ) {
				foreach ( $exclude as $exclude_id ) {
					if ( $id == $exclude_id ) {
						unset( $layouts[ $id ] );
					}
				}
			}
		}

		$layouts = apply_filters( 'kbg_modify_post_layouts', $layouts );

		return $layouts;

	}
endif;

/**
 * Get the list of available post listing layouts
 *
 * @return array List of available options
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_kb_layouts' ) ) :
	function kbg_get_kb_layouts( $filter = array(), $exclude = array() ) {

		$layouts = kbg_get_kb_layouts_map();

		if ( ! empty( $filter ) ) {
			foreach ( $layouts as $id => $layout ) {
				foreach ( $filter as $what => $value ) {
					if ( ( isset( $layout[ $what ] ) && $layout[ $what ] == $value ) || ( ! isset( $layout[ $what ] ) && $value == false ) ) {
						continue;
					}

					unset( $layouts[ $id ] );
				}
			}
		}

		if ( ! empty( $exclude ) ) {
			foreach ( $layouts as $id => $layout ) {
				foreach ( $exclude as $exclude_id ) {
					if ( $id == $exclude_id ) {
						unset( $layouts[ $id ] );
					}
				}
			}
		}

		$layouts = apply_filters( 'kbg_modify_kb_layouts', $layouts );

		return $layouts;

	}
endif;


/**
 * Get the list of header layouts
 *
 * @param bool    $inherit Wheter to display "inherit" option
 * @param bool    $none    Wheter to display "none" option
 * @return array List of available options
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_header_layouts' ) ) :
	function kbg_get_header_layouts( $exclude = array() ) {

		$layouts = array();

		$layouts['1'] = array(
			'alt' => esc_html__( 'Layout 1', 'knowledge-guru' ),
			'src' => get_parent_theme_file_uri( '/assets/img/admin/header_layout_1.svg' ),
		);
		$layouts['2'] = array(
			'alt' => esc_html__( 'Layout 2', 'knowledge-guru' ),
			'src' => get_parent_theme_file_uri( '/assets/img/admin/header_layout_2.svg' ),
		);
		$layouts['3'] = array(
			'alt' => esc_html__( 'Layout 3', 'knowledge-guru' ),
			'src' => get_parent_theme_file_uri( '/assets/img/admin/header_layout_3.svg' ),
		);

		if ( ! empty( $exclude ) ) {
			foreach ( $exclude as $element ) {
				if ( isset( $layouts[ $element ] ) ) {
					unset( $layouts[ $element ] );
				}
			}
		}

		$layouts = apply_filters( 'kbg_modify_header_layouts', $layouts );

		return $layouts;

	}
endif;


/**
 * Get meta options
 *
 * @return array List of available options
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_meta_opts' ) ) :
	function kbg_get_meta_opts( $disable = false, $exclude = array() ) {

		$options             = array();
		$options['category'] = esc_html__( 'Category', 'knowledge-guru' );
		$options['date']     = esc_html__( 'Date', 'knowledge-guru' );
		$options['author']   = esc_html__( 'Author', 'knowledge-guru' );
		$options['rtime']    = esc_html__( 'Reading time', 'knowledge-guru' );
		$options['comments'] = esc_html__( 'Comments', 'knowledge-guru' );

		if ( $disable ) {
			$options['none'] = esc_html__( 'None', 'knowledge-guru' );
		}

		if ( !empty( $exclude ) ) {
			foreach ( $exclude as $meta ) {
				unset($options[$meta]);
			}
		}

		$options = apply_filters( 'kbg_modify_meta_opts', $options );

		return $options;
	}
endif;



/**
 * Get header actions options
 *
 * @return array List of available options
 * @since  1.0
 */
if ( ! function_exists( 'kbg_get_header_main_area_actions' ) ) :
	function kbg_get_header_main_area_actions( $exclude = array() ) {
		$actions = array(
			'search-form'     => esc_html__( 'Search form', 'knowledge-guru' ),
			'social'          => esc_html__( 'Social menu', 'knowledge-guru' ),
		);

		if ( ! empty( $exclude ) ) {
			foreach ( $exclude as $element ) {
				if ( isset( $actions[ $element ] ) ) {
					unset( $actions[ $element ] );
				}
			}
		}

		$actions = apply_filters( 'kbg_modify_header_main_area_actions', $actions );

		return $actions;
	}
endif;


/**
 * Get the list of available pagination types
 *
 * @param bool    $ihnerit Whether you want to include "inherit" option in the list
 * @param bool    $none    Whether you want to add "none" option ( to set layout to "off")
 * @return array List of available options
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_pagination_layouts' ) ) :
	function kbg_get_pagination_layouts( $inherit = false, $none = false ) {

		$layouts = array();

		if ( $inherit ) {
			$layouts['inherit'] = array(
				'alt' => esc_html__( 'Inherit', 'knowledge-guru' ),
				'src' => get_parent_theme_file_uri( '/assets/img/admin/inherit.svg' ),
			);
		}

		if ( $none ) {
			$layouts['none'] = array(
				'alt' => esc_html__( 'None', 'knowledge-guru' ),
				'src' => get_parent_theme_file_uri( '/assets/img/admin/pagination_none.svg' ),
			);
		}

		$layouts['numeric']         = array(
			'alt' => esc_html__( 'Numeric pagination links', 'knowledge-guru' ),
			'src' => get_parent_theme_file_uri( '/assets/img/admin/pagination_numeric.svg' ),
		);
		$layouts['prev-next']       = array(
			'alt' => esc_html__( 'Prev/Next page links', 'knowledge-guru' ),
			'src' => get_parent_theme_file_uri( '/assets/img/admin/pagination_prevnext.svg' ),
		);
		$layouts['load-more']       = array(
			'alt' => esc_html__( 'Load more button', 'knowledge-guru' ),
			'src' => get_parent_theme_file_uri( '/assets/img/admin/pagination_loadmore.svg' ),
		);
		$layouts['infinite-scroll'] = array(
			'alt' => esc_html__( 'Infinite scroll', 'knowledge-guru' ),
			'src' => get_parent_theme_file_uri( '/assets/img/admin/pagination_infinite.svg' ),
		);

		$layouts = apply_filters( 'kbg_modify_pagination_layouts', $layouts );

		return $layouts;
	}
endif;


/**
 * Get footer layouts options
 *
 * @return array List of available options
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_footer_layouts' ) ) :
	function kbg_get_footer_layouts() {
		$layouts = array(
			'12'      => array(
				'alt' => '12',
				'src' => get_parent_theme_file_uri( '/assets/img/admin/footer_12.svg' ),
			),
			'4'       => array(
				'alt' => '4',
				'src' => get_parent_theme_file_uri( '/assets/img/admin/footer_4.svg' ),
			),
			'6-6'     => array(
				'alt' => '6-6',
				'src' => get_parent_theme_file_uri( '/assets/img/admin/footer_6_6.svg' ),
			),
			'4-4-4'   => array(
				'alt' => '4-4-4',
				'src' => get_parent_theme_file_uri( '/assets/img/admin/footer_4_4_4.svg' ),
			),
			'3-3-3-3' => array(
				'alt' => '3-3-3-3',
				'src' => get_parent_theme_file_uri( '/assets/img/admin/footer_3_3_3_3.svg' ),
			),
			'8-4'     => array(
				'alt' => '8-4',
				'src' => get_parent_theme_file_uri( '/assets/img/admin/footer_8_4.svg' ),
			),
			'4-8'     => array(
				'alt' => '4-8',
				'src' => get_parent_theme_file_uri( '/assets/img/admin/footer_4_8.svg' ),
			),
			'6-3-3'   => array(
				'alt' => '6-3-3',
				'src' => get_parent_theme_file_uri( '/assets/img/admin/footer_6_3_3.svg' ),
			),
			'3-3-6'   => array(
				'alt' => '3-3-6',
				'src' => get_parent_theme_file_uri( '/assets/img/admin/footer_3_3_6.svg' ),
			),
			'3-6-3'   => array(
				'alt' => '3-6-3',
				'src' => get_parent_theme_file_uri( '/assets/img/admin/footer_3_6_3.svg' ),
			),
			'3-4-5'   => array(
				'alt' => '3-4-5',
				'src' => get_parent_theme_file_uri( '/assets/img/admin/footer_3_4_5.svg' ),
			),
			'5-4-3'   => array(
				'alt' => '5-4-3',
				'src' => get_parent_theme_file_uri( '/assets/img/admin/footer_5_4_3.svg' ),
			),
			'3-5-4'   => array(
				'alt' => '3-5-4',
				'src' => get_parent_theme_file_uri( '/assets/img/admin/footer_3_5_4.svg' ),
			),
			'4-5-3'   => array(
				'alt' => '4-5-3',
				'src' => get_parent_theme_file_uri( '/assets/img/admin/footer_4_5_3.svg' ),
			),
		);

		$layouts = apply_filters( 'kbg_modify_footer_layouts', $layouts );

		return $layouts;
	}
endif;


/**
 * Get image ratio options
 *
 * @param bool    $kbg Wheter to include "kbg (not cropped)" ratio option
 * @return array List of available options
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_image_ratio_opts' ) ) :
	function kbg_get_image_ratio_opts( $original = false ) {

		$options = array();

		if ( $original ) {
			$options['original'] = esc_html__( 'Original (ratio as uploaded - do not crop)', 'knowledge-guru' );
		}

		$options['21_9']   = esc_html__( '21:9', 'knowledge-guru' );
		$options['16_9']   = esc_html__( '16:9', 'knowledge-guru' );
		$options['3_2']    = esc_html__( '3:2', 'knowledge-guru' );
		$options['4_3']    = esc_html__( '4:3', 'knowledge-guru' );
		$options['1_1']    = esc_html__( '1:1 (square)', 'knowledge-guru' );
		$options['3_4']    = esc_html__( '3:4', 'knowledge-guru' );
		$options['custom'] = esc_html__( 'Custom ratio', 'knowledge-guru' );

		$options = apply_filters( 'kbg_modify_ratio_opts', $options );
		return $options;
	}
endif;

/**
 * Get the list of available single post layouts
 *
 * @param bool    $ihnerit Whether you want to add "inherit" option
 * @return array List of available options
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_single_layouts' ) ) :
	function kbg_get_single_layouts( $inherit = false ) {

		$layouts = array();

		if ( $inherit ) {
			$layouts['inherit'] = array(
				'alt' => esc_html__( 'Inherit', 'knowledge-guru' ),
				'src' => get_parent_theme_file_uri( '/assets/img/admin/inherit.png' ),
			);
		}

		$layouts = apply_filters( 'kbg_modify_single_layouts', $layouts );

		return $layouts;
	}
endif;


/**
 * Get the list of available page layouts
 *
 * @param bool    $inherit Whether you want to add "inherit" option
 * @return array List of available options
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_page_layouts' ) ) :
	function kbg_get_page_layouts( $inherit = false ) {

		$layouts = array();

		if ( $inherit ) {
			$layouts['inherit'] = array(
				'alt' => esc_html__( 'Inherit', 'knowledge-guru' ),
				'src' => get_parent_theme_file_uri( '/assets/img/admin/inherit.png' ),
			);
		}
		
		$layouts = apply_filters( 'kbg_modify_page_layouts', $layouts );

		return $layouts;

	}
endif;


/**
 * Get the list of available archive layouts
 *
 * @param bool    $ihnerit Whether you want to add "inherit" option
 * @return array List of available options
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_archive_layouts' ) ) :
	function kbg_get_archive_layouts( $inherit = false ) {

		$layouts = array();

		if ( $inherit ) {
			$layouts['inherit'] = array(
				'alt' => esc_html__( 'Inherit', 'knowledge-guru' ),
				'src' => get_parent_theme_file_uri( '/assets/img/admin/inherit.png' ),
			);
		}

		$layouts = apply_filters( 'kbg_modify_archive_layouts', $layouts );

		return $layouts;

	}
endif;


/**
 * Get the list of available sidebar layouts
 *
 * You may have left sidebar, right sidebar or no sidebar
 *
 * @param bool    $ihnerit Whether you want to include "inherit" option in the list
 * @return array List of available sidebar layouts
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_sidebar_layouts' ) ) :
	function kbg_get_sidebar_layouts( $inherit = false, $none = false ) {

		$layouts = array();

		if ( $inherit ) {
			$layouts['inherit'] = array(
				'alt' => esc_html__( 'Inherit', 'knowledge-guru' ),
				'src' => get_parent_theme_file_uri( '/assets/img/admin/inherit.svg' ),
			);
		}

		if ( $none ) {
			$layouts['none'] = array(
				'alt' => esc_html__( 'None', 'knowledge-guru' ),
				'src' => get_parent_theme_file_uri( '/assets/img/admin/sidebar_none.svg' ),
			);
		}

		$layouts['left']  = array(
			'alt' => esc_html__( 'Left sidebar', 'knowledge-guru' ),
			'src' => get_parent_theme_file_uri( '/assets/img/admin/sidebar_left.svg' ),
		);
		$layouts['right'] = array(
			'alt' => esc_html__( 'Right sidebar', 'knowledge-guru' ),
			'src' => get_parent_theme_file_uri( '/assets/img/admin/sidebar_right.svg' ),
		);

		$layouts = apply_filters( 'kbg_modify_sidebar_layouts', $layouts );

		return $layouts;
	}
endif;


/**
 * Get the list of registered sidebars
 *
 * @param bool    $ihnerit Whether you want to include "inherit" option in the list
 * @return array Returns list of available sidebars
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_sidebars_list' ) ) :
	function kbg_get_sidebars_list( $inherit = false ) {

		$sidebars = array();

		if ( $inherit ) {
			$sidebars['inherit'] = esc_html__( 'Inherit', 'knowledge-guru' );
		}

		$sidebars['none'] = esc_html__( 'None', 'knowledge-guru' );

		global $wp_registered_sidebars;

		if ( ! empty( $wp_registered_sidebars ) ) {

			foreach ( $wp_registered_sidebars as $sidebar ) {
				$sidebars[ $sidebar['id'] ] = $sidebar['name'];
			}
		}
		// Get sidebars from wp_options if global var is not loaded yet
		$fallback_sidebars = get_option( 'kbg_registered_sidebars' );
		if ( ! empty( $fallback_sidebars ) ) {
			foreach ( $fallback_sidebars as $sidebar ) {
				if ( ! array_key_exists( $sidebar['id'], $sidebars ) ) {
					$sidebars[ $sidebar['id'] ] = $sidebar['name'];
				}
			}
		}

		// Check for theme additional sidebars
		$custom_sidebars = kbg_get_option( 'sidebars' );

		if ( $custom_sidebars ) {
			foreach ( $custom_sidebars as $k => $sidebar ) {
				if ( is_numeric( $k ) && ! array_key_exists( 'kbg_sidebar_' . $k, $sidebars ) ) {
					$sidebars[ 'kbg_sidebar_' . $k ] = $sidebar['name'];
				}
			}
		}

		// Do not display footer sidebars for selection
		unset( $sidebars['kbg_sidebar_footer_1'] );
		unset( $sidebars['kbg_sidebar_footer_2'] );
		unset( $sidebars['kbg_sidebar_footer_3'] );
		unset( $sidebars['kbg_sidebar_footer_4'] );

		// Do not display hidden sidebar for selection
		unset( $sidebars['kbg_sidebar_hidden'] );

		$sidebars = apply_filters( 'kbg_modify_sidebars_list', $sidebars );

		return $sidebars;
	}
endif;


/**
 * Get the list of available options for post ordering
 *
 * @return array List of available options
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_post_order_opts' ) ) :
	function kbg_get_post_order_opts() {

		$options = array(
			'date'          => esc_html__( 'Date', 'knowledge-guru' ),
			'comment_count' => esc_html__( 'Number of comments', 'knowledge-guru' ),
			'title'         => esc_html__( 'Title (alphabetically)', 'knowledge-guru' ),
		);

		$options = apply_filters( 'kbg_modify_post_order_opts', $options );

		return $options;
	}
endif;


/**
 * Get breadcrumbs by options
 *
 * Check breadcrumbs support depending on witch plugins are active
 *
 * @return bool
 * @since  1.0
 */
if ( ! function_exists( 'kbg_get_breadcrumbs_options' ) ) :
	function kbg_get_breadcrumbs_options() {

		$options['none']  = esc_html__( 'None', 'knowledge-guru' );
		$options['yoast'] = esc_html__( 'Yoast SEO (or Yoast Breadcrumbs)', 'knowledge-guru' );
		$options['bcn']   = esc_html__( 'Breadcrumb NavXT', 'knowledge-guru' );

		$options = apply_filters( 'kbg_modify_breadcrumbs_options', $options );

		return $options;
	}
endif;


/**
 * Get Admin JS localized variables
 *
 * Function creates list of variables from theme to pass
 * them to global JS variable so we can use it in JS files
 *
 * @since  1.0
 *
 * @return array List of JS settings
 */
if ( ! function_exists( 'kbg_get_admin_js_settings' ) ) :
	function kbg_get_admin_js_settings() {

		$js_settings             = array();
		$js_settings['ajax_url'] = admin_url( 'admin-ajax.php' );
		return $js_settings;
	}
endif;


/**
 * Get post_types options 
 *
 * @return array List of available options
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_post_types_opts' ) ) :
	function kbg_get_post_types_opts( $disable = false, $exclude = array() ) {

		$post_types = get_post_types(
			array(
				'public' => true, 
				'exclude_from_search' => false
			), 
			'objects'
		);

		$options = array();

		foreach( $post_types as $type) {

			if ( $type->name === 'attachment' ) {
				continue;
			}

			$options[$type->name] = $type->label;
		}
		

		$options = apply_filters( 'kbg_modify_post_types_opts', $options );

		return $options;
	}
endif;
