<?php
/**
 * Helpers
 *
 * @package KB_CPT
 */

namespace Kbg\KB_CPT;




/**
 * Get knowledge base meta data
 *
 * @param unknown $field specific option key
 * @return mixed meta data value or set of values
 * @since  1.5
 */
function kb_get_meta( $term_id = false, $field = false ) {

	$defaults = array(
		'imageUrl' => '',
		'iconUrl' => '',
	);

	if ( $term_id ) {
		$meta = get_term_meta( $term_id, '_kbg_buddy_meta', true );
		$meta = wp_parse_args( (array) $meta, $defaults );
	} else {
		$meta = $defaults;
	}

	if ( $field ) {
		if ( isset( $meta[$field] ) ) {
			return $meta[$field];
		} else {
			return false;
		}
	}

	return $meta;
}


/**
 * Sort items
 *
 * @return array 
 * @since  1.0
 */
if ( ! function_exists( 'kb_sort_option_items' ) ) :
	function kb_sort_option_items( $items, $selected, $field = 'term_id' ) {
		
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
 * Get term slugs by term names for specific taxonomy
 *
 * @param string  $names List of tag names separated by comma
 * @param string  $tax   Taxonomy name
 * @return array List of slugs
 * @since  1.0
 */

if ( !function_exists( 'kb_get_tax_term_slug_by_name' ) ):
	function kb_get_tax_term_slug_by_name( $names, $tax = 'post_tag' ) {

		if ( empty( $names ) ) {
			return '';
		}

		$slugs = array();
		$names = explode( ",", $names );

		foreach ( $names as $name ) {
			$tag = get_term_by( 'name', trim( $name ), $tax );

			if ( !empty( $tag ) && isset( $tag->slug ) ) {
				$slugs[] = $tag->slug;
			}
		}

		return $slugs;

	}
endif;


/**
 * Get term names by term slugs for specific taxonomy
 *
 * @param array   $slugs List of tag slugs
 * @param string  $tax   Taxonomy name
 * @return string List of names separrated by comma
 * @since  1.0
 */

if ( !function_exists( 'kb_get_tax_term_name_by_slug' ) ):
	function kb_get_tax_term_name_by_slug( $slugs, $tax = 'post_tag' ) {

		if ( empty( $slugs ) ) {
			return '';
		}

		$names = array();

		foreach ( $slugs as $slug ) {
			$tag = get_term_by( 'slug', trim( $slug ), $tax );
			if ( !empty( $tag ) && isset( $tag->name ) ) {
				$names[] = $tag->name;
			}
		}

		if ( !empty( $names ) ) {
			$names = implode( ",", $names );
		} else {
			$names = '';
		}

		return $names;

	}
endif;

/**
 * Get the list of time limit options
 *
 * @return array List of available options
 * @since  1.0
 */

if ( !function_exists( 'kb_get_time_diff_opts' ) ) :
	function kb_get_time_diff_opts() {

		$options = array(
			'-1 day' => esc_html__( '1 Day', 'kbg' ),
			'-3 days' => esc_html__( '3 Days', 'kbg' ),
			'-1 week' => esc_html__( '1 Week', 'kbg' ),
			'-1 month' => esc_html__( '1 Month', 'kbg' ),
			'-3 months' => esc_html__( '3 Months', 'kbg' ),
			'-6 months' => esc_html__( '6 Months', 'kbg' ),
			'-1 year' => esc_html__( '1 Year', 'kbg' ),
			'0' => esc_html__( 'All time', 'kbg' )
		);
		$options = apply_filters('kb_modify_time_diff_opts', $options ); //Allow child themes or plugins to modify
		return $options;
	}
endif;
