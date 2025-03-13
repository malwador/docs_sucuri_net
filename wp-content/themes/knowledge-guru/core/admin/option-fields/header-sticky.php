<?php

Kirki::add_section(
	'kbg_header_sticky',
	array(
		'title' => esc_attr__( 'Sticky Header', 'knowledge-guru' ),
		'panel' => 'kbg_panel_header',
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'header_sticky',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Enable sticky header', 'knowledge-guru' ),
		'section'  => 'kbg_header_sticky',
		'default'  => kbg_get_default_option( 'header_sticky' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'header_sticky_layout',
		'section'  => 'kbg_header_sticky',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Layout', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'header_sticky_layout' ),
		'choices'  => kbg_get_header_layouts(),
		'required' => array(
			array(
				'setting'  => 'header_sticky',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings'    => 'header_sticky_offset',
		'type'        => 'number',
		'label'       => esc_html__( 'Sticky header offset', 'knowledge-guru' ),
		'description' => esc_html__( 'Specify after how many px of scrolling the sticky header appears', 'knowledge-guru' ),
		'section'     => 'kbg_header_sticky',
		'default'     => kbg_get_default_option( 'header_sticky_offset' ),
		'choices'     => array(
			'min'  => '50',
			'max'  => '1000',
			'step' => '50',
		),
		'required'    => array(
			array(
				'setting'  => 'header_sticky',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings'    => 'header_sticky_up',
		'type'        => 'toggle',
		'label'       => esc_html__( 'Smart sticky', 'knowledge-guru' ),
		'description' => esc_html__( 'Sticky header appears only if you scroll up', 'knowledge-guru' ),
		'section'     => 'kbg_header_sticky',
		'default'     => kbg_get_default_option( 'header_sticky_up' ),
		'required'    => array(
			array(
				'setting'  => 'header_sticky',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings'  => 'header_sticky_height',
		'type'      => 'slider',
		'label'     => esc_html__( 'Sticky header height', 'knowledge-guru' ),
		'section'   => 'kbg_header_sticky',
		'default'   => kbg_get_default_option( 'header_sticky_height' ),
		'choices'   => array(
			'min'  => '40',
			'max'  => '200',
			'step' => '1',
		),
		'transport' => 'postMessage',
		'required'  => array(
			array(
				'setting'  => 'header_sticky',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'header_sticky_type',
		'section'  => 'kbg_header_sticky',
		'type'     => 'radio',
		'label'    => esc_html__( 'Sticky logo and elements', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'header_sticky_type' ),
		'choices'  => array(
			'inherit'    => esc_html__( 'Inherit from main header', 'knowledge-guru' ),
			'custom' => esc_html__( 'Customize', 'knowledge-guru' ),
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'header_sticky',
					'operator' => '==',
					'value'    => true,
				),
			)
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'header_sticky_nav',
		'section'  => 'kbg_header_sticky',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Enable main navigation', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'header_sticky_nav' ),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'header_sticky_type',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
			array(
				array(
					'setting'  => 'header_sticky',
					'operator' => '==',
					'value'    => true,
				),
			)
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'header_sticky_actions',
		'section'  => 'kbg_header_sticky',
		'type'     => 'sortable',
		'label'    => esc_html__( 'Enable special elements', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'header_sticky_actions' ),
		'choices'  => kbg_get_header_main_area_actions(),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'header_sticky_type',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
			array(
				array(
					'setting'  => 'header_sticky',
					'operator' => '==',
					'value'    => true,
				),
			)
		)
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings'    => 'header_sticky_logo',
		'section'     => 'kbg_header_sticky',
		'type'        => 'image',
		'label'       => esc_html__( 'Sticky logo', 'knowledge-guru' ),
		'default'     => kbg_get_default_option( 'header_sticky_logo' ),
		'choices'     => array(
			'save_as' => 'array',
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'header_sticky_type',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
			array(
				array(
					'setting'  => 'header_sticky',
					'operator' => '==',
					'value'    => true,
				),
			)
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings'    => 'header_sticky_logo_retina',
		'section'     => 'kbg_header_sticky',
		'type'        => 'image',
		'label'       => esc_html__( 'Sticky Retina logo (2x)', 'knowledge-guru' ),
		'default'     => kbg_get_default_option( 'header_sticky_logo_retina' ),
		'choices'     => array(
			'save_as' => 'array',
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'header_sticky_type',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
			array(
				array(
					'setting'  => 'header_sticky',
					'operator' => '==',
					'value'    => true,
				),
			)
		),
	)
);
