<?php

/**
 * Ajax file
 *
 * @package AF
 */

namespace AF\Article_Feedback;

/**
 * Rate ajx action
 * 
 * @since 1.0.0
 */
add_action( 'wp_ajax_af_rate', __NAMESPACE__ . '\af_rate' );
add_action( 'wp_ajax_nopriv_af_rate', __NAMESPACE__ . '\af_rate' );

function af_rate() {

  $id = absint( $_POST['id'] );
  $answer = in_array( $_POST['answer'], array( 'yes', 'no' ) ) ? $_POST['answer'] : false;

  if ( !empty( $answer ) ) {

    $meta = af_get_meta( $id );

    $rate = $meta['rate'];
    $rate[$answer]++;
    $rate['percent'] = round( $rate['yes'] * 100 / ( $rate['yes'] + $rate['no'] ) );
    $meta['rate'] = $rate;

    update_post_meta( $id, '_af_meta', $meta );

    $options = af_get_db_options();
    $thank_you =  do_shortcode( $options['thank_you'] );
    $not_satisfied = do_shortcode( $options['not_satisfied'] );

    if ( $answer == 'yes' ) {
      $msg = wp_kses($thank_you, 'post');
    } else {
      $msg = wp_kses($not_satisfied, 'post');
    }

    wp_send_json_success(  json_encode( $msg ) );
  }

  exit;

}
