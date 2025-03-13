<?php

/**
 * Template Functions
 *
 * @package AF
 */

namespace AF\Article_Feedback;


/**
 * Display Article Feedback
 * 
 * @since  1.0.0
 */

if ( ! function_exists( 'article_feedback' ) ) :
	function article_feedback( $echo = false, $options = array() ) {

		if ( empty( $options ) ) {
			$options = af_get_db_options();
		}

		$label_yes = $options['type'] === 'icon' && $options['hide_yes'] ? '' : $options['button_yes'];
		$label_no  = $options['type'] === 'icon' && $options['hide_no'] ? '' : $options['button_no'];

		$svg_smiley_happy = file_get_contents( AF_URL . 'assets/image/smiley-happy.svg' );
		$svg_smiley_sad   = file_get_contents( AF_URL . 'assets/image/smiley-sad.svg' );
		$svg_thumbs_up 	  = file_get_contents( AF_URL . 'assets/image/thumbs-up.svg' );
		$svg_thumbs_down  = file_get_contents( AF_URL . 'assets/image/thumbs-down.svg' );

		$icon_yes = '';
		$icon_no = '';
		$classes = 'af-button';

		if ( $options['type'] === 'icon' ) {
			if (  $options['icon_type'] === 'smiley' ) {
				$icon_yes = $svg_smiley_happy;
				$icon_no = $svg_smiley_sad;
			} else {
				$icon_yes = $svg_thumbs_up;
				$icon_no = $svg_thumbs_down;
			}
			$classes = 'af-icon';
		} 

		$html = '<div class="af-kb-rate">
					<div class="af-kb-rate-wrapper">
						<strong>'. esc_html( $options['title'] ) .'</strong>
						<button class="af-rate af-yes '. esc_attr( $classes ) .'" data-answer="yes">'. $icon_yes .'<span>'. esc_html( $label_yes ) .'</span></button>
						<button class="af-rate af-no '. esc_attr( $classes ) .'" data-answer="no">'. $icon_no .'<span>'. esc_html( $label_no ) .'</span></button>
					</div>
				</div>';

		if ( $echo ) {
			echo $html;
			return;
		}

		return $html;
	}
endif;
