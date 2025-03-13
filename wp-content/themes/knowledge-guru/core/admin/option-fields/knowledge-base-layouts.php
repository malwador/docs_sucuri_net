<?php

Kirki::add_panel(
	'kbg_panel_knowledge_base_layouts',
	array(
		'panel'    => 'kbg_panel_knowledge_base',
		'title'    => esc_attr__( 'Knowledge Base Listing Layouts', 'knowledge-guru' ),
		'priority' => 10,
	)
);


/* Layout A */

Kirki::add_section(
	'knowledge_base_layout_a',
	array(
		'panel'       => 'kbg_panel_knowledge_base_layouts',
		'title'       => esc_attr__( 'Layout A', 'knowledge-guru' ),
		'description' => kbg_wp_kses( '<img src="' . get_parent_theme_file_uri( '/assets/img/admin/kb_layout_a.svg' ) . '"/>' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'kb_layout_a_meta',
		'section'  => 'knowledge_base_layout_a',
		'type'     => 'sortable',
		'label'    => esc_html__( 'Choose meta', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'kb_layout_a_meta' ),
		'choices'  => kbg_get_meta_opts( false, array( 'comments' ) ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'kb_layout_a_excerpt',
		'section'  => 'knowledge_base_layout_a',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Display post text excerpt', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'kb_layout_a_excerpt' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'kb_layout_a_excerpt_type',
		'section'  => 'knowledge_base_layout_a',
		'type'     => 'radio',
		'label'    => esc_html__( 'Excerpt type', 'knowledge-guru' ),
		'choices'  => array(
			'auto'   => esc_html__( 'Automatic excerpt (with characters limit)', 'knowledge-guru' ),
			'manual' => esc_html__( 'Full content (manually split with read-more tag)', 'knowledge-guru' ),
		),
		'default'  => kbg_get_default_option( 'kb_layout_a_excerpt_type' ),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'kb_layout_a_excerpt',
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
		'settings' => 'kb_layout_a_excerpt_limit',
		'section'  => 'knowledge_base_layout_a',
		'type'     => 'number',
		'label'    => esc_html__( 'Excerpt characters limit', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'kb_layout_a_excerpt_limit' ),
		'choices'  => array(
			'step' => '1',
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'kb_layout_a_excerpt',
					'operator' => '==',
					'value'    => true,
				)
			),
			array(
					array(
					'setting'  => 'kb_layout_a_excerpt_type',
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
		'settings' => 'kb_layout_a_rm',
		'section'  => 'knowledge_base_layout_a',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Display "read more" button', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'kb_layout_a_rm' ),
	)
);


/* Layout B */

Kirki::add_section(
	'knowledge_base_layout_b',
	array(
		'panel'       => 'kbg_panel_knowledge_base_layouts',
		'title'       => esc_attr__( 'Layout B', 'knowledge-guru' ),
		'description' => kbg_wp_kses( '<img src="' . get_parent_theme_file_uri( '/assets/img/admin/kb_layout_b.svg' ) . '"/>' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'type'        => 'custom',
		'settings'    => 'custom_setting',
		'label'       => esc_html__( 'Info', 'knowledge-guru' ), // optional
		'section'     => 'knowledge_base_layout_b',
		'default'     => '<h3 style="padding:15px 10px; background:#fff; margin:0;">' . __( 'Layout B doesn\'t have any options because by design it only lists the article titles.', 'knowledge-guru' ) . '</h3>',
	)
);

