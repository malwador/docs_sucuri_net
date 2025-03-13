<?php

Kirki::add_section( 'kbg_performance', array(
    'panel'          => 'kbg_panel',
    'title'          => esc_attr__( 'Performance', 'knowledge-guru' ),
    'priority'    => 140,
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'minify_css',
    'section'     => 'kbg_performance',
    'type'        => 'toggle',
    'label'    => esc_html__( 'Use minified CSS', 'knowledge-guru' ),
    'description' => esc_html__( 'Load all theme CSS files combined and minified into a single file.', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'minify_css' ),
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'minify_js',
    'section'     => 'kbg_performance',
    'type'        => 'toggle',
    'label'    => esc_html__( 'Use minified JS', 'knowledge-guru' ),
    'description' => esc_html__( 'Load all theme JavaScript files combined and minified into a single file.', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'minify_js' ),
) );


$image_sizes = kbg_get_image_sizes();

foreach ( $image_sizes as $key => $size ) {
$image_sizes[$key] = $size['title'];
}

Kirki::add_field( 'kbg', array(
    'settings'    => 'disable_img_sizes',
    'section'     => 'kbg_performance',
    'type'        => 'multicheck',
    'label'    => esc_html__( 'Disable additional image sizes', 'knowledge-guru' ),
    'description' => esc_html__( 'By default, the theme generates an additional size for each of the layouts. You can use this option to avoid creating additional sizes if you are not using a particular layout, in order to save server space.', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'disable_img_sizes' ),
    'choices' => $image_sizes
) );