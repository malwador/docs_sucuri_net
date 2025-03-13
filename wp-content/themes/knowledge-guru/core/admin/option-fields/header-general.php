<?php

Kirki::add_section(
	'kbg_header_general',
	array(
		'panel' => 'kbg_panel_header',
		'title' => esc_attr__( 'General', 'knowledge-guru' ),
	)
);


Kirki::add_field(
	'kbg',
	array(
		'settings' => 'header_layout',
		'section'  => 'kbg_header_general',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Layout', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'header_layout' ),
		'choices'  => kbg_get_header_layouts(),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings'  => 'header_height',
		'section'   => 'kbg_header_general',
		'type'      => 'slider',
		'label'     => esc_html__( 'Header height', 'knowledge-guru' ),
		'default'   => kbg_get_default_option( 'header_height' ),
		'choices'   => array(
			'min'  => '40',
			'max'  => '300',
			'step' => '1',
		),
		'transport' => 'postMessage',
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'header_orientation',
		'section'  => 'kbg_header_general',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Elements orientation', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'header_orientation' ),
		'choices'  => array(
			'content' => array(
				'alt' => esc_html__( 'Site content', 'knowledge-guru' ),
				'src' => get_parent_theme_file_uri( '/assets/img/admin/header_orientation_content.svg' ),
			),
			'window'  => array(
				'alt' => esc_html__( 'Browser (screen)', 'knowledge-guru' ),
				'src' => get_parent_theme_file_uri( '/assets/img/admin/header_orientation_window.svg' ),
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'header_main_nav',
		'section'  => 'kbg_header_general',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Enable main navigation', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'header_main_nav' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'header_site_desc',
		'section'  => 'kbg_header_general',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Enable site desciprition', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'header_site_desc' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'header_actions',
		'section'  => 'kbg_header_general',
		'type'     => 'sortable',
		'label'    => esc_html__( 'Enable special elements', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'header_actions' ),
		'choices'  => kbg_get_header_main_area_actions(),
		'required' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => 'in',
				'value'    => array( '1', '2', '3' ),
			),
		),

	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings'    => 'logo',
		'section'     => 'kbg_header_general',
		'type'        => 'image',
		'label'       => esc_html__( 'Logo', 'knowledge-guru' ),
		'description' => esc_html__( 'This is your default logo image. If it is not uploaded, the theme will display the website title instead.', 'knowledge-guru' ),
		'default'     => kbg_get_default_option( 'logo' ),
		'choices'     => array(
			'save_as' => 'array',
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings'    => 'logo_retina',
		'section'     => 'kbg_header_general',
		'type'        => 'image',
		'label'       => esc_html__( 'Retina logo (2x)', 'knowledge-guru' ),
		'description' => esc_html__( 'Optionally upload another logo for devices with retina displays. It should be double the size of your standard logo.', 'knowledge-guru' ),
		'default'     => kbg_get_default_option( 'logo_retina' ),
		'choices'     => array(
			'save_as' => 'array',
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings'    => 'logo_mini',
		'section'     => 'kbg_header_general',
		'type'        => 'image',
		'label'       => esc_html__( 'Mobile logo', 'knowledge-guru' ),
		'description' => esc_html__( 'Optionally upload another logo which will be used as mobile/tablet logo.', 'knowledge-guru' ),
		'default'     => kbg_get_default_option( 'logo_mini' ),
		'choices'     => array(
			'save_as' => 'array',
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings'    => 'logo_mini_retina',
		'section'     => 'kbg_header_general',
		'type'        => 'image',
		'label'       => esc_html__( 'Mobile retina logo (2x)', 'knowledge-guru' ),
		'description' => esc_html__( 'Upload double sized mobile logo for devices with retina displays.', 'knowledge-guru' ),
		'default'     => kbg_get_default_option( 'logo_mini_retina' ),
		'choices'     => array(
			'save_as' => 'array',
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings'    => 'logo_custom_url',
		'section'     => 'kbg_header_general',
		'type'        => 'link',
		'label'       => esc_html__( 'Custom logo URL', 'knowledge-guru' ),
		'default'     => kbg_get_default_option( 'logo_custom_url' )
	)
);
