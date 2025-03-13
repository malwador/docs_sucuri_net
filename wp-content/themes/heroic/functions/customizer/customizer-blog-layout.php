<?php

function heroic_blog_layout_customizer($wp_customize) {

    $heroic_current_options = wp_parse_args(get_option('quality_pro_options', array()), quality_theme_data_setup());

    // blog Layout settings
    if (get_option('quality_user', 'new')=='old' || $heroic_current_options['text_title'] != '' || $heroic_current_options['upload_image_logo'] != '' || $heroic_current_options['webrit_custom_css']=='nomorenow') {

        $wp_customize->add_setting('quality_pro_options[blog_masonry4_layout_setting]', array(
            'default' => 'default',
            'sanitize_callback' => 'heroic_sanitize_radio',
            'type' => 'option'
        ));
    } else {

        $wp_customize->add_setting('quality_pro_options[blog_masonry4_layout_setting]', array(
            'default' => 'masonry4',
            'sanitize_callback' => 'heroic_sanitize_radio',
            'type' => 'option'
        ));
    }
    $wp_customize->add_control(new heroic_Image_Radio_Button_Custom_Control($wp_customize, 'quality_pro_options[blog_masonry4_layout_setting]',
                    array(
                'label' => esc_html__('Blog Layout Setting', 'heroic'),
                'section' => 'blog_setting',
                'priority'              => 20,
                'choices' => array(
                    'default' => array(
                        'image' => get_stylesheet_directory_uri() . '/images/quality-blue-blog-default.png',
                        'name' => esc_html__('Standard Layout', 'heroic')
                    ),
                    'masonry4' => array(
                        'image' => get_stylesheet_directory_uri() . '/images/quality-blue-blog-masonry.png',
                        'name' => esc_html__('Masonry 4 Column', 'heroic')
                    )
                )
                    )
    ));
}
add_action('customize_register', 'heroic_blog_layout_customizer');