<?php

/**
 * Include the TGM_Plugin_Activation class.
 */

require_once get_parent_theme_file_path( '/inc/tgm/class-tgm-plugin-activation.php' );

/**
 * Register the required plugins for this theme.
 */

add_action( 'tgmpa_register', 'kbg_register_required_plugins' );

function kbg_register_required_plugins() {

	/**
	 * Array of plugin params
	 */
	$plugins = array(

		array(
			'name'   => 'Kirki',
			'slug'   => 'kirki',
			'required'  => true,
		),

		array(
			'name'   => 'Knowledge Base Blocks',
			'slug'   => 'knowledge-base-blocks',
			'source' => 'https://mekshq.com/static/plugins/knowledge-base-blocks.zip',
			'required'  => true
		),

		array(
			'name'   => 'Knowledge Base Post Type',
			'slug'   => 'knowledge-base-post-type',
			'source' => 'https://mekshq.com/static/plugins/knowledge-base-post-type.zip',
		),

		array(
			'name'   => 'Quick Answers Ajax Search',
			'slug'   => 'quick-answers-ajax-search',
			'source' => 'https://mekshq.com/static/plugins/quick-answers-ajax-search.zip',
		),

		array(
			'name'   => 'Article Feedback',
			'slug'   => 'article-feedback',
			'source' => 'https://mekshq.com/static/plugins/article-feedback.zip',
		),

		array(
			'name'   => 'Meks Flexible Shortcodes',
			'slug'   => 'meks-flexible-shortcodes',
		),

		array(
			'name'   => 'Meks Easy Ads Widget',
			'slug'   => 'meks-easy-ads-widget',
		),

		array(
			'name'   => 'Meks Smart Social Widget',
			'slug'   => 'meks-smart-social-widget',
		),

		array(
			'name'   => 'Meks Smart Author Widget',
			'slug'   => 'meks-smart-author-widget',
		),

		array(
			'name'   => 'Meks Time Ago',
			'slug'   => 'meks-time-ago',
		),

		array(
			'name'   => 'Meks Easy Instagram Widget',
			'slug'   => 'meks-easy-instagram-widget',
		),

		array(
			'name'   => 'Meks Easy Social Share',
			'slug'   => 'meks-easy-social-share',
		),

		array(
			'name'   => 'WPForms',
			'slug'   => 'wpforms-lite',
		),

		array(
			'name'   => 'Force Regenerate Thumbnails',
			'slug'   => 'force-regenerate-thumbnails',
		),

		array(
			'name' 		=> 'Envato Market',
			'slug' 		=> 'envato-market',
			'source'    => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
			'external_url' => 'https://envato.com/market-plugin/',
		)


	);


	/**
	 * Array of configuration settings.
	 */
	$config = array(
		'domain'         => 'knowledge-guru',
		'default_path'   => '',
		'menu'           => 'kbg-plugins',
		'has_notices'       => false,
		'is_automatic'     => true,
		'message'    => '',
		'strings'        => array(
			'page_title'                          => esc_html__( 'Install Recommended Plugins', 'knowledge-guru' ),
			'menu_title'                          => esc_html__( 'Knowledge Guru Plugins', 'knowledge-guru' ),
			'installing'                          => esc_html__( 'Installing Plugin: %s', 'knowledge-guru' ), // %1$s = plugin name
			'oops'                                => esc_html__( 'Something went wrong with the plugin API.', 'knowledge-guru' ),
			'notice_can_install_required'        => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'knowledge-guru' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'   => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'knowledge-guru' ), // %1$s = plugin name(s)
			'notice_cannot_install'       => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'knowledge-guru' ), // %1$s = plugin name(s)
			'notice_can_activate_required'       => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'knowledge-guru' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'   => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'knowledge-guru' ), // %1$s = plugin name(s)
			'notice_cannot_activate'      => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'knowledge-guru' ), // %1$s = plugin name(s)
			'notice_ask_to_update'       => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'knowledge-guru' ), // %1$s = plugin name(s)
			'notice_cannot_update'       => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'knowledge-guru' ), // %1$s = plugin name(s)
			'install_link'           => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'knowledge-guru' ),
			'activate_link'          => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'knowledge-guru' ),
			'return'                              => esc_html__( 'Return to Required Plugins Installer', 'knowledge-guru' ),
			'plugin_activated'                    => esc_html__( 'Plugin activated successfully.', 'knowledge-guru' ),
			'complete'          => esc_html__( 'All plugins installed and activated successfully. %s', 'knowledge-guru' ),
			'nag_type'         => 'updated'
		)
	);

	tgmpa( $plugins, $config );

}