<?php
/**
 * Extensions
 *
 * @package AF
 */

namespace AF\Article_Feedback;


/**
 * Display article feedback box using the_content filter
 * 
 */

add_filter( 'the_content', __NAMESPACE__ . '\display_article_feedback' );

if ( ! function_exists( 'display_article_feedback' ) ) :
    function display_article_feedback( $content ) {

        global $post;
        $options = af_get_db_options();

        if ( !in_array( $post->post_type,  $options['post_types'] ) ) { 
            return $content;
        }

        switch ( $options['position'] ) {

            case 'above':
                return article_feedback() . $content;
                break;
    
            case 'bellow':
                return $content . article_feedback();
                break;
    
            case 'above_bellow':
                return article_feedback() . $content . article_feedback();
                break;
    
            default:
                break;
        }

        return $content;
    }
endif;
