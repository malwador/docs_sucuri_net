<?php
/**
 * Plugin Name: Knowledge Base Post Type 
 * Plugin URI:  https://mekshq.com
 * Description: CPT Knowledge Base and Custom Widgets ( Knowledge Base Category widget, Knowledge Base Article widget, Default Post widget with featured image )
 * Version:     1.0.0
 * Author:      MeksHQ
 * Author URI:  https://mekshq.com
 * Text Domain: kbg
 * Domain Path: /languages
 * License:     
 * License URI: 
 * @package KB_CPT
 */

namespace Kbg\KB_CPT;

//  Exit if accessed directly.
defined('ABSPATH') || exit;

define( 'KB_CPT_FILE', __FILE__ );
define( 'KB_CPT_ROOT', dirname( plugin_basename( KB_CPT_FILE ) ) );
define( 'KB_CPT_BASE', plugin_basename( KB_CPT_FILE ) );
define( 'KB_CPT_DIR', plugin_dir_path( KB_CPT_FILE ) );
define( 'KB_CPT_URL', plugins_url( '/', KB_CPT_FILE ) );
define( 'KB_CPT_VER', '1.0.0' );

// Helpers
include KB_CPT_DIR . '/inc/helpers.php';

// CTP
include KB_CPT_DIR . '/inc/register-cpt.php';

// Widgets
include KB_CPT_DIR . '/inc/widgets.php';

// Enqueue
include KB_CPT_DIR . '/inc/enqueue.php';

if ( is_admin() ) {
	/* Update API */
	require_once KB_CPT_DIR . 'inc/update.php';
}
