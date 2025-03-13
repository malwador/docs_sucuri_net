<?php

/**
 * Main get function for front-end display and checking
 *
 * It gets the value from our theme global variable which contains all the settings for the current template
 *
 * @param string  $option An option value to get
 * @param string  $part   An option part to get, i.e. if option is an array
 * @return mixed
 * @since  1.0
 */
if ( ! function_exists( 'kbg_get' ) ) :
	function kbg_get( $option = '', $part = '' ) {

		if ( empty( $option ) ) {
			return false;
		}

		$kbg = get_query_var( 'kbg' );

		if ( empty( $kbg ) ) {
			$kbg = kbg_templates_setup();
		}

		if ( ! empty( $part ) ) {

			if ( ! isset( $kbg[ $option ][ $part ] ) ) {
				return false;
			}

			return $kbg[ $option ][ $part ];
		}

		if ( isset( $kbg[ $option ] ) ) {
			return $kbg[ $option ];
		}

		return false;
	}
endif;


/**
 * Function to set a specific option/value to our global front-end settings variable
 *
 * @param string  $option name of the option to set
 * @param mixed   $value  option value
 * @return void
 * @since  1.0
 */

if ( ! function_exists( 'kbg_set' ) ) :
	function kbg_set( $option, $value ) {
		global $wp_query;
		$kbg = get_query_var( 'kbg', array() );
		if ( ! empty( $option ) ) {
			$kbg[ $option ] = $value;
			set_query_var( 'kbg', $kbg );
		}

	}
endif;


/**
 * Wrapper function for __()
 *
 * It checks if specific text is translated via options panel
 * If option is set, it returns translated text from theme options
 * If option is not set, it returns default translation string (from language file)
 *
 * @param string  $string_key Key name (id) of translation option
 * @return string Returns translated string
 * @since  1.0
 */

if ( ! function_exists( '__kbg' ) ) :
	function __kbg( $string_key ) {

		$translate = kbg_get_translate_options();

		if ( ! kbg_get_option( 'enable_translate' ) ) {
			return $translate[ $string_key ]['text'];
		}

		$translated_string = kbg_get_option( 'tr_' . $string_key );

		if ( isset( $translate[ $string_key ]['hidden'] ) && trim( $translated_string ) == '' ) {
			return '';
		}

		if ( $translated_string == '-1' ) {
			return '';
		}

		if ( ! empty( $translated_string ) ) {
			return $translated_string;
		}

		return $translate[ $string_key ]['text'];
	}
endif;


/**
 * Get featured image
 *
 * Function gets featured image depending on the size and post id.
 * If image is not set, it gets the default featured image placehloder from theme options.
 *
 * @param string  $size               Image size ID
 * @param bool    $ignore_default_img Wheter to apply default featured image if post doesn't have featured image
 * @param bool    $post_id            If is not provided it will pull the image from the current post
 * @return string Image HTML output
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_featured_image' ) ) :
	function kbg_get_featured_image( $size = 'full', $ignore_default_img = false, $post_id = false, $sid = true ) {

		if ( is_admin() ) return;

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}


		$sidebar = kbg_get( 'sidebar' );

		if ( $sidebar['position'] !== 'none' && $sid ) {
			$size .= '-sid';
		}

		if ( has_post_thumbnail( $post_id ) ) {

			return get_the_post_thumbnail( $post_id, $size );

		} elseif ( ! $ignore_default_img && ( $placeholder = kbg_get_option( 'default_fimg', 'image' ) ) ) {

			// If there is no featured image, try to get default placeholder from theme options

			global $placeholder_img, $placeholder_imgs;

			if ( empty( $placeholder_img ) ) {
				$img_id = kbg_get_image_id_by_url( $placeholder );
			} else {
				$img_id = $placeholder_img;
			}

			if ( ! empty( $img_id ) ) {
				if ( ! isset( $placeholder_imgs[ $size ] ) ) {
					$def_img = wp_get_attachment_image( $img_id, $size );
				} else {
					$def_img = $placeholder_imgs[ $size ];
				}

				if ( ! empty( $def_img ) ) {
					$placeholder_imgs[ $size ] = $def_img;

					return kbg_wp_kses( $def_img );
				}
			}

			return kbg_wp_kses( '<img src="' . esc_attr( $placeholder ) . '" class="size-' . esc_attr( $size ) . '" alt="' . esc_attr( get_the_title( $post_id ) ) . '" />' );
		}

		return '';
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

if ( ! function_exists( 'kbg_get_category_featured_image' ) ) :
	function kbg_get_category_featured_image( $size = 'full', $cat_id = false, $type ) {

		if ( empty( $cat_id ) ) {
			$cat_id = get_queried_object_id();
		}

		$img_html = '';

		$defaults = array(
			'imageUrl' => '',
			'iconUrl' => '',
		);

		if ( $cat_id ) {
			$meta = get_term_meta( $cat_id, '_kbg_buddy_meta', true );
			$meta = wp_parse_args( (array) $meta, $defaults );
		} 

		if ( $type == 'icon' ) {
			$img_url = $meta['iconUrl'];
		}
		
		if ( empty( $img_url ) ) {
			return false;
		} 
		
		$img_id = attachment_url_to_postid( $img_url );
		$img_html = wp_get_attachment_image( $img_id, $size );

		return kbg_wp_kses( $img_html );
	}
endif;



/**
 * Get meta data
 *
 * Function outputs meta data HTML
 *
 * @param array   $meta_data
 * @return string HTML output of meta data
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_meta_data' ) ) :
	function kbg_get_meta_data( $meta_data = array() ) {

		$output = '';

		if ( empty( $meta_data ) ) {
			return $output;
		}

		foreach ( $meta_data as $mkey ) {

			$meta = '';

			switch ( $mkey ) {

				case 'category':
					$meta = kbg_get_category();
					break;

				case 'date':
					$meta = '<span class="updated">' . get_the_date() . '</span>';
					break;

				case 'author':
					$author_id = get_post_field( 'post_author', get_the_ID() );
					$meta      = '<span class="vcard author">' . esc_html( __kbg( 'by' ) ) . ' <a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID', $author_id ) ) ) . '">' . get_the_author_meta( 'display_name' ) . '</a></span>';
					break;

				case 'rtime':
					$meta = kbg_read_time( get_post_field( 'post_content', get_the_ID() ) );
					if ( ! empty( $meta ) ) {
						$meta .= ' ' . esc_html( __kbg( 'min_read' ) );
					}
					break;

				case 'comments':
					if ( comments_open() || get_comments_number() ) {
						ob_start();
						$scroll_class = is_single() && is_main_query() ? 'kbg-scroll-animate' : '';
						comments_popup_link( esc_html(__kbg( 'no_comments' )), esc_html(__kbg( 'one_comment' )), esc_html(__kbg( 'multiple_comments' )), $scroll_class, '' );
						$meta = ob_get_contents();
						ob_end_clean();
					} else {
						$meta = '';
					}
					break;

				default:
					break;
			}

			if ( ! empty( $meta ) ) {
				$output .= '<span class="meta-item meta-' . $mkey . '">' . $meta . '</span>';
			}
		}

		return kbg_wp_kses( $output );

	}
endif;


/**
 * Get post categories
 *
 * Function outputs category links with HTML
 *
 * @param int     $post_id
 * @return string HTML output of category links
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_category' ) ) :
	function kbg_get_category( $post_id = false ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}

		$terms        = array();
		$taxonomy     = is_singular( 'knowledge_base' ) || is_tax( 'kbg_category' ) || is_post_type_archive( 'knowledge_base' ) ? 'kbg_category' : 'category';

		$can_primary_category = kbg_get_option( 'primary_category' ) && ! is_single() && kbg_is_yoast_active();
		$primary_category_id  = $can_primary_category ? get_post_meta( $post_id, '_yoast_wpseo_primary_category', true ) : false;
		

		if ( ! empty( $primary_category_id ) ) {
			$term = get_term( $primary_category_id, $taxonomy );
			if ( ! is_wp_error( $term ) && ! empty( $term ) ) {
				$terms[0] = $term;
			}
		}

		if ( empty( $terms ) ) {
			$terms = get_the_terms( $post_id, $taxonomy );
		}

		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			return '';
		}

		$links = array();

		foreach ( $terms as $term ) {
			$link = get_term_link( $term, $taxonomy );
			if ( ! is_wp_error( $link ) ) {
				$links[] = '<a href="' . esc_url( $link ) . '" rel="tag" class="cat-item cat-' . esc_attr( $term->term_id ) . '">' . $term->name . '</a>';
			}
		}

		if ( ! empty( $links ) ) {
			return kbg_wp_kses( implode( ',&nbsp;', $links ) );
		}

		return '';

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

if ( ! function_exists( 'kbg_get_excerpt' ) ) :
	function kbg_get_excerpt( $limit = 250 ) {

		$manual_excerpt = false;

		if ( has_excerpt() ) {
			$content        = get_the_excerpt();
			$manual_excerpt = true;
		} else {
			$text    = get_the_content( '' );
			$text    = strip_shortcodes( $text );
			$text    = apply_filters( 'the_content', $text );
			$content = str_replace( ']]>', ']]&gt;', $text );
		}

		if ( ! empty( $content ) ) {
			if ( ! empty( $limit ) || ! $manual_excerpt ) {
				$more    = kbg_get_option( 'more_string' );
				$content = wp_strip_all_tags( $content );
				$content = preg_replace( '/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $content );
				$content = kbg_trim_chars( $content, $limit, $more );
			}

			return kbg_wp_kses( wpautop( $content ) );
		}

		return '';

	}
endif;

/**
 * Get category excerpt
 *
 * Function outputs category excerpt
 *
 * @param string  $description
 * @param int     $limit Number of characters to limit excerpt
 * @return string HTML output of category links
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_category_description' ) ) :
	function kbg_get_category_description( $description, $limit = 250 ) {

		if ( !kbg_get_option( 'show_layout_description_excerpt' ) ) {
			return wpautop( $description );
		}

		$user_limit = kbg_get_option( 'show_layout_description_excerpt_limit' );

		if( !empty( $user_limit ) ) {
			$limit = $user_limit;
		}
		
		$text    = strip_shortcodes( $description );
		$text    = apply_filters( 'the_content', $text );
		$content = str_replace( ']]>', ']]&gt;', $text );

		if ( ! empty( $content ) ) {
			if ( ! empty( $limit ) ) {
				$more    = kbg_get_option( 'more_string' );
				$content = wp_strip_all_tags( $content );
				$content = preg_replace( '/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $content );
				$content = kbg_trim_chars( $content, $limit, $more );
			}

			return wpautop( $content );
		}

		return '';

	}
endif;

/**
 * Get branding
 *
 * Returns HTML of logo or website title based on theme options
 *
 * @param string  $use_mini_logo Whether to use mini logo
 * @return string HTML
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_branding' ) ) :
	function kbg_get_branding( $type = 'default' ) {

		//mobile. sticky. sidebar. default

		$use_mini_logo =  false;
		$use_alt_logo = false;

		switch ( $type ) {
		case 'mobile':
			$use_mini_logo = true;
			break;

		case 'sticky':

			if ( 'header_sticky_logo' == 'mini' ) {
				$use_mini_logo = true;
			}
			break;

		case 'sidebar':
			$use_mini_logo = true;
			break;

		default:
			break;
		}


		// Get all logos
		if ( !$use_alt_logo ) {
			$logo             = kbg_get_option( 'logo', 'image' );
			$logo_retina      = kbg_get_option( 'logo_retina', 'image' );
			$logo_mini        = kbg_get_option( 'logo_mini', 'image' );
			$logo_mini_retina = kbg_get_option( 'logo_mini_retina', 'image' );
		} else {
			$logo             = kbg_get_option( 'logo_alt', 'image' );
			$logo_retina      = kbg_get_option( 'logo_alt_retina', 'image' );
			$logo_mini        = kbg_get_option( 'logo_alt_mini', 'image' );
			$logo_mini_retina = kbg_get_option( 'logo_alt_mini_retina', 'image' );
		}

		$logo_text_class  = ''; // if there is no image we use textual class

		if ( empty( $logo_mini ) ) {
			$logo_mini = $logo;
		}

		if ( $use_mini_logo ) {
			$logo        = $logo_mini;
			$logo_retina = $logo_mini_retina;
		}

		if ( $type == 'sticky' && kbg_get_option('header_sticky_type') == 'custom' ) {
			$logo 		 = kbg_get_option( 'header_sticky_logo', 'image' );
			$logo_retina = kbg_get_option( 'header_sticky_logo_retina', 'image' );
			$logo_mini   = kbg_get_option( 'header_sticky_logo', 'image' );
			$logo_mini_retina = kbg_get_option( 'header_sticky_logo_retina', 'image' );
		}

		if ( empty( $logo ) ) {

			$brand           = get_bloginfo( 'name' );
			$logo_text_class = 'logo-img-none';

		} else {

			$grid = kbg_grid_vars();

			$brand  = '<picture class="kbg-logo">';
			$brand .= '<source media="(min-width: '.esc_attr( $grid['breakpoint']['md'] ).'px)" srcset="' . esc_attr( $logo );

			if ( ! empty( $logo_retina ) ) {
				$brand .= ', ' . esc_attr( $logo_retina ) . ' 2x';
			}

			$brand .= '">';
			$brand .= '<source srcset="' . esc_attr( $logo_mini );

			if ( ! empty( $logo_mini_retina ) ) {
				$brand .= ', ' . esc_attr( $logo_mini_retina ) . ' 2x';
			}

			$brand .= '">';
			$brand .= '<img src="' . esc_attr( $logo ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '">';
			$brand .= '</picture>';
		}

		$element   = is_front_page() && ! kbg_get( 'logo_is_displayed' ) ? 'h1' : 'span';
		$url       = kbg_get_option( 'logo_custom_url' ) ? kbg_get_option( 'logo_custom_url' ) : home_url( '/' );
		$site_desc = ! kbg_get( 'logo_is_displayed' ) && kbg_get_option( 'header_site_desc' ) ? '<span class="site-description d-none d-lg-block">' . get_bloginfo( 'description' ) . '</span>' : '';

		$output = '<' . esc_attr( $element ) . ' class="site-title h3 ' . esc_attr( $logo_text_class ) . '"><a href="' . esc_url( $url ) . '" rel="home">' . $brand . '</a></' . esc_attr( $element ) . '>' . $site_desc;

		kbg_set( 'logo_is_displayed', true );

		return apply_filters( 'kbg_modify_branding', $output );

	}
endif;


/**
 * Breadcrumbs
 *
 * Function provides support for several breadcrumb plugins
 * and gets its content to display on frontend
 *
 * @return string HTML output
 * @since  1.0
 */

if ( ! function_exists( 'kbg_breadcrumbs' ) ) :
	function kbg_breadcrumbs() {

		$has_breadcrumbs = kbg_get_option( 'breadcrumbs' );

		if ( $has_breadcrumbs == 'none' ) {
			return '';
		}

		$breadcrumbs = '';

		if ( $has_breadcrumbs == 'yoast' && function_exists( 'yoast_breadcrumb' ) ) {
			$breadcrumbs = yoast_breadcrumb( '<div class="kbg-breadcrumbs mb--md"><div class="row"><div class="col-12">', '</div></div></div>', false );
		}

		if ( $has_breadcrumbs == 'bcn' && function_exists( 'bcn_display' ) ) {
			$breadcrumbs = '<div class="kbg-breadcrumbs mb--md">' . bcn_display( true ) . '</div>';
		}

		return $breadcrumbs;
	}
endif;

/**
 * Get author social links
 *
 * @param int     $author_id ID of an author/user
 * @return string HTML output of social links
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_author_links' ) ) :
	function kbg_get_author_links( $author_id, $archive_link = true, $social = true ) {

		$output = '';

		if ( $archive_link ) {

			$output .= '<a href="' . esc_url( get_author_posts_url( $author_id, get_the_author_meta( 'user_nicename', $author_id ) ) ) . '" class="kbg-button button-tertiary button-small">' . esc_html( __kbg( 'author_view_all' ) ) . '</a>';
		}

		if ( $social ) {

			if ( $url = get_the_author_meta( 'url', $author_id ) ) {
				$output .= '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener" class="kbg-button"><i class="kbg-icon kg kg-website"></i></a>';
			}

			$social = kbg_get_social();

			if ( ! empty( $social ) ) {
				foreach ( $social as $id => $name ) {
					if ( $social_url = get_the_author_meta( $id, $author_id ) ) {

						if ( $id == 'twitter' ) {
							$social_url = ( strpos( $social_url, 'http' ) === false ) ? 'https://twitter.com/' . $social_url : $social_url;
						}

						$output .= '<a href="' . esc_url( $social_url ) . '" target="_blank" rel="noopener" class="kbg-button"><i class="fa fa-' . $id . '"></i></a>';
					}
				}
			}
		}

		return kbg_wp_kses( $output );
	}
endif;


/**
 * Generate related posts query
 *
 * Depending on post ID generate related posts using theme options
 *
 * @param int     $post_id
 * @return object WP_Query
 * @since  1.0
 */
if ( ! function_exists( 'kbg_get_related' ) ) :
	function kbg_get_related( $podcast = 'post', $post_id = false ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}

		$args['post_type']           = is_singular( 'knowledge_base' ) ? 'knowledge_base' : 'post';
		$args['ignore_sticky_posts'] = 1;

		// Exclude current post from query
		$args['post__not_in']  = array( $post_id );
		
		$what_related  = is_singular( 'knowledge_base' ) ? 'kb' : 'post';
	
		$num_posts = absint( kbg_get_option( 'single_' . $what_related . '_related_limit' ) );
		if ( $num_posts > 100 ) {
			$num_posts = 100;
		}
		$args['posts_per_page'] = $num_posts;
		
		$args['orderby'] = kbg_get_option( 'single_' . $what_related . '_related_order' );
		$args['order']   = 'DESC';

		if ( $args['orderby'] == 'title' ) {
			$args['order'] = 'ASC';
		}

		$post_related_type = kbg_get_option( 'single_post_related_type' );
		$knowledge_base_related_type = kbg_get_option( 'single_kb_related_type' );

		if ( $what_related == 'kb' ){	

			switch ( $knowledge_base_related_type ) {

				case 'cat':
					$cats = get_the_terms( $post_id, 'kbg_category' );
					$cat_terms = array();
					if ( ! empty( $cats ) ) {
						$cat_terms = wp_list_pluck($cats, 'term_id');
						$args['tax_query'] = array(
							array(
								'taxonomy' => 'kbg_category',
								'field'    => 'id',
								'terms'    => $cat_terms,
							)
						);
					}

					break;

				case 'tag':

					$tags = get_the_terms( $post_id, 'kbg_tags' );

					$tag_terms = array();
					if ( !empty( $tags ) ) {
						$tag_terms = wp_list_pluck($tags, 'term_id');

						$args['tax_query'] = array(
						array(
							'taxonomy' => 'kbg_tags',
							'field'    => 'id',
							'terms'    => $tag_terms,
						)
						);
					}

					break;

				case 'cat_and_tag':
					
					$cats = get_the_terms( $post_id, 'kbg_category' );
					$cat_terms = array();
					if ( !empty( $cats ) ) {
						$cat_terms = wp_list_pluck($cats, 'term_id');
					}

					$tags = get_the_terms( $post_id, 'kbg_tags' );
					$tag_terms = array();
					if ( !empty( $tags ) ) {
						$tag_terms = wp_list_pluck($tags, 'term_id');
					}

					$args['tax_query'] = array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'kbg_category',
							'field'    => 'id',
							'terms'    => $cat_terms,
						),
						array(
							'taxonomy' => 'kbg_tags',
							'field'    => 'id',
							'terms'    => $tag_terms,
						),
					);

					break;

				case 'cat_or_tag':

					$cats = get_the_terms( $post_id, 'kbg_category' );
					$cat_terms = array();
					if ( ! empty( $cats ) ) {
						$cat_terms = wp_list_pluck($cats, 'term_id');
					}

					$tags = get_the_terms( $post_id, 'kbg_tags' );
					$tag_terms = array();
					if ( ! empty( $tags ) ) {
						$tag_terms = wp_list_pluck($tags, 'term_id');
					}

					$args['tax_query'] = array(
						'relation' => 'OR',
						array(
							'taxonomy' => 'kbg_category',
							'field'    => 'id',
							'terms'    => $cat_terms,
						),
						array(
							'taxonomy' => 'kbg_tags',
							'field'    => 'id',
							'terms'    => $tag_terms,
						),
					);

					break;

				case 'author':
					global $post;
					$author_id      = isset( $post->post_author ) ? $post->post_author : 0;
					$args['author'] = $author_id;
					break;

				case 'default':
					break;
			}


		} else {

			switch ( $post_related_type ) {

				case 'cat':
					$cats     = get_the_category( $post_id );
					$cat_args = array();
					if ( ! empty( $cats ) ) {
						foreach ( $cats as $k => $cat ) {
							$cat_args[] = $cat->term_id;
						}
					}
					$args['category__in'] = $cat_args;
					break;

				case 'tag':
					$tags     = get_the_tags( $post_id );
					$tag_args = array();
					if ( ! empty( $tags ) ) {
						foreach ( $tags as $tag ) {
							$tag_args[] = $tag->term_id;
						}
					}
					$args['tag__in'] = $tag_args;
					break;

				case 'cat_and_tag':
					$cats     = get_the_category( $post_id );
					$cat_args = array();
					if ( ! empty( $cats ) ) {
						foreach ( $cats as $k => $cat ) {
							$cat_args[] = $cat->term_id;
						}
					}
					$tags     = get_the_tags( $post_id );
					$tag_args = array();
					if ( ! empty( $tags ) ) {
						foreach ( $tags as $tag ) {
							$tag_args[] = $tag->term_id;
						}
					}
					$args['tax_query'] = array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'category',
							'field'    => 'id',
							'terms'    => $cat_args,
						),
						array(
							'taxonomy' => 'post_tag',
							'field'    => 'id',
							'terms'    => $tag_args,
						),
					);
					break;

				case 'cat_or_tag':
					$cats     = get_the_category( $post_id );
					$cat_args = array();
					if ( ! empty( $cats ) ) {
						foreach ( $cats as $k => $cat ) {
							$cat_args[] = $cat->term_id;
						}
					}
					$tags     = get_the_tags( $post_id );
					$tag_args = array();
					if ( ! empty( $tags ) ) {
						foreach ( $tags as $tag ) {
							$tag_args[] = $tag->term_id;
						}
					}
					$args['tax_query'] = array(
						'relation' => 'OR',
						array(
							'taxonomy' => 'category',
							'field'    => 'id',
							'terms'    => $cat_args,
						),
						array(
							'taxonomy' => 'post_tag',
							'field'    => 'id',
							'terms'    => $tag_args,
						),
					);
					break;

				case 'author':
					global $post;
					$author_id      = isset( $post->post_author ) ? $post->post_author : 0;
					$args['author'] = $author_id;
					break;

				case 'default':
					break;
			}
		}

		$related_query = new WP_Query( $args );

		return $related_query;
	}
endif;


/**
 * Get post layout options
 * Return post layout params based on theme options
 *
 * @return string
 * @since  1.0
 */
if ( ! function_exists( 'kbg_get_post_layout_options' ) ) :
	function kbg_get_post_layout_options( $layout ) {
		$args = array();

		$archive_type = is_post_type_archive( 'knowledge_base' ) || is_tax( 'kbg_category' ) || is_search() ? 'kb_' : '';

		$args['meta']         = kbg_get_option( $archive_type . 'layout_' . $layout . '_meta' );
		$args['excerpt']      = kbg_get_option( $archive_type . 'layout_' . $layout . '_excerpt' ) ? kbg_get_option( $archive_type . 'layout_' . $layout . '_excerpt_limit' ) : false;
		$args['excerpt_type'] = $args['excerpt'] ? kbg_get_option( $archive_type . 'layout_' . $layout . '_excerpt_type' ) : 'auto';
		$args['rm']           = kbg_get_option( $archive_type . 'layout_' . $layout . '_rm' );
		$args['width']        = kbg_get_option( $archive_type . 'layout_' . $layout . '_width' );
		
		$args['align_class']  = 'justify-content-center';

		$args['is_kb_archive']  =  $archive_type == 'kb_';
		$args['post_format']    =  get_post_format() ? : 'standard';
		
		$args['entry_header_class']  =  $args['is_kb_archive'] ? 'd-flex' : '';

		$args = apply_filters( 'kbg_modify_post_layout_' . $layout . '_options', $args );

		return $args;
	}
endif;


/**
 * Check if is sidebar enabled
 *
 * @param string  $position_to_check sidebar position to check
 * @return bool
 * @since  1.0
 */

if ( ! function_exists( 'kbg_has_sidebar' ) ) :
	function kbg_has_sidebar( $position_to_check = 'right', $sidebar_name = 'sidebar' ) {

		$sidebar = kbg_get( $sidebar_name );

		if ( empty( $sidebar ) ) {
			return false;
		}

		if ( $sidebar['position'] != $position_to_check ) {
			return false;
		}

		return true;
	}
endif;


/**
 * Get bootstrap wrapper col class depending
 * on what layout is used
 *
 * @return string
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_loop_col_class' ) ) :
	function kbg_get_loop_col_class( $layout_id = 1, $type = 'default' ) {

		$has_sidebar_enabled = false;

		$params = kbg_get_post_layouts_map();
		$has_sidebar_enabled = kbg_get_option('archive_sidebar_display');
		$has_sidebar_enabled = is_category() && kbg_get_option('category_settings') == 'custom' ? kbg_get_option('category_sidebar_display') : $has_sidebar_enabled;
		
		if ( $type == 'kb' ) {
			$params = kbg_get_kb_layouts_map();
			$has_sidebar_enabled = kbg_get_option('kb_archive_sidebar_display');
			$has_sidebar_enabled = is_category() && kbg_get_option('kb_category_settings') == 'custom' ? kbg_get_option('kb_category_sidebar_display') : $has_sidebar_enabled;
		}

		if ( ! array_key_exists( $layout_id, $params ) ) {
			return '';
		}
		
		if ( $has_sidebar_enabled && ( isset( $params[ $layout_id ]['sidebar'] ) && $params[ $layout_id ]['sidebar'] )  ) {
			return 'col-lg-8';
		}else{
			return 'col-lg-8';
		}


		
		if ( isset( $params[ $layout_id ]['col'] ) && $params[ $layout_id ]['col']  ) {
			return $params[$layout_id]['col'];
		}

		return '';

	}
endif;


/**
 * Get loop layout params
 *
 * @param int     $layout_id
 * @param int     $loop_index current post in the loop
 * @return array set of parameters
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_loop_params' ) ) :
	function kbg_get_loop_params( $layout_id = 1, $loop_index = 0, $type = 'default' ) {

		$has_sidebar_enabled = false;
		
		$params = kbg_get_post_layouts_map();

		if ( $type == 'kb' ) {
			$params = kbg_get_kb_layouts_map();
		}

		if ( array_key_exists( $layout_id, $params ) ) {

			$layout = $params[ $layout_id ]['loop'];

			if ( count( $layout ) > $loop_index && ! is_paged() ) {
				return $layout[ $loop_index ];
			}

			return $layout[ count( $layout ) - 1 ];
		}

		return false;

	}
endif;

/**
 * Check if specified loop layout can display sidebar
 *
 * @param int     $layout_id
 * @param string  $loop_type
 * @return bool
 * @since  1.0
 */

if ( ! function_exists( 'kbg_loop_has_sidebar' ) ) :
	function kbg_loop_has_sidebar( $layout_id = 1, $loop_type = 'post' ) {

		$params = array();
		$params = kbg_get_post_layouts_map();

		if (  $loop_type == 'kb' ) {
			$params = kbg_get_kb_layouts_map();
		}

		if ( ! array_key_exists( $layout_id, $params ) ) {
			return false;
		}

		if ( isset( $params[ $layout_id ]['sidebar'] ) && $params[ $layout_id ]['sidebar'] ) {
			return true;
		}

		return false;

	}
endif;


/**
 * Get archive content
 *
 * Function gets parts of the archive content like ttitle, description, post count, etc...
 *
 * @return array Args
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_archive_content' ) ) :
	function kbg_get_archive_content( $part = false ) {

		global $wp_query;

		if ( ( is_home() && is_front_page() ) || ( is_home() && ! $wp_query->is_posts_page ) ) {
			return false;
		}

		$defaults = array(
			'avatar'      => '',
			'title'       => '',
			'meta'        => kbg_get_archive_posts_count(),
			'description' => '',
			'subnav'      => '',
		);

		$args = array();

		$title_prefix = '';

		if ( is_category() ) {

			$title_prefix        = esc_html( __kbg( 'category' ) );
			$args['title']       = single_cat_title( '', false );
			$args['description'] = category_description();

		} elseif ( is_tag() ) {
			$title_prefix        = esc_html( __kbg( 'tag' ) );
			$args['title']       = single_tag_title( '', false );
			$args['description'] = tag_description();

		} elseif ( is_author() ) {
			$title_prefix = esc_html( __kbg( 'author' ) );
			$args['title']       = get_the_author();
			$args['description'] = get_the_author_meta( 'description' );
			$args['avatar']      = get_avatar( get_the_author_meta( 'ID' ), 80 );
			$args['subnav']      = kbg_get_author_links( get_the_author_meta( 'ID' ), false );
			
		} elseif ( is_tax( 'kbg_category' ) ) {
			$title_prefix  = esc_html( __kbg( 'category' ) );
			$args['title'] = single_term_title( '', false );
			$args['description'] = term_description( get_queried_object_id(), 'kbg_category');

		} elseif ( is_tax() ) {
			$title_prefix  = kbg_get_archive_type() == 'post' ? esc_html( __kbg( 'archive' ) ) : esc_html( __kbg( 'show' ) );
			$args['title'] = single_term_title( '', false );

		} elseif ( is_search() ) {

			$args['title'] =  esc_html( __kbg( 'search_results_for' ) ) . ' <span class="archive-label">' .  esc_attr( get_search_query() ) . '</span>';

		} elseif ( is_day() ) {
			$title_prefix  = esc_html( __kbg( 'archive' ) );
			$args['title'] = get_the_date();

		} elseif ( is_month() ) {
			$title_prefix  = esc_html( __kbg( 'archive' ) );
			$args['title'] = get_the_date( 'F Y' );

		} elseif ( is_year() ) {
			$title_prefix  = esc_html( __kbg( 'archive' ) );
			$args['title'] = get_the_date( 'Y' );

		} elseif ( $wp_query->is_posts_page ) {
			$posts_page    = get_option( 'page_for_posts' );
			$args['title'] = get_the_title( $posts_page );

		} elseif ( is_post_type_archive( 'knowledge_base' ) ) {

			$args['title'] = post_type_archive_title( __kbg( 'archive' ), false );
			
		} elseif ( is_archive() ) {

			$args['title'] = esc_html( __kbg( 'archive' ) );
		}

		if ( $title_prefix ) {
			$args['title'] = '<span class="archive-label">' . $title_prefix . '</span>' . $args['title'];
		}

		$args = apply_filters( 'kbg_modify_archive_content', wp_parse_args( $args, $defaults ) );

		if ( $part && isset( $args[ $part ] ) ) {
			return $args[ $part ];
		}

		return $args;

	}
endif;


/**
 * Get media
 *
 * Function gets featured image
 *
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_single_media' ) ) :

	function kbg_get_single_media( $type = 'post', $before = '', $after = '' ) {

		$output = '';

		if ( kbg_get( 'fimg' ) && $fimg = kbg_get_featured_image( 'kbg-single-' . $type . '-' . kbg_get( 'layout' ), true, false, false ) ) {
			$output = $fimg;

			if ( kbg_get( 'fimg_cap' ) && $caption = get_post( get_post_thumbnail_id() )->post_excerpt ) {
				$output .= '<figure class="wp-caption-text">' . kbg_wp_kses( $caption ) . '</figure>';
			}
		}

		if ( empty( $output ) ) {
			return '';
		}

		return kbg_wp_kses( $before . $output . $after );

	}

endif;


/**
 * Check archive type base on selected taxonomy and terms (blog or podcast)
 * Use it on frontend and on backed (on category edit page to disable some posts layouts)
 *
 * @param int     $id Archive ID
 * @return bool
 * @since  1.0
 */

if ( ! function_exists( 'kbg_get_archive_type' ) ) :
	function kbg_get_archive_type( $id = false ) {

		if ( !function_exists( 'kbg_get_podcast_arguments' ) ) {
			return 'post';
		}

		$podcast_args = kbg_get_podcast_arguments();
		
		if ( ! $podcast_args['podcast']['shows'] ) {
			return 'post';
		}

		if ( empty( $id ) ) {
			$id = get_queried_object_id();
		}

		if ( is_tax( $podcast_args['podcast']['taxonomy'], array( $id ) ) || ( $podcast_args['podcast']['taxonomy'] == 'category' && is_category() ) ) {
		
			if ( $podcast_args['podcast']['operator'] == 'IN' ) {
				if ( $podcast_args['podcast']['terms'] == 'all' || in_array( $id, $podcast_args['podcast']['terms'] ) ) {
					return 'podcast';
				}
			} 
	
			if ( $podcast_args['podcast']['operator'] == 'NOT IN' ) {
				if (  $podcast_args['podcast']['terms'] != 'all' && !in_array( $id, $podcast_args['podcast']['terms'] ) ) {
					return 'podcast';
				}
			} 
		}

		return 'post';

	}
endif;


/**
 * Generate menu paceholder (if there is no menu set)
 *
 * @return string
 */
if ( ! function_exists( 'kbg_menu_placeholder' ) ) :
	function kbg_menu_placeholder( $label = '' ) {

		include locate_template( 'template-parts/general/header/elements/menu-placeholder.php', false, false );

	}
endif;


/**
 * Check if footer slots has some widgets
 *
 * @return int
 * @since  1.0
 */
if ( ! function_exists( 'kbg_has_footer_widgets' ) ) :
	function kbg_has_footer_widgets() {

        $footer_widgets = kbg_get( 'footer', 'widgets' );

        if ( !empty( $footer_widgets ) ) {
            foreach ( $footer_widgets as $i => $column ) {
                if ( is_active_sidebar( 'kbg_sidebar_footer_'.( $i+1 ) ) ) {
                    return true;
                }
            }
        }

		return false;
	}
endif;

/**
 * Check if subheader has elements
 *
 * @return boolean
 * @since  1.0
 */

if ( ! function_exists( 'kbg_has_subheader' ) ) :
	function kbg_has_subheader() {


		if ( !kbg_get( 'has_subheader' ) ) {
			return false;
		}

		if ( kbg_get( 'subheader_left' ) == 'none' && kbg_get( 'subheader_right' ) == 'none' ) {
			return false;
		}

		return true;
	}
endif;


/**
 * Display breadcrumbs
 *
 * @return void
 * @since  1.0
 */

if ( ! function_exists( 'kbg_the_breadcrumbs' ) ) :
	function kbg_the_breadcrumbs() {

		$type = kbg_get( 'subheader_breadcrumbs_type' );

		switch( $type ) {

			case 'yoast':
				if ( kbg_is_yoast_active() ) {
					yoast_breadcrumb( '<div id="yoast-breadcrumbs">','</div>' );  
				}
				break;
			case 'navxt':
				if ( kbg_is_breadcrumbs_navxt_active() ) {
					bcn_display( $return = false, $linked = true, $reverse = false, $force = false );
				}
				break;

			default:
				break;
		}
		
		return false;
	}
endif;
