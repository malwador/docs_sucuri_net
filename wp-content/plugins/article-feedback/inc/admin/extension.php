<?php
/**
 * Admin Extension
 *
 * @package AF
 */

namespace AF\Article_Feedback;


/**
 * Add row in table columns for rating feedback
 * 
 */

$options = af_get_db_options();

if ( !empty( $options['post_types'] ) ) {
    foreach( $options['post_types'] as $type ) {
        add_filter( 'manage_'. $type .'_posts_columns', __NAMESPACE__ . '\af_set_custom_columns' );
        add_action( 'manage_'. $type .'_posts_custom_column' , __NAMESPACE__ . '\af_custom_column', 10, 2 );
    }
}

function af_set_custom_columns( $columns ) {
  
    $columns['af_rating'] = 'Rating';
    return $columns;
}

function af_custom_column( $column, $post_id ) {

    switch ( $column ) {

        case 'af_rating' :

            $rate = af_get_meta( $post_id, 'rate' );

            if ( empty( $rate['percent'] ) && empty( $rate['yes'] ) && empty( $rate['no'] ) ) {
                echo 'None';
            } else {
                echo '<strong>'.$rate['percent'].'%</strong> ( <span class="af-green">'.$rate['yes'].'</span> / <span class="af-red">'.$rate['no'].'</span> )';
            }

            break;

    }
}
