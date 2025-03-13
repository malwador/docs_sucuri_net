<?php
/**
 * Plugin Name: Article Feedback / Reaction Box 
 * Plugin URI:  https://mekshq.com
 * Description: Collect data from your posts/articles ( custom post types ) about use satisfaction.
 * Version:     1.0.0
 * Author:      MeksHQ
 * Author URI:  https://mekshq.com
 * Text Domain: article-feedback
 * Domain Path: /languages
 * License:     
 * License URI: 
 * @package AF
 */

namespace AF\Article_Feedback;

//  Exit if accessed directly.
defined('ABSPATH') || exit;

define( 'AF_FILE', __FILE__ );
define( 'AF_ROOT', dirname( plugin_basename( AF_FILE ) ) );
define( 'AF_BASE', plugin_basename( AF_FILE ) );
define( 'AF_DIR', plugin_dir_path( AF_FILE ) );
define( 'AF_URL', plugins_url( '/', AF_FILE ) );
define( 'AF_VER', '1.0.0' );

// Helpers
require AF_DIR . 'inc/helpers.php';

// Enqueue JS and CSS
require AF_DIR . '/inc/enqueue.php';

// Ajax
require AF_DIR . '/inc/ajax.php';

// Template Function
require AF_DIR . '/inc/template-functions.php';

// Extensions
require AF_DIR . '/inc/extension.php';

if ( is_admin() ) {
    require AF_DIR . '/inc/admin/enqueue.php';
    require AF_DIR . 'inc/admin/extension.php';
    require AF_DIR . 'inc/admin/class.options.php';
    require AF_DIR . 'inc/admin/update.php';
}

add_action( 'plugins_loaded', __NAMESPACE__ . '\load_textdomain' );

function load_textdomain() {
    load_plugin_textdomain( 'article-feedback', false, AF_DIR . '/languages' );
}
