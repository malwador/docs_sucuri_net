<?php

/**
 * Get default option by passing option id or don't pass anything to function and get all options
 *
 * @param string  $option
 * @return array|mixed|false
 * @param since   1.0
 */

if ( !function_exists( 'kbg_get_default_option' ) ):
	function kbg_get_default_option( $option = null ) {

		$translate = kbg_get_translate_options();

		$defaults = array(

			// Header - General
			'header_layout' => '1',
			'header_height' => 90,
			'header_orientation' => 'content', // content, window
			'header_main_nav' => true,
			'header_site_desc' => false,
			'header_actions' => array(), // search-form | social
			'logo' => array( 'url' => esc_url( get_parent_theme_file_uri( '/assets/img/knowledgeguru_logo.png' ) ) ),
			'logo_retina' => array( 'url' => esc_url( get_parent_theme_file_uri( '/assets/img/knowledgeguru_logo@2x.png' ) ) ),
			'logo_mini' => array( 'url' => esc_url( get_parent_theme_file_uri( '/assets/img/knowledgeguru_logo_mini.png' ) ) ),
			'logo_mini_retina' => array( 'url' => esc_url( get_parent_theme_file_uri( '/assets/img/knowledgeguru_logo_mini@2x.png' ) ) ),
			'logo_custom_url' => '',

			// Header - Sticky
			'header_sticky' => true,
			'header_sticky_layout' => '1',
			'header_sticky_height' => 70,
			'header_sticky_offset' => 300,
			'header_sticky_up' => false,
			'header_sticky_type' => 'custom', // inherit | custom 			
			'header_sticky_nav' => true,
			'header_sticky_actions' => array(),
			'header_sticky_logo' => array( 'url' => esc_url( get_parent_theme_file_uri( '/assets/img/knowledgeguru_logo_mini.png' ) ) ),
			'header_sticky_logo_retina' => array( 'url' => esc_url( get_parent_theme_file_uri( '/assets/img/knowledgeguru_logo_mini@2x.png' ) ) ),
	
			// Header - Responsive
			'header_responsive_search' => true,
			
			// Content
			'color_bg' => '#F9F9F9',
			'color_h' => '#1D2B36',
			'color_txt' => '#1D2B36',
			'color_main' => '#0084c2',
			'color_option' => 'inherit', // inherit | custom 
			// Button Colors
			'color_button_primary' => '#FECF27',
			'color_button_primary_text' => '#790000',
			'color_button_secondary' => '#0092CC',
			'color_button_tertiary' => '#EBF0FA',
			// Header colors
			'color_header_bg_type' => 'solid', // solid | gradient
			'color_header_bg_solid' => '#00A7DB',
			'color_header_txt' => '#FFF',
			// Sticky header
			'color_header_sticky_bg' => '#00A7DB',
			'color_header_sticky_txt' => '#fff',			
			// Footer colors
			'color_footer_bg' => '#00A3D7',
			'color_footer_txt' => '#FFF',
			// Theme style
			'theme_style' => 'rounded', // sharp | rounded | pill

			
			// Sidebars
			'sidebars' => array(),


			// Footer
			'footer_widgets' => false,
			'footer_widgets_layout' => '4-4-4',
			'footer_widgets_style' => 'unboxed', // unboxed | boxed
			'footer_copyright_and_menu' => true,
			'footer_copyright' => kbg_wp_kses( sprintf( __( ' Created by <a href="https://mekshq.com" target="_blank" rel="noopener">Meks</a> &#169; {current_year} %s', 'knowledge-guru' ), '' ) ),
			'copyright_menu' => true,


			// blog layouts
			'layout_a_meta' => array( 'author', 'date', 'category' ),
			'layout_a_excerpt' => true,
			'layout_a_excerpt_limit' => 250,
			'layout_a_excerpt_type' => 'auto',
			'layout_a_rm' => true,

			'layout_b_meta' => array( 'date' ),
			'layout_b_excerpt' => true,
			'layout_b_excerpt_limit' => 150,
			'layout_b_excerpt_type' => 'auto',
			'layout_b_rm' => false,


			// Knowledge base layouts
			'kb_layout_a_meta' => array('date'),
			'kb_layout_a_excerpt' => true,
			'kb_layout_a_excerpt_limit' => 250,
			'kb_layout_a_excerpt_type' => 'auto',
			'kb_layout_a_rm' => true,

			'kb_layout_b_meta' => array(),
			'kb_layout_b_excerpt' => true,
			'kb_layout_b_excerpt_limit' => 150,
			'kb_layout_b_excerpt_type' => 'auto',
			'kb_layout_b_rm' => false,


			// Blog images
			'layout_a_img_ratio' => '4_2',
			'layout_a_img_custom' => '',
			'layout_b_img_ratio' => '5_3',
			'layout_b_img_custom' => '',

			// Knowledge base taxonomy images
			'layout_tax_a_img_ratio' => '4_2',
			'layout_tax_a_img_custom' => '',
			'layout_tax_b_img_ratio' => '4_2',
			'layout_tax_b_img_custom' => '',
			'layout_tax_c_img_ratio' => '5_3',
			'layout_tax_c_img_custom' => '',
			'layout_tax_d_img_ratio' => '5_3',
			'layout_tax_d_img_custom' => '',
			'layout_tax_e_img_ratio' => '1_1',
			'layout_tax_e_img_custom' => '',
		

			// Single Blog
			'single_post_layout' => '1',
			'single_post_layout_1_img_ratio' => '16_9',
			'single_post_layout_1_img_custom' => '',
			'single_post_sidebar_position' => 'right',
			'single_post_sidebar_standard' => 'kbg_sidebar_default',
			'single_post_sidebar_sticky' => 'kbg_sidebar_default_sticky',
			'single_post_width' => '10',
			'single_post_meta' => array( 'date', 'author', 'comments' ),
			'single_post_fimg' => true,
			'single_post_fimg_cap' => true,
			'single_post_headline' => false,
			'single_post_tags' => true,
			'single_post_prev_next' => true,
			'single_post_author' => true,
			'single_post_related' => false,
			'single_post_related_layout' => '1',
			'single_post_related_limit' => 6,
			'single_post_related_type' => 'cat',
			'single_post_related_order' => 'date',
			'single_post_subheader' => false,
			'single_post_subheader_left' => 'breadcrumbs', // breadcrumbs | search-form | none
			'single_post_subheader_right' => 'search-form',
			'single_post_subheader_breadcrumbs_type' => 'yoast',


			// Single Knowledge Base
			'single_kb_layout' => '1',
			'single_kb_layout_1_img_ratio' => '16_9',
			'single_kb_layout_1_img_custom' => '',
			'single_kb_sidebar_position' => 'left',
			'single_kb_sidebar_standard' => 'kbg_sidebar_default',
			'single_kb_sidebar_sticky' => 'kbg_sidebar_default_sticky',
			'single_kb_width' => '10',
			'single_kb_meta' => array( 'date', 'rtime', 'author' ),
			'single_kb_fimg' => true,
			'single_kb_fimg_cap' => true,
			'single_kb_headline' => false,
			'single_kb_tags' => true,
			'single_kb_prev_next' => false,
			'single_kb_author' => false,
			'single_kb_related' => true,
			'single_kb_related_layout' => '1',
			'single_kb_related_limit' => 6,
			'single_kb_related_type' => 'cat',
			'single_kb_related_order' => 'date',
			'single_kb_subheader' => true,
			'single_kb_subheader_left' => 'breadcrumbs', // breadcrumbs | search-form | none
			'single_kb_subheader_right' => 'search-form',
			'single_kb_subheader_breadcrumbs_type' => 'yoast', // yoast | navxt

			// Page
			'page_layout' => '1',
			'page_layout_1_img_ratio' => '16_9',
			'page_layout_1_img_custom' => '',
			'page_sidebar_position' => 'none',
			'page_sidebar_standard' => 'kbg_sidebar_default',
			'page_sidebar_sticky' => 'kbg_sidebar_default_sticky',
			'page_width' => '8',
			'page_fimg' => true,
			'page_fimg_cap' => false,

			// Archive
			'archive_layout' => '1',
			'archive_description' => false,
			'archive_meta' => true,
			'archive_loop' => '1',
			'archive_ppp' => 'inherit',
			'archive_ppp_num' => get_option( 'posts_per_page' ),
			'archive_pagination' => 'numeric',
			'archive_sidebar_display' => true,
			'archive_sidebar_position' => 'right',
			'archive_sidebar_standard' => 'kbg_sidebar_default',
			'archive_sidebar_sticky' => 'kbg_sidebar_default_sticky',
			
			// Special Search Archive page
			'search_archive_layout' => '1',
			'search_archive_meta' => true,
			'search_archive_loop' => '1',
			'search_archive_ppp' => 'inherit',
			'search_archive_ppp_num' => get_option( 'posts_per_page' ),
			'search_archive_pagination' => 'numeric',
			'search_archive_sidebar_display' => true,
			'search_archive_sidebar_position' => 'left',
			'search_archive_sidebar_standard' => 'kbg_search_sidebar_default',
			'search_archive_sidebar_sticky' => 'kbg_search_sidebar_default_sticky',
			'search_archive_include_types' => kbg_get_post_types_search_defaults(),

			// Category
			'category_settings' => 'inherit',
			'category_layout' => '1',
			'category_description' => false,
			'category_meta' => true,
			'category_loop' => '1',
			'category_ppp' => 'inherit',
			'category_ppp_num' =>  get_option( 'posts_per_page' ),
			'category_pagination' => 'numeric',
			'category_sidebar_display' => true,
			'category_sidebar_position' => 'right',
			'category_sidebar_standard' => 'kbg_sidebar_default',
			'category_sidebar_sticky' => 'kbg_sidebar_default_sticky',

			// Knowledge Base Archive
			'kb_archive_layout' => '1',
			'kb_archive_description' => false,
			'kb_archive_meta' => true,
			'kb_archive_loop' => '1',
			'kb_archive_ppp' => 'inherit',
			'kb_archive_ppp_num' => get_option( 'posts_per_page' ),
			'kb_archive_pagination' => 'numeric',
			'kb_archive_sidebar_display' => true,
			'kb_archive_sidebar_position' => 'left',
			'kb_archive_sidebar_standard' => 'kbg_sidebar_default',
			'kb_archive_sidebar_sticky' => 'kbg_sidebar_default_sticky',

			// Category Knowledge Base
			'kb_category_settings' => 'inherit',
			'kb_category_layout' => '1',
			'kb_category_description' => false,
			'kb_category_meta' => true,
			'kb_category_icon' => false,
			'kb_category_loop' => '1',
			'kb_category_ppp' => 'inherit',
			'kb_category_ppp_num' =>  get_option( 'posts_per_page' ),
			'kb_category_pagination' => 'load-more',
			'kb_category_sidebar_display' => true,
			'kb_category_sidebar_position' => 'left',
			'kb_category_sidebar_standard' => 'kbg_sidebar_default',
			'kb_category_sidebar_sticky' => 'kbg_sidebar_default_sticky',

			// Typography
			'main_font' => array(
				'font-family' => 'Inter',
				'variant'  => '400',
				'font-weight' => '400'
			),

			'h_font' => array(
				'font-family' => 'Open Sans',
				'variant' => '600',
				'font-weight' => '600'
			),

			'nav_font' => array(
				'font-family' => 'Inter',
				'variant' => '700',
				'font-weight' => '700'
			),

			'button_font' => array(
				'font-family' => 'Inter',
				'variant' => '700',
				'font-weight' => '700'
			),

			'font_size_p' => '16',
			'font_size_small' => '14',
			'font_size_nav' => '14',
			'font_size_nav_ico' => '24',
			'font_size_section_title' => '26',
			'font_size_widget_title' => '20',
			'font_size_punchline' => '50',
			'font_size_h1' => '30',
			'font_size_h2' => '24',
			'font_size_h3' => '20',
			'font_size_h4' => '18',
			'font_size_h5' => '16',
			'font_size_h6' => '14',

			'uppercase' => array('buttons', '.kbg-header li a'),

			// Misc.
			'default_fimg' => array( 'url' => esc_url( get_parent_theme_file_uri( '/assets/img/kbg_default.jpg' ) ) ),
			'404_image' => '',
			'rtl_mode' => false,
			'rtl_lang_skip' => '',
			'more_string' => '...',
			'words_read_per_minute' => 180,

			// Ads
			'ad_above_archive' => '',
			'ad_above_singular' => '',
			'ad_above_footer' => '',
			'ad_between_posts' => '',
			'ad_between_position' => 3,
			'ad_exclude' => array(),

			// Translation Options
			'enable_translate' => true,

			// Performance
			'minify_css' => true,
			'minify_js' => true,
			'disable_img_sizes' => array(),
		);

		foreach ( $translate as $string_key => $item ) {

			if ( isset( $item['hidden'] ) ) {
				continue;
			}

			if ( isset( $item['default'] ) ) {
				$defaults['tr_' . $string_key] = $item['default'];
			}
		}

		$defaults = apply_filters( 'kbg_modify_default_options', $defaults );

		if ( empty( $option ) ) {
			return $defaults;
		}

		if ( isset( $defaults[$option] ) ) {
			return $defaults[$option];
		}

		return false;
	}
endif;
