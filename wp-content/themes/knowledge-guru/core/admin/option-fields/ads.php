<?php

Kirki::add_section( 'kbg_ads', array(
    'panel'          => 'kbg_panel',
    'title'          => esc_attr__( 'Ads', 'knowledge-guru' ),
    'description'   => esc_html__( 'Use these options to set up your ads throughout the website. Both HTML/image and JavaScript ads are allowed. You can use shortcodes from your favorite ad plugins as well.', 'knowledge-guru' ),
    'priority'    => 110,
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'ad_above_archive',
    'section'     => 'kbg_ads',
    'type'        => 'editor',
    'label'    => esc_html__( 'Archive top', 'knowledge-guru' ),
    'description' => esc_html__( 'This ad will be displayed above the content of your archive templates (i.e. categories, tags, etc.)', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'ad_above_archive' ),
    'sanitize_callback' => 'kbg_sanitize_ad'
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'ad_above_singular',
    'section'     => 'kbg_ads',
    'type'        => 'editor',
    'label'    => esc_html__( 'Single post/page top', 'knowledge-guru' ),
    'description' => esc_html__( 'This ad will be displayed above the content of single posts and pages', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'ad_above_singular' ),
    'sanitize_callback' => 'kbg_sanitize_ad'
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'ad_above_footer',
    'section'     => 'kbg_ads',
    'type'        => 'editor',
    'label'    => esc_html__( 'Above footer', 'knowledge-guru' ),
    'description' => esc_html__( 'This ad will be displayed above the footer area on all templates', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'ad_above_footer' ),
    'sanitize_callback' => 'kbg_sanitize_ad'
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'ad_between_posts',
    'section'     => 'kbg_ads',
    'type'        => 'editor',
    'label'    => esc_html__( 'Between posts', 'knowledge-guru' ),
    'description' => esc_html__( 'This ad will be displayed between the posts listing on your archive templates', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'ad_between_posts' ),
    'sanitize_callback' => 'kbg_sanitize_ad'
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'ad_between_position',
    'section'     => 'kbg_ads',
    'type'        => 'number',
    'label'    => esc_html__( 'Between posts ad position', 'knowledge-guru' ),
    'description' => esc_html__( 'Specify after how many posts you want to display the ad', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'ad_between_position' ),
    'required'    => array(
        array(
            'setting'  => 'ad_between_posts',
            'operator' => '!=',
            'value'    => '',
        ),
    ),
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'ad_exclude',
    'section'     => 'kbg_ads',
    'type'        => 'select',
    'multiple'    => 10,
    'label'       => esc_html__( 'Do not show ads on these specific pages', 'knowledge-guru' ),
    'description'       => esc_html__( 'Select pages you don\'t want to display ads on', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'ad_exclude' ),
    'choices'     => Kirki_Helper::get_posts( array( 'post_type' => 'page', 'posts_per_page' => '-1' ) )
) );