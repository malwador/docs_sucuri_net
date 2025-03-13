<?php


Kirki::add_section( 
    'kbg_page', 
    array(
        'panel'          => 'kbg_panel',
        'title'          => esc_attr__( 'Page', 'knowledge-guru' ),
        'priority'    => 80,
    ) 
);

Kirki::add_field( 
    'kbg', 
    array(
        'settings'    => 'page_sidebar_position',
        'section'     => 'kbg_page',
        'type'        => 'radio-image',
        'label'       => esc_html__( 'Sidebar position', 'knowledge-guru' ),
        'default'     => kbg_get_default_option( 'page_sidebar_position' ),
        'choices'     => kbg_get_sidebar_layouts( false, true )
    )
);

Kirki::add_field( 
    'kbg', 
    array(
        'settings'    => 'page_sidebar_standard',
        'section'     => 'kbg_page',
        'type'        => 'select',
        'label'       => esc_html__( 'Standard sidebar', 'knowledge-guru' ),
        'default'     => kbg_get_default_option( 'page_sidebar_standard' ),
        'choices'     => kbg_get_sidebars_list(),
        'required'    => array(
            array(
                'setting'  => 'page_sidebar_position',
                'operator' => '!=',
                'value'    =>  'none'
            )
        )
    )
);

Kirki::add_field( 
    'kbg', 
    array(
        'settings'    => 'page_sidebar_sticky',
        'section'     => 'kbg_page',
        'type'        => 'select',
        'label'       => esc_html__( 'Sticky sidebar', 'knowledge-guru' ),
        'default'     => kbg_get_default_option( 'page_sidebar_sticky' ),
        'choices'     => kbg_get_sidebars_list(),
        'required'    => array(
            array(
                'setting'  => 'page_sidebar_position',
                'operator' => '!=',
                'value'    =>  'none'
            )
        )
    )
);

Kirki::add_field( 
    'kbg', 
    array(
        'settings'    => 'page_fimg',
        'section'     => 'kbg_page',
        'type'        => 'toggle',
        'label'       => esc_html__( 'Display featured image', 'knowledge-guru' ),
        'default'     => kbg_get_default_option( 'page_fimg' ),
    )
);

Kirki::add_field( 
    'kbg', 
    array(
        'settings'    => 'page_fimg_cap',
        'section'     => 'kbg_page',
        'type'        => 'toggle',
        'label'       => esc_html__( 'Display featured image caption', 'knowledge-guru' ),
        'default'     => kbg_get_default_option( 'page_fimg_cap' ),
        'required'    => array(
            array(
                'setting'  => 'page_fimg',
                'operator' => '==',
                'value'    =>  true
            )
        )
    )
);
Kirki::add_field( 
    'kbg', 
    array(
        'settings'    => 'page_layout_1_img_ratio',
        'section'     => 'kbg_page',
        'type'        => 'select',
        'label'       => esc_html__( 'Image ratio for layout 1', 'knowledge-guru' ),
        'default'     => kbg_get_default_option( 'page_layout_1_img_ratio' ),
        'choices'   => kbg_get_image_ratio_opts(),
        'required'    => array(
            array(
                'setting'  => 'page_layout',
                'operator' => '==',
                'value'    => '1'
            ),
            array(
                'setting'  => 'page_fimg',
                'operator' => '==',
                'value'    =>  true
            )
        ),
    )
);

Kirki::add_field( 
    'kbg', 
    array(
        'settings'    => 'page_layout_1_img_custom',
        'section'     => 'kbg_page',
        'type'        => 'text',
        'label'       => esc_html__( 'Your custom ratio', 'knowledge-guru' ),
        'description'      => esc_html__( 'i.e. Put 2:1', 'knowledge-guru' ),
        'default'     => kbg_get_default_option( 'page_layout_1_img_custom' ),
        'required'    => array(
            array(
                'setting'  => 'page_layout_1_img_ratio',
                'operator' => '==',
                'value'    => 'custom'
            ),
            array(
                'setting'  => 'page_layout',
                'operator' => '==',
                'value'    => '1'
            ),
            array(
                'setting'  => 'page_fimg',
                'operator' => '==',
                'value'    =>  true
            )

        ),
    )
);
