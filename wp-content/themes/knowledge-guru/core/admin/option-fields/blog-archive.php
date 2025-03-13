<?php

Kirki::add_section(
	'kbg_archives_general',
	array(
		'panel' => 'kbg_panel_blog',
		'title' => esc_attr__( 'Archives Template', 'knowledge-guru' ),
		'priority' => 20,
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'archive_description',
		'section'  => 'kbg_archives_general',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Display archive description', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'archive_description' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'archive_meta',
		'section'  => 'kbg_archives_general',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Display number of posts label', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'archive_meta' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'archive_loop',
		'section'  => 'kbg_archives_general',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Posts layout', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'archive_loop' ),
		'choices'  => kbg_get_post_layouts(),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'archive_sidebar_display',
		'section'  => 'kbg_archives_general',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Enable sidebar for this layout', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'archive_sidebar_display' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'archive_sidebar_position',
		'section'  => 'kbg_archives_general',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Sidebar position', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'archive_sidebar_position' ),
		'choices'  => kbg_get_sidebar_layouts(),
		'required' => array(
			array(
				'setting'  => 'archive_sidebar_display',
				'operator' => '==',
				'value'    => true
			)
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'archive_sidebar_standard',
		'section'  => 'kbg_archives_general',
		'type'     => 'select',
		'label'    => esc_html__( 'Standard sidebar', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'archive_sidebar_standard' ),
		'choices'  => kbg_get_sidebars_list(),
		'required' => array(
			array(
				'setting'  => 'archive_sidebar_display',
				'operator' => '==',
				'value'    => true
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'archive_sidebar_sticky',
		'section'  => 'kbg_archives_general',
		'type'     => 'select',
		'label'    => esc_html__( 'Sticky sidebar', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'archive_sidebar_sticky' ),
		'choices'  => kbg_get_sidebars_list(),
		'required' => array(
			array(
				'setting'  => 'archive_sidebar_display',
				'operator' => '==',
				'value'    => true
			),
		),
	)
);


Kirki::add_field(
	'kbg',
	array(
		'settings' => 'archive_ppp',
		'section'  => 'kbg_archives_general',
		'type'     => 'radio',
		'label'    => esc_html__( 'Number of posts per page', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'archive_ppp' ),
		'choices'  => array(
			'inherit' => esc_html__( 'Inherit from global option set in Settings / Reading', 'knowledge-guru' ),
			'custom'  => esc_html__( 'Custom number', 'knowledge-guru' ),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'archive_ppp_num',
		'section'  => 'kbg_archives_general',
		'type'     => 'number',
		'label'    => esc_html__( 'Specify number of posts', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'archive_ppp_num' ),
		'required' => array(
			array(
				'setting'  => 'archive_ppp',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'archive_pagination',
		'section'  => 'kbg_archives_general',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Pagination', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'archive_pagination' ),
		'choices'  => kbg_get_pagination_layouts(),
	)
);