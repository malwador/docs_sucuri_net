<?php


Kirki::add_section( 'kbg_typography', array(
    'panel'          => 'kbg_panel',
    'title'          => esc_attr__( 'Typography', 'knowledge-guru' ),
    'priority'    => 100,
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'main_font',
    'section'     => 'kbg_typography',
    'type'        => 'typography',
    'label'       => esc_html__( 'Main text font', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'main_font' ),
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'h_font',
    'section'     => 'kbg_typography',
    'type'        => 'typography',
    'label'       => esc_html__( 'Headings font', 'knowledge-guru' ),
    'description'    => esc_html__( 'This is the font used for titles and headings', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'h_font' ),
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'nav_font',
    'section'     => 'kbg_typography',
    'type'        => 'typography',
    'label'       => esc_html__( 'Navigation font', 'knowledge-guru' ),
    'description'    => esc_html__( 'This is the font used for main website navigation', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'nav_font' ),
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'nav_font',
    'section'     => 'kbg_typography',
    'type'        => 'typography',
    'label'       => esc_html__( 'Navigation font', 'knowledge-guru' ),
    'description'    => esc_html__( 'This is the font used for main website navigation', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'nav_font' ),
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'button_font',
    'section'     => 'kbg_typography',
    'type'        => 'typography',
    'label'       => esc_html__( 'Button font', 'knowledge-guru' ),
    'description'    => esc_html__( 'This is the font used for buttons and special labels', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'button_font' ),
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'font_size_p',
    'section'     => 'kbg_typography',
    'type'        => 'number',
    'label'       => esc_html__( 'Regular text font size', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'font_size_p' ),
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'font_size_small',
    'section'     => 'kbg_typography',
    'type'        => 'number',
    'label'       => esc_html__( 'Small text font size', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'font_size_small' ),
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'font_size_nav',
    'section'     => 'kbg_typography',
    'type'        => 'number',
    'label'       => esc_html__( 'Main website navigation font size', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'font_size_nav' ),
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'font_size_nav_ico',
    'section'     => 'kbg_typography',
    'type'        => 'number',
    'label'       => esc_html__( 'Navigation icons (hamburger, search...) font size', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'font_size_nav_ico' ),
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'font_size_section_title',
    'section'     => 'kbg_typography',
    'type'        => 'number',
    'label'       => esc_html__( 'Section title font size', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'font_size_section_title' ),
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'font_size_widget_title',
    'section'     => 'kbg_typography',
    'type'        => 'number',
    'label'       => esc_html__( 'Widget title font size', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'font_size_widget_title' ),
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'font_size_punchline',
    'section'     => 'kbg_typography',
    'type'        => 'number',
    'label'       => esc_html__( 'Punchline font size', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'font_size_punchline' ),
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'font_size_h1',
    'section'     => 'kbg_typography',
    'type'        => 'number',
    'label'       => esc_html__( 'H1 font size', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'font_size_h1' ),
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'font_size_h2',
    'section'     => 'kbg_typography',
    'type'        => 'number',
    'label'       => esc_html__( 'H2 font size', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'font_size_h2' ),
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'font_size_h3',
    'section'     => 'kbg_typography',
    'type'        => 'number',
    'label'       => esc_html__( 'H3 font size', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'font_size_h3' ),
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'font_size_h4',
    'section'     => 'kbg_typography',
    'type'        => 'number',
    'label'       => esc_html__( 'H4 font size', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'font_size_h4' ),
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'font_size_h5',
    'section'     => 'kbg_typography',
    'type'        => 'number',
    'label'       => esc_html__( 'H5 font size', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'font_size_h5' ),
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'font_size_h6',
    'section'     => 'kbg_typography',
    'type'        => 'number',
    'label'       => esc_html__( 'H6 font size', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'font_size_h6' ),
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'uppercase',
    'section'     => 'kbg_typography',
    'type'        => 'multicheck',
    'label'       => esc_html__( 'Uppercase text', 'knowledge-guru' ),
    'description' => esc_html__( 'Select elements that you want to display with all CAPITAL LETTERS', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'uppercase' ),
    'choices'  => kbg_get_typography_uppercase_options(),
) );