<?php
/**
 * Config
 *
 * @package Meks Blocks
 */

namespace Kbg\Kbg_Buddy;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Blocks_Config' ) ) {

	/**
	 * Class Blocks_Config.
	 */
	class Blocks_Config {

		/**
		 * Block Attributes
		 *
		 * @var block_attributes
		 */
		public static $block_attributes = null;

		/**
		 * Block Assets
		 *
		 * @var block_assets
		 */
		public static $block_assets = null;

		/**
		 * Get Widget List.
		 *
		 * @since 0.0.1
		 *
		 * @return array The Widget List.
		 */
		public static function get_block_attributes() {

			if ( null === self::$block_attributes ) {
				self::$block_attributes = array(
					'kbg/knowledge-base-image'          => array(
						'slug'        => '',
						'title'       => __( 'Category Image', 'kbg' ),
						'description' => __( 'Display your knowledge base categories in a card layout with a featured image', 'meks-blocks' ),
						'default'     => true,
						'attributes'  => array(
							'inheritFromTheme'            => false,
							'titleTag'                    => 'h3',
							'ctaText'                     => __( 'Articles', 'kbg' ),
						),
					),
					'kbg/knowledge-base-icon'          => array(
						'slug'        => '',
						'title'       => __( 'Category Icon', 'kbg' ),
						'description' => __( 'Display your knowledge base categories in a card layout with a featured icon', 'meks-blocks' ),
						'default'     => true,
						'attributes'  => array(
							'inheritFromTheme'            => false,
							'titleTag'                    => 'h3',
							'ctaText'                     => __( 'Articles', 'kbg' ),
						),
					),
					'kbg/knowledge-base-list'          => array(
						'slug'        => '',
						'title'       => __( 'Category List', 'kbg' ),
						'description' => __( 'Display your knowledge base categories and articles in a card layout', 'meks-blocks' ),
						'default'     => true,
						'attributes'  => array(
							'inheritFromTheme'            => false,
							'titleTag'                    => 'h3',
							'ctaText'                     => __( 'All Articles', 'kbg' ),
							'postPagination'              => '',
							'pageLimit'                   => '',
						),
					),
				);
			}
			return self::$block_attributes;
		}

	}
}
