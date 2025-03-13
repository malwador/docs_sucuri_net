<?php
/**
 * Blocks Helper.
 *
 * @package Meks Blocks
 */

namespace Kbg\Kbg_Buddy;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Blocks_Helper' ) ) {

	/**
	 * Class Blocks_Helper.
	 */
	final class Blocks_Helper {


		/**
		 * Member Variable
		 *
		 * @since 0.0.1
		 * @var instance
		 */
		private static $instance;

		/**
		 * Member Variable
		 *
		 * @since 0.0.1
		 * @var instance
		 */
		public static $block_list;


		/**
		 *  Initiator
		 *
		 * @since 0.0.1
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		public function __construct() {

			if ( ! defined( 'FS_CHMOD_FILE' ) ) {
				define( 'FS_CHMOD_FILE', ( fileperms( ABSPATH . 'index.php' ) & 0777 | 0644 ) );
			}

			require KBG_DIR . 'inc/class-config.php';
			self::$block_list      = Blocks_Config::get_block_attributes();

			add_filter( 'redirect_canonical', array( $this, 'override_canonical' ), 1, 2 );
		}

		/**
		 * Parse Gutenberg Block.
		 *
		 * @param string $content the content string.
		 * @since 1.1.0
		 */
		public function parse( $content ) {

			global $wp_version;

			return ( version_compare( $wp_version, '5', '>=' ) ) ? parse_blocks( $content ) : gutenberg_parse_blocks( $content );
		}


		/**
		 * Returns Query.
		 *
		 * @param array  $attributes The block attributes.
		 * @param string $block_type The Block Type.
		 * @since 1.8.2
		 */
		public static function get_query( $attributes, $block_type ) {

			$query_args = array(
				'posts_per_page'      => ( isset( $attributes['postsToShow'] ) ) ? $attributes['postsToShow'] : 6,
				'post_status'         => 'publish',
				'post_type'           => ( isset( $attributes['postType'] ) ) ? $attributes['postType'] : 'post',
				'order'               => ( isset( $attributes['order'] ) ) ? $attributes['order'] : 'desc',
				'orderby'             => ( isset( $attributes['orderBy'] ) ) ? $attributes['orderBy'] : 'date',
				'ignore_sticky_posts' => 1,
				'paged'               => 1,
			);

			if ( $attributes['excludeCurrentPost'] ) {
				$query_args['post__not_in'] = array( get_the_ID() );
			}

			if ( isset( $attributes['categories'] ) && '' !== $attributes['categories'] ) {
				$query_args['tax_query'][] = array(
					'taxonomy' => ( isset( $attributes['taxonomyType'] ) ) ? $attributes['taxonomyType'] : 'category',
					'field'    => 'id',
					'terms'    => $attributes['categories'],
					'operator' => 'IN',
				);
			}

			if ( 'grid' === $block_type && isset( $attributes['postPagination'] ) && true === $attributes['postPagination'] ) {

				if ( get_query_var( 'paged' ) ) {

					$paged = get_query_var( 'paged' );

				} elseif ( get_query_var( 'page' ) ) {

					$paged = get_query_var( 'page' );

				} else {

					$paged = 1;

				}
				$query_args['posts_per_page'] = $attributes['postsToShow'];
				$query_args['paged']          = $paged;

			}

			if ( 'masonry' === $block_type && isset( $attributes['paginationType'] ) && 'none' !== $attributes['paginationType'] && isset( $attributes['paged'] ) ) {

				$query_args['paged'] = $attributes['paged'];

			}

			$query_args = apply_filters( "kbg_post_query_args_{$block_type}", $query_args, $attributes );

			return new \WP_Query( $query_args );
		}

		/**
		 * Returns Knowledge Base Query.
		 *
		 * @param array  $attributes The block attributes.
		 * @param string $block_type The Block Type.
		 * @since 1.8.2
		 */
		public static function get_kbg_category_knowledge_base_query( $attributes ) {

			$terms = $attributes['terms'];

			$categories = get_terms( array(
				'post_type' => 'knowledge_base',
				'taxonomy' => 'kbg_category',
				'hide_empty' => true,
			) );

			$new_items = array();

			foreach ( $terms as $term ) {
				foreach ( $categories as $category ) {
					if ( $term['state'] && $term['slug'] == $category->slug ) {
						$new_items[] = $category;
					}
				}
			}


			$new_items = apply_filters( "kbg_category_knowledge_base_query_args", $new_items, $attributes );

			return $new_items;
		}

		/**
		 * Get size information for all currently-registered image sizes.
		 *
		 * @global $_wp_additional_image_sizes
		 * @uses   get_intermediate_image_sizes()
		 * @link   https://codex.wordpress.org/Function_Reference/get_intermediate_image_sizes
		 * @since  1.9.0
		 * @return array $sizes Data for all currently-registered image sizes.
		 */
		public static function get_image_sizes() {

			global $_wp_additional_image_sizes;

			$sizes       = get_intermediate_image_sizes();
			$image_sizes = array();

			$image_sizes[] = array(
				'value' => 'full',
				'label' => esc_html__( 'Full', 'kbg' ),
			);

			foreach ( $sizes as $size ) {
				if ( in_array( $size, array( 'thumbnail', 'medium', 'medium_large', 'large' ), true ) ) {
					$image_sizes[] = array(
						'value' => $size,
						'label' => ucwords( trim( str_replace( array( '-', '_' ), array( ' ', ' ' ), $size ) ) ),
					);
				} else {
					$image_sizes[] = array(
						'value' => $size,
						'label' => sprintf(
							'%1$s (%2$sx%3$s)',
							ucwords( trim( str_replace( array( '-', '_' ), array( ' ', ' ' ), $size ) ) ),
							$_wp_additional_image_sizes[ $size ]['width'],
							$_wp_additional_image_sizes[ $size ]['height']
						),
					);
				}
			}

			$image_sizes = apply_filters( 'kbg_post_featured_image_sizes', $image_sizes );

			return $image_sizes;
		}

		/**
		 * Get Post Types.
		 *
		 * @since 1.11.0
		 * @access public
		 */
		public static function get_post_types() {

			$post_types = get_post_types(
				array(
					'public'       => true,
					'show_in_rest' => true,
				),
				'objects'
			);

			$options = array();

			foreach ( $post_types as $post_type ) {
				if ( 'product' === $post_type->name ) {
					continue;
				}

				if ( 'attachment' === $post_type->name ) {
					continue;
				}

				$options[] = array(
					'value' => $post_type->name,
					'label' => $post_type->label,
				);
			}

			return apply_filters( 'kbg_loop_post_types', $options );
		}

		/**
		 * Get all taxonomies.
		 *
		 * @since 1.11.0
		 * @access public
		 */
		public static function get_related_taxonomy() {

			$post_types = self::get_post_types();

			$return_array = array();

			foreach ( $post_types as $key => $value ) {
				$post_type = $value['value'];

				$taxonomies = get_object_taxonomies( $post_type, 'objects' );
				$data       = array();

				foreach ( $taxonomies as $tax_slug => $tax ) {
					if ( ! $tax->public || ! $tax->show_ui || ! $tax->show_in_rest ) {
						continue;
					}

					$data[ $tax_slug ] = $tax;

					$terms = get_terms( $tax_slug );

					$related_tax = array();

					if ( ! empty( $terms ) ) {
						foreach ( $terms as $t_index => $t_obj ) {
							$related_tax[] = array(
								'id'   => $t_obj->term_id,
								'name' => $t_obj->name,
							);
						}

						$return_array[ $post_type ]['terms'][ $tax_slug ] = $related_tax;
					}
				}

				$return_array[ $post_type ]['taxonomy'] = $data;
			}

			return apply_filters( 'kbg_post_loop_taxonomies', $return_array );
		}


		/**
		 * Checks to see if the site has SSL enabled or not.
		 *
		 * @since 1.14.0
		 * @return bool
		 */
		public static function is_ssl() {
			if (
				is_ssl() ||
				( 0 === stripos( get_option( 'siteurl' ), 'https://' ) ) ||
				( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && 'https' === $_SERVER['HTTP_X_FORWARDED_PROTO'] )
			) {
				return true;
			}
			return false;
		}


		/**
		 * Disable canonical on Single Post.
		 *
		 * @param  string $redirect_url  The redirect URL.
		 * @param  string $requested_url The requested URL.
		 * @since  1.14.9
		 * @return bool|string
		 */
		public function override_canonical( $redirect_url, $requested_url ) {

			global $wp_query;

			if ( is_array( $wp_query->query ) ) {

				if ( true === $wp_query->is_singular
					&& - 1 === $wp_query->current_post
					&& true === $wp_query->is_paged
				) {
					$redirect_url = false;
				}
			}

			return $redirect_url;
		}


		public static function get_template( $template ){
			$template_slug = rtrim($template, '.php');
			$template = $template_slug . '.php';

			$theme_file = locate_template( array('/template-parts/kb/layouts/'.$template) );

			if ( file_exists( $theme_file ) ) :
				$file = $theme_file;
			else :
				$file = KBG_DIR . 'template-parts/kb/layouts/' . $template;
			endif;
	
			return $file;
		}

		/**
		 * Get knowledge base meta data
		 *
		 * @param unknown $field specific option key
		 * @return mixed meta data value or set of values
		 * @since  1.5
		 */

		public static function kbg_get_knowledge_base_meta( $term_id = false, $field = false ) {

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
		 * Get knowledge base category taxonomies 
		 *
		 * @return array meta data value or set of values
		 * @since  1.0
		 */

		public static function kbg_get_cpt_category_terms() {

			$args = array(
				'post_type' => 'knowledge_base',
				'taxonomy' => 'kbg_category',
				'hide_empty' => true,
			);

			$terms = get_terms( $args );
			$new_terms = [];

			if ( !empty( $terms ) && !is_wp_error( $terms )  ) {
				foreach( $terms as $key => $term ) {
					$new_terms[$key]['name'] = $term->name;
					$new_terms[$key]['slug'] = $term->slug;
					$new_terms[$key]['id'] = $term->term_id;
					$new_terms[$key]['state'] = true;
				}
			}

			return $new_terms;
		}

		
		/**
		 * Get knowledge base meta data
		 *
		 * @param unknown $field specific option key
		 * @return mixed meta data value or set of values
		 * @since  1.5
		 */

		public static function kbg_get_knowledge_base_post_list( $term_id, $attributes ) {

			$args = array(
				'post_type' => 'knowledge_base',
				'posts_per_page' => $attributes['postsToShow'],
				'orderby' => $attributes['postsOrder'],
				'order' => \strtoupper($attributes['postsSort']),
				'tax_query' => array(
					array(
						'taxonomy' => 'kbg_category',
						'field'    => 'id',
						'terms'    => $term_id,
						'operator' => 'IN',
					)
				)

			);

			return new \WP_Query( $args );
		}
		
		/**
		 * Get sidebar layouts
		 *
		 * @since  1.0
		 */

		public static function kbg_get_sidebar_layouts() {

			return $radioImageOptions = [
				1 => (object)[
					'optionMatch'=> 1,
					'value'=> 'none',
					'label'=> 'None',
					'preview'=> KBG_URL . 'assets/img/admin/sidebar_none.svg',
				],
				2 => (object)[
					'optionMatch'=> 2,
					'value'=> 'left',
					'label'=> 'Left',
					'preview'=> KBG_URL . 'assets/img/admin/sidebar_left.svg',
				],
				3 => (object)[
					'optionMatch'=> 3,
					'value'=> 'right',
					'label'=> 'Right',
					'preview'=> KBG_URL . 'assets/img/admin/sidebar_right.svg',
				]
			];
		
		}

		/**
		 * Get images for editor
		 *
		 * @since  1.0
		 */

		public static function kbg_get_admin_images() {

			return [
				'search_box_icon' => KBG_URL . 'assets/img/admin/search-icon.png',
				'contact_box_icon' => KBG_URL . 'assets/img/admin/contact-icon.png',
				'contact_box_image' => KBG_URL . 'assets/img/admin/contact-image-small.jpg',
				'contact_box_image_large' => KBG_URL . 'assets/img/admin/contact-image-large.png',
				'block_image_preview'   => KBG_URL . 'assets/img/admin/block-image.jpg',
				'block_icon_preview'   => KBG_URL . 'assets/img/admin/block-icon.jpg',
				'block_list_preview'   => KBG_URL . 'assets/img/admin/block-list.jpg',
				'block_search_preview'   => KBG_URL . 'assets/img/admin/block-search.jpg',
				'block_contact_preview'   => KBG_URL . 'assets/img/admin/block-contact.jpg',
				'block_faq_preview'   => KBG_URL . 'assets/img/admin/block-faq.jpg',
			];
		
		}


	}


	/**
	 *  Prepare if class 'Blocks_Helper' exist.
	 *  Kicking this off by calling 'get_instance()' method
	 */
	Blocks_Helper::get_instance();

}
