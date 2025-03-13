<?php

Kirki::add_section(
	'kbg_archives_category',
	array(
		'panel' => 'kbg_panel_blog',
		'title' => esc_attr__( 'Category Template', 'knowledge-guru' ),
		'priority' => 30,
	)
);


Kirki::add_field(
	'kbg',
	array(
		'settings' => 'category_settings',
		'section'  => 'kbg_archives_category',
		'type'     => 'radio',
		'label'    => esc_html__( 'Category settings', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'category_settings' ),
		'choices'  => array(
			'inherit' => esc_html__( 'Inherit from general Archive settings', 'knowledge-guru' ),
			'custom'  => esc_html__( 'Customize', 'knowledge-guru' ),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'category_description',
		'section'  => 'kbg_archives_category',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Display category description', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'category_description' ),
		'required' => array(
			array(
				'setting'  => 'category_settings',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'category_meta',
		'section'  => 'kbg_archives_category',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Display number of posts label', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'category_meta' ),
		'required' => array(
			array(
				'setting'  => 'category_settings',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'category_loop',
		'section'  => 'kbg_archives_category',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Posts layout', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'category_loop' ),
		'choices'  => kbg_get_post_layouts_map(),
		'required' => array(
			array(
				'setting'  => 'category_settings',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'category_sidebar_display',
		'section'  => 'kbg_archives_category',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Enable sidebar for this layout', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'category_sidebar_display' ),
		'required' => array(
			array(
				'setting'  => 'category_settings',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'category_sidebar_position',
		'section'  => 'kbg_archives_category',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Sidebar position', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'category_sidebar_position' ),
		'choices'  => kbg_get_sidebar_layouts(),
		'required' => array(
			array(
				'setting'  => 'category_sidebar_display',
				'operator' => '==',
				'value'    => true
			),
			array(
				'setting'  => 'category_settings',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'category_sidebar_standard',
		'section'  => 'kbg_archives_category',
		'type'     => 'select',
		'label'    => esc_html__( 'Standard sidebar', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'category_sidebar_standard' ),
		'choices'  => kbg_get_sidebars_list(),
		'required' => array(
			array(
				'setting'  => 'category_sidebar_display',
				'operator' => '==',
				'value'    => true
			),
			array(
				'setting'  => 'category_settings',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'category_sidebar_sticky',
		'section'  => 'kbg_archives_category',
		'type'     => 'select',
		'label'    => esc_html__( 'Sticky sidebar', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'category_sidebar_sticky' ),
		'choices'  => kbg_get_sidebars_list(),
		'required' => array(
			array(
				'setting'  => 'category_sidebar_display',
				'operator' => '==',
				'value'    => true
			),
			array(
				'setting'  => 'category_settings',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'category_ppp',
		'section'  => 'kbg_archives_category',
		'type'     => 'radio',
		'label'    => esc_html__( 'Number of posts per page', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'category_ppp' ),
		'choices'  => array(
			'inherit' => esc_html__( 'Inherit from global option set in Settings / Reading', 'knowledge-guru' ),
			'custom'  => esc_html__( 'Custom number', 'knowledge-guru' ),
		),
		'required' => array(
			array(
				'setting'  => 'category_settings',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'category_ppp_num',
		'section'  => 'kbg_archives_category',
		'type'     => 'number',
		'label'    => esc_html__( 'Specify number of posts', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'category_ppp_num' ),
		'required' => array(
			array(
				'setting'  => 'category_ppp',
				'operator' => '==',
				'value'    => 'custom',
			),
			array(
				'setting'  => 'category_settings',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'category_pagination',
		'section'  => 'kbg_archives_category',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Pagination', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'category_pagination' ),
		'choices'  => kbg_get_pagination_layouts(),
		'required' => array(
			array(
				'setting'  => 'category_settings',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);