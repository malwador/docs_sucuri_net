<?php
// Footer copyright section
    function heroic_copyright_customizer($wp_customize)
    {
        $wp_customize->add_section(
            'copyright_section_one',
            array(
            'title' => esc_html__('Footer Copyright Setting', 'heroic'),
            'priority' => 1100,
            'panel'  => 'quality_footer_setting',
        )
        );

        $wp_customize->add_setting(
            'quality_pro_options[footer_copyright_text]',
            array(

         'default' => '<p>'.__('Proudly powered by <a href="https://wordpress.org">WordPress</a> | Theme: <a href="https://webriti.com" rel="nofollow">Heroic</a> by Webriti', 'heroic').'</p>',
         'type' =>'option',
        'sanitize_callback' => 'heroic_copyright_sanitize_text',
    )
        );
        $wp_customize->add_control(
            'quality_pro_options[footer_copyright_text]',
            array(
        'label' => esc_html__('Copyright Text', 'heroic'),
        'section' => 'copyright_section_one',
        'type' => 'textarea',
    )
        );
    }

function heroic_copyright_sanitize_text($input)
{
    return wp_kses_post(force_balance_tags($input));
}

add_action('customize_register', 'heroic_copyright_customizer');

/**
 * Add selective refresh for Front page section section controls.
 */
function heroic_register_home_copy_right_section_partials($wp_customize)
{
    $wp_customize->selective_refresh->add_partial('quality_pro_options[footer_copyright_text]', array(
        'selector'            => '.site-footer .site-info',
        'settings'            => 'quality_pro_options[footer_copyright_text]',

    ));
}
add_action('customize_register', 'heroic_register_home_copy_right_section_partials');