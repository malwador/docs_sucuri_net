<?php
/**
 * Template functions
 *
 * @package Kbg_Buddy
 */

namespace Kbg\Kbg_Buddy;


/**
 * Debug (log) function
 *
 * Outputs any content into log file in theme root directory
 *
 * @param mixed   $mixed Content to output
 * @since  1.0
 */

if ( ! function_exists( 'kbg_log' ) ) :
	function kbg_log( $mixed ) {

		if ( ! function_exists( 'WP_Filesystem' ) || ! WP_Filesystem() ) {
			return false;
		}

		if ( is_array( $mixed ) ) {
			$mixed = print_r( $mixed, 1 );
		} elseif ( is_object( $mixed ) ) {
				ob_start();
				var_dump( $mixed );
				$mixed = ob_get_clean();
		}

		global $wp_filesystem;
		$existing = $wp_filesystem->get_contents( KBG_DIR . 'log' );
		$wp_filesystem->put_contents( KBG_DIR . 'log', $existing . $mixed . PHP_EOL );
	}
endif;

/**
 * Function for escaping through WordPress's KSES API
 * wp_kses() and wp_kses_allowed_html()
 *
 * @param string $content
 * @param bool $echo
 * @return string
 * @since  1.0
 */
if ( ! function_exists( 'kbg_buddy_wp_kses' ) ) :
	function kbg_buddy_wp_kses( $content, $echo = false ) {

		$allowed_tags                  = wp_kses_allowed_html( 'post' );
		$allowed_tags['img']['srcset'] = array();
		$allowed_tags['img']['sizes']  = array();

		$tags = apply_filters( 'kbg_buddy_wp_kses_allowed_html', $allowed_tags );

		if ( ! $echo ) {
			return wp_kses( $content, $tags );
		}

		echo wp_kses( $content, $tags );

	}
endif;


/**
 * Get category featured image
 *
 * Function gets category featured image depending on the size
 *
 * @param string  $size   Image size ID
 * @param int     $cat_id
 * @return string Image HTML output
 * @since  1.0
 */

if ( ! function_exists( 'kbg_buddy_get_category_featured_image' ) ) :
	function kbg_buddy_get_category_featured_image( $size = 'full', $cat_id = false, $blockType ) {

		if ( empty( $cat_id ) ) {
			$cat_id = get_queried_object_id();
		}

		$img_html = '';

		if ( $blockType == 'image' ) {
			$img_url = Blocks_Helper::kbg_get_knowledge_base_meta( $cat_id, 'imageUrl' );
		} else if ( $blockType == 'list' ) {
			$img_url = Blocks_Helper::kbg_get_knowledge_base_meta( $cat_id, 'iconUrl' );
		} else {
			$size = 'full';
			$img_url = Blocks_Helper::kbg_get_knowledge_base_meta( $cat_id, 'iconUrl' );
		}
		
		if ( empty( $img_url ) ) {
			return false;
		} 
		
		$img_id = getIconIdByUrl( $img_url );
		$img_html = wp_get_attachment_image( $img_id, $size );

		return kbg_buddy_wp_kses( $img_html );
	}
endif;


/**
 * Sort items
 *
 * @return array 
 * @since  1.0
 */
if ( ! function_exists( 'kbg_buddy_sort_option_items' ) ) :
	function kbg_buddy_sort_option_items( $items, $selected, $field = 'term_id' ) {
		
		if ( empty( $selected ) ) {
			return $items;
		}

		$new_items = array();
		$temp_items = array();
		$temp_items_ids = array();

		foreach ( $selected as $selected_item_id ) {

			foreach ( $items as $item ) {
				if ( $selected_item_id == $item->$field ) {
					$new_items[] = $item;
				} else {
					if ( !in_array( $item->$field, $selected ) && !in_array( $item->$field, $temp_items_ids ) ) {
						$temp_items[] = $item;
						$temp_items_ids[] = $item->$field;
					}
				}
			}

		}

		$new_items = array_merge( $new_items, $temp_items );

		return $new_items;
	}
endif;


/**
 * Get the list of available options for post ordering
 *
 * @return array List of available options
 * @since  1.0
 */

if ( !function_exists( 'kbg_cpt_get_post_order_opts' ) ) :
	function kbg_cpt_get_post_order_opts() {

		$options = array(
			'date' => esc_html__( 'Date', 'kbg_cpt' ),
			'comment_count' => esc_html__( 'Number of comments', 'kbg_cpt' ),
			'views' => esc_html__( 'Number of views', 'kbg_cpt' ),
			'title'	=> esc_html__( 'Title (alphabetically)', 'kbg_cpt' ),
			'rand' => esc_html__( 'Random', 'kbg_cpt' ),
		);

		$options = apply_filters('kbg_cpt_modify_post_order_opts', $options ); //Allow child themes or plugins to modify
		return $options;
	}
endif;


/**
 * Get all registered sidebars for select option
 *
 * @return array List of available options
 * @since  1.0
 */

if ( ! function_exists( 'kbg_buddy_get_sidebars_list' ) ) :
	function kbg_buddy_get_sidebars_list( $inherit = false ) {

		$sidebars = array();

		if ( $inherit ) {
			$sidebars['inherit'] = esc_html__( 'Inherit', 'kbg' );
		}

		$sidebars['none'] = esc_html__( 'None', 'kbg' );

		global $wp_registered_sidebars;

		if ( ! empty( $wp_registered_sidebars ) ) {

			foreach ( $wp_registered_sidebars as $sidebar ) {
				$sidebars[ $sidebar['id'] ] = $sidebar['name'];
			}
		}
		// Get sidebars from wp_options if global var is not loaded yet
		$fallback_sidebars = get_option( 'kbg_registered_sidebars' );
		if ( ! empty( $fallback_sidebars ) ) {
			foreach ( $fallback_sidebars as $sidebar ) {
				if ( ! array_key_exists( $sidebar['id'], $sidebars ) ) {
					$sidebars[ $sidebar['id'] ] = $sidebar['name'];
				}
			}
		}

		// Check for theme additional sidebars
		$custom_sidebars = kbg_get_option( 'sidebars' );

		if ( $custom_sidebars ) {
			foreach ( $custom_sidebars as $k => $sidebar ) {
				if ( is_numeric( $k ) && ! array_key_exists( 'kbg_sidebar_' . $k, $sidebars ) ) {
					$sidebars[ 'kbg_sidebar_' . $k ] = $sidebar['name'];
				}
			}
		}

		// Do not display footer sidebars for selection
		unset( $sidebars['kbg_sidebar_footer_1'] );
		unset( $sidebars['kbg_sidebar_footer_2'] );
		unset( $sidebars['kbg_sidebar_footer_3'] );
		unset( $sidebars['kbg_sidebar_footer_4'] );

		// Do not display hidden sidebar for selection
		unset( $sidebars['kbg_sidebar_hidden'] );

		$sidebars = apply_filters( 'kbg_modify_sidebars_list', $sidebars );

		return $sidebars;
	}
endif;


/**
 * Get category icon ID from URL
 *
 * @return int|bool
 * @since  1.0.1
 */
if ( ! function_exists( 'getIconIdByUrl' ) ) :

	function getIconIdByUrl( $url ){
		global $wpdb;

		$image = attachment_url_to_postid( $url );

		if ( !empty( $image ) ) {
			return $image;
		}

		// If the URL is auto-generated thumbnail, remove the sizes and get the URL of the original image
		$url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif|svg)$)/i', '', $url );

		$image = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $url ));

		if( !empty($image) ) {
			return $image[0];
		}

		return false;
	}
endif;
