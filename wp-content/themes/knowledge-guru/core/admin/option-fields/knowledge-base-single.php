<?php

/* Single blog */
Kirki::add_section(
	'knowledge_base_single_article',
	array(
		'panel' => 'kbg_panel_knowledge_base',
		'title' => esc_attr__( 'Single article', 'knowledge-guru' ),
		'priority' => 40,
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'single_kb_subheader',
		'section'  => 'knowledge_base_single_article',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Enable subheader options', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'single_kb_subheader' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'single_kb_subheader_left',
		'section'  => 'knowledge_base_single_article',
		'type'     => 'radio',
		'label'    => esc_html__( 'Subheader left slot', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'single_kb_subheader_left' ),
		'choices'  => array(
			'breadcrumbs' => esc_html__( 'Breadcrumbs', 'knowledge-guru' ),
			'search-form' => esc_html__( 'Search form', 'knowledge-guru' ),
			'none' => esc_html__( 'None', 'knowledge-guru' ),
			
		),
		'required' => array(
			array(
				'setting'  => 'single_kb_subheader',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'single_kb_subheader_right',
		'section'  => 'knowledge_base_single_article',
		'type'     => 'radio',
		'label'    => esc_html__( 'Subheader right slot', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'single_kb_subheader_right' ),
		'choices'  => array(
			'breadcrumbs' => esc_html__( 'Breadcrumbs', 'knowledge-guru' ),
			'search-form' => esc_html__( 'Search form', 'knowledge-guru' ),
			'none' => esc_html__( 'None', 'knowledge-guru' ),
			
		),
		'required' => array(
			array(
				'setting'  => 'single_kb_subheader',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'single_kb_subheader_breadcrumbs_type',
		'section'  => 'knowledge_base_single_article',
		'type'     => 'radio',
		'label'    => esc_html__( 'Subheader breadcrumbs type', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'single_kb_subheader_breadcrumbs_type' ),
		'choices'  => array(
			'yoast' => esc_html__( 'Yoast Breadcrumb', 'knowledge-guru' ),
			'navxt' => esc_html__( 'Breadcrumb NavXT', 'knowledge-guru' ),
		),
		'required' => array(
			array(
				'setting'  => 'single_kb_subheader',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'single_kb_sidebar_position',
		'section'  => 'knowledge_base_single_article',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Sidebar position', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'single_kb_sidebar_position' ),
		'choices'  => kbg_get_sidebar_layouts( false, true ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'single_kb_sidebar_standard',
		'section'  => 'knowledge_base_single_article',
		'type'     => 'select',
		'label'    => esc_html__( 'Standard sidebar', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'single_kb_sidebar_standard' ),
		'choices'  => kbg_get_sidebars_list(),
		'required' => array(
			array(
				'setting'  => 'single_kb_sidebar_position',
				'operator' => '!=',
				'value'    => 'none',
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'single_kb_sidebar_sticky',
		'section'  => 'knowledge_base_single_article',
		'type'     => 'select',
		'label'    => esc_html__( 'Sticky sidebar', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'single_kb_sidebar_sticky' ),
		'choices'  => kbg_get_sidebars_list(),
		'required' => array(
			array(
				'setting'  => 'single_kb_sidebar_position',
				'operator' => '!=',
				'value'    => 'none',
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'single_kb_meta',
		'section'  => 'knowledge_base_single_article',
		'type'     => 'sortable',
		'label'    => esc_html__( 'Choose meta', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'single_kb_meta' ),
		'choices'  => kbg_get_meta_opts( false, array( 'episode', 'comments' ) ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'single_kb_fimg',
		'section'  => 'knowledge_base_single_article',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Display featured image', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'single_kb_fimg' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'single_kb_fimg_cap',
		'section'  => 'knowledge_base_single_article',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Display featured image caption', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'single_kb_fimg_cap' ),
		'required' => array(
			array(
				'setting'  => 'single_kb_fimg',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'single_kb_layout_1_img_ratio',
		'section'  => 'knowledge_base_single_article',
		'type'     => 'select',
		'label'    => esc_html__( 'Featured image ratio', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'single_kb_layout_1_img_ratio' ),
		'choices'  => kbg_get_image_ratio_opts(),
		'required' => array(
			array(
				'setting'  => 'single_kb_layout',
				'operator' => '==',
				'value'    => '1',
			),
			array(
				'setting'  => 'single_kb_fimg',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings'    => 'single_kb_layout_1_img_custom',
		'section'     => 'knowledge_base_single_article',
		'type'        => 'text',
		'label'       => esc_html__( 'Your custom ratio', 'knowledge-guru' ),
		'description' => esc_html__( 'i.e. Put 2:1', 'knowledge-guru' ),
		'default'     => kbg_get_default_option( 'single_kb_layout_1_img_custom' ),
		'required'    => array(
			array(
				'setting'  => 'single_kb_layout_1_img_ratio',
				'operator' => '==',
				'value'    => 'custom',
			),
			array(
				'setting'  => 'single_kb_layout',
				'operator' => '==',
				'value'    => '1',
			),
			array(
				'setting'  => 'single_kb_fimg',
				'operator' => '==',
				'value'    => true,
			),

		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'single_kb_headline',
		'section'  => 'knowledge_base_single_article',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Display headline (post excerpt)', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'single_kb_headline' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'single_kb_tags',
		'section'  => 'knowledge_base_single_article',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Display tags', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'single_kb_tags' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'single_kb_author',
		'section'  => 'knowledge_base_single_article',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Display author area', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'single_kb_author' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'single_kb_related',
		'section'  => 'knowledge_base_single_article',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Display "related posts" area', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'single_kb_related' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'single_kb_related_limit',
		'section'  => 'knowledge_base_single_article',
		'type'     => 'number',
		'label'    => esc_html__( 'Number of related post', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'single_kb_related_limit' ),
		'required' => array(
			array(
				'setting'  => 'single_kb_related',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'single_kb_related_type',
		'section'  => 'knowledge_base_single_article',
		'type'     => 'radio',
		'label'    => esc_html__( 'Related area chooses from posts', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'single_kb_related_type' ),
		'choices'  => array(
			'cat'         => esc_html__( 'Located in the same category', 'knowledge-guru' ),
			'tag'         => esc_html__( 'Tagged with at least one same tag', 'knowledge-guru' ),
			'cat_or_tag'  => esc_html__( 'Located in the same category OR tagged with a same tag', 'knowledge-guru' ),
			'cat_and_tag' => esc_html__( 'Located in the same category AND tagged with a same tag', 'knowledge-guru' ),
			'author'      => esc_html__( 'By the same author', 'knowledge-guru' ),
			'0'           => esc_html__( 'All posts', 'knowledge-guru' ),
		),
		'required' => array(
			array(
				'setting'  => 'single_kb_related',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'single_kb_related_order',
		'section'  => 'knowledge_base_single_article',
		'type'     => 'radio',
		'label'    => esc_html__( 'Related posts are ordered by', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'single_kb_related_order' ),
		'choices'  => kbg_get_post_order_opts(),
		'required' => array(
			array(
				'setting'  => 'single_kb_related',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);
