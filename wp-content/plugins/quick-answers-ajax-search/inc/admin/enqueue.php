<?php

/**
 * Enqueue file
 *
 * @package Quick_Answers
 */

namespace QA\Quick_Answers;

/* Load frontend scripts and styles */
add_action( 'admin_enqueue_scripts', __NAMESPACE__ .'\qa_load_admin_scripts' );

/**
 * Load scripts and styles on admin
 *
 * It just wraps two other separate functions for loading css and js files
 *
 * @since  1.0
 */

function qa_load_admin_scripts( $hook ) {

	// we only need it on Failed searches sub page
	if ( $hook === 'live-ajax-search_page_quick-answers-search-table' ) {
		qa_load_admin_css();
		qa_load_admin_js();
	}
}


/**
 * Load frontend CSS files
 *
 * @since  1.0
 */

function qa_load_admin_css() {

	wp_register_style( 'jquery-ui', 'https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css' );
	wp_enqueue_style( 'jquery-ui' );

	wp_add_inline_style( 'jquery-ui', '.qa-highlight a { background: #FFBF00 !important; }' );
}



/**
 * Load frontend js files
 *
 * @since  1.0
 */

function qa_load_admin_js() {
		
	wp_enqueue_script( 'qa-edit', QA_URL . 'assets/js/admin/edit.js', array( 'jquery', 'jquery-ui-datepicker' ), QA_VER, true );
	wp_localize_script( 'qa-edit', 'qa_js_admin_settings', qa_get_js_settings() );
}
