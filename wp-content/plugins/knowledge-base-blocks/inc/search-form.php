<?php
/**
 * Server-side rendering of the `kbg/search-form` block.
 *
 */

/**
 * Registers the `kbg/search-form` block on the server.
 */
add_action( 'init', 'register_block_kbg_search_form' );

function register_block_kbg_search_form() {
	register_block_type(
		'kbg/search-form',
		array(
			'attributes' => array(
				"placeholder" => array(
					"type"=> "string",
					"default" => "Ask a question here...",
				),
				"buttonText" =>  array(
					"type"=> "string",
					"default" => "Search",
				),
				"buttonUseIcon" => array(
					"type" => "boolean",
					"default" => false
				),
				"searchType" =>  array(
					"type"=> "string",
					"default" => "big",
				),
				"preSearchMenu" =>  array(
					"type"=> "boolean",
					"default" => false,
				),
				"preSearchMenuLabel" =>  array(
					"type"=> "string",
					"default" => "",
				),
			),
			'render_callback' => 'render_block_kbg_search_form',
		)
	);
}


/**
 * Dynamically renders the `core/search` block.
 *
 * @param array $attributes The block attributes.
 *
 * @return string The search block markup.
 */
function render_block_kbg_search_form( $attributes ) {
	static $instance_id = 0;

	$input_id        = 'wp-block-search__input-' . ++$instance_id;
	$classnames      = classnames_for_block_kbg_search( $attributes );
	$use_icon_button = ( ! empty( $attributes['buttonUseIcon'] ) ) ? true : false;
	$input_markup    = '';
	$button_markup   = '';
	$pre_search_markup   = '';
	$show_input      =  true;
	$show_button     =  true;

	if ( $show_input ) {
		$input_markup = sprintf(
			'<input type="search" id="%s" class="wp-block-search__input" name="s" value="%s" placeholder="%s" required />',
			$input_id,
			esc_attr( get_search_query() ),
			esc_attr( $attributes['placeholder'] )
		);
	}

	if ( $show_button ) {
		$button_internal_markup = '';
		$button_classes         = '';

		if ( ! $use_icon_button ) {
			if ( ! empty( $attributes['buttonText'] ) ) {
				$button_internal_markup = $attributes['buttonText'];
			}
		} else {
			$button_classes        .= 'has-icon';
			$button_internal_markup =
				'<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M13.5 6C10.5 6 8 8.5 8 11.5c0 1.1.3 2.1.9 3l-3.4 3 1 1.1 3.4-2.9c1 .9 2.2 1.4 3.6 1.4 3 0 5.5-2.5 5.5-5.5C19 8.5 16.5 6 13.5 6zm0 9.5c-2.2 0-4-1.8-4-4s1.8-4 4-4 4 1.8 4 4-1.8 4-4 4z"></path></svg>';
		}

		$button_markup = sprintf(
			'<button type="submit" class="wp-block-search__button %s">%s</button>',
			$button_classes,
			$button_internal_markup
		);
	}

	$field_markup       = sprintf(
		'<div class="wp-block-search__inside-wrapper">%s</div>',
		$input_markup . $button_markup
	);

	if ( $attributes['preSearchMenu'] ) {

		$menu_label = isset( $attributes['preSearchMenuLabel'] ) && !empty( $attributes['preSearchMenuLabel'] ) ? '<span>'. $attributes['preSearchMenuLabel'] .'</span>' : '';

		$pre_search_markup = '<div class="kbg-pre-search">' . $menu_label . wp_nav_menu( array( 'theme_location' => 'kbg_pre_search_menu', 'container'=> 'nav', 'menu_class' => 'kbg-pre-search-menu', 'echo' => false ) ) .'</div>';
	}
	
	$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => $classnames ) );

	return sprintf(
		'<div %s><form role="search" method="get" action="%s">%s</form>%s</div>',
		$wrapper_attributes,
		esc_url( home_url( '/' ) ),
		$field_markup,
		$pre_search_markup
	);
}



/**
 * Builds the correct top level classnames for the 'core/search' block.
 *
 * @param array $attributes The block attributes.
 *
 * @return string The classnames used in the block.
 */
function classnames_for_block_kbg_search( $attributes ) {
	$classnames = array();

	$classnames[] = 'wp-block-search';
	$classnames[] = 'kbg-' . $attributes['searchType'];

	if ( ! empty( $attributes['searchType'] ) ) {
		if ( 'small' === $attributes['searchType'] || 'big' === $attributes['searchType'] ) {
			$classnames[] = 'wp-block-search__button-inside';
		}

		if ( 'boxed' === $attributes['searchType'] ) {
			$classnames[] = 'wp-block-search__button-outside';
		}

	}

	if ( isset( $attributes['buttonUseIcon'] ) ) {
		if ( $attributes['buttonUseIcon'] ) {
			$classnames[] = 'wp-block-search__icon-button';
		} else {
			$classnames[] = 'wp-block-search__text-button';
		}
	}

	return implode( ' ', $classnames );
}
