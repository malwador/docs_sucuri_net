<?php

/**
 * Ajax file
 *
 * @package Quick_Answers
 */

namespace QA\Quick_Answers;

/**
 * Get searched term on ajax call for auto-complete functionality
 */
add_action( 'wp_ajax_qa_ajax_search', __NAMESPACE__ . '\qa_ajax_search' );
add_action( 'wp_ajax_nopriv_qa_ajax_search', __NAMESPACE__ . '\qa_ajax_search' );

if ( ! function_exists( 'qa_ajax_search' ) ) :

	function qa_ajax_search() {

        $s = trim( stripslashes( $_GET['term'] ) );
        
		$defaults = array( 'description' => 0, 'include_types' => array( 'post', 'page' ) );
		$options = get_option( 'qa_settings' );
		$options = wp_parse_args( $options, $defaults );

		if ( qa_is_kbg_theme_active() ) {
			$options['include_types'] = kbg_get_option('search_archive_include_types');
		}
		
		$query_args = array(
			's'              => $s,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'post_type'      => $options['include_types'],
		);

		$query = new \WP_Query( $query_args );


        $results = array();

		if ( $query->have_posts() ) {

			while( $query->have_posts() ) {
				$query->the_post();

				$results[ $query->current_post ]['label']   = get_the_title();
				$results[ $query->current_post ]['link']    = get_permalink();
				$results[ $query->current_post ]['id']      = get_the_ID();
				$results[ $query->current_post ]['format']  = get_post_format() ? : 'standard';
				$results[ $query->current_post ]['excerpt'] = $options['description'] ? qa_get_excerpt( $options['description_limit'] ) : '';
			}
		
               
		} else {

			$results[0]['label']   = '';
			$results[0]['link']    = '';
			$results[0]['id']      = '';
			$results[0]['format']  = '';
			$results[0]['excerpt'] = '';

			Searches_DB::insert_searches($s);
		}

		$response = $_GET['callback'] . '(' . json_encode( $results ) . ')';

		echo wp_kses_post( $response );

		wp_die();

	}
endif;


/**
 * Update searches in editor
 */
add_action( 'wp_ajax_qa_update', __NAMESPACE__ . '\qa_update' );

if ( ! function_exists( 'qa_update' ) ) :

	function qa_update() {


		$id = absint( $_POST['id'] );
		$search_term = $_POST['search_term'];
		$tags = $_POST['tags'];
		$month = $_POST['month'];
		$day = $_POST['day'];
		$year = $_POST['year'];
		$hours = $_POST['hours'];
		$minutes = $_POST['minutes'];

		$date = $year .'-'. $month .'-'. $day .' '.  $hours .':'. $minutes .':00';
		$date = date("Y-m-d H:i:s", strtotime($date) );

		$data = [
			'terms' => $search_term,
			'tags' => $tags,
			'date' => $date,
			'id' => $id
		];
		
		Searches_DB::update_searches( $data );

		echo json_encode( $data );
		wp_die();

	}
endif;
