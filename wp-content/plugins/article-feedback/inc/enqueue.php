<?php

/**
 * Enqueue file
 *
 * @package AF
 */

namespace AF\Article_Feedback;

/* Load frontend scripts and styles */
add_action( 'wp_enqueue_scripts', __NAMESPACE__ .'\af_load_scripts' );

/**
 * Load scripts and styles on frontend
 *
 * It just wraps two other separate functions for loading css and js files
 *
 * @since  1.0
 */

function af_load_scripts() {
	af_load_css();
	af_load_js();
}

/**
 * Load frontend css files
 *
 * @since  1.0
 */

function af_load_css() {
	wp_enqueue_style( 'af-main', AF_URL . 'assets/css/main.css', false, AF_VER );
}


/**
 * Load frontend js files
 *
 * @since  1.0
 */

function af_load_js() {

	wp_enqueue_script( 'af-main', AF_URL . 'assets/js/main.js', array( 'jquery' ), AF_VER, true );

	//Load JS settings object
	wp_localize_script( 'af-main', 'af_js_settings', af_get_js_settings() );
}
