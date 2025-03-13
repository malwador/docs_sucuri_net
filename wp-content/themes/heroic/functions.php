<?php

// Global variables define
define('HEROIC_PARENT_TEMPLATE_DIR_URI', get_template_directory_uri());
define('HEROIC_TEMPLATE_DIR_URI', get_stylesheet_directory_uri());
define('HEROIC_TEMPLATE_DIR', trailingslashit(get_stylesheet_directory()));

if (!function_exists('wp_body_open')) {

    function wp_body_open() {
        /**
         * Triggered after the opening <body> tag.
         */
        do_action('wp_body_open');
    }

}
add_action('wp_enqueue_scripts', 'heroic_enqueue_styles', 9999);

function heroic_enqueue_styles() {
    wp_enqueue_style('bootstrap', HEROIC_PARENT_TEMPLATE_DIR_URI . '/css/bootstrap.css');
    wp_enqueue_style('heroic-parent-style', HEROIC_PARENT_TEMPLATE_DIR_URI . '/style.css');
    wp_enqueue_style('heroic-child-style', HEROIC_TEMPLATE_DIR_URI . '/style.css', array('parent-style'));
    wp_enqueue_style('heroic-theme-menu', HEROIC_PARENT_TEMPLATE_DIR_URI . '/css/theme-menu.css');
    wp_enqueue_style('heroic-default-style-css', HEROIC_TEMPLATE_DIR_URI . "/css/default.css");
    wp_dequeue_style('default-css', HEROIC_PARENT_TEMPLATE_DIR_URI . '/css/default.css');
    //Add script
    wp_enqueue_script('heroic-mp-masonry-js', HEROIC_TEMPLATE_DIR_URI . '/js/masonry/mp.mansory.min.js');
    $heroic_setting = wp_parse_args(get_option('quality_pro_options', array()), heroic_default_data());
    if ($heroic_setting['header_sticky_layout_setting'] == 'sticky') {
        wp_enqueue_script('heroic-menu-sticky-js', HEROIC_TEMPLATE_DIR_URI . '/js/menu-sticky.js');
    }
}

add_action('after_setup_theme', 'heroic_setup');

function heroic_setup() {
    load_theme_textdomain('heroic', HEROIC_TEMPLATE_DIR . '/languages');

    require(HEROIC_TEMPLATE_DIR . '/functions/customizer/customizer-copyright.php');
    require( HEROIC_TEMPLATE_DIR . '/functions/customizer/customizer-header-layout.php');
    require( HEROIC_TEMPLATE_DIR . '/functions/customizer/customizer-blog-layout.php');
    require( HEROIC_TEMPLATE_DIR . '/functions/template-tag.php' );

    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
}

function heroic_general_settings_customizer($wp_customize) {

    /* Remove banner image */
    $wp_customize->add_section('banner_image_setting', array(
        'title' => esc_html__('Banner Setting', 'heroic'),
        'panel' => 'general_options',
    ));


    // Banner Image remove
    $wp_customize->add_setting('remove_banner_image', array(
        'capability' => 'edit_theme_options',
        'default' => false,
        'sanitize_callback' => 'heroic_sanitize_checkbox',
    ));
    $wp_customize->add_control('remove_banner_image', array(
        'label' => esc_html__('Remove banner image from all pages', 'heroic'),
        'section' => 'banner_image_setting',
        'type' => 'checkbox',
    ));
}

add_action('customize_register', 'heroic_general_settings_customizer');

function heroic_remove_slider_customizer() {
    remove_action('customize_register', 'quality_slider_customizer');
}

if (is_admin()) {
    require get_stylesheet_directory() . '/admin/admin-init.php';
}


add_action('after_setup_theme', 'heroic_remove_slider_customizer', 9);

//Slider Customizer
function heroic_slider_customizer($wp_customize) {
    $selective_refresh = isset($wp_customize->selective_refresh) ? true : false;

    //slider Section
    $wp_customize->add_panel('quality_homepage_section_setting', array(
        'priority' => 500,
        'capability' => 'edit_theme_options',
        'title' => esc_html__('Homepage Section Settings', 'heroic'),
    ));

    $wp_customize->add_section(
            'slider_section_settings',
            array(
                'title' => esc_html__('Slider Settings', 'heroic'),
                'panel' => 'quality_homepage_section_setting',
                'priority' => 1,)
    );


    $wp_customize->add_setting(
            'quality_pro_options[slider_enable]',
            array(
                'default' => true,
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'heroic_sanitize_checkbox',
                'type' => 'option',
            )
    );

    $wp_customize->add_control(
            'quality_pro_options[slider_enable]',
            array(
                'label' => esc_html__('Enable slider on homepage.', 'heroic'),
                'section' => 'slider_section_settings',
                'type' => 'checkbox',
            )
    );


    $wp_customize->add_setting('quality_pro_options[home_feature]', array('default' => HEROIC_PARENT_TEMPLATE_DIR_URI . '/images/slider/slide.jpg',
        'type' => 'option', 'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(
            new WP_Customize_Image_Control(
                    $wp_customize,
                    'quality_pro_options[home_feature]',
                    array(
                'type' => 'upload',
                'label' => esc_html__('Image', 'heroic'),
                'section' => 'example_section_one',
                'settings' => 'quality_pro_options[home_feature]',
                'section' => 'slider_section_settings',
                    )
            )
    );

    //Slider Title
    $wp_customize->add_setting(
            'quality_pro_options[home_image_title]',
            array(
                'default' => esc_html__('Fusce consectetur', 'heroic'),
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
                'type' => 'option',
            )
    );
    $wp_customize->add_control('quality_pro_options[home_image_title]', array(
        'label' => esc_html__('Title', 'heroic'),
        'section' => 'slider_section_settings',
        'priority' => 150,
        'type' => 'text',
    ));

    //Slider sub title
    $wp_customize->add_setting(
            'quality_pro_options[home_image_sub_title]',
            array(
                'default' => esc_html__('Lorem ipsum dolor sit amet', 'heroic'),
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
                'type' => 'option',
            )
    );
    $wp_customize->add_control('quality_pro_options[home_image_sub_title]', array(
        'label' => esc_html__('Subtitle', 'heroic'),
        'section' => 'slider_section_settings',
        'priority' => 150,
        'type' => 'text',
    ));

    //Slider Banner discription
    $wp_customize->add_setting(
            'quality_pro_options[home_image_description]',
            array(
                'default' => esc_html__('Suspendisse molestie lacus, 100% consectetur tellus ac mauris.', 'heroic'),
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
                'type' => 'option',
            )
    );
    $wp_customize->add_control('quality_pro_options[home_image_description]', array(
        'label' => esc_html__('Description', 'heroic'),
        'section' => 'slider_section_settings',
        'priority' => 150,
        'type' => 'text',
    ));


    // Slider banner button text
    $wp_customize->add_setting(
            'quality_pro_options[home_image_button_text]',
            array(
                'default' => esc_html__('Quisque a risus', 'heroic'),
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
                'type' => 'option',
            )
    );

    $wp_customize->add_control('quality_pro_options[home_image_button_text]', array(
        'label' => esc_html__('Button Text', 'heroic'),
        'section' => 'slider_section_settings',
        'priority' => 150,
        'type' => 'text',
    ));

    // Slider banner button link
    $wp_customize->add_setting(
            'quality_pro_options[home_image_button_link]',
            array(
                'default' => 'https://webriti.com/heroic-wordpress-theme/',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'esc_url_raw',
                'type' => 'option',
            )
    );

    $wp_customize->add_control('quality_pro_options[home_image_button_link]', array(
        'label' => esc_html__('Button Link', 'heroic'),
        'section' => 'slider_section_settings',
        'priority' => 150,
        'type' => 'text',
    ));
}

add_action('customize_register', 'heroic_slider_customizer');

//Remove Banner Image
function heroic_banner_image() {
    $remove_banner_image = get_theme_mod('remove_banner_image', false);
    if ($remove_banner_image != true) {
        get_template_part('index', 'static');
    }
}

if (!function_exists('heroic_sanitize_checkbox')) :

    /**
     * Sanitize checkbox.
     *
     * @since 1.0.0
     *
     * @param bool $checked Whether the checkbox is checked.
     * @return bool Whether the checkbox is checked.
     */
    function heroic_sanitize_checkbox($checked) {
        return ((isset($checked) && true === $checked) ? true : false);
    }

endif;

// Read more tag to formatting in blog page
function heroic_new_content_more($more) {
    global $post;
    return '<p><a href="' . esc_url(get_permalink()) . "#more-{$post->ID}\" class=\"more-link\">" . esc_html__('Read More', 'heroic') . "</a></p>";
}

add_filter('excerpt_more', 'heroic_new_content_more');

//Default Slider value
function heroic_theme_data_setup() {
    return $theme_options = array(
        //Logo and Fevicon header
        'home_feature' => HEROIC_PARENT_TEMPLATE_DIR_URI . '/images/slider/slide.jpg',
        /* Home Image */
        'home_image_title' => esc_html__('Fusce consectetur', 'heroic'),
        'home_image_sub_title' => esc_html__('Lorem ipsum dolor sit amet', 'heroic'),
        'home_image_description' => esc_html__('Suspendisse molestie lacus, 100% consectetur tellus ac mauris.', 'heroic'),
        'home_image_button_text' => esc_html__('Quisque a risus', 'heroic'),
        'home_image_button_link' => 'https://webriti.com/heroic-wordpress-theme/',
    );
}

//Set for old user
if (!get_option('quality_user', false)) {
     //detect old user and set value
    $heroic_user = get_option('quality_pro_options', array());
    if ((isset($heroic_user['service_title']) || isset($heroic_user['service_description']) || isset($heroic_user['blog_heading']) || isset($heroic_user['home_blog_description']))) {
        add_option('quality_user', 'old');
    }else{
        add_option('quality_user', 'new');
    }
}

if (!function_exists('heroic_default_data')) {

    function heroic_default_data() {
        $heroic_current_options = wp_parse_args(get_option('quality_pro_options', array()), quality_theme_data_setup());
//print_r($header_setting);
        if (get_option('quality_user', 'new')=='old' || $heroic_current_options['text_title'] != '' || $heroic_current_options['upload_image_logo'] != '' || $heroic_current_options['webrit_custom_css'] == 'nomorenow') {

            $array_new = array(
                'header_sticky_layout_setting' => 'default',
                'service_slide_layout_setting' => 'default',
                'blog_masonry4_layout_setting' => 'default',
            );
        } else {
            $array_new = array(
                'header_sticky_layout_setting' => 'sticky',
                'service_slide_layout_setting' => 'slide',
                'blog_masonry4_layout_setting' => 'masonry4',
            );
        }

        $array_old = array(
            // general settings
            'footer_copyright_text' => '<p>' . __('Proudly powered by <a href="https://wordpress.org">WordPress</a> | Theme: <a href="https://webriti.com" rel="nofollow">Heroic</a> by Webriti', 'heroic') . '</p>',
        );
        return $result = array_merge($array_new, $array_old);
    }

}
//Remove Theme color
add_action('customize_register', 'heroic_remove_custom', 1000);

function heroic_remove_custom($wp_customize) {
    $wp_customize->remove_section('theme_color');
}

// Add Script for four column masonry
function heroic_custom_script() {

    wp_reset_query();
    $col = 3;
    ?>
    <script>
        jQuery(document).ready(function (jQuery) {
            jQuery("#blog-masonry").mpmansory(
                    {
                        childrenClass: 'item', // default is a div
                        columnClasses: 'padding', //add classes to items
                        breakpoints: {
                            lg: 3, //Change masonry column here like 2, 3, 4 column
                            md: 6,
                            sm: 6,
                            xs: 12
                        },
                        distributeBy: {order: false, height: false, attr: 'data-order', attrOrder: 'asc'}, //default distribute by order, options => order: true/false, height: true/false, attr => 'data-order', attrOrder=> 'asc'/'desc'
                        onload: function (items) {
                            //make somthing with items
                        }
                    }
            );
        });
    </script>
    <?php

}

add_action('wp_footer', 'heroic_custom_script');

$heroic_theme = wp_get_theme();
if( $heroic_theme->name == 'Heroic' || $heroic_theme->name == 'Heroic child' || $heroic_theme->name == 'Heroic Child' ) {
    // Notice to add required plugin
    function heroic_admin_plugin_notice_warn() {
        $screen = get_current_screen();
        if( $screen->id == 'themes'){
            $theme_name = wp_get_theme();
            if ( get_option( 'dismissed-heroic_comanion_plugin', false ) ) {
               return;
            }
            if ( function_exists('webriti_companion_activate')) {
                return;
            }?>

            <div class="updated notice is-dismissible heroic-theme-notice">

                <div class="owc-header">
                    <h2 class="theme-owc-title">               
                        <svg height="60" width="60" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 70 70"><defs><style>.cls-1{font-size:33px;font-family:Verdana-Bold, Verdana;font-weight:700;}</style></defs><title>Artboard 1</title><text class="cls-1" transform="translate(-0.56 51.25)">WC</text></svg>
                        <?php echo esc_html('Webriti Companion','heroic');?>
                    </h2>
                </div>

                <div class="heroic-theme-content">
                    <h3><?php printf (esc_html__('Thank you for installing the %1$s theme.', 'heroic'), esc_html($theme_name)); ?></h3>

                    <p><?php esc_html_e( 'We highly recommend you to install and activate the', 'heroic' ); ?>
                        <b><?php esc_html_e( 'Webriti Companion', 'heroic' ); ?></b> plugin.
                        <br>
                        <?php esc_html_e( 'This plugin will unlock enhanced features to build a beautiful website.', 'heroic' ); ?>
                    </p>
                    <button id="install-plugin-button-welcome-page" data-plugin-url="<?php echo esc_url( 'https://webriti.com/extensions/webriti-companion.zip');?>"><?php echo esc_html__( 'Install', 'heroic' ); ?></button>
                </div>
            </div>
            
            <script type="text/javascript">
                jQuery(function($) {
                $( document ).on( 'click', '.heroic-theme-notice .notice-dismiss', function () {
                    var type = $( this ).closest( '.heroic-theme-notice' ).data( 'notice' );
                    $.ajax( ajaxurl,
                      {
                        type: 'POST',
                        data: {
                          action: 'dismissed_notice_handler',
                          type: type,
                        }
                      } );
                  } );
              });
            </script>
            <?php
        }
    }
    add_action( 'admin_notices', 'heroic_admin_plugin_notice_warn' );
    add_action( 'wp_ajax_dismissed_notice_handler', 'heroic_ajax_notice_handler');

    function heroic_ajax_notice_handler() {
        update_option( 'dismissed-heroic_comanion_plugin', TRUE );
    }

    function heroic_notice_style(){?>
        <style type="text/css">
            label.tg-label.breadcrumbs img {
                width: 6%;
                padding: 0;
            }
            .heroic-theme-notice .theme-owc-title{
                display: flex;
                align-items: center;
                height: 100%;
                margin: 0;
                font-size: 1.5em;
            }
            .heroic-theme-notice p{
                font-size: 14px;
            }
            .updated.notice.heroic-theme-notice h3{
                margin: 0;
            }
            div.heroic-theme-notice.updated {
                border-left-color: #ee591f;
            }
            .heroic-theme-content{
                padding: 0 0 1.2rem 3.57rem;
            }
        </style>
    <?php
    }
    add_action('admin_enqueue_scripts','heroic_notice_style');
}

// Hook the AJAX action for logged-in users
add_action('wp_ajax_heroic_check_plugin_status', 'heroic_check_plugin_status');

function heroic_check_plugin_status() {
    if (!current_user_can('install_plugins')) {
        wp_send_json_error('You do not have permission to manage plugins.');
        return;
    }

    if (!isset($_POST['plugin_slug'])) {
        wp_send_json_error('No plugin slug provided.');
        return;
    }

    $plugin_slug = sanitize_text_field($_POST['plugin_slug']);
    $plugin_main_file = $plugin_slug . '/' . $plugin_slug . '.php'; // Adjust this based on your plugin structure

    // Check if the plugin exists
    $plugins = get_plugins();
    if (isset($plugins[$plugin_main_file])) {
        if (is_plugin_active($plugin_main_file)) {
            wp_send_json_success(array('status' => 'activated'));
        } else {
            wp_send_json_success(array('status' => 'installed'));
        }
    } else {
        wp_send_json_success(array('status' => 'not_installed'));
    }
}

// Existing AJAX installation function for installing and activating
add_action('wp_ajax_heroic_install_activate_plugin', 'heroic_install_and_activate_plugin');

function heroic_install_and_activate_plugin() {
    if (!current_user_can('install_plugins')) {
        wp_send_json_error('You do not have permission to install plugins.');
        return;
    }

    if (!isset($_POST['plugin_url'])) {
        wp_send_json_error('No plugin URL provided.');
        return;
    }

    // Include necessary WordPress files for plugin installation
    include_once(ABSPATH . 'wp-admin/includes/file.php');
    include_once(ABSPATH . 'wp-admin/includes/misc.php');
    include_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');

    $plugin_url = esc_url($_POST['plugin_url']);
    $plugin_slug = sanitize_text_field($_POST['plugin_slug']);
    $plugin_main_file = $plugin_slug . '/' . $plugin_slug . '.php'; // Ensure this matches your plugin structure

    // Download the plugin file
    WP_Filesystem();
    $temp_file = download_url($plugin_url);

    if (is_wp_error($temp_file)) {
        wp_send_json_error($temp_file->get_error_message());
        return;
    }

    // Unzip the plugin to the plugins folder
    $plugin_folder = WP_PLUGIN_DIR;
    $result = unzip_file($temp_file, $plugin_folder);
    
    // Clean up temporary file
    unlink($temp_file);

    if (is_wp_error($result)) {
        wp_send_json_error($result->get_error_message());
        return;
    }

    // Activate the plugin if it was installed
    $activate_result = activate_plugin($plugin_main_file);

    

    // Return success with redirect URL
    wp_send_json_success(array('redirect_url' => admin_url('admin.php?page=heroic-welcome')));
}

// Enqueue JavaScript for the button functionality
add_action('admin_enqueue_scripts', 'heroic_enqueue_plugin_installer_script',11);

function heroic_enqueue_plugin_installer_script(){
    global $hook_suffix;
    wp_dequeue_script('quality-plugin-installer-js');
    wp_enqueue_script('heroic-plugin-installer-js',  HEROIC_TEMPLATE_DIR_URI . '/admin/assets/js/plugin-installer.js', array('jquery'), null, true);
    wp_localize_script('heroic-plugin-installer-js', 'pluginInstallerAjax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'hook_suffix' => $hook_suffix,
        'nonce' => wp_create_nonce('plugin_installer_nonce'),

    ));
}