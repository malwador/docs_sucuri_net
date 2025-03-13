<?php
/**
 * Enqueue
 *
 * @package KB_CPT
 */

namespace Kbg\KB_CPT;


/* Load admin scripts and styles */
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\load_admin_scripts' );

function load_admin_scripts() {

	global $pagenow, $typenow;
	
	$category_js_path = 'assets/js/metaboxes-category.js';
	$widgets_js_path = 'assets/js/widgets.js';

	//Load category JS
	if ( in_array( $pagenow, array( 'edit-tags.php', 'term.php' ) ) && isset( $_GET['taxonomy'] ) && ( $_GET['taxonomy'] == 'kbg_category' ) ) {

		wp_enqueue_media();

		wp_enqueue_script( 
			'kbg_category-category', 
			KB_CPT_URL . $category_js_path, 
			array( 'jquery' ), 
			KB_CPT_VER
		);
	}

	if( $pagenow == 'widgets.php' ){
		wp_enqueue_script( 
			'kbg-widgets', 
			KB_CPT_URL . $widgets_js_path, 
			array( 'jquery', 'jquery-ui-sortable'), 
			KB_CPT_VER 
		);
	}

}
