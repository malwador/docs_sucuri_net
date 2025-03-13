<?php

/* Load admin scripts and styles */
add_action( 'admin_enqueue_scripts', 'kbg_load_admin_scripts' );


/**
 * Load scripts and styles in admin
 *
 * It just wrapps two other separate functions for loading css and js files in admin
 *
 * @since  1.0
 */

function kbg_load_admin_scripts() {
	kbg_load_admin_css();
	kbg_load_admin_js();
}


/**
 * Load admin css files
 *
 * @since  1.0
 */

function kbg_load_admin_css() {

	global $pagenow, $typenow;

	//Load minor admin style tweaks
	wp_enqueue_style( 'kbg-global', get_parent_theme_file_uri( '/assets/css/admin/global.css' ), false, KBG_THEME_VERSION );
}


/**
 * Load admin js files
 *
 * @since  1.0
 */

function kbg_load_admin_js() {

	global $pagenow, $typenow;

	//Load global js
	wp_enqueue_script( 'kbg-global', get_parent_theme_file_uri( '/assets/js/admin/global.js' ) , array( 'jquery' ), KBG_THEME_VERSION );

	//Load category JS
	if ( in_array( $pagenow, array( 'edit-tags.php', 'term.php' ) ) && isset( $_GET['taxonomy'] ) && ( $_GET['taxonomy'] == 'category' || $_GET['taxonomy'] == 'series' ) ) {
	 wp_enqueue_media();
	 wp_enqueue_script( 'kbg-category', get_parent_theme_file_uri( '/assets/js/admin/metaboxes-category.js' ), array( 'jquery' ), KBG_THEME_VERSION );
	}

	//Load post & page js
	if ( $typenow == 'page' && in_array( $pagenow, array( 'post.php', 'post-new.php' ) ) ) {
	  wp_enqueue_script( 'kbg-page', get_parent_theme_file_uri( '/assets/js/admin/metaboxes-page.js' ), array( 'jquery' ), KBG_THEME_VERSION );
	  wp_localize_script( 'kbg-page', 'kbg_js_settings', kbg_get_admin_js_settings() );
	}


}

/**
 * Load dynamic editor styles
 *
 * @since  1.0
 */

add_action( 'enqueue_block_editor_assets', 'kbg_block_editor_styles', 99 );

function kbg_block_editor_styles() {

	if ( $fonts_link = kbg_generate_fonts_link() ) {
		wp_enqueue_style( 'kbg-fonts', $fonts_link, false, KBG_THEME_VERSION );
	}
	
	wp_enqueue_style( 'kbg-editor-iconfont', get_parent_theme_file_uri( '/assets/css/iconfont.css' ), false, KBG_THEME_VERSION );
	if ( kbg_get_option( 'minify_js' ) ) {
		wp_enqueue_style( 'kbg-editor-styles', get_parent_theme_file_uri( '/assets/css/admin/editor-style.css' ), false, KBG_THEME_VERSION );
	} else {
		wp_enqueue_style( 'kbg-editor-styles', get_parent_theme_file_uri( '/assets/css/admin/editor-min-style.css' ), false, KBG_THEME_VERSION );
	}

	wp_add_inline_style( 'kbg-editor-styles', kbg_generate_dynamic_editor_css() );

}
