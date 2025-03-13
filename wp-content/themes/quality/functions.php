<?php
/* * Theme Name : Quality
 * Theme Core Functions and Codes
 */
/* * Includes reqired resources here* */
define('QUALITY_TEMPLATE_DIR_URI', get_template_directory_uri());
define('QUALITY_TEMPLATE_DIR', get_template_directory());
define('QUALITY_THEME_FUNCTIONS_PATH', QUALITY_TEMPLATE_DIR . '/functions');
define('QUALITY_THEME_OPTIONS_PATH', QUALITY_TEMPLATE_DIR_URI . '/functions/theme_options');

require( QUALITY_THEME_FUNCTIONS_PATH . '/menu/new_Walker.php'); //NEW Walker Class Added.  
require( QUALITY_THEME_FUNCTIONS_PATH . '/menu/default_menu_walker.php');

require_once( QUALITY_THEME_FUNCTIONS_PATH . '/scripts/scripts.php');     //Theme Scripts And Styles    

require( QUALITY_THEME_FUNCTIONS_PATH . '/commentbox/comment-function.php'); //Comment Handling
require( QUALITY_THEME_FUNCTIONS_PATH . '/widget/custom-sidebar.php'); //Sidebar Registration
//Customizer
require( QUALITY_THEME_FUNCTIONS_PATH . '/customizer/customizer-pro-feature.php');
require( QUALITY_THEME_FUNCTIONS_PATH . '/customizer/customizer-general.php');
require( QUALITY_THEME_FUNCTIONS_PATH . '/customizer/customizer-slider.php');
require( QUALITY_THEME_FUNCTIONS_PATH . '/customizer/customizer-copyright.php');
require( QUALITY_THEME_FUNCTIONS_PATH . '/customizer/customizer-blog.php');
require( QUALITY_THEME_FUNCTIONS_PATH . '/customizer/customizer-archive.php');
require( QUALITY_THEME_FUNCTIONS_PATH . '/customizer/customizer_recommended_plugin.php');
require( QUALITY_THEME_FUNCTIONS_PATH . '/customizer/customizer_import_data.php');
require( QUALITY_THEME_FUNCTIONS_PATH . '/breadcrumbs/breadcrumbs.php');
require_once('theme_setup_data.php');
require( QUALITY_TEMPLATE_DIR . '/class-tgm-plugin-activation.php');

require( QUALITY_THEME_FUNCTIONS_PATH . '/template-tags.php');

function quality_register_required_plugins() {
    /*
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
        // This is an example of how to include a plugin from the WordPress Plugin Repository.
        array(
            'name' => esc_html__('Contact Form 7', 'quality'),
            'slug' => 'contact-form-7',
            'required' => false,
        ),
        array(
            'name' => esc_html__('WooCommerce','quality'),
            'slug' => 'woocommerce',
            'required' => false,
        ),
        array(
            'name' => esc_html__('Carousel, Recent Post Slider and Banner Slider','quality'),
            'slug' => 'spice-post-slider',
            'required' => false,
        ),
        array(
            'name' => esc_html__('Seo Optimized Images','quality'),
            'slug' => 'seo-optimized-images',
            'required' => false,
        )

    );

    /*
     * Array of configuration settings. Amend each line as needed.
     *
     * TGMPA will start providing localized text strings soon. If you already have translations of our standard
     * strings available, please help us make TGMPA even better by giving us access to these translations or by
     * sending in a pull-request with .po file(s) with the translations.
     *
     * Only uncomment the strings in the config array if you want to customize the strings.
     */
    $config = array(
        'id' => 'tgmpa', // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '', // Default absolute path to bundled plugins.
        'menu' => 'tgmpa-install-plugins', // Menu slug.
        'has_notices' => true, // Show admin notices or not.
        'dismissable' => true, // If false, a user cannot dismiss the nag message.
        'dismiss_msg' => '', // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false, // Automatically activate plugins after installation or not.
        'message' => '', // Message to output right before the plugins table.
    );

    tgmpa($plugins, $config);
}

add_action('tgmpa_register', 'quality_register_required_plugins');

//$repeater_path = trailingslashit(get_template_directory()) . '/functions/customizer-repeater/functions.php';
//if (file_exists($repeater_path)) {
//    require_once( $repeater_path );
//}

//wp title tag starts here
function quality_head($title, $sep) {
    global $paged, $page;
    if (is_feed())
        return $title;
    // Add the site name.
    $title .= esc_html(get_bloginfo('name'));
    // Add the site description for the home/front page.
    $site_description = esc_html(get_bloginfo('description'));
    if ($site_description && ( is_home() || is_front_page() ))
        $title = "$title $sep $site_description";
    // Add a page number if necessary.
    if ($paged >= 2 || $page >= 2)
        $title = "$title $sep " . sprintf(esc_html_e('Page', 'quality'), max($paged, $page));
    return $title;
}

add_filter('wp_title', 'quality_head', 10, 2);

add_action('after_setup_theme', 'quality_setup');

function quality_setup() {
    require_once('child_theme_compatible.php');  
    //content width
    if (!isset($content_width))
        $content_width = 700; //In PX

        
// Load text domain for translation-ready
    load_theme_textdomain('quality', QUALITY_TEMPLATE_DIR . '/languages');
    add_theme_support('post-thumbnails'); //supports featured image
    // This theme uses wp_nav_menu() in one location.
    register_nav_menu('primary', __('Primary Menu', 'quality')); //Navigation
    // theme support    
    add_theme_support('automatic-feed-links');

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    //Title tag
    add_theme_support("title-tag");

    // woocommerce support
    add_theme_support('woocommerce');

    // Woocommerce Gallery Support
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    //Custom logo

    add_theme_support('custom-logo', array(
        'height' => 49,
        'width' => 153,
        'flex-height' => true,
        'header-text' => array('site-title', 'site-description'),
    ));

    require_once('theme_setup_data.php');
    // setup admin pannel defual data for index page        
    $quality_options = quality_theme_data_setup();

    //About Theme
    $theme = wp_get_theme(); // gets the current theme
    if ('Quality' == $theme->name  || $theme->name == 'Quality orange' || $theme->name == 'Quality blue' || $theme->name == 'Quality green') {
        if (is_admin()) {
            require get_template_directory() . '/admin/admin-init.php';
        }
    }
}

// Read more tag to formatting in blog page 
function quality_new_content_more($more) {
    global $post;
    return '<p><a href="' . esc_url(get_permalink()) . "#more-{$post->ID}\" class=\"more-link\">" . esc_html__('Read More', 'quality') . "</a></p>";
}

add_filter('the_content_more_link', 'quality_new_content_more');

function quality_customizer_css() {
    wp_enqueue_style('quality-customizer-info', QUALITY_TEMPLATE_DIR_URI . '/css/pro-feature.css');
}

add_action('admin_init', 'quality_customizer_css');

add_filter("the_excerpt", "quality_add_class_to_excerpt");

function quality_add_class_to_excerpt($excerpt) {
    return str_replace('<p', '<p class="qua-blog-post-description"', $excerpt);
}

if (!function_exists('wp_body_open')) {

    function wp_body_open() {
        do_action('wp_body_open');
    }

}
the_tags();
//customizer sanitize_callback checkbox box function
function quality_sanitize_checkbox($checked) {
    // Boolean check.
    return ( ( isset($checked) && true == $checked ) ? 1 : 0 );
}

    //radio box sanitization function
    function quality_sanitize_radio($input, $setting) {

        $input = sanitize_key($input);

        $choices = $setting->manager->get_control($setting->id)->choices;

        //return if valid 
        return ( array_key_exists($input, $choices) ? $input : $setting->default );
    }
    
    
    add_filter('wp_get_attachment_image_attributes', function($attr) {
    if (isset($attr['class']) && 'custom-logo' === $attr['class'])
        $attr['class'] = 'custom-logo';
    return $attr;
});

add_filter('get_custom_logo', 'quality_change_logo_class');

function quality_change_logo_class($quality_html) {
    $quality_html = str_replace('custom-logo-link', 'navbar-brand', $quality_html);
    return $quality_html;
}

//Custom CSS compatibility
$quality_current_options = wp_parse_args(get_option('quality_pro_options', array()), quality_theme_data_setup());
if ($quality_current_options['webrit_custom_css'] != '' && $quality_current_options['webrit_custom_css'] != 'nomorenow') {
    $quality_css = '';
    $quality_css .= $quality_current_options['webrit_custom_css'];
    $quality_css .= (string) wp_get_custom_css(get_stylesheet());
    $quality_current_options['webrit_custom_css'] = 'nomorenow';
    update_option('quality_pro_options', $quality_current_options);
    wp_update_custom_css_post($quality_css, array());
}

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function quality_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- js/skip-link-focus-fix.js`.
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'quality_skip_link_focus_fix' );
?>
<?php 
/**
* Enqueue theme fonts.
*/
function quality_theme_fonts() {
    $fonts_url = quality_get_fonts_url();
    // Load Fonts if necessary.
    if( $fonts_url ) {
        require_once get_theme_file_path( 'wptt-webfont-loader.php' );
        wp_enqueue_style( 'quality-theme-fonts', wptt_get_webfont_url( $fonts_url ), array(), '20201110' );
    }
}
add_action( 'wp_enqueue_scripts', 'quality_theme_fonts' );
add_action( 'enqueue_block_editor_assets', 'quality_theme_fonts' );
/**
 * Retrieve webfont URL to load fonts locally.
 */
function quality_get_fonts_url() {
    $font_families = array(
        'Raleway:400,600,700,800',
		'Roboto: 100,300,400,500,600,700,800,900',   
        'Open Sans: 100,300,400,500,600,700,800,900', 		
    );
    $query_args = array(
        'family'  => urlencode( implode( '|', $font_families ) ),
        'subset'  => urlencode( 'latin,latin-ext' ),
        'display' => urlencode( 'swap' ),
    );
    return apply_filters( 'quality_get_fonts_url', add_query_arg( $query_args, 'https://fonts.googleapis.com/css' ) );
}

$quality_theme = wp_get_theme();
if( $quality_theme->name == 'Quality' || $quality_theme->name == 'Quality child' || $quality_theme->name == 'Quality Child'  || $quality_theme->name == 'Quality orange'  || $quality_theme->name == 'Quality orange child'  || $quality_theme->name == 'Quality orange Child'  || $quality_theme->name == 'Quality blue'  || $quality_theme->name == 'Quality blue child'  || $quality_theme->name == 'Quality blue Child'  || $quality_theme->name == 'Quality green'  || $quality_theme->name == 'Quality green child'  || $quality_theme->name == 'Quality green Child' ) {
    // Notice to add required plugin
    function quality_admin_plugin_notice_warn() {
        $theme_name = wp_get_theme();
        if ( get_option( 'dismissed-quality_comanion_plugin', false ) ) {
           return;
        }
        if ( function_exists('webriti_companion_activate')) {
            return;
        }?>

        <div class="updated notice is-dismissible quality-theme-notice">

            <div class="owc-header">
                <h2 class="theme-owc-title">               
                    <svg height="60" width="60" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 70 70"><defs><style>.cls-1{font-size:33px;font-family:Verdana-Bold, Verdana;font-weight:700;}</style></defs><title>Artboard 1</title><text class="cls-1" transform="translate(-0.56 51.25)">WC</text></svg>
                    <?php echo esc_html('Webriti Companion','quality');?>
                </h2>
            </div>

            <div class="quality-theme-content">
                <h3><?php printf (esc_html__('Thank you for installing the %1$s theme.', 'quality'), esc_html($theme_name)); ?></h3>

                <p><?php esc_html_e( 'We highly recommend you to install and activate the', 'quality' ); ?>
                    <b><?php esc_html_e( 'Webriti Companion', 'quality' ); ?></b> plugin.
                    <br>
                    <?php esc_html_e( 'This plugin will unlock enhanced features to build a beautiful website.', 'quality' ); ?>
                </p>
                <button id="install-plugin-button-welcome-page" data-plugin-url="<?php echo esc_url( 'https://webriti.com/extensions/webriti-companion.zip');?>"><?php echo esc_html__( 'Install', 'quality' ); ?></button>
            </div>
        </div>
        
        <script type="text/javascript">
            jQuery(function($) {
            $( document ).on( 'click', '.quality-theme-notice .notice-dismiss', function () {
                var type = $( this ).closest( '.quality-theme-notice' ).data( 'notice' );
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
    add_action( 'admin_notices', 'quality_admin_plugin_notice_warn' );
    add_action( 'wp_ajax_dismissed_notice_handler', 'quality_ajax_notice_handler');

    function quality_ajax_notice_handler() {
        update_option( 'dismissed-quality_comanion_plugin', TRUE );
    }

    function quality_notice_style(){?>
        <style type="text/css">
            label.tg-label.breadcrumbs img {
                width: 6%;
                padding: 0;
            }
            .quality-theme-notice .theme-owc-title{
                display: flex;
                align-items: center;
                height: 100%;
                margin: 0;
                font-size: 1.5em;
            }
            .quality-theme-notice p{
                font-size: 14px;
            }
            .updated.notice.quality-theme-notice h3{
                margin: 0;
            }
            div.quality-theme-notice.updated {
                border-left-color: #ee591f;
            }
            .quality-theme-content{
                padding: 0 0 1.2rem 3.57rem;
            }
        </style>
    <?php
    }
    add_action('admin_enqueue_scripts','quality_notice_style');
}

// Hook the AJAX action for logged-in users
add_action('wp_ajax_quality_check_plugin_status', 'quality_check_plugin_status');

function quality_check_plugin_status() {
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
add_action('wp_ajax_quality_install_activate_plugin', 'quality_install_and_activate_plugin');

function quality_install_and_activate_plugin() {
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
    wp_send_json_success(array('redirect_url' => admin_url('admin.php?page=quality-welcome')));
}

// Enqueue JavaScript for the button functionality
add_action('admin_enqueue_scripts', 'quality_enqueue_plugin_installer_script');

function quality_enqueue_plugin_installer_script() {
    global $hook_suffix;
    wp_enqueue_script('quality-plugin-installer-js',  QUALITY_TEMPLATE_DIR_URI . '/admin/assets/js/plugin-installer.js', array('jquery'), null, true);
    wp_localize_script('quality-plugin-installer-js', 'pluginInstallerAjax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'hook_suffix' => $hook_suffix,
        'nonce' => wp_create_nonce('plugin_installer_nonce'),

    ));
}
