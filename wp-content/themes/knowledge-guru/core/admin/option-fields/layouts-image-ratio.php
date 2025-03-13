<?php

Kirki::add_panel(
    'kbg_panel_layouts_images',
    array(
        'panel'    => 'kbg_panel',
        'title'    => esc_attr__( 'Images ratio', 'knowledge-guru' ),
        'priority' => 20,
    )
);



/* Blog Layout Section */

Kirki::add_section(
	'kbg_layouts_blog_image_ratio',
	array(
        'panel'       => 'kbg_panel_layouts_images',
        'title'       => esc_attr__( 'Blog', 'knowledge-guru' ),
	)
);

/* Layout A */
Kirki::add_field(
	'kbg',
	array(
		'settings' => 'layout_a_img_ratio',
		'section'  => 'kbg_layouts_blog_image_ratio',
		'type'     => 'select',
		'label'    => esc_html__( 'Image ratio for layout A', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'layout_a_img_ratio' ),
		'choices'  => kbg_get_image_ratio_opts(),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings'    => 'layout_a_img_custom',
		'section'     => 'kbg_layouts_blog_image_ratio',
		'type'        => 'text',
		'label'       => esc_html__( 'Your custom ratio for layout A', 'knowledge-guru' ),
		'description' => esc_html__( 'i.e. Put 2:1', 'knowledge-guru' ),
		'default'     => kbg_get_default_option( 'layout_a_img_custom' ),
		'required'    => array(
			array(
				'setting'  => 'layout_a_img_ratio',
				'operator' => '==',
				'value'    => 'custom',
			),

		),
	)
);

/* Layout B */
Kirki::add_field(
	'kbg',
	array(
		'settings' => 'layout_b_img_ratio',
		'section'  => 'kbg_layouts_blog_image_ratio',
		'type'     => 'select',
		'label'    => esc_html__( 'Image ratio for layout B', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'layout_b_img_ratio' ),
		'choices'  => kbg_get_image_ratio_opts(),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings'    => 'layout_b_img_custom',
		'section'     => 'kbg_layouts_blog_image_ratio',
		'type'        => 'text',
		'label'       => esc_html__( 'Your custom ratio for layout B', 'knowledge-guru' ),
		'description' => esc_html__( 'i.e. Put 2:1', 'knowledge-guru' ),
		'default'     => kbg_get_default_option( 'layout_b_img_custom' ),
		'required'    => array(
			array(
				'setting'  => 'layout_b_img_ratio',
				'operator' => '==',
				'value'    => 'custom',
			),

		),
	)
);


/* Knowledge Base Category Layouts */

Kirki::add_section(
	'kbg_layouts_kb_image_ratio',
	array(
        'panel'       => 'kbg_panel_layouts_images',
        'title'       => esc_attr__( 'KnowledgeBase Category Block', 'knowledge-guru' ),
	)
);

/* Layout A */
Kirki::add_field(
	'kbg',
	array(
		'settings' => 'layout_tax_a_img_ratio',
		'section'  => 'kbg_layouts_kb_image_ratio',
		'type'     => 'select',
		'label'    => esc_html__( 'Category image ratio for layout A', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'layout_tax_a_img_ratio' ),
		'choices'  => kbg_get_image_ratio_opts(),
	)
);
Kirki::add_field(
	'kbg',
	array(
		'settings'    => 'layout_tax_a_img_custom',
		'section'     => 'kbg_layouts_kb_image_ratio',
		'type'        => 'text',
		'label'       => esc_html__( 'Your custom ratio for layout A', 'knowledge-guru' ),
		'description' => esc_html__( 'i.e. Put 2:1', 'knowledge-guru' ),
		'default'     => kbg_get_default_option( 'layout_tax_a_img_custom' ),
		'required'    => array(
			array(
				'setting'  => 'layout_tax_a_img_ratio',
				'operator' => '==',
				'value'    => 'custom',
			),

		),
	)
);

/* Layout B */
Kirki::add_field(
	'kbg',
	array(
		'settings' => 'layout_tax_b_img_ratio',
		'section'  => 'kbg_layouts_kb_image_ratio',
		'type'     => 'select',
		'label'    => esc_html__( 'Category image ratio for layout B', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'layout_tax_b_img_ratio' ),
		'choices'  => kbg_get_image_ratio_opts(),
	)
);
Kirki::add_field(
	'kbg',
	array(
		'settings'    => 'layout_tax_b_img_custom',
		'section'     => 'kbg_layouts_kb_image_ratio',
		'type'        => 'text',
		'label'       => esc_html__( 'Your custom ratio for layout B', 'knowledge-guru' ),
		'description' => esc_html__( 'i.e. Put 2:1', 'knowledge-guru' ),
		'default'     => kbg_get_default_option( 'layout_tax_b_img_custom' ),
		'required'    => array(
			array(
				'setting'  => 'layout_tax_b_img_ratio',
				'operator' => '==',
				'value'    => 'custom',
			),

		),
	)
);

/* Layout C */
Kirki::add_field(
	'kbg',
	array(
		'settings' => 'layout_tax_c_img_ratio',
		'section'  => 'kbg_layouts_kb_image_ratio',
		'type'     => 'select',
		'label'    => esc_html__( 'Category image ratio for layout C', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'layout_tax_c_img_ratio' ),
		'choices'  => kbg_get_image_ratio_opts(),
	)
);
Kirki::add_field(
	'kbg',
	array(
		'settings'    => 'layout_tax_c_img_custom',
		'section'     => 'kbg_layouts_kb_image_ratio',
		'type'        => 'text',
		'label'       => esc_html__( 'Your custom ratio for layout C', 'knowledge-guru' ),
		'description' => esc_html__( 'i.e. Put 2:1', 'knowledge-guru' ),
		'default'     => kbg_get_default_option( 'layout_tax_c_img_custom' ),
		'required'    => array(
			array(
				'setting'  => 'layout_tax_c_img_ratio',
				'operator' => '==',
				'value'    => 'custom',
			),

		),
	)
);

/* Layout D */
Kirki::add_field(
	'kbg',
	array(
		'settings' => 'layout_tax_d_img_ratio',
		'section'  => 'kbg_layouts_kb_image_ratio',
		'type'     => 'select',
		'label'    => esc_html__( 'Category image ratio for layout D', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'layout_tax_d_img_ratio' ),
		'choices'  => kbg_get_image_ratio_opts(),
	)
);
Kirki::add_field(
	'kbg',
	array(
		'settings'    => 'layout_tax_d_img_custom',
		'section'     => 'kbg_layouts_kb_image_ratio',
		'type'        => 'text',
		'label'       => esc_html__( 'Your custom ratio for layout D', 'knowledge-guru' ),
		'description' => esc_html__( 'i.e. Put 2:1', 'knowledge-guru' ),
		'default'     => kbg_get_default_option( 'layout_tax_d_img_custom' ),
		'required'    => array(
			array(
				'setting'  => 'layout_tax_d_img_ratio',
				'operator' => '==',
				'value'    => 'custom',
			),

		),
	)
);

/* Layout E */
Kirki::add_field(
	'kbg',
	array(
		'settings' => 'layout_tax_e_img_ratio',
		'section'  => 'kbg_layouts_kb_image_ratio',
		'type'     => 'select',
		'label'    => esc_html__( 'Category image ratio for layout E', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'layout_tax_e_img_ratio' ),
		'choices'  => kbg_get_image_ratio_opts(),
	)
);
Kirki::add_field(
	'kbg',
	array(
		'settings'    => 'layout_tax_e_img_custom',
		'section'     => 'kbg_layouts_kb_image_ratio',
		'type'        => 'text',
		'label'       => esc_html__( 'Your custom ratio for layout E', 'knowledge-guru' ),
		'description' => esc_html__( 'i.e. Put 2:1', 'knowledge-guru' ),
		'default'     => kbg_get_default_option( 'layout_tax_e_img_custom' ),
		'required'    => array(
			array(
				'setting'  => 'layout_tax_e_img_ratio',
				'operator' => '==',
				'value'    => 'custom',
			),

		),
	)
);
