<?php
/**
 * Plugin Name: Quick Answers - WordPress Ajax Search
 * Plugin URI:  https://mekshq.com
 * Description: Find instantly what you need with Ajax Search Plugin
 * Version:     1.0.0
 * Author:      MeksHQ
 * Author URI:  https://mekshq.com
 * Text Domain: qa
 * Domain Path: /languages
 * License:
 * License URI:
 *
 * @package Quick_Answers
 */

namespace QA\Quick_Answers;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

define( 'QA_FILE', __FILE__ );
define( 'QA_ROOT', dirname( plugin_basename( QA_FILE ) ) );
define( 'QA_BASE', plugin_basename( QA_FILE ) );
define( 'QA_DIR', plugin_dir_path( QA_FILE ) );
define( 'QA_URL', plugins_url( '/', QA_FILE ) );
define( 'QA_VER', '1.0.0' );

// Helpers
require QA_DIR . '/inc/helpers.php';

// Enqueue JS and CSS
require QA_DIR . '/inc/enqueue.php';

// DB
require QA_DIR . '/inc/admin/class.searches-db.php';

// Ajax
require QA_DIR . '/inc/ajax.php';

if ( is_admin() ) {

    //allow redirection, even if my theme starts to send output to the browser
    add_action('init', __NAMESPACE__ . '\do_output_buffer');
    function do_output_buffer() {
        ob_start();
    }

    require QA_DIR . '/inc/admin/class.options.php';
    require QA_DIR . '/inc/admin/class.searches-page.php';
    require QA_DIR . '/inc/admin/class.searches-table.php';
    require QA_DIR . '/inc/admin/enqueue.php';

    /* Update API */
	require_once QA_DIR . 'inc/admin/update.php';
}


add_action( 'plugins_loaded', __NAMESPACE__ . '\load_textdomain' );

function load_textdomain() {
    load_plugin_textdomain( 'quick-answers-ajax-search', false, QA_DIR . '/languages' );
}
