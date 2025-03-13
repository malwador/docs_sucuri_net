<?php

/**
 * Helpers file
 *
 * @package AF
 */

namespace AF\Article_Feedback;

/**
 * Debug (log) function
 *
 * Outputs any content into log file in theme root directory
 *
 * @param mixed   $mixed Content to output
 * @since  1.0
 */

if ( ! function_exists( 'af_log' ) ) :
	function af_log( $mixed ) {

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
		$existing = $wp_filesystem->get_contents( AF_DIR . 'log' );
		$wp_filesystem->put_contents( AF_DIR . 'log', $existing . $mixed . PHP_EOL );
	}
endif;


/**
 * Get JS settings
 *
 * Function creates list of settings from theme options to pass
 * them to global JS variable so we can use it in JS files
 *
 * @return array List of JS settings
 * @since  1.0
 */

if ( ! function_exists( 'af_get_js_settings' ) ) :
	function af_get_js_settings() {
		$js_settings = array();

		// $options = get_option( 'af_settings' );
		// $defaults = array('search_characters' => '3', 'no_results' => 'No results found. Please try again with a different search term.');
		// $options = wp_parse_args( $options, $defaults );

		$protocol                               = is_ssl() ? 'https://' : 'http://';
		$js_settings['ajax_url']                = admin_url( 'admin-ajax.php', $protocol );
		$js_settings['current_ID'] 				= get_the_ID();

		$js_settings = apply_filters( 'af_modify_js_settings', $js_settings );

		return $js_settings;
	}
endif;

/**
 * Get article feedback meta
 *
 * @since  1.0
 */
if ( ! function_exists( 'af_get_meta' ) ) :
	function af_get_meta( $post_id, $field = false ) {

		$defaults = array(
			'rate' => array(
				'yes' => 0,
				'no' => 0,
				'percent' => 0
			)
		);

		$meta = get_post_meta( $post_id, '_af_meta', true );
		$meta = wp_parse_args( $meta, $defaults );

		if ( $field ) {
			if ( isset( $meta[$field] ) ) {
				return $meta[$field];
			} else {
				return false;
			}
		}

		return $meta;
	}
endif;

/**
 * Get plugin options
 *
 * @since  1.0
 */
if ( ! function_exists( 'af_get_db_options' ) ) :
	function af_get_db_options() {

		$defaults = array(
			'post_types' =>  array(),
            'position' => 'bellow',
            'title' => 'Was this article helpful?',
            'type' => 'button',
            'button_yes' => 'Yes',
            'button_no' => 'No',
            'hide_yes' => '0',
            'hide_no' => '0',
            'icon_type' => 'smiley',
            'thank_you' => '<p>Thank you for your feedback.</p>',
            'not_satisfied' => '<strong>Yikes!</strong> <span>Could you please let us know how we can help?</span> <a class="button" href="#">Contact us</a>'
		);

		$options = get_option( 'af_settings' );
		$options = wp_parse_args( $options, $defaults );

		return $options;
	}
endif;


/**
 * Check is Knowledge Base Guru theme active
 *
 * @since  1.0
 */
// function af_is_kbg_theme_active() {
// 	return defined( 'KBG_THEME_VERSION' );
// }

// /* Get JS Settings */
// function af_get_js_settings() {

// 	$js_settings = array();

// 	$current_docs = 0;

// 	if ( is_tax( 'af_knowledge_base' ) ) {

// 		$current_docs = get_queried_object_id();

// 	} else if ( is_singular( 'af_docs' ) || is_singular( 'af_faq' ) ) {
// 			$term = af_get_current_knowledge_base();
// 			$current_docs = $term->term_id;
// 		}

// 	$js_settings['knb_ajax_url'] = add_query_arg( array( 'action' => 'knb_search', 'current_docs' => $current_docs ), admin_url( 'admin-ajax.php' ) );
// 	$js_settings['ajax_url'] = admin_url( 'admin-ajax.php' );
// 	$js_settings['current_ID'] = get_the_ID();

// 	return $js_settings;
// }