<?php

Kirki::add_section(
	'kbg_misc',
	array(
		'panel'    => 'kbg_panel',
		'title'    => esc_attr__( 'Miscellaneous', 'knowledge-guru' ),
		'priority' => 120,
	)
);



Kirki::add_field(
	'kbg',
	array(
		'settings'    => 'rtl_mode',
		'section'     => 'kbg_misc',
		'type'        => 'toggle',
		'label'       => esc_html__( 'RTL mode (right to left)', 'knowledge-guru' ),
		'description' => esc_html__( 'Enable this option if the website is using right to left writing/reading', 'knowledge-guru' ),
		'default'     => kbg_get_default_option( 'rtl_mode' ),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings'    => 'rtl_lang_skip',
		'section'     => 'kbg_misc',
		'type'        => 'text',
		'label'       => esc_html__( 'Skip RTL for specific language(s)', 'knowledge-guru' ),
		'description' => esc_html__( 'i.e. If you are using Arabic and English versions on the same WordPress installation you should put "en_US" in this field and its version will not be displayed as RTL. Note: To exclude multiple languages, separate by comma: en_US, de_DE', 'knowledge-guru' ),
		'default'     => kbg_get_default_option( 'rtl_lang_skip' ),
		'required'    => array(
			array(
				'setting'  => 'rtl_mode',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'kbg',
	array(
		'settings'    => 'more_string',
		'section'     => 'kbg_misc',
		'type'        => 'text',
		'label'       => esc_html__( 'More string', 'knowledge-guru' ),
		'description' => esc_html__( 'Specify your "more" string to append after the limited post excerpts', 'knowledge-guru' ),
		'default'     => kbg_get_default_option( 'more_string' ),
	)
);


Kirki::add_field(
	'kbg',
	array(
		'settings'    => 'words_read_per_minute',
		'section'     => 'kbg_misc',
		'type'        => 'number',
		'label'       => esc_html__( 'Words to read per minute', 'knowledge-guru' ),
		'description' => esc_html__( 'Use this option to set the number of words your visitors read per minute, in order to fine-tune the calculation of the post reading time meta data', 'knowledge-guru' ),
		'default'     => kbg_get_default_option( 'words_read_per_minute' ),
		'choices'     => array(
			'step' => '1',
		),
	)
);


Kirki::add_field(
	'kbg',
	array(
		'settings'    => 'default_fimg',
		'section'     => 'kbg_misc',
		'type'        => 'image',
		'label'       => esc_html__( 'Default featured image', 'knowledge-guru' ),
		'description' => esc_html__( 'Upload your default featured image/placeholder. It will be displayed for posts that do not have a featured image set', 'knowledge-guru' ),
		'default'     => kbg_get_default_option( 'default_fimg' ),
		'choices'     => array(
			'save_as' => 'array',
		),
	)
);


Kirki::add_field(
	'kbg',
	array(
		'settings'    => '404_image',
		'section'     => 'kbg_misc',
		'type'        => 'image',
		'label'       => esc_html__( '404 image', 'knowledge-guru' ),
		'description' => esc_html__( 'Upload your 404 image. It will be displayed on the 404/not found page', 'knowledge-guru' ),
		'default'     => kbg_get_default_option( '404_image' ),
		'choices'     => array(
			'save_as' => 'array',
		),
	)
);
