<?php

/**
 * Helpers file
 *
 * @package Quick_Answers
 */

namespace QA\Quick_Answers;

/**
 * Debug (log) function
 *
 * Outputs any content into log file in theme root directory
 *
 * @param mixed   $mixed Content to output
 * @since  1.0
 */

if ( ! function_exists( 'qa_log' ) ) :
	function qa_log( $mixed ) {

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
		$existing = $wp_filesystem->get_contents( QA_DIR . 'log' );
		$wp_filesystem->put_contents( QA_DIR . 'log', $existing . $mixed . PHP_EOL );
	}
endif;


/**
 * Get post excerpt
 *
 * Function outputs post excerpt for specific layout
 *
 * @param int     $limit Number of characters to limit excerpt
 * @return string HTML output of category links
 * @since  1.0
 */

if ( ! function_exists( 'qa_get_excerpt' ) ) :
	function qa_get_excerpt( $limit = 250 ) {

		$manual_excerpt = false;

		if ( has_excerpt() ) {
			$content        = get_the_excerpt();
			$manual_excerpt = true;
		} else {
			$text    = get_the_content();
			$text    = strip_shortcodes( $text );
			$text    = apply_filters( 'the_content', $text );
			$content = str_replace( ']]>', ']]&gt;', $text );
		}

		if ( ! empty( $content ) ) {
			if ( ! empty( $limit ) || ! $manual_excerpt ) {
				$more    = '...';
				$content = wp_strip_all_tags( $content );
				$content = preg_replace( '/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $content );
				$content = qa_trim_chars( $content, $limit, $more );
			}

			return wpautop( $content );
		}

		return '';

	}
endif;


/**
 * Trim chars of a string
 *
 * @param string  $string Content to trim
 * @param int     $limit  Number of characters to limit
 * @param string  $more   Chars to append after trimed string
 * @return string Trimmed part of the string
 * @since  1.0
 */

if ( ! function_exists( 'qa_trim_chars' ) ) :
	function qa_trim_chars( $string, $limit, $more = '...' ) {

		if ( ! empty( $limit ) ) {

			$text = trim( preg_replace( "/[\n\r\t ]+/", ' ', $string ), ' ' );
			preg_match_all( '/./u', $text, $chars );
			$chars = $chars[0];
			$count = count( $chars );

			if ( $count > $limit ) {

				$chars = array_slice( $chars, 0, $limit );

				for ( $i = ( $limit - 1 ); $i >= 0; $i-- ) {
					if ( in_array( $chars[ $i ], array( '.', ' ', '-', '?', '!' ) ) ) {
						break;
					}
				}

				$chars   = array_slice( $chars, 0, $i );
				$string  = implode( '', $chars );
				$string  = rtrim( $string, '.,-?!' );
				$string .= $more;
			}
		}

		return $string;
	}
endif;


/**
 * Get JS settings
 *
 * Function creates list of settings from thme options to pass
 * them to global JS variable so we can use it in JS files
 *
 * @return array List of JS settings
 * @since  1.0
 */

if ( ! function_exists( 'qa_get_js_settings' ) ) :
	function qa_get_js_settings() {
		$js_settings = array();

		$options = get_option( 'qa_settings' );
		$defaults = array('search_characters' => '3', 'no_results' => 'No results found. Please try again with a different search term.');
		$options = wp_parse_args( $options, $defaults );

		$protocol                               = is_ssl() ? 'https://' : 'http://';
		$js_settings['ajax_url']                = admin_url( 'admin-ajax.php', $protocol );
		$js_settings['search_characters_limit'] = $options['search_characters'];
		$js_settings['no_results_found'] 		= $options['no_results'];

		$js_settings = apply_filters( 'qa_modify_js_settings', $js_settings );

		return $js_settings;
	}
endif;


/**
 * Filter Function to set pre search menu 
 *
 * @since 1.3.2
 *
 * @return   $content
 */

//add_filter( 'the_content', __NAMESPACE__ . '\qa_gutenberg_search_filter', 9 );

if ( !function_exists( 'qa_gutenberg_search_filter' ) ) :

	function qa_gutenberg_search_filter( $content ) {

		$function_name =  function_exists( 'parse_blocks' ) ? 'parse_blocks' : 'gutenberg_parse_blocks';

		if ( empty( $content ) ) {
			$post = get_post();
			$content = $post->post_content;
		}

		$blocks = parse_blocks( $content );

		if ( empty( $blocks ) ) {
			return $content;
		}
		
		foreach ( $blocks as $block ) {
			
			
			print_r( $block );
			if ( $block['blockName'] == 'core/search' || $block['blockName'] == 'kbg/search-box' ) {
				

				$pattern = '/<\/form>/i';
				$replacement = '<span>Jovanovic</span></form>';

				$content = preg_replace( $pattern, $replacement, $content, 1 );

			}
		}

		return $content;
	}
endif;

/**
 * Check is Knowledge Base Guru theme active
 *
 * @since  1.0
 */
function qa_is_kbg_theme_active() {
	return defined( 'KBG_THEME_VERSION' );
}
