<?php

Kirki::add_panel( 'kbg_sidebar_panel', array(
'panel'          => 'kbg_panel',
'title'          => esc_attr__( 'Sidebar', 'knowledge-guru' ),
'priority'    => 21,
) );

Kirki::add_section(
	'kbg_sidebar_section',
	array(
		'panel' => 'kbg_panel',
        'title' => esc_attr__( 'Sidebars', 'knowledge-guru' ),
        'priority'    => 50,
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings'     => 'sidebars',
		'section'      => 'kbg_sidebar_section',
		'type'         => 'repeater',
		'label'        => esc_html__( 'Sidebars', 'knowledge-guru' ),
		'description'  => kbg_wp_kses( sprintf( __( 'Use this option to create additional sidebars for your website. Afterwards, you can manage sidebars content in the <a href="%s">Apperance -> Widgets</a> settings.', 'knowledge-guru' ), admin_url( 'widgets.php' ) ) ),
		'row_label'    => array(
			'type'  => 'text',
			'value' => esc_html__( 'Custom sidebar', 'knowledge-guru' ),
		),

		'button_label' => esc_html__( 'Add new', 'knowledge-guru' ),

		'default'      => kbg_get_default_option( 'sidebars' ),
		'fields'       => array(
			'name' => array(
				'type'    => 'text',
				'label'   => esc_html__( 'Sidebar name', 'knowledge-guru' ),
				'default' => '',
			),
		),
	)
);
