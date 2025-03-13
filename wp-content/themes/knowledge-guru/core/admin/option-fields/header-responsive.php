<?php

Kirki::add_section(
	'kbg_header_mobile',
	array(
		'title' => esc_attr__( 'Mobile Header', 'knowledge-guru' ),
		'panel' => 'kbg_panel_header',
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'header_responsive_search',
		'section'  => 'kbg_header_mobile',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Enable search button', 'knowledge-guru' ),
		'description' => esc_html__( 'Search button will open search form on click/touch event on mobile/responsive header.', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'header_responsive_search' ),
	)
);
