<?php

Kirki::add_panel(
	'kbg_panel_header',
	array(
		'priority' => 40,
		'panel'    => 'kbg_panel',
		'title'    => esc_attr__( 'Header', 'knowledge-guru' ),
	)
);

require_once get_parent_theme_file_path( '/core/admin/option-fields/header-general.php' );
require_once get_parent_theme_file_path( '/core/admin/option-fields/header-sticky.php' );
require_once get_parent_theme_file_path( '/core/admin/option-fields/header-responsive.php' );