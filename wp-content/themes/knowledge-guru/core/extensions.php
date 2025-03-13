<?php

/**
 * body_class callback
 *
 * Checks for specific options and applies additional class to body element
 *
 * @since  1.0
 */

add_filter( 'body_class', 'kbg_body_class' );

if ( !function_exists( 'kbg_body_class' ) ):
	function kbg_body_class( $classes ) {


		if ( kbg_has_sidebar( 'right' ) ) {
			$classes[] = 'kbg-sidebar-right';
		}

		if ( kbg_has_sidebar( 'left' ) ) {
			$classes[] = 'kbg-sidebar-left';
		}

		if ( kbg_has_sidebar( 'none' ) ) {
			$classes[] = 'kbg-sidebar-none';
		}

		if ( kbg_get_option( 'header_orientation' ) == 'window' ) {
			$classes[] = 'kbg-header-window';
		}

		if ( !kbg_get_option( 'header_labels' ) ) {
			$classes[] = 'kbg-header-labels-hidden';
		}

		$classes[] = 'kbg-v_' . str_replace( '.', '_', KBG_THEME_VERSION );

		if ( is_child_theme() ) {
			$classes[] = 'kbg-child';
		}

		return $classes;
	}
endif;


/**
 * Content width
 *
 * Checks for specific options and change content width global based on the current layout
 *
 * @since  1.0
 */

add_action( 'template_redirect', 'kbg_content_width', 0 );

if ( !function_exists( 'kbg_content_width' ) ):
	function kbg_content_width() {

		if ( is_page() ) {
			$content_width = kbg_size_by_col( kbg_get_option( 'page_width' ) );
		} elseif ( is_single() ) {
			$content_width = kbg_size_by_col( kbg_get_option( 'single_post_width' ) );
		} else {
			$content_width = kbg_size_by_col( 12 );
		}

		$GLOBALS['content_width'] = $content_width;
	}
endif;


/**
 * frontpage_template filter callback
 *
 * Use front-page.php template only if a user enabled it in theme options.
 * This provides a possibility for the user to opt-out and use wordpress default reading settings.
 *
 * @since  1.0
 */

add_filter( 'frontpage_template',  'kbg_front_page_template' );

if ( !function_exists( 'kbg_front_page_template' ) ):
	function kbg_front_page_template( $template ) {

		if ( kbg_get_option( 'front_page_template' ) ) {
			return $template;
		}

		if ( 'posts' == get_option( 'show_on_front' ) ) {
			$template = get_home_template();
		} else {
			$template = get_page_template();
		}

		return $template;
	}

endif;


/**
 * Modify Woocommerce Product Category Widget arguments
 *
 * @since  1.0
 */

add_filter( 'woocommerce_product_categories_widget_args', 'kbg_modify_wc_product_cat_count' );

if ( !function_exists( 'kbg_modify_wc_product_cat_count' ) ):
	function kbg_modify_wc_product_cat_count( $args ) {

		$args['walker'] = new kbg_Modify_WC_Product_Cat_List();

		return $args;
	}
endif;


/**
 * Add css class to parent in category widget so we can have an accordion menu
 *
 * @since  1.0
 */

add_filter( 'category_css_class', 'kbg_modify_category_widget_css_class', 10, 4 );

if ( !function_exists( 'kbg_modify_category_widget_css_class' ) ):
	function kbg_modify_category_widget_css_class( $css_classes, $category, $depth, $args ) {
		if ( isset( $args['hierarchical'] ) && $args['hierarchical'] ) {
			$term = get_queried_object();
			$children = get_terms( $category->taxonomy, array(
					'parent'    => $category->term_id,
					'hide_empty' => false
				) );

			if ( !empty( $children ) ) {
				$css_classes[] = 'cat-parent';
			}

		}
		return $css_classes;
	}
endif;


/**
 * Add span elements to post count number in archives widget
 *
 * @since  1.0
 */

add_filter( 'get_archives_link', 'kbg_modify_archive_widget_post_count', 10, 6 );

if ( !function_exists( 'kbg_modify_archive_widget_post_count' ) ):
	function kbg_modify_archive_widget_post_count( $link_html, $url, $text, $format, $before, $after ) {

		if ( $format == 'html' && !empty( $after ) ) {
			$new_after = str_replace( '(', '<span class="count">', $after );
			$new_after = str_replace( ')', '</span>', $new_after );

			$link_html = str_replace( $after, $new_after, $link_html );
		}

		return $link_html;
	}
endif;



/**
 * Modify WooCommerce wrappers
 *
 * Provide support for WooCommerce pages to match theme HTML markup
 *
 * @return HTML output
 * @since  1.0
 */

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
add_action( 'woocommerce_before_main_content', 'kbg_woocommerce_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'kbg_woocommerce_wrapper_end', 10 );

if ( !function_exists( 'kbg_woocommerce_wrapper_start' ) ):
	function kbg_woocommerce_wrapper_start() {

		echo '<div class="kbg-section">';
		echo '<div class="container">';
		echo '<div class="section-content row">';

		if ( kbg_has_sidebar( 'left' ) ) {
			echo '<div class="col-12 col-lg-4 kbg-order-3">';
			get_sidebar();
			echo '</div>';
		}

		$class =  kbg_has_sidebar( 'none' ) ? '' : 'col-lg-8';

		echo '<div class="col-12 kbg-order-1 '.esc_attr( $class ).'">';

	}
endif;

if ( !function_exists( 'kbg_woocommerce_wrapper_end' ) ):
	function kbg_woocommerce_wrapper_end() {
		echo '</div>';
		if ( kbg_has_sidebar( 'right' ) ) {
			echo '<div class="col-12 col-lg-4 kbg-order-3">';
			get_sidebar();
			echo '</div>';
		}
		echo '</div>';
		echo '</div>';
		echo '</div>';
	}
endif;


/**
 * pre_get_posts filter callback
 *
 * If a user select custom number of posts per specific archive
 * template, override default post per page value
 *
 * @since  1.0
 */

add_action( 'pre_get_posts', 'kbg_pre_get_posts' );

if ( !function_exists( 'kbg_pre_get_posts' ) ):
	function kbg_pre_get_posts( $query ) {

		$ppp = get_option( 'posts_per_page' );

		/* Archive page pagination */
		if ( !is_admin() && $query->is_main_query() && ( $query->is_archive() || $query->is_search() || $query->is_posts_page ) && !$query->is_feed() ) {

			if ( $query->is_category() || $query->is_tax( 'kbg_category' ) ) {
		
				$ppp = kbg_get_category_meta( get_queried_object_id(), 'ppp_num' );

			} else if ( $query->is_post_type_archive( 'knowledge_base' ) || $query->is_tax( 'kbg_tag' ) ) {

				$ppp = kbg_get_option( 'kb_archive_ppp' ) == 'custom' ? kbg_get_option(  'kb_archive_ppp_num' ) : $ppp;
			
			} else if ( $query->is_author ) {

				$query->set('post_type', array( 'post', 'knowledge_base' ) );
				$ppp = kbg_get_option( 'archive_ppp' ) == 'custom' ? kbg_get_option(  'archive_ppp_num' ) : $ppp;

			} else if ( $query->is_search() ){

				$post_type_to_include = kbg_get_option( 'search_archive_include_types' );
				$query->set('post_type', $post_type_to_include);
									
				$ppp = kbg_get_option( 'search_archive_ppp' ) == 'custom' ? kbg_get_option(  'search_archive_ppp_num' ) : $ppp;

			} else {
				
				$ppp = kbg_get_option( 'archive_ppp' ) == 'custom' ? kbg_get_option(  'archive_ppp_num' ) : $ppp;

			}

			
			$query->set( 'posts_per_page', absint( $ppp ) );

		}

	}
endif;


/**
 * wp_link_pages_link filter callback
 *
 * Used to add css classes to style paginated post links
 *
 * @since  1.0
 */

add_filter( 'wp_link_pages_link', 'kbg_wp_link_pages_link' );

if ( !function_exists( 'kbg_wp_link_pages_link' ) ):
	function kbg_wp_link_pages_link( $link ) {

		if ( stripos( $link, '<a' ) !== false ) {
			$link = str_replace( '<a' , '<a class="kbg-button"'  , $link );
		} else {
			$link = '<span class="kbg-button current">'.$link.'</span>';
		}

		return $link;
	}
endif;


/**
 * Woocommerce Ajaxify Cart
 *
 * @return bool
 * @since  1.0
 */


add_filter( 'woocommerce_add_to_cart_fragments', 'kbg_woocommerce_ajax_fragments' );

if ( !function_exists( 'kbg_woocommerce_ajax_fragments' ) ):

	function kbg_woocommerce_ajax_fragments( $fragments ) {
		ob_start();
		get_template_part( 'template-parts/general/header/elements/cart' );
		$fragments['.kbg-cart'] = ob_get_clean();
		return $fragments;
	}

endif;


/**
 * Add comment form default fields args filter
 * to replace comment fields labels
 *
 * @since  1.0
 */

add_filter( 'comment_form_default_fields', 'kbg_comment_fields_labels' );

if ( !function_exists( 'kbg_comment_fields_labels' ) ):
	function kbg_comment_fields_labels( $fields ) {

		$replace = array(
			'author' => array(
				'old' => esc_html__( 'Name', 'knowledge-guru' ),
				'new' => esc_html(__kbg( 'comment_name' ))
			),
			'email' => array(
				'old' => esc_html__( 'Email', 'knowledge-guru' ),
				'new' => esc_html(__kbg( 'comment_email' ))
			),
			'url' => array(
				'old' => esc_html__( 'Website', 'knowledge-guru' ),
				'new' => esc_html(__kbg( 'comment_website' ))
			),

			'cookies' => array(
				'old' => esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'knowledge-guru' ),
				'new' => esc_html(__kbg( 'comment_cookie_gdpr' ))
			)
		);

		foreach ( $fields as $key => $field ) {

			if ( array_key_exists( $key, $replace ) ) {
				$fields[$key] = str_replace( $replace[$key]['old'], $replace[$key]['new'], $fields[$key] );
			}

		}

		return $fields;

	}

endif;



/**
 * Filter for flicker widget defaults
 *
 * @param array  $defaults
 * @return array
 * @since  1.0
 */
add_filter( 'mks_flickr_widget_modify_defaults', 'kbg_modify_flicker_widget_defaults' );

if ( !function_exists( 'kbg_modify_flicker_widget_defaults' ) ):
	function kbg_modify_flicker_widget_defaults( $defaults ) {

		
		$defaults['t_width'] = 111;
		$defaults['t_height'] = 111;

		return $defaults;

	}
endif;

/**
 * Filter for Instagram widget defaults
 *
 * @param array  $defaults
 * @return array
 * @since  1.0
 */
add_filter( 'meks_instagram_widget_modify_defaults', 'kbg_modify_instagram_widget_defaults' );

if ( !function_exists( 'kbg_modify_instagram_widget_defaults' ) ):
	function kbg_modify_instagram_widget_defaults( $defaults ) {

		
		$defaults['photo_space'] = 5;
		$defaults['container_size'] = 333;

		return $defaults;

	}
endif;

/**
 * WordPress wp_enqueue_style don't support new google fonts API 2 
 * We add it on wp_head hook instead
 *
 * @since  1.0
 */
add_action( 'wp_head', 'kbg_set_google_fonts_api_2', 7 );

if ( !function_exists( 'kbg_set_google_fonts_api_2' ) ) :
	function kbg_set_google_fonts_api_2() {
		$link_src = kbg_generate_fonts_link();
		echo '<link rel="stylesheet" id="kbg-fonts-fonts" href="'. $link_src .'&ver='. KBG_THEME_VERSION .'" type="text/css" media="all" />';
	}
endif;


/**
 * WordPress Media - thumbnail size change to 60x60
 *
 * @since  1.0
 */
add_action( 'init', 'kbg_change_thumbnail_image_size' );

if ( !function_exists( 'kbg_change_thumbnail_image_size' ) ) :
	function kbg_change_thumbnail_image_size() {

		$update_thumb = get_option( 'update_thumbnail' );

		if ( $update_thumb ) {
			return;
		}
		
		update_option( 'update_thumbnail', 1 );
		update_option( 'thumbnail_size_w', 60 );
		update_option( 'thumbnail_size_h', 60 );

	}
endif;
