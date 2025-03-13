<?php

/**
 * Hide update notification and update theme version
 *
 * @since  1.0
 */

add_action( 'wp_ajax_kbg_update_version', 'kbg_update_version' );

if ( !function_exists( 'kbg_update_version' ) ):
	function kbg_update_version() {
		update_option( 'KBG_THEME_VERSION', KBG_THEME_VERSION );
		wp_die();
	}
endif;


/**
 * Hide welcome notification
 *
 * @since  1.0
 */

add_action( 'wp_ajax_kbg_hide_welcome', 'kbg_hide_welcome' );

if ( !function_exists( 'kbg_hide_welcome' ) ):
	function kbg_hide_welcome() {
		update_option( 'kbg_welcome_box_displayed', true );
		wp_die();
	}
endif;
