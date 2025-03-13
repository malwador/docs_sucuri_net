<?php

/**
 * Register Widgets
 *
 * @package KB_CPT
 */

namespace Kbg\KB_CPT;

/**
 * Register widgets
 *
 * Callback function which includes widget classes and initializes theme specific widgets
 *
 * @return void
 * @since  1.0
 */


add_action( 'widgets_init', __NAMESPACE__ . '\kbg_include_and_register_widgets' );

function kbg_include_and_register_widgets() {

	include KB_CPT_DIR . '/inc/widgets/class-widget-kbg-category.php';
	include KB_CPT_DIR . '/inc/widgets/class-widget-knowledge-base-articles.php';
	include KB_CPT_DIR . '/inc/widgets/class-widget-kbg-posts.php';

	register_widget( KBG_Category_Widget::class );
	register_widget( KBG_CPT_Knowledge_Base_Posts_Widget::class );
	register_widget( KBG_Posts_Widget::class );
}
