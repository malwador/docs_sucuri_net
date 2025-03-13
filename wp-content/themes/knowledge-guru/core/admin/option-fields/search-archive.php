<?php

Kirki::add_section(
	'knowledge_base_search_archive',
	array(
		'panel' => 'kbg_panel_knowledge_base',
		'title' => esc_attr__( 'Search Template', 'knowledge-guru' ),
		'priority' => 40,
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'search_archive_meta',
		'section'  => 'knowledge_base_search_archive',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Display number of posts label', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'search_archive_meta' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'search_archive_loop',
		'section'  => 'knowledge_base_search_archive',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Archive layout', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'search_archive_loop' ),
		'choices'  => kbg_get_kb_layouts(),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'search_archive_include_types',
		'section'  => 'knowledge_base_search_archive',
		'type'     => 'sortable',
		'label'    => esc_html__( 'Include in search', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'search_archive_include_types' ),
		'choices'  => kbg_get_post_types_opts(),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'search_archive_sidebar_display',
		'section'  => 'knowledge_base_search_archive',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Enable sidebar for this layout', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'search_archive_sidebar_display' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'search_archive_sidebar_position',
		'section'  => 'knowledge_base_search_archive',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Sidebar position', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'search_archive_sidebar_position' ),
		'choices'  => kbg_get_sidebar_layouts(),
		'required' => array(
			array(
				'setting'  => 'search_archive_sidebar_display',
				'operator' => '==',
				'value'    => true
			)
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'search_archive_sidebar_standard',
		'section'  => 'knowledge_base_search_archive',
		'type'     => 'select',
		'label'    => esc_html__( 'Standard sidebar', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'search_archive_sidebar_standard' ),
		'choices'  => kbg_get_sidebars_list(),
		'required' => array(
			array(
				'setting'  => 'search_archive_sidebar_display',
				'operator' => '==',
				'value'    => true
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'search_archive_sidebar_sticky',
		'section'  => 'knowledge_base_search_archive',
		'type'     => 'select',
		'label'    => esc_html__( 'Sticky sidebar', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'search_archive_sidebar_sticky' ),
		'choices'  => kbg_get_sidebars_list(),
		'required' => array(
			array(
				'setting'  => 'search_archive_sidebar_display',
				'operator' => '==',
				'value'    => true
			),
		),
	)
);


Kirki::add_field(
	'kbg',
	array(
		'settings' => 'search_archive_ppp',
		'section'  => 'knowledge_base_search_archive',
		'type'     => 'radio',
		'label'    => esc_html__( 'Number of posts per page', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'search_archive_ppp' ),
		'choices'  => array(
			'inherit' => esc_html__( 'Inherit from global option set in Settings / Reading', 'knowledge-guru' ),
			'custom'  => esc_html__( 'Custom number', 'knowledge-guru' ),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'search_archive_ppp_num',
		'section'  => 'knowledge_base_search_archive',
		'type'     => 'number',
		'label'    => esc_html__( 'Specify number of posts', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'search_archive_ppp_num' ),
		'required' => array(
			array(
				'setting'  => 'search_archive_ppp',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'search_archive_pagination',
		'section'  => 'knowledge_base_search_archive',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Pagination', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'search_archive_pagination' ),
		'choices'  => kbg_get_pagination_layouts(),
	)
);