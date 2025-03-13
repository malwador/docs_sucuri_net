<?php

/**
 * Display theme admin notices
 *
 * @since  1.0
 */

add_action( 'admin_init', 'kbg_check_installation' );

if ( !function_exists( 'kbg_check_installation' ) ):
	function kbg_check_installation() {
		add_action( 'admin_notices', 'kbg_welcome_msg', 1 );
		add_action( 'admin_notices', 'kbg_update_msg', 1 );
		add_action( 'admin_notices', 'kbg_required_plugins_msg', 30 );
	}
endif;


/**
 * Display welcome message and quick tips after theme activation
 *
 * @since  1.0
 */

if ( !function_exists( 'kbg_welcome_msg' ) ):
	function kbg_welcome_msg() {

		if ( get_option( 'kbg_welcome_box_displayed' ) ||  get_option( 'merlin_knowledgeguru_completed' ) ) {
			return false;
		}

		update_option( 'KBG_THEME_VERSION', KBG_THEME_VERSION );
		include_once get_parent_theme_file_path( '/core/admin/welcome-panel.php' );
	}
endif;


/**
 * Display message when new version of the theme is installed/updated
 *
 * @since  1.0
 */

if ( !function_exists( 'kbg_update_msg' ) ):
	function kbg_update_msg() {

		if ( !get_option( 'kbg_welcome_box_displayed' ) && !get_option( 'merlin_knowledgeguru_completed' ) ) {
			return false;
		}

		$prev_version = get_option( 'KBG_THEME_VERSION', '0.0.0' );

		if ( version_compare( KBG_THEME_VERSION, $prev_version, '>' ) ) {
			include_once get_parent_theme_file_path( '/core/admin/update-panel.php' );
		}

	}
endif;

/**
 * Display message if required plugins are not installed and activated
 *
 * @since  1.0
 */

if ( !function_exists( 'kbg_required_plugins_msg' ) ):
	function kbg_required_plugins_msg() {

		if ( !get_option( 'kbg_welcome_box_displayed' ) && !get_option( 'merlin_knowledgeguru_completed' ) ) {
			return false;
		}

		if ( !kbg_is_kirki_active() ) {
			$class = 'notice notice-error';
			$message = kbg_wp_kses( sprintf( __( 'Important: Kirki Toolkit plugin is required to run your Theme Options / Customizer panel. Please visit <a href="%s">recommended plugins page</a> to install it.', 'knowledge-guru' ), admin_url( 'admin.php?page=kbg-plugins' ) ) );
			printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
		}

		if ( !kbg_is_kb_blocks_active() ) {
			$class = 'notice notice-error';
			$message = kbg_wp_kses( sprintf( __( 'Important: Knowledge Base Blocks plugin is required for full theme functionality. Please visit <a href="%s">recommended plugins page</a> to install it.', 'knowledge-guru' ), admin_url( 'admin.php?page=kbg-plugins' ) ) );
			printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
		}
	}
endif;



/**
 * Store registered sidebars and menus so we can use them inside theme options
 * before wp_registered_sidebars global is initialized
 *
 * @since  1.0
 */

add_action( 'admin_init', 'kbg_check_sidebars_and_menus' );

if ( !function_exists( 'kbg_check_sidebars_and_menus' ) ):
	function kbg_check_sidebars_and_menus() {
		global $wp_registered_sidebars;
		if ( !empty( $wp_registered_sidebars ) ) {
			update_option( 'kbg_registered_sidebars', $wp_registered_sidebars );
		}

		$registered_menus = get_registered_nav_menus();
		if ( !empty( $registered_menus ) ) {
			update_option( 'kbg_registered_menus', $registered_menus );
		}

	}
endif;


/**
 * Change default arguments of author widget plugin
 *
 * @since  1.0
 */

add_filter( 'mks_author_widget_modify_defaults', 'kbg_author_widget_defaults' );

if ( !function_exists( 'kbg_author_widget_defaults' ) ):
	function kbg_author_widget_defaults( $defaults ) {
		$defaults['title'] = '';
		$defaults['avatar_size'] = 100;
		return $defaults;
	}
endif;


/**
 * Change default arguments of flickr widget plugin
 *
 * @since  1.0
 */

add_filter( 'mks_flickr_widget_modify_defaults', 'kbg_flickr_widget_defaults' );

if ( !function_exists( 'kbg_flickr_widget_defaults' ) ):
	function kbg_flickr_widget_defaults( $defaults ) {

		$defaults['count'] = 9;
		$defaults['t_width'] = 76;
		$defaults['t_height'] = 76;

		return $defaults;
	}
endif;



/**
 * Remove audio player fields from its settings page
 *
 * @since  1.0
 */

add_filter( 'meks_ap_modify_options_fields', 'kbg_ap_modify_options_fields' );

if ( !function_exists( 'kbg_ap_modify_options_fields' ) ):
	function kbg_ap_modify_options_fields( $fields ) {

		unset( $fields['post_type'] );

		return $fields;
	}
endif;



/**
 * Remove WP Forms activation redirection
 *
 * @since  1.0.0
 */
remove_action( 'in_admin_header', 'wpforms_admin_header', 100 );
update_option( 'wpforms_activation_redirect', 1 );


/**
 * Remove search post type includes field from Quick Answers Ajax Search Plugin
 *
 * @since  1.0.0
 */
add_filter( 'qa_modify_options_fields', 'kbg_modify_quick_answers_ajax_search_options' );

if ( !function_exists( 'kbg_modify_quick_answers_ajax_search_options' ) ):
	function kbg_modify_quick_answers_ajax_search_options( $fields ) {

		unset( $fields['include_types'] );
		return $fields;
	}
endif;

/**
 * Disable Meks plugins notification 
 * 
 * @since  1.0
 */
add_action( 'admin_init', 'kbg_disable_meks_plugins_admin_notice' );

if ( !function_exists( 'kbg_disable_meks_plugins_admin_notice' ) ) :
	function kbg_disable_meks_plugins_admin_notice() {

		update_option('meks_admin_notice_info', 1);
		update_option('track_transient', 0);
	}
endif;



/**
 * Add Meks dashboard widget
 *
 * @since  1.0
 */

add_action( 'wp_dashboard_setup', 'kbg_add_dashboard_widgets' );

if ( !function_exists( 'kbg_add_dashboard_widgets' ) ):
	function kbg_add_dashboard_widgets() {
		add_meta_box( 'kbg_dashboard_widget', 'Meks - WordPress Themes & Plugins', 'kbg_dashboard_widget_cb', 'dashboard', 'side', 'high' );
	}
endif;


/**
 * Meks dashboard widget
 *
 * @since  1.0
 */
if ( !function_exists( 'kbg_dashboard_widget_cb' ) ):
	function kbg_dashboard_widget_cb() {

		$transient = 'kbg_mksaw';
		$hide = '<style>#kbg_dashboard_widget{display:none;}</style>';

		$data = get_transient( $transient );
	
		if ( $data == 'error' ) {
			echo $hide;
			return;
		}

		if ( !empty( $data ) ) {
			echo $data;
			return;
		}

		$url = 'https://demo.mekshq.com/mksaw.php';
		$args = array( 'body' => array( 'key' => md5( 'meks' ), 'theme' => 'knowledge-guru' ) );
		$response = wp_remote_post( $url, $args );

		if ( is_wp_error( $response ) ) {
			set_transient( $transient, 'error', DAY_IN_SECONDS );
			echo $hide;
			return;
		}

		$json = wp_remote_retrieve_body( $response );

		if ( empty( $json ) ) {
			set_transient( $transient, 'error', DAY_IN_SECONDS );
			echo $hide;
			return;
		}

		$json = json_decode( $json );

		if ( !isset( $json->data ) ) {
			set_transient( $transient, 'error', DAY_IN_SECONDS );
			echo $hide;
			return;
		} 

		set_transient( $transient, $json->data, DAY_IN_SECONDS );
		echo $json->data;
		
	}
endif;
