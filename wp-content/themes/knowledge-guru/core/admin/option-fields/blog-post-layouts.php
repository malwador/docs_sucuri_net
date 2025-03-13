<?php

Kirki::add_panel(
	'kbg_panel_post_layouts',
	array(
		'panel'    => 'kbg_panel_blog',
		'title'    => esc_attr__( 'Post Listing Layouts', 'knowledge-guru' ),
		'priority' => 10,
	)
);


/* Layout A */

Kirki::add_section(
	'kbg_layout_a',
	array(
		'panel'       => 'kbg_panel_post_layouts',
		'title'       => esc_attr__( 'Layout A', 'knowledge-guru' ),
		'description' => kbg_wp_kses( '<img src="' . get_parent_theme_file_uri( '/assets/img/admin/post_layout_a.svg' ) . '"/>' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'layout_a_meta',
		'section'  => 'kbg_layout_a',
		'type'     => 'sortable',
		'label'    => esc_html__( 'Choose meta', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'layout_a_meta' ),
		'choices'  => kbg_get_meta_opts( false ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'layout_a_excerpt',
		'section'  => 'kbg_layout_a',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Display post text excerpt', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'layout_a_excerpt' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'layout_a_excerpt_type',
		'section'  => 'kbg_layout_a',
		'type'     => 'radio',
		'label'    => esc_html__( 'Excerpt type', 'knowledge-guru' ),
		'choices'  => array(
			'auto'   => esc_html__( 'Automatic excerpt (with characters limit)', 'knowledge-guru' ),
			'manual' => esc_html__( 'Full content (manually split with read-more tag)', 'knowledge-guru' ),
		),
		'default'  => kbg_get_default_option( 'layout_a_excerpt_type' ),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'layout_a_excerpt',
					'operator' => '==',
					'value'    => true,
				)
			)
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'layout_a_excerpt_limit',
		'section'  => 'kbg_layout_a',
		'type'     => 'number',
		'label'    => esc_html__( 'Excerpt characters limit', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'layout_a_excerpt_limit' ),
		'choices'  => array(
			'step' => '1',
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'layout_a_excerpt',
					'operator' => '==',
					'value'    => true,
				)
			),
			array(
					array(
					'setting'  => 'layout_a_excerpt_type',
					'operator' => '==',
					'value'    => 'auto',
				)
			),
		)
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'layout_a_rm',
		'section'  => 'kbg_layout_a',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Display "read more" button', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'layout_a_rm' ),
	)
);






/* Layout B */

Kirki::add_section(
	'kbg_layout_b',
	array(
		'panel'       => 'kbg_panel_post_layouts',
		'title'       => esc_attr__( 'Layout B', 'knowledge-guru' ),
		'description' => kbg_wp_kses( '<img src="' . get_parent_theme_file_uri( '/assets/img/admin/post_layout_b.svg' ) . '"/>' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'layout_b_meta',
		'section'  => 'kbg_layout_b',
		'type'     => 'sortable',
		'label'    => esc_html__( 'Choose meta', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'layout_b_meta' ),
		'choices'  => kbg_get_meta_opts( false ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'layout_b_excerpt',
		'section'  => 'kbg_layout_b',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Display post text excerpt', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'layout_b_excerpt' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'layout_b_excerpt_type',
		'section'  => 'kbg_layout_b',
		'type'     => 'radio',
		'label'    => esc_html__( 'Excerpt type', 'knowledge-guru' ),
		'choices'  => array(
			'auto'   => esc_html__( 'Automatic excerpt (with characters limit)', 'knowledge-guru' ),
			'manual' => esc_html__( 'Full content (manually split with read-more tag)', 'knowledge-guru' ),
		),
		'default'  => kbg_get_default_option( 'layout_b_excerpt_type' ),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'layout_b_excerpt',
					'operator' => '==',
					'value'    => true,
				)
			)
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'layout_b_excerpt_limit',
		'section'  => 'kbg_layout_b',
		'type'     => 'number',
		'label'    => esc_html__( 'Excerpt characters limit', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'layout_b_excerpt_limit' ),
		'choices'  => array(
			'step' => '1',
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'layout_b_excerpt',
					'operator' => '==',
					'value'    => true,
				)
			),
			array(
					array(
					'setting'  => 'layout_b_excerpt_type',
					'operator' => '==',
					'value'    => 'auto',
				)
			),
		)
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'layout_b_rm',
		'section'  => 'kbg_layout_b',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Display "read more" button', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'layout_b_rm' ),
	)
);

