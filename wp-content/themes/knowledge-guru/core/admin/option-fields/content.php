<?php

Kirki::add_section(
	'kbg_content',
	array(
        'panel'    => 'kbg_panel',
		'title'    => esc_attr__( 'Colors and Styling', 'knowledge-guru' ),
		'priority' => 90,
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'theme_style',
		'section'  => 'kbg_content',
		'type'     => 'radio',
		'label'    => esc_html__( 'Theme style', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'theme_style' ),
		'choices'  => array(
			'sharp' => esc_html__( 'Sharp', 'knowledge-guru' ),
			'rounded'    => esc_html__( 'Rounded', 'knowledge-guru' ),
			'pill'    => esc_html__( 'Pill', 'knowledge-guru' ),
		)
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'color_main',
		'section'  => 'kbg_content',
		'type'     => 'color',
		'label'    => esc_html__( 'Main color', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'color_main' ),
	)
);


Kirki::add_field(
	'kbg',
	array(
		'settings' => 'color_txt',
		'section'  => 'kbg_content',
		'type'     => 'color',
		'label'    => esc_html__( 'Text color', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'color_txt' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'color_bg',
		'section'  => 'kbg_content',
		'type'     => 'color',
		'label'    => esc_html__( 'Background color', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'color_bg' ),
	)
);


Kirki::add_field(
	'kbg',
	array(
		'settings' => 'color_button_primary',
		'section'  => 'kbg_content',
		'type'     => 'color',
		'label'    => esc_html__( 'Button primary color', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'color_button_primary' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'color_button_primary_text',
		'section'  => 'kbg_content',
		'type'     => 'color',
		'label'    => esc_html__( 'Button primary text color', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'color_button_primary_text' ),
	)
);


// Inherit Main Color or Custom color options

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'color_option',
		'section'  => 'kbg_content',
		'type'     => 'radio',
		'label'    => esc_html__( 'Additional color options', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'color_option' ),
		'choices'  => array(
			'inherit'    => esc_html__( 'Generate from main color', 'knowledge-guru' ),
			'custom' => esc_html__( 'Customize colors', 'knowledge-guru' ),
		)
	)
);




// Button colors

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'color_button_secondary',
		'section'  => 'kbg_content',
		'type'     => 'color',
		'label'    => esc_html__( 'Button secondary', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'color_button_secondary' ),
		'required' => array(
			array(
				'setting'  => 'color_option',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'color_button_tertiary',
		'section'  => 'kbg_content',
		'type'     => 'color',
		'label'    => esc_html__( 'Button tertiary', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'color_button_tertiary' ),
		'required' => array(
			array(
				'setting'  => 'color_option',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);


// Main Header colors

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'color_header_bg_solid',
		'section'  => 'kbg_content',
		'type'     => 'color',
		'label'    => esc_html__( 'Header background color', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'color_header_bg_solid' ),
		'required' => array(
			array(
				'setting'  => 'color_option',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'color_header_txt',
		'section'  => 'kbg_content',
		'type'     => 'color',
		'label'    => esc_html__( 'Header text color', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'color_header_txt' ),
		'required' => array(
			array(
				'setting'  => 'color_option',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);

// Sticky Header colors

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'color_header_sticky_bg',
		'section'  => 'kbg_content',
		'type'     => 'color',
		'label'    => esc_html__( 'Sticky header background color', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'color_header_sticky_bg' ),
		'required' => array(
			array(
				'setting'  => 'color_option',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'color_header_sticky_txt',
		'section'  => 'kbg_content',
		'type'     => 'color',
		'label'    => esc_html__( 'Sticky header text color', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'color_header_sticky_txt' ),
		'required' => array(
			array(
				'setting'  => 'color_option',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);


// Footer colors

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'color_footer_bg',
		'section'  => 'kbg_content',
		'type'     => 'color',
		'label'    => esc_html__( 'Footer background color', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'color_footer_bg' ),
		'required' => array(
			array(
				'setting'  => 'color_option',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings' => 'color_footer_txt',
		'section'  => 'kbg_content',
		'type'     => 'color',
		'label'    => esc_html__( 'Footer text color', 'knowledge-guru' ),
		'default'  => kbg_get_default_option( 'color_footer_txt' ),
		'required' => array(
			array(
				'setting'  => 'color_option',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);
