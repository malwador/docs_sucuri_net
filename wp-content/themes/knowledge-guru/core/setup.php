<?php

/**
 * After Theme Setup
 *
 * Callback for after_theme_setup hook
 *
 * @since  1.0
 */

add_action( 'after_setup_theme', 'kbg_theme_setup' );

function kbg_theme_setup() {

	/* Define default content width */
	$GLOBALS['content_width'] = kbg_size_by_col( 12 );

	/* Localization */
	load_theme_textdomain( 'knowledge-guru', get_parent_theme_file_path( '/languages' ) );

	/* Add thumbnails support */
	add_theme_support( 'post-thumbnails' );

	/* Add theme support for title tag */
	add_theme_support( 'title-tag' );

	/* Add image sizes */
	$image_sizes = kbg_get_image_sizes();

	if ( ! empty( $image_sizes ) ) {
		foreach ( $image_sizes as $id => $size ) {
			add_image_size( $id, $size['w'], $size['h'], $size['crop'] );
		}
	}

	/* Support for HTML5 elements */
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

	/* Automatic feed links */
	add_theme_support( 'automatic-feed-links' );

	/* Load editor styles */
	add_theme_support( 'editor-styles' );

	/* Support for align full elements */
	add_theme_support( 'align-wide' );
	add_theme_support( 'align-full' );


	/* Support for responsive embeds */
	add_theme_support( 'responsive-embeds' );

	/* Support for responsive embeds */
	add_theme_support( 'post-formats', array( 'video' ) );

	/*
	 Support for predefined colors in editor */
	add_theme_support( 'editor-color-palette', kbg_get_editor_colors() );

	/*
	 Support for predefined font-sizes in editor */
	add_theme_support( 'editor-font-sizes', kbg_get_editor_font_sizes() );

	/* WooCommerce features support */
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Remove 5.8 widget block editor
	remove_theme_support( 'widgets-block-editor' );

}


/**
 * Check all display settings from theme options
 * and store it globally as a query var so we can access it from any template file
 *
 * @since  1.0
 */

add_action( 'template_redirect', 'kbg_templates_setup' );

if ( ! function_exists( 'kbg_templates_setup' ) ) :
	function kbg_templates_setup() {

		$defaults = kbg_get_default_template_options();

		if ( is_front_page() ) {
			if ( 'posts' == get_option( 'show_on_front' ) ) {
				$kbg = kbg_get_archive_template_options();
			} else {
				$kbg = kbg_get_page_template_options();
			}

			if ( is_page_template( 'template-knowledge-base-blocks.php' ) ) {
				$kbg = kbg_get_page_template_options();
			}
			
		} elseif ( is_page_template( 'template-blank.php' ) ) {
			$kbg = kbg_get_blank_template_options();
		} elseif ( is_page_template( 'template-knowledge-base-blocks.php' ) ) {
			$kbg = kbg_get_page_template_options();
		} elseif ( is_page() ) {
			$kbg = kbg_get_page_template_options();
		} elseif ( is_single() ) {
			$kbg = kbg_get_single_template_options();
		} elseif ( is_search() ) {
			$kbg = kbg_get_search_template_options();
		} elseif ( is_category() || is_tax( 'kbg_category' ) ) {
			$kbg = kbg_get_category_template_options();
		} elseif ( is_404() ) {
			$kbg = kbg_get_404_template_options();
		} else {
			$kbg = kbg_get_archive_template_options();
		}

		$kbg['header'] = kbg_get_header_options();
		$kbg['footer'] = kbg_get_footer_options();
		$kbg['ads']    = kbg_get_ads_options();
		
		$kbg = kbg_parse_args( $kbg, $defaults );
		$kbg = apply_filters( 'kbg_modify_templates_setup', $kbg );

		set_query_var( 'kbg', $kbg );

	}
endif;


/**
 * Get default display options
 *
 * @since  1.0
 * @return array
 */

if ( ! function_exists( 'kbg_get_default_template_options' ) ) :
	function kbg_get_default_template_options() {

		$args         = array();
		
		$args['sidebar'] = array( 'position' => 'none' );
		$args['display'] = array(
			'header' => true,
			'footer' => true,
			'title'  => true,
		);

		$podcast_args = function_exists('kbg_get_podcast_arguments') ? kbg_get_podcast_arguments() : array();
		if ( !empty( $podcast_args ) ) {
			$args['podcast'] 	  = $podcast_args['podcast'];
			$blog_terms = isset($podcast_args['post']['terms']) ? $podcast_args['post']['terms'] : array();
			$args['episodes_ids'] = kbg_get_episodes_ids( array(), $blog_terms );
		}

		return apply_filters( 'kbg_modify_default_template_options', $args );
	}
endif;


/**
 * Get archives options
 * Return archives params based on theme options
 *
 * @since  1.0
 * @return array
 */

if ( ! function_exists( 'kbg_get_archive_template_options' ) ) :
	function kbg_get_archive_template_options() {

		$args = array();

		$archive_type = is_post_type_archive( 'knowledge_base' ) || is_tax( 'kbg_category' ) ? 'kb_' : '';
		
		$args['archive_type']      = $archive_type == 'kb_' ? 'kb' : 'post' ;
		$args['layout']            = kbg_get_option( $archive_type . 'archive_layout' );
		$args['loop']              = kbg_get_option( $archive_type . 'archive_loop' );
		$args['pagination']        = kbg_get_option( $archive_type . 'archive_pagination' );

		if ( kbg_get_option( $archive_type . 'archive_sidebar_display' ) ) {
			$args['sidebar'] = array(
				'position' => kbg_get_option( $archive_type . 'archive_sidebar_position' ),
				'classic'  => kbg_get_option( $archive_type . 'archive_sidebar_standard' ),
				'sticky'   => kbg_get_option( $archive_type . 'archive_sidebar_sticky' ),
			);
		}

		$archive = kbg_get_archive_content();

		if ( $archive ) {
			$args['archive_content']     = true;
			$args['archive_title']       = $archive['title'];
			$args['archive_description'] = kbg_get_option( $archive_type . 'archive_description' ) ? $archive['description'] : '';
			$args['archive_meta']        = kbg_get_option( $archive_type . 'archive_meta' ) ? $archive['meta'] : '';
			$args['archive_avatar']      = $archive['avatar'];
			$args['archive_subnav']      = $archive['subnav'];
		} else {
			$args['archive_content'] = false;
		}


		if ( kbg_loop_has_sidebar( $args['loop'] ) && isset($archive['meta']) && $archive['meta'] ) {
			$args['archive_class'] = 'justify-content-start';
		} else {
			$args['archive_class'] = 'justify-content-center';
		}
	
		$args['masonry_class'] = $args['archive_type'] == 'post' && $args['loop'] == 2  ? 'kbg-masonry' : '';			

		$args = apply_filters( 'kbg_modify_archive_template_options', $args );

		return $args;
	}
endif;

/**
 * Get search archive options
 * Return archives params based on theme options
 *
 * @since  1.0
 * @return array
 */

if ( ! function_exists( 'kbg_get_search_template_options' ) ) :
	function kbg_get_search_template_options() {

		$args = array();
		
		$args['archive_type']      = 'kb';
		$args['layout']            = kbg_get_option( 'search_archive_layout' );
		$args['loop']              = kbg_get_option( 'search_archive_loop' );
		$args['pagination']        = kbg_get_option( 'search_archive_pagination' );

		if ( kbg_get_option( 'search_archive_sidebar_display' ) ) {
			$args['sidebar'] = array(
				'position' => kbg_get_option( 'search_archive_sidebar_position' ),
				'classic'  => kbg_get_option( 'search_archive_sidebar_standard' ),
				'sticky'   => kbg_get_option( 'search_archive_sidebar_sticky' ),
			);
		}

		$archive = kbg_get_archive_content();

		if ( $archive ) {
			$args['archive_content']     = true;
			$args['archive_title']       = $archive['title'];
			$args['archive_description'] = '';
			$args['archive_meta']        = kbg_get_option( 'search_archive_meta' ) ? $archive['meta'] : '' ;
		} else {
			$args['archive_content'] = false;
		}


		if ( kbg_loop_has_sidebar( $args['loop'] ) && kbg_get_option( 'search_archive_sidebar_display' ) ) {
			$args['archive_class'] = 'justify-content-start';
		}else{
			$args['archive_class'] = 'justify-content-center';
		}
	
		$args['masonry_class'] = '';		

		$args = apply_filters( 'kbg_modify_search_archive_template_options', $args );

		return $args;
	}
endif;

/**
 * Get category options
 * Return category params based on theme options
 *
 * @since  1.0
 * @return array
 */

if ( ! function_exists( 'kbg_get_category_template_options' ) ) :
	function kbg_get_category_template_options() {

		$cat_id       = get_queried_object_id();
		$meta         = kbg_get_category_meta( $cat_id );

		$args = array();

		$args['archive_type'] = is_tax( 'kbg_category' ) ? 'kb' : 'post';
		$args['layout']       = $meta['layout'];
		$args['loop']         = $meta['loop'];
		$args['pagination']   = $meta['pagination'];

		if ( kbg_loop_has_sidebar( $args['loop'], $args['archive_type'] ) && $meta['sidebar_enabled'] ) {
			$args['sidebar'] = array(
				'position' => $meta['sidebar']['position'],
				'classic'  => $meta['sidebar']['classic'],
				'sticky'   => $meta['sidebar']['sticky'],
			);
		}

		$archive = kbg_get_archive_content();

		if ( $archive ) {
			$args['archive_content']     = true;
			$args['archive_title']       = $archive['title'];
			$args['archive_description'] = $meta['archive']['description'] ? $archive['description'] : '';
			$args['archive_meta']        = $meta['archive']['meta'] ? $archive['meta'] : '';
		} else {
			$args['archive_content'] = false;
		}

		if ( kbg_loop_has_sidebar( $args['loop'] ) && $meta['sidebar_enabled'] ) {
			$args['archive_class'] = 'justify-content-start';
		} else {
			$args['archive_class'] = 'justify-content-center';
		}
		
		$args['masonry_class'] = $args['archive_type'] == 'post' && $args['loop'] == 2  ? 'kbg-masonry' : '';		
		
		// KB Category Icon
		if ( $args['archive_type'] == 'kb' ) {
			$args['has_icon'] = kbg_get_option('kb_category_icon');
		}

		return apply_filters( 'kbg_modify_category_template_options', $args );

	}
endif;


/**
 * Get single template options
 * Return single post params based on theme options
 *
 * @since  1.0
 * @return array
 */

if ( ! function_exists( 'kbg_get_single_template_options' ) ) :
	function kbg_get_single_template_options() {

		$meta = kbg_get_post_meta();
		$args = array();

		$args['type']    = is_singular( 'knowledge_base' ) ? 'kb' : 'post';
		$args['layout']  = $meta['layout'];
		$args['sidebar'] = $meta['sidebar'];
		
		$args['meta']      		= kbg_get_option( 'single_' . $args['type'] . '_meta' );
		$args['headline']       = kbg_get_option( 'single_' . $args['type'] . '_headline' );
		$args['fimg']           = kbg_get_option( 'single_' . $args['type'] . '_fimg' );
		$args['fimg_cap']       = kbg_get_option( 'single_' . $args['type'] . '_fimg_cap' );
		$args['tags']           = kbg_get_option( 'single_' . $args['type'] . '_tags' );
		$args['prev_next']      = kbg_get_option( 'single_' . $args['type'] . '_prev_next' );
		$args['author']         = kbg_get_option( 'single_' . $args['type'] . '_author' );
		$args['related']        = kbg_get_option( 'single_' . $args['type'] . '_related' );
		$args['related_layout'] = kbg_get_option( 'single_' . $args['type'] . '_related_layout' );
		
		$args['post_format'] =  get_post_format() ? : 'standard';

		$args['has_fimg'] = $args['fimg'] && has_post_thumbnail( get_the_ID() ) ? true : false;

		// subheader breadcrumbs and search
		$args['has_subheader'] = kbg_get_option( 'single_' . $args['type'] . '_subheader' );
		$args['subheader_left'] = kbg_get_option( 'single_' . $args['type'] . '_subheader_left' );
		$args['subheader_right'] = kbg_get_option( 'single_' . $args['type'] . '_subheader_right' );
		$args['subheader_breadcrumbs_type'] = kbg_get_option( 'single_' . $args['type'] . '_subheader_breadcrumbs_type' );

		return apply_filters( 'kbg_modify_single_template_options', $args );
	}
endif;


/**
 * Get page template options
 * Return page template params based on theme options
 *
 * @since  1.0
 * @return array
 */

if ( ! function_exists( 'kbg_get_page_template_options' ) ) :
	function kbg_get_page_template_options() {

		$meta = kbg_get_page_meta();

		$args = array();

		$args['layout']   = $meta['layout'];
		$args['fimg']     = kbg_get_option( 'page_fimg' );
		$args['fimg_cap'] = kbg_get_option( 'page_fimg_cap' );
		$args['sidebar']  = $meta['sidebar'];
		
		if ( in_array( $args['layout'], array( '2' ) ) ) {
			$args['cover'] = true;
		}

		return apply_filters( 'kbg_modify_page_template_options', $args );
	}
endif;


/**
 * Get 404 template options
 * Return page template params based on theme options
 *
 * @since  1.0
 * @return array
 */

if ( ! function_exists( 'kbg_get_404_template_options' ) ) :
	function kbg_get_404_template_options() {

		$args = array();

		$args['title']     = esc_html(__kbg( '404_title' ));
		$args['404_image'] = kbg_get_option( '404_image', 'image' );
		$args['text']      = kbg_wp_kses(__kbg( '404_text' ));

		if ( ! empty( $args['404_image'] ) ) {
			$args['cover'] = true;
		}

		return apply_filters( 'kbg_modify_404_template_options', $args );
	}
endif;


/**
 * Get page template options
 * Return page template params based on theme options
 *
 * @since  1.0
 * @return array
 */

if ( ! function_exists( 'kbg_get_blank_template_options' ) ) :
	function kbg_get_blank_template_options() {
		$args = array();

		$args['display'] = array(
			'header' => false,
			'footer' => false,
			'title'  => false,
		);

		return apply_filters( 'kbg_modify_blank_template_options', $args );
	}
endif;


/**
 * Get header options
 * Return header params based on theme options
 *
 * @since  1.0
 * @return array
 */

if ( ! function_exists( 'kbg_get_header_options' ) ) :
	function kbg_get_header_options() {

		$args = array();

		$args['actions'] = kbg_get_option( 'header_actions' );	

		$args['layout']              = kbg_get_option( 'header_layout' );
		$args['nav']                 = kbg_get_option( 'header_main_nav' );
		
		$args['sticky']        = kbg_get_option( 'header_sticky' );
		$args['sticky_layout'] = kbg_get_option( 'header_sticky_layout' );
		
		$sticky_inherit_header =  kbg_get_option( 'header_sticky_type' );

		$args['sticky_nav']     = $sticky_inherit_header == 'inherit' ? $args['nav'] : kbg_get_option( 'header_sticky_nav' );
		$args['sticky_actions'] = $sticky_inherit_header == 'inherit' ? $args['actions'] : kbg_get_option( 'header_sticky_actions' );

		$args = apply_filters( 'kbg_modify_header_options', $args );

		return $args;
	}
endif;

/**
 * Get footer options
 * Return header params based on theme options
 *
 * @since  1.0
 * @return array
 */

if ( ! function_exists( 'kbg_get_footer_options' ) ) :
	function kbg_get_footer_options() {
		$args = array();

		$args['widgets'] = kbg_get_option( 'footer_widgets' ) ? explode( '-', kbg_get_option( 'footer_widgets_layout' ) ) : false;

		$args['widgets_class'] = kbg_get_option( 'footer_widgets_layout' ) == '4' ? 'footer-widgets-center' : false;
		$args['widgets_style'] = kbg_get_option( 'footer_widgets_style' );

		$args['display_copyright_and_menu'] = kbg_get_option( 'footer_copyright_and_menu' );
		
		$args['copyright'] = kbg_get_option( 'footer_copyright' ) ? str_replace( '{current_year}', date( 'Y' ), kbg_get_option( 'footer_copyright' ) ) : '';
		$args['copyright_menu'] = kbg_get_option( 'copyright_menu' );
		$args['copyright_align_class'] = kbg_get_option( 'copyright_menu' ) ? 'text--right' : '';

		if ( kbg_get_option( 'popup' ) && function_exists( 'has_block' ) && is_singular() ) {

			$id = get_the_ID();

			if ( has_block( 'image', $id ) || has_block( 'gallery', $id ) ) {
				$args['popup'] = true;
			}
		}

		$args = apply_filters( 'kbg_modify_footer_options', $args );

		return $args;
	}
endif;


/**
 * Get ads options
 * Return ad slots content based on theme options
 *
 * @since  1.0
 * @return array
 */

if ( ! function_exists( 'kbg_get_ads_options' ) ) :
	function kbg_get_ads_options() {
		$args = array();

		if ( ! is_404() ) {

			$args['above_archive']    = kbg_get_option( 'ad_above_archive' );
			$args['above_singular']   = kbg_get_option( 'ad_above_singular' );
			$args['above_footer']     = kbg_get_option( 'ad_above_footer' );
			$args['between_posts']    = kbg_get_option( 'ad_between_posts' );
			$args['between_position'] = ! empty( $args['between_posts'] ) ? absint( kbg_get_option( 'ad_between_position' ) ) - 1 : false;

			$args['above_archive']  = wp_specialchars_decode( $args['above_archive'], ENT_QUOTES );
			$args['above_singular'] = wp_specialchars_decode( $args['above_singular'], ENT_QUOTES );
			$args['above_footer']   = wp_specialchars_decode( $args['above_footer'], ENT_QUOTES );
			$args['between_posts']  = wp_specialchars_decode( $args['between_posts'], ENT_QUOTES );

			if ( is_page() && in_array( get_the_ID(), kbg_get_option( 'ad_exclude' ) ) ) {
				$args = array();
			}
		}

		$args = apply_filters( 'kbg_modify_ads_options', $args );

		return $args;
	}
endif;

