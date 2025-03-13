<?php
/**
 * Extensions
 *
 * @package Meks Blocks
 */

namespace Kbg\Kbg_Buddy;

/**
 * Compatibility notice, disable plugin if theme isn;t active
 *
 * @since  1.0
 */
add_action( 'admin_init', __NAMESPACE__ . '\kb_compatibility' );

function kb_compatibility() {

	if ( is_admin() && current_user_can( 'activate_plugins' ) && !kbg_is_theme_active() ) {

		add_action( 'admin_notices', __NAMESPACE__ . '\kb_compatibility_notice' );

		deactivate_plugins( KBG_BASE );

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
	}
}

/**
 * Check is KBG theme active
 *
 * @since  1.0
 */
function kbg_is_theme_active() {
	return defined( 'KBG_THEME_VERSION' );
}

/**
 * Notice function
 *
 * @since  1.0
 */
function kb_compatibility_notice() {
	echo '<div class="notice notice-warning"><p><strong>Note:</strong> Knowledge Base Buddy plugin has been deactivated as it requires KnowledgeGuru Theme to be active.</p></div>';
}

/**
 * Register category for knowledge base blocks
 *
 * @since  1.0
 */

if ( version_compare( get_bloginfo('version'), '5.8', '>=' ) ) {
    add_filter( 'block_categories_all', __NAMESPACE__ . '\reorder_editor_block_categories', 10, 2 );
} else {
    add_filter( 'block_categories', __NAMESPACE__ . '\reorder_editor_block_categories', 10, 2 );
}

function _plugin_block_categories( $categories, $post ) {
    // if ( $post->post_type !== 'post' ) {
    //     return $categories;
    // }
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'kbg',
                'title' => __( 'Knowledge Base Blocks', 'kbg' ),
                'icon'  => 'dashicons-products',
            ),
        )
    );
}


/**
 * Reorder categories, make our category be first one
 *
 * @since  1.0
 */
if ( version_compare( get_bloginfo('version'), '5.8', '>=' ) ) {
    add_filter( 'block_categories_all', __NAMESPACE__ . '\reorder_editor_block_categories', 10, 2 );
} else {
    add_filter( 'block_categories', __NAMESPACE__ . '\reorder_editor_block_categories', 10, 2 );
}

function reorder_editor_block_categories( $categories, $post ) {
    $kbg_category = array(
      'slug' => 'kbg',
      'title' => __( 'Knowledge Base Blocks', 'kbg' ),
      //'icon'  => 'admin-home',
    );

    $reordered_categories[] = $kbg_category;

    foreach( $categories as $category ) {
        if ( $category['slug'] !== $kbg_category['slug'] ) {
            $reordered_categories[] = $category;
        }
    }

    return $reordered_categories;
}


/**
 * Register specific image sizes for blocks
 *
 * @since  1.0
 */
add_filter( 'kbg_add_image_sizes', __NAMESPACE__ . '\set_additional_image_sizes', 50 );

function set_additional_image_sizes( $sizes = true ) {
    
    $sizes['kbg-contact-icon'] = array(
        'title' => esc_html__( 'Block - Contact box icon 140x140', 'kbg' ),
        'w'     => 140,
        'h'     => 140,
        'crop'  => true,
    );

    $sizes['kbg-contact-image-small'] = array(
        'title' => esc_html__( 'Block - Contact box image 260px width', 'kbg' ),
        'w'     => 260,
        'h'     => 9999,
        'crop'  => false,
    );

    $sizes['kbg-contact-image'] = array(
        'title' => esc_html__( 'Block - Contact box image large 1102x500', 'kbg' ),
        'w'     => 1102,
        'h'     => 500,
        'crop'  => true,
    );

    $sizes['kbg-search-icon'] = array(
        'title' => esc_html__( 'Block - Search icon 430 width', 'kbg' ),
        'w'     => 430,
        'h'     => 99999,
        'crop'  => false,
    );

    $sizes['kbg-category-list-icon'] = array(
        'title' => esc_html__( 'Block - Category list icon', 'kbg' ),
        'w'     => 60,
        'h'     => 99999,
        'crop'  => false,
    );

    return $sizes;

}


/**
 * Filter new image sizes for selecting size in editor options
 *
 * @since  1.0
 */
add_filter( 'image_size_names_choose',  __NAMESPACE__ . '\set_custom_image_sizes_on_media_upload_object', 99 );

function set_custom_image_sizes_on_media_upload_object( $size_names ) {
    $new_sizes = array(
        'kbg-contact-icon' => __( 'Contact box icon 140x140', 'kbg'),
        'kbg-contact-image-small' => __( 'Contact box image 260x260', 'kbg'),
        'kbg-contact-image' => __( 'Contact box image large 1102x500'),
        'kbg-search-icon' => __( 'Search icon 430 width'),
        'kbg-category-list-icon' => __( 'Category list icon'),
    );
    return array_merge( $size_names, $new_sizes );
}



/**
 * Register pre search menu
 *
 * @since  1.0
 */
add_action( 'init', __NAMESPACE__ . '\register_pre_search_menu' );

function register_pre_search_menu() {
    
    register_nav_menu( 'kbg_pre_search_menu', esc_html__( 'Quick links menu (Search box block)' , 'kbg' ) );
}
