<?php
/**
 * Rest API.
 *
 * @package Meks Blocks
 */

namespace Kbg\Kbg_Buddy;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Blocks_Rest_API' ) ) {

	/**
	 * Class Blocks_Rest_API.
	 */
	final class Blocks_Rest_API {

		/**
		 * Member Variable
		 *
		 * @var instance
		 */
		private static $instance;

		/**
		 *  Initiator
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

			// Activation hook.
			add_action( 'rest_api_init', array( $this, 'blocks_register_rest_fields' ) );
			add_action( 'init', array( $this, 'register_rest_orderby_fields' ) );
		}

		/**
		 * Create API fields for additional info
		 *
		 * @since 0.0.1
		 */
		public function blocks_register_rest_fields() {
			
			$post_type = Blocks_Helper::get_post_types();

			foreach ( $post_type as $key => $value ) {
				// Add featured image source.
				register_rest_field(
					$value['value'],
					'kbg_buddy_featured_image_src',
					array(
						'get_callback'    => array( $this, 'get_image_src' ),
						'update_callback' => null,
						'schema'          => null,
					)
				);

				register_rest_field(
					'kbg_category',
					'imageUrl',
					array(
						'get_callback'    => array( $this, 'get_term_image_src' ),
						'update_callback' => null,
						'schema'          => null,
					)
				);

				register_rest_field(
					'kbg_category',
					'iconUrl',
					array(
						'get_callback'    => array( $this, 'get_term_icon_src' ),
						'update_callback' => null,
						'schema'          => null,
					)
				);

				// Get meta.
				register_rest_field(
					$value['value'],
					'kbg_buddy_meta',
					array(
						'get_callback'    => array( $this, 'get_page_meta' ),
						'update_callback' => array( $this, 'update_page_meta' ),
						'schema'          => null,
					)
				);

				// Get meta inherit
				register_rest_field(
					$value['value'],
					'kbg_buddy_meta_inherit',
					array(
						'get_callback'    => array( $this, 'get_page_meta_inherit' ),
						'update_callback' => null,
						'schema'          => null,
					)
				);

				// Get sidebars.
				register_rest_field(
					$value['value'],
					'kbg_buddy_sidebars',
					array(
						'get_callback'    => array( $this, 'get_sidebars' ),
						'update_callback' => null,
						'schema'          => null,
					)
				);

			}

		}

		/**
		 * Get featured image source for the rest field as per size
		 *
		 * @param object $object Post Object.
		 * @param string $field_name Field name.
		 * @param object $request Request Object.
		 * @since 0.0.1
		 */
		public function get_image_src( $object, $field_name, $request ) {
			$image_sizes = Blocks_Helper::get_image_sizes();

			$featured_images = array();

			if ( ! isset( $object['featured_media'] ) ) {
				return $featured_images;
			}

			foreach ( $image_sizes as $key => $value ) {
				$size = $value['value'];

				$featured_images[ $size ] = wp_get_attachment_image_src(
					$object['featured_media'],
					$size,
					false
				);
			}

			return $featured_images;
		}

		/**
		 * Get tax image source for the rest field as per size
		 *
		 * @param object $object Post Object.
		 * @param string $field_name Field name.
		 * @param object $request Request Object.
		 * @since 0.0.1
		 */
		public function get_term_image_src( $object, $field_name, $request ) {
			
			$featured_images = array();
			
			$image_sizes = Blocks_Helper::get_image_sizes();
			
			$terms = get_terms( array(
				'post_type' => 'knowledge_base',
				'taxonomy' => 'kbg_category',
				'hide_empty' => false,
			) );

			foreach ( $terms as $term ) {
				
				$meta = Blocks_Helper::kbg_get_knowledge_base_meta( $term->term_id );
				$image_id = getIconIdByUrl($meta['imageUrl']);

				foreach ( $image_sizes as $key => $value ) {
					$size = $value['value'];

					$featured_images[$term->term_id][ $size ] = wp_get_attachment_image_src(
						$image_id,
						$size,
						false
					);
				}

			}
			
			return $featured_images;
		}

		/**
		 * Get tax icon src for the rest field 
		 *
		 * @param object $object Post Object.
		 * @param string $field_name Field name.
		 * @param object $request Request Object.
		 * @since 0.0.1
		 */
		public function get_term_icon_src( $object, $field_name, $request ) {
			
			$featured_images = array();
			
			$image_sizes = Blocks_Helper::get_image_sizes();
			
			$terms = get_terms( array(
				'post_type' => 'knowledge_base',
				'taxonomy' => 'kbg_category',
				'hide_empty' => false,
			) );

			foreach ( $terms as $term ) {
				
				$meta = Blocks_Helper::kbg_get_knowledge_base_meta( $term->term_id );
				
				$image_id = getIconIdByUrl($meta['iconUrl']);

				foreach ( $image_sizes as $key => $value ) {
					$size = $value['value'];

					$featured_images[$term->term_id][ $size ] = wp_get_attachment_image_src(
						$image_id,
						$size,
						false
					);
				}

			}
			
			return $featured_images;
		}

		/**
		 * Get page meta
		 *
		 * @param object $object Post Object.
		 * @param string $field_name Field name.
		 * @param object $request Request Object.
		 * @since 0.0.1
		 */
		public function get_page_meta_inherit( $object, $field_name, $request ) {
			
			$type = $object['type'];

			if ( $type === 'knowledge_base' ) {
				$type = 'single_kb';
			}

			if ( $type === 'post' ) {
				$type = 'single_post';
			}

			
			return array(
				'settings' => 'inherit',
				'layout'   => kbg_get_option( $type . '_layout' ),
				'sidebar'  => array(
					'position' => kbg_get_option( $type . '_sidebar_position' ),
					'classic'  => kbg_get_option( $type . '_sidebar_standard' ),
					'sticky'   => kbg_get_option( $type . '_sidebar_sticky' ),
				),
			);

		}

		/**
		 * Get page meta
		 *
		 * @param object $object Post Object.
		 * @param string $field_name Field name.
		 * @param object $request Request Object.
		 * @since 0.0.1
		 */
		public function get_page_meta( $object, $field_name, $request ) {
				
			$post_id = $object['id'];
			$type = $object['type'];

			if ( $type === 'knowledge_base' ) {
				$type = 'single_kb';
			}

			if ( $type === 'post' ) {
				$type = 'single_post';
			}



			$defaults = array(
				'settings' => 'inherit',
				'layout'   => kbg_get_option( $type . '_layout' ),
				'sidebar'  => array(
					'position' => kbg_get_option( $type . '_sidebar_position' ),
					'classic'  => kbg_get_option( $type . '_sidebar_standard' ),
					'sticky'   => kbg_get_option( $type . '_sidebar_sticky' ),
				),
			);
	
			$meta = get_post_meta( $post_id, '_kbg_meta', true );
			$meta = kbg_parse_args( $meta, $defaults );

			$field = false;
	
			if ( $field ) {
				if ( isset( $meta[ $field ] ) ) {
					return $meta[ $field ];
				} else {
					return false;
				}
			}
	
			return $meta;
		}

		/**
		 * Update page meta
		 *
		 * @param object $object Post Object.
		 * @param string $field_name Field name.
		 * @param object $request Request Object.
		 * @since 0.0.1
		 */
		public function update_page_meta( $value, $object, $field_name ) {
				
			if ( ! $value ) {
				return;
			}
			return update_post_meta( $object->ID, '_kbg_meta', $value );
		}


		/**
		 * Get sidebars
		 *
		 * @param object $object Post Object.
		 * @param string $field_name Field name.
		 * @param object $request Request Object.
		 * @since 0.0.1
		 */
		public function get_sidebars( $object, $field_name, $request ) {
					
			return kbg_buddy_get_sidebars_list();
		}

		/**
		 * Create API Order By Fields
		 *
		 * @since 1.12.0
		 */
		public function register_rest_orderby_fields() {
			$post_type = Blocks_Helper::get_post_types();

			foreach ( $post_type as $key => $type ) {
				add_filter( "rest_{$type['value']}_collection_params", array( $this, 'add_orderby' ), 10, 1 );
			}
		}

		/**
		 * Adds Order By values to Rest API
		 *
		 * @param object $params Parameters.
		 * @since 1.12.0
		 */
		public function add_orderby( $params ) {

			$params['orderby']['enum'][] = 'rand';
			$params['orderby']['enum'][] = 'menu_order';

			return $params;
		}

	}

	/**
	 *  Prepare if class 'Blocks_Rest_API' exist.
	 *  Kicking this off by calling 'get_instance()' method
	 */
	Blocks_Rest_API::get_instance();
}
