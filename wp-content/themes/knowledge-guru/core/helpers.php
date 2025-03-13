<?php

/**
 * Debug (log) function
 *
 * Outputs any content into log file in theme root directory
 *
 * @param mixed   $mixed Content to output
 * @since  1.0
 */

if ( ! function_exists( 'kbg_log' ) ) :
	function kbg_log( $mixed ) {

		if ( ! function_exists( 'WP_Filesystem' ) || ! WP_Filesystem() ) {
			return false;
		}

		if ( is_array( $mixed ) ) {
			$mixed = print_r( $mixed, 1 );
		} elseif ( is_object( $mixed ) ) {
				ob_start();
				var_dump( $mixed );
				$mixed = ob_get_clean();
		}

		global $wp_filesystem;
		$existing = $wp_filesystem->get_contents( get_parent_theme_file_path( 'log' ) );
		$wp_filesystem->put_contents( get_parent_theme_file_path( 'log' ), $existing . $mixed . PHP_EOL );
	}
endif;

/**
 * Get option value from theme options
 *
 * A wrapper function for WordPress native get_option()
 * which gets an option from specific option key (set in theme options panel)
 *
 * @param string  $option Name of the option
 * @param string  $format How to parse the option based on its type
 * @return mixed Specific option value or "false" (if option is not found)
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_option' ) ) :
	function kbg_get_option( $option, $format = false ) {

		global $kbg_settings, $kbg_default_settings;

		if ( empty( $kbg_settings ) || is_customize_preview() ) {
			$kbg_settings = get_option( 'kbg_settings' );
		}

		if ( ! isset( $kbg_settings[ $option ] ) ) {

			if ( empty( $kbg_default_settings ) ) {
				$kbg_default_settings = kbg_get_default_option();
			}

			$kbg_settings[ $option ] = isset( $kbg_default_settings[ $option ] ) ? $kbg_default_settings[ $option ] : false;
		}

		if ( empty( $format ) ) {
			return $kbg_settings[ $option ];
		}

		$value = $kbg_settings[ $option ];

		switch ( $format ) {

			case 'image':
				$value = is_array( $kbg_settings[ $option ] ) && isset( $kbg_settings[ $option ]['url'] ) ? $kbg_settings[ $option ]['url'] : '';
				break;
			case 'multi':
				$value = is_array( $kbg_settings[ $option ] ) && ! empty( $kbg_settings[ $option ] ) ? array_keys( array_filter( $kbg_settings[ $option ] ) ) : array();
				break;

			case 'font':
				$native_fonts = kbg_get_native_fonts();
				if ( ! in_array( $value['font-family'], $native_fonts ) ) {
					$value['font-family'] = "'" . $value['font-family'] . "'";
				}

				break;

			default:
				$value = false;
				break;
		}

		return $value;

	}
endif;


/**
 * Get grid vars
 *
 * We use grid vars for dynamic sizes of specific elements such as generating image sizes and breakpoints etc...
 *
 * @return array
 * @since  1.0
 */

if ( ! function_exists( 'kbg_grid_vars' ) ) :
	function kbg_grid_vars() {

		$grid['column'] = 46;

		$grid['gutter'] = array(
			'xs' => 15,
			'sm' => 15,
			'md' => 30,
			'lg' => 30,
			'xl' => 50,
		);

		$grid['breakpoint'] = array(
			'xs' => 0,
			'sm' => 374,
			'md' => 600,
			'lg' => 989,
			'xl' => 1102,
		);

		$grid = apply_filters( 'kbg_modify_grid_vars', $grid );

		return $grid;

	}
endif;


if ( ! function_exists( 'kbg_size_by_col' ) ) :
	function kbg_size_by_col( $cols, $breakpoint = 'xl' ) {
		$grid = kbg_grid_vars();
		return ceil( ( $cols * $grid['column'] ) + ( ( $cols - 1 ) * $grid['gutter'][ $breakpoint ] ) );
	}
endif;


/**
 * Check if RTL mode is enabled
 *
 * @return bool
 * @since  1.0
 */

if ( ! function_exists( 'kbg_is_rtl' ) ) :
	function kbg_is_rtl() {

		if ( kbg_get_option( 'rtl_mode' ) ) {
			$rtl = true;
			// Check if current language is excluded from RTL
			$rtl_lang_skip = explode( ',', kbg_get_option( 'rtl_lang_skip' ) );
			if ( ! empty( $rtl_lang_skip ) ) {
				$locale = get_locale();
				if ( in_array( $locale, $rtl_lang_skip ) ) {
					$rtl = false;
				}
			}
		} else {
			$rtl = false;
		}

		return $rtl;
	}
endif;



/**
 * Generate dynamic css
 *
 * Function parses theme options and generates css code dynamically
 *
 * @return string Generated css code
 * @since  1.0
 */

if ( ! function_exists( 'kbg_generate_dynamic_css' ) ) :
	function kbg_generate_dynamic_css() {
		ob_start();
		get_template_part( 'assets/css/dynamic-css' );
		$output = ob_get_contents();
		ob_end_clean();

		$output = kbg_compress_css_code( $output );

		return $output;
	}
endif;

/**
 * Generate dynamic css
 *
 * Function parses theme options and generates css code dynamically
 *
 * @return string Generated css code
 * @since  1.0
 */
if ( ! function_exists( 'kbg_generate_dynamic_editor_css' ) ) :
	function kbg_generate_dynamic_editor_css() {
		ob_start();
		get_template_part( 'assets/css/admin/dynamic-editor-css' );
		$output = ob_get_contents();
		ob_end_clean();
		$output = kbg_compress_css_code( $output );

		return $output;
	}
endif;


/**
 * Get JS settings
 *
 * Function creates list of settings from thme options to pass
 * them to global JS variable so we can use it in JS files
 *
 * @return array List of JS settings
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_js_settings' ) ) :
	function kbg_get_js_settings() {
		$js_settings = array();

		$protocol                            = is_ssl() ? 'https://' : 'http://';
		$js_settings['ajax_url']             = admin_url( 'admin-ajax.php', $protocol );
		$js_settings['rtl_mode']             = kbg_is_rtl() ? true : false;
		$js_settings['header_sticky']        = kbg_get_option( 'header_sticky' ) ? true : false;
		$js_settings['header_sticky_offset'] = absint( kbg_get_option( 'header_sticky_offset' ) );
		$js_settings['header_sticky_up']     = kbg_get_option( 'header_sticky_up' ) ? true : false;
		$js_settings['grid']                 = kbg_grid_vars();

		$js_settings = apply_filters( 'kbg_modify_js_settings', $js_settings );

		return $js_settings;
	}
endif;


/**
 * Generate fonts link
 *
 * Function creates font link from fonts selected in theme options
 *
 * @return string
 * @since  1.0
 */

if ( ! function_exists( 'kbg_generate_fonts_link' ) ) :
	function kbg_generate_fonts_link() {

		$fonts       = array();
		$fonts[]     = kbg_get_option( 'main_font' );
		$fonts[]     = kbg_get_option( 'h_font' );
		$fonts[]     = kbg_get_option( 'nav_font' );
		$fonts[]     = kbg_get_option( 'button_font' );
		$unique      = array(); // do not add same font links
		$link        = array();
		$native      = kbg_get_native_fonts();
		$kirki_fonts = array( '', 'initial', 'inherit', 'Georgia,Times,"Times New Roman",serif', '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif', 'Monaco,"Lucida Sans Typewriter","Lucida Typewriter","Courier New",Courier,monospace' );
		$protocol    = is_ssl() ? 'https://' : 'http://';

		foreach ( $fonts as $font ) {
			if ( ! in_array( $font['font-family'], $kirki_fonts ) ) {
				$unique[ $font['font-family'] ]['wght'][] = $font['font-weight'];
				if ( in_array( $font['variant'], array( '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic' ) ) ) {
					$unique[ $font['font-family'] ]['ital'][] = $font['font-weight'];
				}
			}
		}

		foreach ( $unique as $family => $variants ) {

			$link[ $family ] = $family;

			$normal_weight = $variants['wght'];
			$italic_weight = array();
			$font_style    = '';

			if ( isset( $variants['ital'] ) ) {
				$italic_weight = $variants['ital'];

				foreach ( $italic_weight as $key => $weight ) {
					unset( $variants['wght'][ $key ] );
					$normal_weight = $variants['wght'];
					$font_style   .= '1,' . $weight;
				}
			}

			$font_style  = ! empty( $normal_weight ) ? implode( ',', array( '0', implode( ';0,', array_unique( $normal_weight ) ) ) ) : '';
			$font_style .= ! empty( $normal_weight ) && ! empty( $italic_weight ) ? ';' : '';
			$font_style .= ! empty( $italic_weight ) ? implode( ',', array( '1', implode( ';1,', array_unique( $italic_weight ) ) ) ) : '';

			$link[ $family ] .= ':ital,wght@' . $font_style;
		}

		if ( ! empty( $link ) ) {
			$query_args = array(
				'family' => implode( '&family=', $link ),
			);
			$fonts_url  = add_query_arg( $query_args, $protocol . 'fonts.googleapis.com/css2' );

			// add font-display swap parameter
			$fonts_url .= '&display=swap';

			return esc_url_raw( $fonts_url );
		}

		return '';

	}
endif;


/**
 * Get native fonts
 *
 * @return array List of native fonts
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_native_fonts' ) ) :
	function kbg_get_native_fonts() {

		$fonts = array(
			'Arial, Helvetica, sans-serif',
			"'Arial Black', Gadget, sans-serif",
			"'Bookman Old Style', serif",
			"'Comic Sans MS', cursive",
			'Courier, monospace',
			'Garamond, serif',
			'Georgia, serif',
			'Impact, Charcoal, sans-serif',
			"'Lucida Console', Monaco, monospace",
			"'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
			"'MS Sans Serif', Geneva, sans-serif",
			"'MS Serif', 'New York', sans-serif",
			"'Palatino Linotype', 'Book Antiqua', Palatino, serif",
			'Tahoma,Geneva, sans-serif',
			"'Times New Roman', Times,serif",
			"'Trebuchet MS', Helvetica, sans-serif",
			'Verdana, Geneva, sans-serif',
		);

		return $fonts;
	}
endif;


/**
 * Get list of image sizes
 *
 * @return array
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_image_sizes' ) ) :
	function kbg_get_image_sizes() {

		$sizes = array(
			'kbg-a'             => array(
				'title' => esc_html__( 'Blog A', 'knowledge-guru' ),
				'w'     => kbg_size_by_col( 8 ),
				'ratio' => kbg_get_image_ratio( 'layout_a' ),
				'crop'  => true,
			),
			'kbg-a-sid'             => array(
				'title' => esc_html__( 'Blog A (no sidebar)', 'knowledge-guru' ),
				'w'     => kbg_size_by_col( 8 ),
				'ratio' => kbg_get_image_ratio( 'layout_a' ),
				'crop'  => true,
			),
			'kbg-b'             => array(
				'title' => esc_html__( 'Blog B', 'knowledge-guru' ),
				'w'     => kbg_size_by_col( 6 ),
				'ratio' => kbg_get_image_ratio( 'layout_b' ),
				'crop'  => true,
			),
			'kbg-b-sid'             => array(
				'title' => esc_html__( 'Blog B (no sidebar)', 'knowledge-guru' ),
				'w'     => kbg_size_by_col( 4 ),
				'ratio' => kbg_get_image_ratio( 'layout_b' ),
				'crop'  => true,
			),

			'kbg-tax-a'             => array(
				'title' => esc_html__( 'KB Category A', 'knowledge-guru' ),
				'w'     => kbg_size_by_col( 12 ),
				'ratio' => kbg_get_image_ratio( 'layout_tax_a' ),
				'crop'  => true,
			),
			'kbg-tax-b'             => array(
				'title' => esc_html__( 'KB Category B', 'knowledge-guru' ),
				'w'     => kbg_size_by_col( 6 ),
				'ratio' => kbg_get_image_ratio( 'layout_tax_b' ),
				'crop'  => true,
			),
			'kbg-tax-c'             => array(
				'title' => esc_html__( 'KB Category C', 'knowledge-guru' ),
				'w'     => kbg_size_by_col( 4 ),
				'ratio' => kbg_get_image_ratio( 'layout_tax_c' ),
				'crop'  => true,
			),
			'kbg-tax-d'             => array(
				'title' => esc_html__( 'KB Category D', 'knowledge-guru' ),
				'w'     => kbg_size_by_col( 3 ),
				'ratio' => kbg_get_image_ratio( 'layout_tax_d' ),
				'crop'  => true,
			),
			'kbg-tax-e'             => array(
				'title' => esc_html__( 'KB Category E', 'knowledge-guru' ),
				'w'     => 238,
				'ratio' => kbg_get_image_ratio( 'layout_tax_e' ),
				'crop'  => true,
			),

			'kbg-single-post-1' => array(
				'title' => esc_html__( 'Single post layout 1', 'knowledge-guru' ),
				'w'     => kbg_size_by_col( 8 ),
				'ratio' => kbg_get_image_ratio( 'single_post_layout_1' ),
				'crop'  => true,
			),
			'kbg-single-page-1' => array(
				'title' => esc_html__( 'Page layout 1', 'knowledge-guru' ),
				'w'     => kbg_size_by_col( 8 ),
				'ratio' => kbg_get_image_ratio( 'page_layout_1' ),
				'crop'  => true,
			),

		);

		$sizes = apply_filters( 'kbg_add_image_sizes', $sizes );

		$disable_img_sizes = kbg_get_option( 'disable_img_sizes' );

		if ( ! empty( $disable_img_sizes ) ) {
			$disable_img_sizes = array_keys( array_filter( $disable_img_sizes ) );
		}

		if ( ! empty( $disable_img_sizes ) ) {
			foreach ( $disable_img_sizes as $size_id ) {
				unset( $sizes[ $size_id ] );
			}
		}

		foreach ( $sizes as $key => $size ) {

			if ( ! isset( $size['ratio'] ) ) {
				continue;
			}

			if ( $size['ratio'] == 'original' ) {
				$size['h']    = 99999;
				$size['crop'] = false;
			} else {
				$size['h'] = kbg_calculate_image_height( $size['w'], $size['ratio'] );
			}

			unset( $size['ratio'] );
			$sizes[ $key ] = $size;
		}

		$sizes = apply_filters( 'kbg_modify_image_sizes', $sizes );

		return $sizes;
	}
endif;


/**
 * Gets an image ratio setting for a specific layout
 *
 * @param string  $option ID
 * @return string
 */
if ( ! function_exists( 'kbg_get_image_ratio' ) ) :
	function kbg_get_image_ratio( $layout ) {

		$ratio        = kbg_get_option( $layout . '_img_ratio' );
		$custom_ratio = kbg_get_option( $layout . '_img_custom' );

		if ( $ratio === 'custom' && ! empty( $custom_ratio ) ) {
			$ratio = str_replace( ':', '_', $custom_ratio );
		}

		$ratio = apply_filters( 'kbg_modify_' . $layout . '_image_ratio', $ratio );

		return $ratio;
	}
endif;


/**
 * Parse image height
 *
 * Calculate an image size based on a given ratio and width
 *
 * @param int     $width
 * @param string  $ration in 'w_h' format
 * @return int $height
 * @since  1.0
 */

if ( ! function_exists( 'kbg_calculate_image_height' ) ) :
	function kbg_calculate_image_height( $width = 1200, $ratio = '16_9' ) {

		$ratio = explode( '_', $ratio );

		if ( ! isset( $ratio[0] ) || ! is_numeric( $ratio[0] ) || ! isset( $ratio[1] ) || ! is_numeric( $ratio[1] ) ) {
			$ratio[0] = 16;
			$ratio[1] = 9;
		}

		$height = ceil( $width * absint( $ratio[1] ) / absint( $ratio[0] ) );

		return $height;
	}
endif;


/**
 * Get editor font sizes
 *
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_editor_font_sizes' ) ) :
	function kbg_get_editor_font_sizes() {

		$regular = absint( kbg_get_option( 'font_size_p' ) );

		$s  = $regular * 0.8;
		$l  = $regular * 1.8;
		$xl = $regular * 2.4;

		$sizes = array(
			array(
				'name'      => esc_html__( 'Small', 'knowledge-guru' ),
				'shortName' => esc_html__( 'S', 'knowledge-guru' ),
				'size'      => $s,
				'slug'      => 'small',
			),

			array(
				'name'      => esc_html__( 'Normal', 'knowledge-guru' ),
				'shortName' => esc_html__( 'M', 'knowledge-guru' ),
				'size'      => $regular,
				'slug'      => 'normal',
			),

			array(
				'name'      => esc_html__( 'Large', 'knowledge-guru' ),
				'shortName' => esc_html__( 'L', 'knowledge-guru' ),
				'size'      => $l,
				'slug'      => 'large',
			),
			array(
				'name'      => esc_html__( 'Huge', 'knowledge-guru' ),
				'shortName' => esc_html__( 'XL', 'knowledge-guru' ),
				'size'      => $xl,
				'slug'      => 'huge',
			),
		);

		$sizes = apply_filters( 'kbg_modify_editor_font_sizes', $sizes );

		return $sizes;

	}
endif;


/**
 * Get editor colors
 *
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_editor_colors' ) ) :
	function kbg_get_editor_colors() {

		$colors = array(
			array(
				'name'  => esc_html__( 'Main color', 'knowledge-guru' ),
				'slug'  => 'kbg-main',
				'color' => kbg_get_option( 'color_main' ),
			),
			array(
				'name'  => esc_html__( 'Text color', 'knowledge-guru' ),
				'slug'  => 'kbg-text',
				'color' => kbg_get_option( 'color_txt' ),
			),
			array(
				'name'  => esc_html__( 'Background color', 'knowledge-guru' ),
				'slug'  => 'kbg-bg',
				'color' => kbg_get_option( 'color_bg' ),
			),
			array(
				'name'  => esc_html__( 'Headings color', 'knowledge-guru' ),
				'slug'  => 'kbg-h',
				'color' => kbg_get_option( 'color_h' ),
			),
			array(
				'name'  => esc_html__( 'Button primary color', 'knowledge-guru' ),
				'slug'  => 'kbg-primary-color',
				'color' => kbg_get_option( 'color_button_primary' ),
			),
			array(
				'name'  => esc_html__( 'Button primary text color', 'knowledge-guru' ),
				'slug'  => 'kbg-primary-text-color',
				'color' => kbg_get_option( 'color_button_primary_text' ),
			),
		);

		$colors = apply_filters( 'kbg_modify_editor_colors', $colors );

		return $colors;

	}
endif;



/**
 * Get image ID from URL
 *
 * It gets image/attachment ID based on URL
 *
 * @param string  $image_url URL of image/attachment
 * @return int|bool Attachment ID or "false" if not found
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_image_id_by_url' ) ) :
	function kbg_get_image_id_by_url( $image_url ) {
		global $wpdb;

		$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ) );

		if ( isset( $attachment[0] ) ) {
			return $attachment[0];
		}

		return false;
	}
endif;


/**
 * Calculate reading time by content length
 *
 * @param string  $text Content to calculate
 * @return int Number of minutes
 * @since  1.0
 */

if ( ! function_exists( 'kbg_read_time' ) ) :
	function kbg_read_time( $text ) {

		$words                   = count( preg_split( "/[\n\r\t ]+/", wp_strip_all_tags( $text ) ) );
		$number_words_per_minute = kbg_get_option( 'words_read_per_minute' );
		$number_words_per_minute = ! empty( $number_words_per_minute ) ? absint( $number_words_per_minute ) : 200;

		if ( ! empty( $words ) ) {
			$time_in_minutes = ceil( $words / $number_words_per_minute );
			return $time_in_minutes;
		}

		return false;
	}
endif;


/**
 * Trim chars of a string
 *
 * @param string  $string Content to trim
 * @param int     $limit  Number of characters to limit
 * @param string  $more   Chars to append after trimed string
 * @return string Trimmed part of the string
 * @since  1.0
 */

if ( ! function_exists( 'kbg_trim_chars' ) ) :
	function kbg_trim_chars( $string, $limit, $more = '...' ) {

		if ( ! empty( $limit ) ) {

			$text = trim( preg_replace( "/[\n\r\t ]+/", ' ', $string ), ' ' );
			preg_match_all( '/./u', $text, $chars );
			$chars = $chars[0];
			$count = count( $chars );

			if ( $count > $limit ) {

				$chars = array_slice( $chars, 0, $limit );

				for ( $i = ( $limit - 1 ); $i >= 0; $i-- ) {
					if ( in_array( $chars[ $i ], array( '.', ' ', '-', '?', '!' ) ) ) {
						break;
					}
				}

				$chars   = array_slice( $chars, 0, $i );
				$string  = implode( '', $chars );
				$string  = rtrim( $string, '.,-?!' );
				$string .= $more;
			}
		}

		return $string;
	}
endif;


/**
 * Parse args ( merge arrays )
 *
 * Similar to wp_parse_args() but extended to also merge multidimensional arrays
 *
 * @param array   $a - set of values to merge
 * @param array   $b - set of default values
 * @return array Merged set of elements
 * @since  1.0
 */

if ( ! function_exists( 'kbg_parse_args' ) ) :
	function kbg_parse_args( &$a, $b ) {
		$a = (array) $a;
		$b = (array) $b;
		$r = $b;
		foreach ( $a as $k => &$v ) {
			if ( is_array( $v ) && isset( $r[ $k ] ) ) {
				$r[ $k ] = kbg_parse_args( $v, $r[ $k ] );
			} else {
				$r[ $k ] = $v;
			}
		}
		return $r;
	}
endif;


/**
 * Compare two values
 *
 * Fucntion compares two values and sanitazes 0
 *
 * @param mixed   $a
 * @param mixed   $b
 * @return bool Returns true if equal
 * @since  1.0
 */

if ( ! function_exists( 'kbg_compare' ) ) :
	function kbg_compare( $a, $b ) {
		return (string) $a === (string) $b;
	}
endif;


/**
 * Compare two values and return a string if true
 *
 * @param mixed   $a
 * @param mixed   $b
 * @param string  $output
 * @return string Returns output if true
 * @since  1.0
 */
if ( ! function_exists( 'kbg_selected' ) ) :
	function kbg_selected( $a, $b, $output ) {
		return kbg_compare( $a, $b ) ? $output : '';
	}
endif;


/**
 * Sort option items
 *
 * Use this function to properly order sortable options
 *
 * @param array   $items    Array of items
 * @param array   $selected Array of IDs of currently selected items
 * @return array ordered items
 * @since  1.0
 */

if ( ! function_exists( 'kbg_sort_option_items' ) ) :
	function kbg_sort_option_items( $items, $selected, $field = 'term_id' ) {

		if ( empty( $selected ) ) {
			return $items;
		}

		$new_items      = array();
		$temp_items     = array();
		$temp_items_ids = array();

		foreach ( $selected as $selected_item_id ) {

			foreach ( $items as $item ) {
				if ( $selected_item_id == $item->$field ) {
					$new_items[] = $item;
				} else {
					if ( ! in_array( $item->$field, $selected ) && ! in_array( $item->$field, $temp_items_ids ) ) {
						$temp_items[]     = $item;
						$temp_items_ids[] = $item->$field;
					}
				}
			}
		}

		$new_items = array_merge( $new_items, $temp_items );

		return $new_items;
	}
endif;


/**
 * Compress CSS Code
 *
 * @param string  $code Uncompressed css code
 * @return string Compressed css code
 * @since  1.0
 */

if ( ! function_exists( 'kbg_compress_css_code' ) ) :
	function kbg_compress_css_code( $code ) {

		// Remove Comments
		$code = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $code );

		// Remove tabs, spaces, newlines, etc.
		$code = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $code );

		return $code;
	}
endif;


/**
 * Get list of social options
 *
 * Used for user social profiles
 *
 * @return array
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_social' ) ) :
	function kbg_get_social() {
		$social = array(
			'behance'      => 'Behance',
			'delicious'    => 'Delicious',
			'deviantart'   => 'DeviantArt',
			'digg'         => 'Digg',
			'dribbble'     => 'Dribbble',
			'facebook'     => 'Facebook',
			'flickr'       => 'Flickr',
			'github'       => 'Github',
			'google'       => 'GooglePlus',
			'instagram'    => 'Instagram',
			'linkedin'     => 'LinkedIN',
			'pinterest'    => 'Pinterest',
			'reddit'       => 'ReddIT',
			'rss'          => 'Rss',
			'skype'        => 'Skype',
			'snapchat'     => 'Snapchat',
			'slack'        => 'Slack',
			'stumbleupon'  => 'StumbleUpon',
			'soundcloud'   => 'SoundCloud',
			'spotify'      => 'Spotify',
			'tumblr'       => 'Tumblr',
			'twitter'      => 'Twitter',
			'vimeo-square' => 'Vimeo',
			'vk'           => 'vKontakte',
			'vine'         => 'Vine',
			'weibo'        => 'Weibo',
			'wordpress'    => 'WordPress',
			'xing'         => 'Xing',
			'yahoo'        => 'Yahoo',
			'youtube'      => 'Youtube',
		);

		return $social;
	}
endif;



/**
 * Calculate time difference
 *
 * @param string  $timestring String to calculate difference from
 * @return  int Time difference in miliseconds
 * @since  1.0
 */
if ( ! function_exists( 'kbg_calculate_time_diff' ) ) :
	function kbg_calculate_time_diff( $timestring ) {

		$now = current_time( 'timestamp' );

		switch ( $timestring ) {
			case '-1 day':
				$time = $now - DAY_IN_SECONDS;
				break;
			case '-3 days':
				$time = $now - ( 3 * DAY_IN_SECONDS );
				break;
			case '-1 week':
				$time = $now - WEEK_IN_SECONDS;
				break;
			case '-1 month':
				$time = $now - ( YEAR_IN_SECONDS / 12 );
				break;
			case '-3 months':
				$time = $now - ( 3 * YEAR_IN_SECONDS / 12 );
				break;
			case '-6 months':
				$time = $now - ( 6 * YEAR_IN_SECONDS / 12 );
				break;
			case '-1 year':
				$time = $now - ( YEAR_IN_SECONDS );
				break;
			default:
				$time = $now;
		}

		return $time;
	}
endif;


/**
 * Get page meta data
 *
 * @param string  $field specific option array key
 * @return mixed meta data value or set of values
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_page_meta' ) ) :
	function kbg_get_page_meta( $post_id = false, $field = false ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}

		$defaults = array(
			'settings' => 'inherit',
			'layout'   => kbg_get_option( 'page_layout' ),
			'sidebar'  => array(
				'position' => kbg_get_option( 'page_sidebar_position' ),
				'classic'  => kbg_get_option( 'page_sidebar_standard' ),
				'sticky'   => kbg_get_option( 'page_sidebar_sticky' ),
			)
		);

		$meta = get_post_meta( $post_id, '_kbg_meta', true );

		if ( isset($meta['settings']) && $meta['settings'] === 'inherit' ) {
			$meta = $defaults;
		} else {
			$meta = kbg_parse_args( $meta, $defaults );
		}

		if ( $field ) {
			if ( isset( $meta[ $field ] ) ) {
				return $meta[ $field ];
			} else {
				return false;
			}
		}

		return $meta;
	}
endif;

/**
 * Get post meta data
 *
 * @param string  $field specific option array key
 * @return mixed meta data value or set of values
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_post_meta' ) ) :
	function kbg_get_post_meta( $post_id = false, $field = false ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}

		$args['type'] = is_singular( 'knowledge_base' ) ? 'kb' : 'post';

		$defaults = array(
			'settings' => 'inherit',
			'layout'   => kbg_get_option( 'single_' . $args['type'] . '_layout' ),
			'sidebar'  => array(
				'position' => kbg_get_option( 'single_' . $args['type'] . '_sidebar_position' ),
				'classic'  => kbg_get_option( 'single_' . $args['type'] . '_sidebar_standard' ),
				'sticky'   => kbg_get_option( 'single_' . $args['type'] . '_sidebar_sticky' ),
			),
		);

		$meta = get_post_meta( $post_id, '_kbg_meta', true );

		$meta = kbg_parse_args( $meta, $defaults );

		if ( $field ) {
			if ( isset( $meta[ $field ] ) ) {
				return $meta[ $field ];
			} else {
				return false;
			}
		}

		return $meta;
	}
endif;

/**
 * Get category meta data
 *
 * @param string  $field specific option array key
 * @return mixed meta data value or set of values
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_category_meta' ) ) :
	function kbg_get_category_meta( $cat_id = false, $field = false ) {

		$archive_type = is_tax( 'kbg_category' ) ? 'kb_' : '';

		$inherit_from = kbg_get_option( $archive_type . 'category_settings' ) == 'custom' ? $archive_type . 'category' : $archive_type . 'archive';

		$defaults = array(
			'settings'        => 'inherit',
			'image'           => '',
			'loop'            => kbg_get_option( $inherit_from . '_loop' ),
			'layout'          => kbg_get_option( $inherit_from . '_layout' ),
			'sidebar_enabled' => kbg_get_option( $inherit_from . '_sidebar_display' ),
			'sidebar'         => array(
				'position' => kbg_get_option( $inherit_from . '_sidebar_position' ),
				'classic'  => kbg_get_option( $inherit_from . '_sidebar_standard' ),
				'sticky'   => kbg_get_option( $inherit_from . '_sidebar_sticky' ),
			),
			'pagination'      => kbg_get_option( $inherit_from . '_pagination' ),
			'ppp_num'         => kbg_get_option( $inherit_from . '_ppp' ) == 'inherit' ? kbg_get_default_option( $inherit_from . '_ppp_num' ) : kbg_get_option( $inherit_from . '_ppp_num' ),
			'order'           => 'DESC',
			'archive'         => array(
				'description' => kbg_get_option( $inherit_from . '_description' ),
				'meta'        => kbg_get_option( $inherit_from . '_meta' ),
			),
		);

		if ( $cat_id ) {
			$meta = get_term_meta( $cat_id, '_kbg_meta', true );
			$meta = kbg_parse_args( $meta, $defaults );
		} else {
			$meta = $defaults;
		}

		if ( $field ) {
			if ( isset( $meta[ $field ] ) ) {
				return $meta[ $field ];
			} else {
				return false;
			}
		}

		return $meta;
	}
endif;


if ( ! function_exists( 'kbg_main_color_lite' ) ) :
	function kbg_main_color_lite( $color ) {

		$hsl = kbg_hex_to_hsla( $color );

		$hsl[0] = $hsl[0] - 3;
		$hsl[2] = $hsl[2] + 3;

		return 'hsl(' . $hsl[0] . ', ' . $hsl[1] . '%, ' . $hsl[2] . '%)';

	}
endif;

if ( ! function_exists( 'kbg_main_color_lite_95_percent' ) ) :
	function kbg_main_color_lite_95_percent( $color, $hex = false ) {

		$hsl = kbg_hex_to_hsla( $color );

		$hsl[0] = $hsl[0] + 20;
		$hsl[1] = $hsl[1] - 40;
		$hsl[2] = 95;

		if ( $hex ) {
			return kbg_HSL_toHex( $hsl[0], $hsl[1], $hsl[2], $hex );
		} 

		return 'hsl(' . $hsl[0] . ', ' . $hsl[1] . '%, ' . $hsl[2] . '%)';

	}
endif;

/**
 * Hex to hsl
 *
 * Convert hexadecimal color to hsl
 *
 * @param string  $color   Hexadecimal color value
 * @param float   $opacity Opacity value
 * @return string RGBA color value
 * @since  1.0
 */
if ( ! function_exists( 'kbg_hex_to_hsla' ) ) :
	function kbg_hex_to_hsla( $hex, $opacity = 1, $raw = false ) {

		$rgb = kbg_hex_to_rgba( $hex, false, true );

		$hsl = kbg_rgb_to_hsl( $rgb );

		return $hsl;

	}
endif;

/**
 * Hex to rgba
 *
 * Convert hexadecimal color to rgba
 *
 * @param string  $color   Hexadecimal color value
 * @param float   $opacity Opacity value
 * @return string RGBA color value
 * @since  1.0
 */
if ( ! function_exists( 'kbg_hex_to_rgba' ) ) :
	function kbg_hex_to_rgba( $color, $opacity = false, $array = false ) {
		$default = 'rgb(0,0,0)';

		// Return default if no color provided
		if ( empty( $color ) ) {
			return $default;
		}

		// Sanitize $color if "#" is provided
		if ( $color[0] == '#' ) {
			$color = substr( $color, 1 );
		}

		// Check if color has 6 or 3 characters and get values
		if ( strlen( $color ) == 6 ) {
			$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) == 3 ) {
			$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
			return $default;
		}

		// Convert hexadec to rgb
		$rgb = array_map( 'hexdec', $hex );

		if ( $array ) {
			return $rgb;
		}

		// Check if opacity is set(rgba or rgb)
		if ( $opacity !== false ) {
			if ( abs( $opacity ) > 1 ) {
				$opacity = 1.0;
			}
			$output = 'rgba(' . implode( ',', $rgb ) . ',' . $opacity . ')';
		} else {
			$output = 'rgb(' . implode( ',', $rgb ) . ')';
		}

		// Return rgb(a) color string
		return $output;
	}
endif;


/**
 * Convert RGB to HSL color code
 *
 * @param $rgb
 * @return array HSL color
 * @since  1.1
 */
if ( ! function_exists( 'kbg_rgb_to_hsl' ) ) :
	function kbg_rgb_to_hsl( $rgb ) {

		$r   = $rgb[0];
		$g   = $rgb[1];
		$b   = $rgb[2];
		$r  /= 255;
		$g  /= 255;
		$b  /= 255;
		$max = max( $r, $g, $b );
		$min = min( $r, $g, $b );
		$h   = 0;
		$s   = 0;
		$l   = ( $max + $min ) / 2;
		$d   = $max - $min;
		if ( $d == 0 ) {
			$h = $s = 0; // achromatic
		} else {
			$s = $d / ( 1 - abs( 2 * $l - 1 ) );
			switch ( $max ) {
				case $r:
					$h = 60 * fmod( ( ( $g - $b ) / $d ), 6 );
					if ( $b > $g ) {
						$h += 360;
					}
					break;
				case $g:
					$h = 60 * ( ( $b - $r ) / $d + 2 );
					break;
				case $b:
					$h = 60 * ( ( $r - $g ) / $d + 4 );
					break;
			}
		}
		return array( round( $h ), round( $s * 100 ), round( $l * 100 ) );
	}
endif;

/**
 * Convert HSL to RGB color code
 *
 * @param unknown $hsl
 * @return array RGB color
 * @since  1.1
 */
function kbg_HSL_toHex( $h, $s, $l, $toHex=true ){
    $h /= 360;
    $s /=100;
    $l /=100;

    $r = $l;
    $g = $l;
    $b = $l;
    $v = ($l <= 0.5) ? ($l * (1.0 + $s)) : ($l + $s - $l * $s);
    if ($v > 0){
          $m;
          $sv;
          $sextant;
          $fract;
          $vsf;
          $mid1;
          $mid2;

          $m = $l + $l - $v;
          $sv = ($v - $m ) / $v;
          $h *= 6.0;
          $sextant = floor($h);
          $fract = $h - $sextant;
          $vsf = $v * $sv * $fract;
          $mid1 = $m + $vsf;
          $mid2 = $v - $vsf;

          switch ($sextant)
          {
                case 0:
                      $r = $v;
                      $g = $mid1;
                      $b = $m;
                      break;
                case 1:
                      $r = $mid2;
                      $g = $v;
                      $b = $m;
                      break;
                case 2:
                      $r = $m;
                      $g = $v;
                      $b = $mid1;
                      break;
                case 3:
                      $r = $m;
                      $g = $mid2;
                      $b = $v;
                      break;
                case 4:
                      $r = $mid1;
                      $g = $m;
                      $b = $v;
                      break;
                case 5:
                      $r = $v;
                      $g = $m;
                      $b = $mid2;
                      break;
          }
    }
    $r = round($r * 255, 0);
    $g = round($g * 255, 0);
    $b = round($b * 255, 0);

    if ($toHex) {
        $r = ($r < 15)? '0' . dechex($r) : dechex($r);
        $g = ($g < 15)? '0' . dechex($g) : dechex($g);
        $b = ($b < 15)? '0' . dechex($b) : dechex($b);
        return "#$r$g$b";
    } else {
        return "rgb($r, $g, $b)";    
    }
}


/**
 * Get number of posts for the current archive
 *
 * @return int
 * @since  1.0
 */
if ( ! function_exists( 'kbg_get_archive_posts_count' ) ) :
	function kbg_get_archive_posts_count() {

		global $wp_query;

		return isset( $wp_query->found_posts ) ? $wp_query->found_posts : 0;
	}
endif;


/**
 * Check if Yoast SEO is active
 *
 * @return bool
 * @since  1.0
 */
if ( ! function_exists( 'kbg_is_yoast_active' ) ) :
	function kbg_is_yoast_active() {
		return class_exists( 'WPSEO_Frontend' ) || class_exists( 'WPSEO_Admin' );
	}
endif;

/**
 * Check if Breadcrumb NavXT is active
 *
 * @return bool
 * @since  1.0
 */
if ( ! function_exists( 'kbg_is_breadcrumbs_navxt_active' ) ) :
	function kbg_is_breadcrumbs_navxt_active() {
		return class_exists( 'breadcrumb_navxt' );
	}
endif;

/**
 * Check if Kirki customozer framework is active
 *
 * @return bool
 * @since  1.0
 */
if ( ! function_exists( 'kbg_is_kirki_active' ) ) :
	function kbg_is_kirki_active() {
		if ( class_exists( 'Kirki' ) ) {
			return true;
		}

		return false;
	}
endif;

/**
 * Check if Knowledge Base Bocks is active
 *
 * @return bool
 * @since  1.0
 */
if ( ! function_exists( 'kbg_is_kb_blocks_active' ) ) :
	function kbg_is_kb_blocks_active() {
		return class_exists( 'Kbg\Kbg_Buddy\KnowledgeBaseBlocks' ); 
	}
endif;



/**
 * Check if Knowledge Base CPT is active
 *
 * @return bool
 * @since  1.0
 */
if ( ! function_exists( 'kbg_is_knowledge_base_cpt_active' ) ) :
	function kbg_is_knowledge_base_cpt_active() {
		return defined( 'KB_CPT_BASE' );
	}
endif;


/**
 * Get layouts map
 *
 * Function which keeps the definition parameters for each of post listing layouts
 *
 * @param int     $layout_id
 * @param int     $loop_index current post in the loop
 * @return array set of parameters
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_kb_layouts_map' ) ) :
	function kbg_get_kb_layouts_map() {

		$params = array(

			// Layout A
			1 => array(
				'src'     => get_parent_theme_file_uri( '/assets/img/admin/kb_layout_a.svg' ),
				'alt'     => esc_html__( 'A', 'knowledge-guru' ),
				'sidebar' => true,
				'loop'    => array(
					array(
						'col'   => 'item',
						'style' => 'a',
					),
				),
			),

			// Layout B
			2 => array(
				'src'     => get_parent_theme_file_uri( '/assets/img/admin/kb_layout_b.svg' ),
				'alt'     => esc_html__( 'B', 'knowledge-guru' ),
				'sidebar' => true,
				'loop'    => array(
					array(
						'col'   => 'item',
						'style' => 'b',
					),
				),
			),

		);

		return apply_filters( 'kbg_modify_layouts_map', $params );

	}
endif;

/**
 * Get archive layouts map
 *
 * Function which keeps the definition parameters for each of post listing layouts for archives
 *
 * @param int     $layout_id
 * @param int     $loop_index current post in the loop
 * @return array set of parameters
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_post_layouts_map' ) ) :
	function kbg_get_post_layouts_map() {

		$params = array(

			// Layout A
			1 => array(
				'src'     => get_parent_theme_file_uri( '/assets/img/admin/post_layout_a.svg' ),
				'alt'     => esc_html__( 'A', 'knowledge-guru' ),
				'sidebar' => true,
				'loop'    => array(
					array(
						'col'   => 'col-12',
						'style' => 'a',
					),
				),
			),

			// Layout B
			2 => array(
				'src'     => get_parent_theme_file_uri( '/assets/img/admin/post_layout_b.svg' ),
				'alt'     => esc_html__( 'B', 'knowledge-guru' ),
				'sidebar' => true,
				'loop'    => array(
					array(
						'col'   => 'col-12 col-md-6 col-lg-6 masonry-item',
						'style' => 'b',
					),
				),
			)

		);

		return apply_filters( 'kbg_modify_layouts_map', $params );

	}
endif;


/**
 * Function for escaping through WordPress's KSES API
 * wp_kses() and wp_kses_allowed_html()
 *
 * @param string $content
 * @param bool $echo
 * @return string
 * @since  1.0
 */
if ( ! function_exists( 'kbg_wp_kses' ) ) :
	function kbg_wp_kses( $content, $echo = false ) {

		$allowed_tags                  = wp_kses_allowed_html( 'post' );
		$allowed_tags['img']['srcset'] = array();
		$allowed_tags['img']['sizes']  = array();

		$tags = apply_filters( 'kbg_wp_kses_allowed_html', $allowed_tags );

		if ( ! $echo ) {
			return wp_kses( $content, $tags );
		}

		echo wp_kses( $content, $tags );

	}
endif;


/**
 * Prevent Kirki from breaking ad slot options
 *
 * @return string
 * @since  1.0
 */
function kbg_sanitize_ad( $string ) {
	return $string;
}

/**
 * Get typography uppercase options
 *
 * @since  1.0
 * @return array
 */
if ( ! function_exists( 'kbg_get_typography_uppercase_options' ) ) :
	function kbg_get_typography_uppercase_options() {
		return array(
			'.kbg-header .site-title a'                => esc_html__( 'Site title (when logo is not used)', 'knowledge-guru' ),
			'.site-description'                            => esc_html__( 'Site description', 'knowledge-guru' ),
			'.kbg-header li a'                         => esc_html__( 'Main site navigation', 'knowledge-guru' ),
			'.widget-title, .kbg-footer .widget-title' => esc_html__( 'Widget title', 'knowledge-guru' ),
			'.section-title'                               => esc_html__( 'Section title', 'knowledge-guru' ),
			'.entry-title, .meks-ap-title'                 => esc_html__( 'Post/page title', 'knowledge-guru' ),
			'h1, h2, h3, h4, h5, h6, .fn, .h7, .h8'        => esc_html__( 'Text headings', 'knowledge-guru' ),
			'buttons'                                      => esc_html__( 'Buttons/special labels', 'knowledge-guru' ),
		);
	}
endif;


/**
 * Check if footer sidebar/widgets active
 *
 * @return bool
 * @since  1.0.0
 */
if ( ! function_exists( 'kbg_is_active_footer_widgets' ) ) :
	function kbg_is_active_footer_widgets() {
		return is_active_sidebar( 'kbg_sidebar_footer_1' ) || is_active_sidebar( 'kbg_sidebar_footer_2 ' ) || is_active_sidebar( 'kbg_sidebar_footer_3' ) || is_active_sidebar( 'kbg_sidebar_footer_4' );
	}
endif;


/**
 * Default search post type options  
 *
 * @return array 
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_post_types_search_defaults' ) ) :
	function kbg_get_post_types_search_defaults( $disable = false, $exclude = array() ) {

		
		$defaults = array();

		$defaults[] = 'post';
		$defaults[] = 'page';

		if ( kbg_is_knowledge_base_cpt_active() ) {
			$defaults[] = 'knowledge_base';
		}

		return $defaults;
	}
endif;
