<?php

/**
 * Register menus
 *
 * Callback function theme menus registration and init
 *
 * @since  1.0
 */

add_action( 'init', 'kbg_register_menus' );

if ( !function_exists( 'kbg_register_menus' ) ) :
	function kbg_register_menus() {
		register_nav_menu( 'kbg_menu_primary', esc_html__( 'Primary Menu' , 'knowledge-guru' ) );
		register_nav_menu( 'kbg_menu_social', esc_html__( 'Social Menu' , 'knowledge-guru' ) );
		register_nav_menu( 'kbg_menu_copyright', esc_html__( 'Copyright Menu' , 'knowledge-guru' ) );
	}
endif;
