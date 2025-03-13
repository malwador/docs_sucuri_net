<?php

/**
 * Register sidebars
 *
 * Callback function for theme sidebars registration and init
 *
 * @since  1.0
 */

add_action( 'widgets_init', 'kbg_register_sidebars' );

if ( !function_exists( 'kbg_register_sidebars' ) ) :
    function kbg_register_sidebars() {

        /* Default Sidebar */
        register_sidebar(
            array(
                'id' => 'kbg_sidebar_default',
                'name' => esc_html__( 'Default Sidebar', 'knowledge-guru' ),
                'description' => esc_html__( 'This is the default sidebar', 'knowledge-guru' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s col-12 col-md-6 col-lg-12"><div class="widget-inside kbg-card">',
                'after_widget' => '</div></div>',
                'before_title' => '<h4 class="widget-title">',
                'after_title' => '</h4>'
            )
        );

        /* Default Sidebar */
        register_sidebar(
            array(
                'id' => 'kbg_sidebar_default_sticky',
                'name' => esc_html__( 'Default Sticky Sidebar', 'knowledge-guru' ),
                'description' => esc_html__( 'This is the default sticky sidebar', 'knowledge-guru' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s col-12 col-md-6 col-lg-12"><div class="widget-inside kbg-card">',
                'after_widget' => '</div></div>',
                'before_title' => '<h4 class="widget-title">',
                'after_title' => '</h4>'
            )
        );

        /* Search Sidebar */
        register_sidebar(
            array(
                'id' => 'kbg_search_sidebar_default',
                'name' => esc_html__( 'Search Archive Sidebar', 'knowledge-guru' ),
                'description' => esc_html__( 'This is the search archive sidebar, special created for search archive page', 'knowledge-guru' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s col-12 col-md-6 col-lg-12"><div class="widget-inside kbg-card">',
                'after_widget' => '</div></div>',
                'before_title' => '<h4 class="widget-title">',
                'after_title' => '</h4>'
            )
        );

        /* Search Sticky Sidebar */
        register_sidebar(
            array(
                'id' => 'kbg_search_sidebar_default_sticky',
                'name' => esc_html__( 'Search Archive Sticky Sidebar', 'knowledge-guru' ),
                'description' => esc_html__( 'This is the search archive sticky sidebar, special created for search archive page', 'knowledge-guru' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s col-12 col-md-6 col-lg-12"><div class="widget-inside kbg-card">',
                'after_widget' => '</div></div>',
                'before_title' => '<h4 class="widget-title">',
                'after_title' => '</h4>'
            )
        );

        /* Footer Sidebar Area 1*/
        register_sidebar(
            array(
                'id' => 'kbg_sidebar_footer_1',
                'name' => esc_html__( 'Footer Column 1', 'knowledge-guru' ),
                'description' => esc_html__( 'This is footer area column 1.', 'knowledge-guru' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s ">',
                'after_widget' => '</div>',
                'before_title' => '<h5 class="widget-title">',
                'after_title' => '</h5>'
            )
        );

        /* Footer Sidebar Area 2*/
        register_sidebar(
            array(
                'id' => 'kbg_sidebar_footer_2',
                'name' => esc_html__( 'Footer Column 2', 'knowledge-guru' ),
                'description' => esc_html__( 'This is footer area column 2.', 'knowledge-guru' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h5 class="widget-title">',
                'after_title' => '</h5>'
            )
        );



        /* Footer Sidebar Area 3*/
        register_sidebar(
            array(
                'id' => 'kbg_sidebar_footer_3',
                'name' => esc_html__( 'Footer Column 3', 'knowledge-guru' ),
                'description' => esc_html__( 'This is footer area column 3.', 'knowledge-guru' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h5 class="widget-title">',
                'after_title' => '</h5>'
            )
        );

        /* Footer Sidebar Area 4*/
        register_sidebar(
            array(
                'id' => 'kbg_sidebar_footer_4',
                'name' => esc_html__( 'Footer Column 4', 'knowledge-guru' ),
                'description' => esc_html__( 'This is footer area column 4.', 'knowledge-guru' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h5 class="widget-title">',
                'after_title' => '</h5>'
            )
        );

        /* Add sidebars from theme options */
        $custom_sidebars = kbg_get_option( 'sidebars' );

        if ( !empty( $custom_sidebars ) ) {
            foreach ( $custom_sidebars as $key => $sidebar ) {

                if ( is_numeric( $key ) ) {
                    register_sidebar(
                        array(
                            'id' => 'kbg_sidebar_'.$key,
                            'name' => esc_html( $sidebar['name'] ),
                            'description' => esc_html__( 'This is custom sidebar area.', 'knowledge-guru' ),
                            'before_widget' => '<div id="%1$s" class="widget %2$s col-12 col-md-6 col-lg-12"><div class="widget-inside kbg-card">',
                            'after_widget' => '</div></div>',
                            'before_title' => '<h4 class="widget-title">',
                            'after_title' => '</h4>'
                        )
                    );
                }
            }
        }
    }

endif;