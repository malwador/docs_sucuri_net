<?php

/**
 * Enqueue file
 *
 * @package AF
 */

namespace AF\Article_Feedback;

/* Load frontend scripts and styles */
add_action( 'admin_enqueue_scripts', __NAMESPACE__ .'\af_load_admin_scripts' );

/**
 * Load scripts and styles on frontend
 *
 * It just wraps two other separate functions for loading css and js files
 *
 * @since  1.0
 */

function af_load_admin_scripts() {
	af_load_admin_css();
	af_load_admin_js();
}

/**
 * Load frontend css files
 *
 * @since  1.0
 */

function af_load_admin_css() {

	wp_enqueue_style( 'af-admin', AF_URL . 'assets/css/admin.css', false, AF_VER );
}


/**
 * Load frontend js files
 *
 * @since  1.0
 */

function af_load_admin_js() {

	wp_enqueue_script( 'af-admin', AF_URL . 'assets/js/admin.js', array( 'jquery' ), AF_VER, true );


}
