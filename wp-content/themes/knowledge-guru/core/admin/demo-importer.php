<?php

require_once get_parent_theme_file_path( '/inc/merlin/vendor/autoload.php' );
require_once get_parent_theme_file_path( '/inc/merlin/class-merlin.php' );

/**
 * Merlin WP configuration file.
 */

if ( ! class_exists( 'Merlin' ) ) {
	return;
}

$strings = array(
	'admin-menu'               => esc_html__( 'Knowledge Guru Setup Wizard', 'knowledge-guru' ),
	'title%s%s%s%s'            => esc_html__( '%s%s Themes &lsaquo; Theme Setup: %s%s', 'knowledge-guru' ),
	'return-to-dashboard'     => esc_html__( 'Return to the dashboard', 'knowledge-guru' ),
	'ignore'                   => esc_html__( 'Disable this wizard', 'knowledge-guru' ),

	'btn-skip'                  => esc_html__( 'Skip', 'knowledge-guru' ),
	'btn-next'                  => esc_html__( 'Next', 'knowledge-guru' ),
	'btn-start'                 => esc_html__( 'Start', 'knowledge-guru' ),
	'btn-no'                    => esc_html__( 'Cancel', 'knowledge-guru' ),
	'btn-plugins-install'       => esc_html__( 'Install', 'knowledge-guru' ),

	'btn-child-install'         => esc_html__( 'Install', 'knowledge-guru' ),
	'btn-content-install'       => esc_html__( 'Install', 'knowledge-guru' ),
	'btn-import'                => esc_html__( 'Import', 'knowledge-guru' ),
	'btn-license-activate'     => esc_html__( 'Activate', 'knowledge-guru' ),
	'btn-license-skip'         => esc_html__( 'Later', 'knowledge-guru' ),

	'welcome-header%s'         => esc_html__( 'Welcome to %s', 'knowledge-guru' ),
	'welcome-header-success%s' => esc_html__( 'Hi. Welcome back', 'knowledge-guru' ),
	'welcome%s'                => esc_html__( 'This wizard will set up your theme, install plugins, and import content. It is optional & should take only a few minutes.', 'knowledge-guru' ),
	'welcome-success%s'        => esc_html__( 'You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.', 'knowledge-guru' ),

	'license-header%s'         => esc_html__( 'Activate %s', 'knowledge-guru' ),
	'license-header-success%s' => esc_html__( '%s is Activated', 'knowledge-guru' ),
	'license%s'                => esc_html__( 'Enter your license key to enable remote updates and theme support.', 'knowledge-guru' ),
	'license-label'            => esc_html__( 'License key', 'knowledge-guru' ),
	'license-success%s'        => esc_html__( 'The theme is already registered, so you can go to the next step!', 'knowledge-guru' ),
	'license-json-success%s'   => esc_html__( 'Your theme is activated! Remote updates and theme support are enabled.', 'knowledge-guru' ),
	'license-tooltip'          => esc_html__( 'Need help?', 'knowledge-guru' ),

	'child-header'         => esc_html__( 'Install Child Theme', 'knowledge-guru' ),
	'child-header-success' => esc_html__( 'You\'re good to go!', 'knowledge-guru' ),
	'child'                => esc_html__( 'Let\'s build & activate a child theme so you may easily make theme changes.', 'knowledge-guru' ),
	'child-success%s'      => esc_html__( 'Your child theme has already been installed and is now activated, if it wasn\'t already.', 'knowledge-guru' ),
	'child-action-link'    => esc_html__( 'Learn about child themes', 'knowledge-guru' ),
	'child-json-success%s' => esc_html__( 'Awesome. Your child theme has already been installed and is now activated.', 'knowledge-guru' ),
	'child-json-already%s' => esc_html__( 'Awesome. Your child theme has been created and is now activated.', 'knowledge-guru' ),

	'plugins-header'         => esc_html__( 'Install Plugins', 'knowledge-guru' ),
	'plugins-header-success' => esc_html__( 'You\'re up to speed!', 'knowledge-guru' ),
	'plugins'                => esc_html__( 'Let\'s install some essential WordPress plugins to get your site up to speed.', 'knowledge-guru' ),
	'plugins-success%s'      => esc_html__( 'The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.', 'knowledge-guru' ),
	'plugins-action-link'    => esc_html__( 'Plugins', 'knowledge-guru' ),

	'import-header'      => esc_html__( 'Import Content', 'knowledge-guru' ),
	'import'             => esc_html__( 'Let\'s import content to your website, to help you get familiar with the theme.', 'knowledge-guru' ),
	'import-action-link' => esc_html__( 'Details', 'knowledge-guru' ),

	'ready-header'      => esc_html__( 'All done. Have fun!', 'knowledge-guru' ),
	'ready%s'           => esc_html__( 'Your theme has been all set up. Enjoy your new theme by %s.', 'knowledge-guru' ),
	'ready-action-link' => esc_html__( 'Extras', 'knowledge-guru' ),
	'ready-big-button'  => esc_html__( 'View your website', 'knowledge-guru' ),

	'ready-link-3' => '',
	'ready-link-2' => wp_kses( sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://mekshq.com/documentation/knowledge-guru/', esc_html__( 'Theme Documentation', 'knowledge-guru' ) ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ),
);

if ( kbg_is_kirki_active() ) {
	$strings['ready-link-1'] = wp_kses( sprintf( '<a href="'.add_query_arg( array( 'autofocus[panel]' => 'kbg_panel' ), admin_url( 'customize.php' ) ).'">%s</a>', esc_html__( 'Start Customizing', 'knowledge-guru' ) ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) );
}

/**
 * Set directory locations, text strings, and other settings for Merlin WP.
 *
 * @since 1.0
 */
$kbg_wizard = new Merlin(

	// Configure Merlin with custom settings.
	$config = array(
		'directory'            => 'inc/merlin', // Location / directory where Merlin WP is placed in your theme.
		'merlin_url'           => 'kbg-importer', // The wp-admin page slug where Merlin WP loads.
		'parent_slug'          => 'themes.php', // The wp-admin parent page slug for the admin menu item.
		'capability'           => 'manage_options', // The capability required for this menu to be displayed to the user.
		'child_action_btn_url' => 'https://codex.wordpress.org/child_themes', // URL for the 'child-action-link'.
		'dev_mode'             => false, // Enable development mode for testing.
		'license_step'         => false, // EDD license activation step.
		'license_required'     => false, // Require the license activation step.
		'license_help_url'     => '', // URL for the 'license-tooltip'.
		'edd_remote_api_url'   => '', // EDD_Theme_Updater_Admin remote_api_url.
		'edd_item_name'        => '', // EDD_Theme_Updater_Admin item_name.
		'edd_theme_slug'       => '', // EDD_Theme_Updater_Admin item_slug.
		'ready_big_button_url' => get_home_url(), // Link for the big button on the ready step.
	),

	// Text strings.
	$strings

);


/**
 * Prepare files to import
 *
 * @since 1.0
 */
add_filter( 'merlin_import_files', 'kbg_demo_import_files' );

if ( !function_exists( 'kbg_demo_import_files' ) ):
	function kbg_demo_import_files() {
		return array(
			array(
				'import_file_name'         => 'Knowledge Guru Default',
				'local_import_file'          => trailingslashit( get_template_directory() ) . 'inc/demo/default/content.xml',
				'local_import_widget_file'   => trailingslashit( get_template_directory() ) . 'inc/demo/default/widgets.wie',
				'local_import_customizer_file'   => trailingslashit( get_template_directory() ) . 'inc/demo/default/options.dat',
				'import_preview_image_url' => get_parent_theme_file_uri( '/screenshot.png' ),
				'import_notice'            => '',
				'preview_url'              => 'https://demo.mekshq.com/knowledge-guru/',
			)
		);
	}
endif;

/**
 * Execute custom code after the whole import has finished.
 *
 * @since 1.0
 */
add_action( 'merlin_after_all_import', 'kbg_merlin_after_import_setup' );
if ( !function_exists( 'kbg_merlin_after_import_setup' ) ):

	function kbg_merlin_after_import_setup( ) {

		/* Set Menus */
		$menus = array();

		$main_menu = get_term_by( 'name', 'Main', 'nav_menu' );
		if ( isset( $main_menu->term_id ) ) {
			$menus['kbg_menu_primary'] = $main_menu->term_id;
		}

		$social_menu = get_term_by( 'name', 'Social', 'nav_menu' );
		if ( isset( $social_menu->term_id ) ) {
			$menus['kbg_menu_social'] = $social_menu->term_id;
		}

		$copyright_menu = get_term_by( 'name', 'Footer', 'nav_menu' );
		if ( isset( $copyright_menu->term_id ) ) {
			$menus['kbg_menu_copyright'] = $copyright_menu->term_id;
		}

		$quick_links = get_term_by( 'name', 'Quick links', 'nav_menu' );
		if ( isset( $quick_links->term_id ) ) {
			$menus['kbg_pre_search_menu'] = $quick_links->term_id;
		}

		if ( !empty( $menus ) ) {
			set_theme_mod( 'nav_menu_locations', $menus );
		}

		/* Update home URL in menu item */
		$home = get_page_by_title( 'Home', false, 'nav_menu_item' );
		update_post_meta( $home->ID, '_menu_item_url', get_home_url() );
		

		/* Import contact form */
		kbg_import_contact_form();
		
	}

endif;

/**
 * Insert WPForms contact form
 *
 * @return void
 * @since 1.3.4
 */

if ( !function_exists( 'kbg_import_contact_form' ) ):
	function kbg_import_contact_form( ) {
		
		if ( !function_exists( 'WP_Filesystem' ) || !WP_Filesystem() ) {
			return false;
		}

		global $wp_filesystem;
		$forms = json_decode( $wp_filesystem->get_contents(  get_parent_theme_file_path( '/inc/demo/default/wpforms.json' ) ), true );

		if ( ! empty( $forms ) ) {

			foreach ( $forms as $form ) {

				$title  = ! empty( $form['settings']['form_title'] ) ? $form['settings']['form_title'] : '';
				$desc   = ! empty( $form['settings']['form_desc'] ) ? $form['settings']['form_desc'] : '';
				$new_id = wp_insert_post( array(
					'post_title'   => $title,
					'post_status'  => 'publish',
					'post_type'    => 'wpforms',
					'post_excerpt' => $desc,
				) );
				if ( $new_id ) {
					$form['id'] = $new_id;
					wp_update_post(
						array(
							'ID'           => $new_id,
							'post_content' =>  wp_slash( wp_json_encode( $form ) ),
						)
					);
				}
			}
		}

	}
endif;


/**
 * Unset the default widgets
 *
 * @return array
 * @since 1.0
 */

add_action( 'merlin_widget_importer_before_widgets_import', 'kbg_remove_widgets_before_import' );

if ( !function_exists( 'kbg_remove_widgets_before_import' ) ):
	function kbg_remove_widgets_before_import() {
		delete_option( 'sidebars_widgets' );
	}
endif;

/**
 * Unset the child theme generator step in merlin welcome panel
 *
 * @param unknown $steps
 * @return mixed
 * @since 1.0
 */

add_filter( 'knowledge-guru_merlin_steps', 'kbg_remove_child_theme_generator_from_merlin' );

if ( !function_exists( 'kbg_remove_child_theme_generator_from_merlin' ) ):
	function kbg_remove_child_theme_generator_from_merlin( $steps ) {
		unset( $steps['child'] );
		return $steps;
	}
endif;


/**
 * Stop initial redirect after theme is activated
 *
 * @since 1.0
 */

remove_action( 'after_switch_theme', array( $kbg_wizard, 'switch_theme' ) );
