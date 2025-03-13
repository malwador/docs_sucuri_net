<?php

/**
 * Enqueue file
 *
 * @package Quick_Answers
 */

namespace QA\Quick_Answers;

/* Load frontend scripts and styles */
add_action( 'wp_enqueue_scripts', __NAMESPACE__ .'\qa_load_scripts' );

/**
 * Load scripts and styles on frontend
 *
 * It just wraps two other separate functions for loading css and js files
 *
 * @since  1.0
 */

function qa_load_scripts() {
	qa_load_css();
	qa_load_js();
}

/**
 * Load frontend css files
 *
 * @since  1.0
 */

function qa_load_css() {

	wp_enqueue_style( 'qa-search', QA_URL . 'assets/css/search.css', false, QA_VER );
}


/**
 * Load frontend js files
 *
 * @since  1.0
 */

function qa_load_js() {

	wp_enqueue_script( 'qa-search', QA_URL . 'assets/js/search.js', array( 'jquery', 'jquery-ui-autocomplete' ), QA_VER, true );

	//Load JS settings object
	wp_localize_script( 'qa-search', 'qa_js_settings', qa_get_js_settings() );

}
