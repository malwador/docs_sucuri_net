<?php

Kirki::add_section(
	'kbg_footer',
	array(
		'panel' => 'kbg_panel',
        'title' => esc_attr__( 'Footer', 'knowledge-guru' ),
        'priority'    => 40,
	)
);


Kirki::add_field(
	'kbg',
	array(
		'settings' => 'footer_widgets',
		'section'  => 'kbg_footer',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Display footer widgets', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'footer_widgets' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'footer_widgets_style',
		'section'  => 'kbg_footer',
		'type'     => 'radio',
		'label'    => esc_html__( 'Widgets style', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'footer_widgets_style' ),
		'choices'  => array(
			'unboxed' => esc_html__( 'Unboxed', 'knowledge-guru' ),
			'boxed'    => esc_html__( 'Boxed', 'knowledge-guru' ),
		),
		'required' => array(
			array(
				'setting'  => 'footer_widgets',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'footer_widgets_layout',
		'section'  => 'kbg_footer',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Footer widgets layout', 'knowledge-guru' ),
		'description'     => kbg_wp_kses( sprintf( __( 'Note: Each column represents one Footer Sidebar in <a href="%s">Apperance -> Widgets</a> settings.', 'knowledge-guru' ), admin_url( 'widgets.php' ) ) ),
		'default'  => kbg_get_default_option( 'footer_widgets_layout' ),
		'choices'  => kbg_get_footer_layouts(),
		'required' => array(
			array(
				'setting'  => 'footer_widgets',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);


Kirki::add_field(
	'kbg',
	array(
		'settings' => 'footer_copyright_and_menu',
		'section'  => 'kbg_footer',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Display footer copyright and menu', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'footer_copyright_and_menu' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'footer_copyright',
		'section'  => 'kbg_footer',
		'type'     => 'textarea',
		'label'    => esc_html__( 'Footer copyright text', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'footer_copyright' ),
		'required' => array(
			array(
				'setting'  => 'footer_copyright_and_menu',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'copyright_menu',
		'section'  => 'kbg_footer',
		'type'     => 'toggle',
		'label'    => esc_html__( 'Display copyright menu', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'copyright_menu' ),
		'required' => array(
			array(
				'setting'  => 'footer_copyright_and_menu',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);
