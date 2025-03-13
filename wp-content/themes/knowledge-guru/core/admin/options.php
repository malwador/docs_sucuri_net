<?php

//delete_option('kbg_settings');

/**
 * Load Kirki Framework
 */

if ( ! class_exists( 'Kirki' ) ) {
	return;
}

add_filter( 'kirki_config', 'kbg_modify_kirki_config' );

function kbg_modify_kirki_config( $config ) {
	return wp_parse_args( array(
			'disable_loader' => true
		), $config );
}

/**
 * Theme Options initialization
 */
add_action( 'init', 'kbg_options_init', 100 );

function kbg_options_init() {

	/**
	 * Kirki params
	 */

	Kirki::add_config( 'kbg', array(
			'capability'    => 'edit_theme_options',
			'option_type'   => 'option',
			'option_name'   => 'kbg_settings',
		) );

	/* Root */

	Kirki::add_panel( 'kbg_panel', array(
			'priority'    => 10,
			'title'       => esc_html__( 'Theme Options', 'knowledge-guru' )
		) );


	/* Blog */
	require_once get_parent_theme_file_path( '/core/admin/option-fields/blog.php' );

	/* KnowledgeBase */
	require_once get_parent_theme_file_path( '/core/admin/option-fields/knowledge-base.php' );

	/* Search archive */
	require_once get_parent_theme_file_path( '/core/admin/option-fields/search-archive.php' );

	/* Header */
	require_once get_parent_theme_file_path( '/core/admin/option-fields/header.php' );

	/* Content */
	require_once get_parent_theme_file_path( '/core/admin/option-fields/content.php' );

	/* Layouts image ratio */
	require_once get_parent_theme_file_path( '/core/admin/option-fields/layouts-image-ratio.php' );

	/* Footer */
	require_once get_parent_theme_file_path( '/core/admin/option-fields/footer.php' );

	/* Sidebar */
	require_once get_parent_theme_file_path( '/core/admin/option-fields/sidebar.php' );

	/* Page */
	require_once get_parent_theme_file_path( '/core/admin/option-fields/page.php' );

	/* Typography */
	require_once get_parent_theme_file_path( '/core/admin/option-fields/typography.php' );

	/* Ads */
	require_once get_parent_theme_file_path( '/core/admin/option-fields/ads.php' );

	/* Miscellaneous */
	require_once get_parent_theme_file_path( '/core/admin/option-fields/miscellaneous.php' );

	/* Performance */
	require_once get_parent_theme_file_path( '/core/admin/option-fields/performance.php' );

	/* Translate */
	require_once get_parent_theme_file_path( '/core/admin/option-fields/translate.php' );

}