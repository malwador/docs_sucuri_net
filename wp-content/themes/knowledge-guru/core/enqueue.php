<?php

/* Load frontend scripts and styles */
add_action( 'wp_enqueue_scripts', 'kbg_load_scripts' );

/**
 * Load scripts and styles on frontend
 *
 * It just wraps two other separate functions for loading css and js files
 *
 * @since  1.0
 */

function kbg_load_scripts() {
	kbg_load_css();
	kbg_load_js();
}

/**
 * Load frontend css files
 *
 * @since  1.0
 */

function kbg_load_css() {

	//Check if is minified option active and load appropriate files
	if ( kbg_get_option( 'minify_css' ) ) {
		wp_enqueue_style( 'kbg-iconfont', get_parent_theme_file_uri( '/assets/css/iconfont.css' ) , true, KBG_THEME_VERSION );
		wp_enqueue_style( 'kbg-main', get_parent_theme_file_uri( '/assets/css/min-style.css' ) , false, KBG_THEME_VERSION );
		wp_enqueue_style( 'kbg-main-custom', get_parent_theme_file_uri( '/assets/css/scss/main.css' ) , false, KBG_THEME_VERSION );
	} else {

		$styles = array(
			'kbg-iconfont' => 'iconfont.css',
			'kbg-main' => 'main-style.css'
		);

		foreach ( $styles as $id => $style ) {
			wp_enqueue_style( $id, get_parent_theme_file_uri( '/assets/css/'. $style ) , false, KBG_THEME_VERSION );
		}
	}


	//Append dynamic css
	wp_add_inline_style( 'kbg-main', kbg_generate_dynamic_css() );

	//Load RTL css
	if ( kbg_is_rtl() ) {
		wp_enqueue_style( 'kbg-rtl', get_parent_theme_file_uri( '/assets/css/rtl.css' ), array( 'kbg-main' ), KBG_THEME_VERSION );
	}

}


/**
 * Load frontend js files
 *
 * @since  1.0
 */

function kbg_load_js() {

	//Check if is minified option active and load appropriate files
	if ( kbg_get_option( 'minify_js' ) ) {

		wp_enqueue_script( 'kbg-main', get_parent_theme_file_uri( '/assets/js/min.js' ) , array( 'jquery', 'imagesloaded' ), KBG_THEME_VERSION, true );

	} else {

		$scripts = array(
			'kbg-sticky-kit' => 'sticky-kit.js',
			'kbg-main' => 'main.js'
		);

		foreach ( $scripts as $id => $script ) {
			wp_enqueue_script( $id, get_parent_theme_file_uri( '/assets/js/'. $script ), array( 'jquery', 'imagesloaded' ), KBG_THEME_VERSION, true );
		}
	}

	if ( 
		in_array( '2', array( kbg_get_option( 'archive_loop' ), kbg_get_option( 'category_loop' ) ) ) 
		&& 
		( !is_tax( 'kbg_category' ) || !is_post_type_archive( 'knowledge_base' ) || !is_tax( 'kbg_tag' ) ) ) 
	{
		wp_enqueue_script('jquery-masonry');
	}

	//Load JS settings object
	wp_localize_script( 'kbg-main', 'kbg_js_settings', kbg_get_js_settings() );

	//Load comment reply js
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}


/**
 * Load customizer/preview js files
 *
 * @since  1.0
 */

add_action( 'customize_preview_init', 'kbg_preview_js' );

function kbg_preview_js() {
	
  	wp_enqueue_script( 'kbg-customizer', get_parent_theme_file_uri( '/assets/js/admin/customizer.js' ), array( 'customize-preview', 'jquery' ), KBG_THEME_VERSION, true );
}
