<?php

Kirki::add_section( 'kbg_translate', array(
    'panel'          => 'kbg_panel',
    'title'          => esc_attr__( 'Translation', 'knowledge-guru' ),
    'description'   => esc_html__( 'Use these settings to quickly translate or change the text in this theme. If you want to remove the text completely instead of modifying it, you can use "-1" as a value for a particular field. Note: If you are using this theme for a multilingual website, you need to disable these options and use multilanguage plugins (such as WPML) and manual translation with .po and .mo files located inside the "languages" folder.', 'knowledge-guru' ),
    'priority'    => 130
) );

Kirki::add_field( 'kbg', array(
    'settings'    => 'enable_translate',
    'section'     => 'kbg_translate',
    'type'        => 'toggle',
    'label'       => esc_html__( 'Enable theme translation', 'knowledge-guru' ),
    'default'     => kbg_get_default_option( 'enable_translate' ),
) );


$translate_strings = kbg_get_translate_options();

foreach ( $translate_strings as $string_key => $item ) {

if ( isset( $item['hidden'] ) ) {
    continue;
}

Kirki::add_field( 'kbg', array(
        'settings'    => 'tr_' . $string_key,
        'section'     => 'kbg_translate',
        'type'        => 'text',
        'label'       => esc_html( $item['text'] ),
        'description' => isset( $item['desc'] ) ? $item['desc'] : '',
        'default'  => isset( $item['default'] ) ? $item['default'] : '',
    ) );
}