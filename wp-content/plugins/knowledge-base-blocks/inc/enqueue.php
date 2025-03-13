<?php
/**
 * Enqueue
 *
 * @package Meks Blocks
 */

namespace Kbg\Kbg_Buddy;

/**
 * Enqueue block editor only JavaScript and CSS.
 */
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_block_editor_assets' );

function enqueue_block_editor_assets() {
	// Make paths variables so we don't write em twice ;)
	$block_path = 'assets/js/editor.blocks.js';
	$style_path = 'assets/css/blocks.editor.css';

	// Enqueue the bundled block JS file
	wp_enqueue_script(
		'kbg-js',
		KBG_URL . $block_path,
		[ 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor', 'wp-plugins', 'wp-edit-post', 'wp-core-data' ],
		KBG_VER
	);

	$kbg_buddy_ajax_nonce = wp_create_nonce( 'kbg_buddy_ajax_nonce' );

	wp_localize_script(
		'kbg-js',
		'kbg_buddy_js_settings',
		array(
			'blocks'            => Blocks_Config::get_block_attributes(),
			'category'          => 'kbg',
			'ajax_url'          => admin_url( 'admin-ajax.php' ),
			'home_url'          => home_url( '/' ),
			'admin_kb_tax_url'  => admin_url( 'edit-tags.php?taxonomy=kbg_category&post_type=knowledge_base' ),
			'post_types'        => Blocks_Helper::get_post_types(),
			'all_taxonomy'      => Blocks_Helper::get_related_taxonomy(),
			'image_sizes'       => Blocks_Helper::get_image_sizes(),
			'sidebarOptions'    => Blocks_Helper::kbg_get_sidebar_layouts(),
			'adminImages'       => Blocks_Helper::kbg_get_admin_images(),
			'kbg_buddy_ajax_nonce'   => $kbg_buddy_ajax_nonce,
		)
	);



	// Enqueue optional editor only styles
	wp_enqueue_style(
		'kbg-editor-css',
		KBG_URL . $style_path,
		[ ],
		KBG_VER
	);
}

/**
 * Enqueue front end and editor JavaScript and CSS assets.
 */
add_action( 'enqueue_block_assets', __NAMESPACE__ . '\enqueue_assets' );

function enqueue_assets() {
	$style_path = 'assets/css/blocks.style.css';
	
	wp_enqueue_style(
		'kbg',
		KBG_URL . $style_path,
		null
	);
	
	wp_enqueue_style(
		'kbg-font-awesome',
		KBG_URL . 'assets/font-awesome/css/font-awesome.min.css',
		null
	);

	wp_enqueue_script( 
		'kbg-helpers-js',
		KBG_URL . 'assets/js/accordion.js',
		[ 'jquery' ],
		KBG_VER,
		true
	);

}

/**
 * Enqueue frontend JavaScript and CSS assets.
 */
add_action( 'enqueue_block_assets', __NAMESPACE__ . '\enqueue_frontend_assets' );

function enqueue_frontend_assets() {

	// If in the backend, bail out.
	if ( is_admin() ) {
		return;
	}

	$block_path = 'assets/js/frontend.blocks.js';
	wp_enqueue_script(
		'kbg-frontend',
		KBG_URL . $block_path,
		[],
		KBG_VER
	);
}
