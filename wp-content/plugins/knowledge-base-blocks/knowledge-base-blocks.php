<?php
/**
 * Plugin Name: Knowledge Base Blocks 
 * Plugin URI:  https://mekshq.com
 * Description: Special Gutenberg blocks for KnowledgeGuru theme
 * Version:     1.0.2
 * Author:      MeksHQ
 * Author URI:  https://mekshq.com
 * Text Domain: kbg
 * Domain Path: /languages
 * License:     
 * License URI: 
 * @package Kbg_Buddy
 */

namespace Kbg\Kbg_Buddy;

//  Exit if accessed directly.
defined('ABSPATH') || exit;

define( 'KBG_FILE', __FILE__ );
define( 'KBG_ROOT', dirname( plugin_basename( KBG_FILE ) ) );
define( 'KBG_BASE', plugin_basename( KBG_FILE ) );
define( 'KBG_DIR', plugin_dir_path( KBG_FILE ) );
define( 'KBG_URL', plugins_url( '/', KBG_FILE ) );
define( 'KBG_VER', '1.0.2' );

// Enqueue JS and CSS
include KBG_DIR . '/inc/enqueue.php';

// Extensions
include KBG_DIR . '/inc/extensions.php';

// Template functions
include KBG_DIR . '/inc/template-functions.php';

// Helpers
include KBG_DIR . '/inc/class-helpers.php';

// REST API
include KBG_DIR . '/inc/class-rest-api.php';

// Knowledge base
include KBG_DIR . '/inc/class-knowledge-base.php';

// Search form block - server rendering
include KBG_DIR . '/inc/search-form.php';

// Create Page Template
include KBG_DIR . '/inc/class-page-template.php';

if ( is_admin() ) {
	/* Update API */
	require_once KBG_DIR . 'inc/update.php';
}
