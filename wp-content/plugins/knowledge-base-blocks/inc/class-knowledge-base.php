<?php
/**
 * Meks Post.
 *
 * @package Meks Blocks
 */

namespace Kbg\Kbg_Buddy;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'KnowledgeBaseBlocks' ) ) {

	/**
	 * Class KnowledgeBaseBlocks.
	 */
	class KnowledgeBaseBlocks {


		/**
		 * Member Variable
		 *
		 * @since x.x.x
		 * @var instance
		 */
		private static $instance;

		/**
		 * Member Variable
		 *
		 * @since x.x.x
		 * @var settings
		 */
		private static $settings;

		/**
		 *  Initiator
		 *
		 * @since x.x.x
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

			add_action( 'init', array( $this, 'register_blocks' ), 20 );
		}

		/**
		 * Registers the block on server.
		 *
		 * @since 0.0.1
		 */
		public function register_blocks() {
			// Check if the register function exists.
			if ( ! function_exists( 'register_block_type' ) ) {
				return;
			}

			$common_attributes = $this->get_common_attributes();

			register_block_type(
				'kbg/knowledge-base-image',
				array(
					'attributes'      => array_merge(
						$common_attributes,
						array(
							'blockType'   => array(
								'type'    => 'string',
								'default' => 'image',
							),
							'layoutOptions' 		  => array(
								'type'    => 'array',
								'default' => array(
									1 => (object) array( 
										'optionMatch'=> 1,
										'value'=> '1',
										'label'=> 'Layout A',
										'style'=> 'A',
										'preview'=> KBG_URL . 'assets/img/admin/layout_a_image.svg',
										'loop' => array(
											'col'   => 'col-12',
											'style' => 'a',
										)
									),
									2 => (object) array( 
										'optionMatch'=> 2,
										'value'=> '2',
										'label'=> 'Layout B',
										'style'=> 'B',
										'preview'=> KBG_URL . 'assets/img/admin/layout_b_image.svg',
										'loop' => array(
											'col'   => 'col-12 col-md-6',
											'style' => 'b',
										)
									),
									3 => (object) array( 
										'optionMatch'=> 3,
										'value'=> '3',
										'label'=> 'Layout C',
										'style'=> 'C',
										'preview'=> KBG_URL . 'assets/img/admin/layout_c_image.svg',
										'loop' => array(
											'col'   => 'col-12 col-md-6 col-lg-4',
											'style' => 'c',
										)
									),
									4 => (object) array( 
										'optionMatch'=> 4,
										'value'=> '4',
										'label'=> 'Layout D',
										'style'=> 'D',
										'preview'=> KBG_URL . 'assets/img/admin/layout_d_image.svg',
										'loop' => array(
											'col'   => 'col-12 col-md-6 col-lg-3',
											'style' => 'd',
										)
									),
									5 => (object) array( 
										'optionMatch'=> 5,
										'value'=> '5',
										'label'=> 'Layout E',
										'style'=> 'E',
										'preview'=> KBG_URL . 'assets/img/admin/layout_e_image.svg',
										'loop' => array(
											'col'   => 'col-12 col-md-6 col-lg-6',
											'style' => 'e',
										)
									),
								),
							),
							'layoutDefaultOptions' 		  => array(
								'type'    => 'array',
								'default' => array(
									1 => (object) array( 
										'optionMatch'=> 1,
										'value'=> '1',
										'label'=> 'Layout A',
										'style'=> 'A',
										'preview'=> KBG_URL . 'assets/img/admin/layout_a_image.svg',
										'loop' => array(
											'col'   => 'col-12',
											'style' => 'b',
										)
									),
									2 => (object) array( 
										'optionMatch'=> 2,
										'value'=> '2',
										'label'=> 'Layout B',
										'style'=> 'B',
										'preview'=> KBG_URL . 'assets/img/admin/layout_b_image.svg',
										'loop' => array(
											'col'   => 'col-12 col-md-6',
											'style' => 'c',
										)
									),
									3 => (object) array( 
										'optionMatch'=> 3,
										'value'=> '3',
										'label'=> 'Layout C',
										'style'=> 'C',
										'preview'=> KBG_URL . 'assets/img/admin/layout_c_image.svg',
										'loop' => array(
											'col'   => 'col-12 col-md-6 col-lg-4',
											'style' => 'd',
										)
									),
									4 => (object) array(
										'optionMatch'=> 3, 
										'value'=> '3',
										'label'=> 'Layout C',
										'style'=> 'C',
										'preview'=> KBG_URL . 'assets/img/admin/layout_c_image.svg',
										'loop' => array(
											'col'   => 'col-12 col-md-6 col-lg-4',
											'style' => 'd',
										)
									),
									5 => (object) array(
										'optionMatch'=> 5, 
										'value'=> '5',
										'label'=> 'Layout E',
										'style'=> 'E',
										'preview'=> KBG_URL . 'assets/img/admin/layout_e_image.svg',
										'loop' => array(
											'col'   => 'col-12',
											'style' => 'e',
										)
									),
								),
							),
							'displayPostExcerpt'      => array(
								'type'    => 'boolean',
								'default' => true,
							),
							'displayPostContentRadio' => array(
								'type'    => 'string',
								'default' => 'excerpt',
							),
							'excerptLength'           => array(
								'type'    => 'number',
								'default' => 25,
							),
							'displayPostImage'        => array(
								'type'    => 'boolean',
								'default' => true,
							),
							'imgSize'                 => array(
								'type'    => 'string',
								'default' => 'c',
							),
						)
					),
					'render_callback' => array( $this, 'knowledge_base_image_callback' ),
				)
			);

			register_block_type(
				'kbg/knowledge-base-icon',
				array(
					'attributes'      => array_merge(
						$common_attributes,
						array(
							'blockType'   => array(
								'type'    => 'string',
								'default' => 'icon',
							),
							'layoutOptions' 		  => array(
								'type'    => 'array',
								'default' => array(
									1 => (object) array( 
										'optionMatch'=> 1,
										'value'=> '1',
										'label'=> 'Layout A',
										'style'=> 'A',
										'preview'=> KBG_URL . 'assets/img/admin/layout_a_icon.svg',
										'loop' => array(
											'col'   => 'col-12',
											'style' => 'a',
										)
									),
									2 => (object) array( 
										'optionMatch'=> 2,
										'value'=> '2',
										'label'=> 'Layout B',
										'style'=> 'B',
										'preview'=> KBG_URL . 'assets/img/admin/layout_b_icon.svg',
										'loop' => array(
											'col'   => 'col-12 col-md-6',
											'style' => 'b',
										)
									),
									3 => (object) array( 
										'optionMatch'=> 3,
										'value'=> '3',
										'label'=> 'Layout C',
										'style'=> 'C',
										'preview'=> KBG_URL . 'assets/img/admin/layout_c_icon.svg',
										'loop' => array(
											'col'   => 'col-12 col-md-6 col-lg-4',
											'style' => 'c',
										)
									),
									4 => (object) array( 
										'optionMatch'=> 4,
										'value'=> '4',
										'label'=> 'Layout D',
										'style'=> 'D',
										'preview'=> KBG_URL . 'assets/img/admin/layout_d_icon.svg',
										'loop' => array(
											'col'   => 'col-12 col-md-6 col-lg-3',
											'style' => 'd',
										)
									),
									5 => (object) array( 
										'optionMatch'=> 5,
										'value'=> '5',
										'label'=> 'Layout E',
										'style'=> 'E',
										'preview'=> KBG_URL . 'assets/img/admin/layout_e_icon.svg',
										'loop' => array(
											'col'   => 'col-12 col-md-6 col-lg-6',
											'style' => 'e',
										)
									),
								),
							),
							'layoutDefaultOptions' 		  => array(
								'type'    => 'array',
								'default' => array(
									1 => (object) array( 
										'optionMatch'=> 1,
										'value'=> '1',
										'label'=> 'Layout A',
										'style'=> 'A',
										'preview'=> KBG_URL . 'assets/img/admin/layout_a_icon.svg',
										'loop' => array(
											'col'   => 'col-12',
											'style' => 'b',
										)
									),
									2 => (object) array( 
										'optionMatch'=> 2,
										'value'=> '2',
										'label'=> 'Layout B',
										'style'=> 'B',
										'preview'=> KBG_URL . 'assets/img/admin/layout_b_icon.svg',
										'loop' => array(
											'col'   => 'col-12 col-md-6',
											'style' => 'c',
										)
									),
									3 => (object) array( 
										'optionMatch'=> 3,
										'value'=> '3',
										'label'=> 'Layout C',
										'style'=> 'C',
										'preview'=> KBG_URL . 'assets/img/admin/layout_c_icon.svg',
										'loop' => array(
											'col'   => 'col-12 col-md-6 col-lg-4',
											'style' => 'd',
										)
									),
									4 => (object) array( 
										'optionMatch'=> 3,
										'value'=> '3',
										'label'=> 'Layout C',
										'style'=> 'C',
										'preview'=> KBG_URL . 'assets/img/admin/layout_c_icon.svg',
										'loop' => array(
											'col'   => 'col-12 col-md-6 col-lg-4',
											'style' => 'd',
										)
									),
									5 => (object) array( 
										'optionMatch'=> 5,
										'value'=> '5',
										'label'=> 'Layout E',
										'style'=> 'E',
										'preview'=> KBG_URL . 'assets/img/admin/layout_e_icon.svg',
										'loop' => array(
											'col'   => 'col-12',
											'style' => 'e',
										)
									),
								),
							),
							'displayPostExcerpt'      => array(
								'type'    => 'boolean',
								'default' => true,
							),
							'displayPostContentRadio' => array(
								'type'    => 'string',
								'default' => 'excerpt',
							),
							'excerptLength'           => array(
								'type'    => 'number',
								'default' => 25,
							),
							'displayPostImage'        => array(
								'type'    => 'boolean',
								'default' => true,
							),
						)
					),
					'render_callback' => array( $this, 'knowledge_base_image_callback' ),
				)
			);

			register_block_type(
				'kbg/knowledge-base-list',
				array(
					'attributes'      => array_merge(
						$common_attributes,
						array(
							'blockType'   => array(
								'type'    => 'string',
								'default' => 'list',
							),
							'layoutOptions' 		  => array(
								'type'    => 'array',
								'default' => array(
									1 => (object) array( 
										'optionMatch'=> 1,
										'value'=> '1',
										'label'=> 'Layout A',
										'style'=> 'A',
										'preview'=> KBG_URL . 'assets/img/admin/layout_a_list.svg',
										'loop' => array(
											'col'   => 'col-12',
											'style' => 'a',
										)
									),
									2 => (object) array( 
										'optionMatch'=> 2,
										'value'=> '2',
										'label'=> 'Layout B',
										'style'=> 'B',
										'preview'=> KBG_URL . 'assets/img/admin/layout_b_list.svg',
										'loop' => array(
											'col'   => 'col-12 col-lg-6',
											'style' => 'b',
										)
									),
									3 => (object) array( 
										'optionMatch'=> 3,
										'value'=> '3',
										'label'=> 'Layout C',
										'style'=> 'C',
										'preview'=> KBG_URL . 'assets/img/admin/layout_c_list.svg',
										'loop' => array(
											'col'   => 'col-12 col-md-12 col-lg-4',
											'style' => 'c',
										)
									)
								),
							),
							'layoutDefaultOptions' 		  => array(
								'type'    => 'array',
								'default' => array(
									1 => (object) array( 
										'optionMatch'=> 1,
										'value'=> '1',
										'label'=> 'Layout A',
										'style'=> 'A',
										'preview'=> KBG_URL . 'assets/img/admin/layout_a_list.svg',
										'loop' => array(
											'col'   => 'col-12',
											'style' => 'a',
										)
									),
									2 => (object) array( 
										'optionMatch'=> 2,
										'value'=> '2',
										'label'=> 'Layout B',
										'style'=> 'B',
										'preview'=> KBG_URL . 'assets/img/admin/layout_b_list.svg',
										'loop' => array(
											'col'   => 'col-12 col-md-6',
											'style' => 'b',
										)
									),
									3 => (object) array( 
										'optionMatch'=> 2,
										'value'=> '2',
										'label'=> 'Layout B',
										'style'=> 'B',
										'preview'=> KBG_URL . 'assets/img/admin/layout_b_list.svg',
										'loop' => array(
											'col'   => 'col-12 col-md-6',
											'style' => 'b',
										)
									)
								),
							),
							'postsToShow'             => array(
								'type'    => 'number',
								'default' => 6,
							),
							'postsOrder'             => array(
								'type'    => 'string',
								'default' => 'date',
							),
							'postsSort'             => array(
								'type'    => 'string',
								'default' => 'desc',
							),
							'ctaText'                 => array(
								'type'    => 'string',
								'default' => __( 'View all', 'kbg' ),
							),
							'metaText'                 => array(
								'type'    => 'string',
								'default' => __( 'articles', 'kbg' ),
							),
							'displayPostImage'      => array(
								'type'    => 'boolean',
								'default' => false,
							),
							'displayArticleIcon'       => array(
								'type'    => 'boolean',
								'default' => true,
							),

						)
					),
					'render_callback' => array( $this, 'knowledge_base_image_callback' ),
				)
			);

		}

		/**
		 * Get Post common attributes for all Post Grid, Masonry and Carousel.
		 *
		 * @since 0.0.1
		 */
		public function get_common_attributes() {

			return array(
				'terms'            => array(
					'type'    => 'array',
					'default' => Blocks_Helper::kbg_get_cpt_category_terms()
				),
				'inheritFromTheme'        => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'block_id'                => array(
					'type'    => 'string',
					'default' => 'not_set',
				),
				'equalHeight'                 => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'layout' 				  => array(
					'type' => 'string',
					'default' => '3',
				),
				'displayReadMoreLink'         => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'readMoreLinkType'     => array(
					'type'    => 'string',
					'default' => 'button',
				),
				'newTab'                  => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'ctaText'                 => array(
					'type'    => 'string',
					'default' => __( 'Articles', 'kbg' ),
				),
				'titleTag'                => array(
					'type'    => 'string',
					'default' => 'h2',
				),
				'pageTemplate'            => array(
					'type'    => 'string',
					'default' => 'template-default',
				),
				'previewExample'     => array(
					'type'    => 'boolean',
					'default' => false,
				),
		
			);
		}

		/**
		 * Renders the post grid block on server.
		 *
		 * @param array $attributes Array of block attributes.
		 *
		 * @since 0.0.1
		 */
		public function knowledge_base_image_callback( $attributes ) {

			// Get query.
			$categories = Blocks_Helper::get_kbg_category_knowledge_base_query( $attributes );

			// Cache the settings.
			self::$settings['kbg_category'][ $attributes['block_id'] ] = $attributes;

			ob_start();

			$this->get_knowledge_base_html( $attributes, $categories, 'kbg_category' );

			// Output the post markup.
			return ob_get_clean();
		}


		/**
		 * Get grid layout loop params
		 *
		 * @param array $attributes Array.
		 * @param int $layout
		 *
		 * @since 0.0.1
		 */
		public function get_grid_layout_loop( $attributes, $layout ) {

			$style = 'a';

			$layoutLoop = $attributes['layoutDefaultOptions'];

			$sidebar = kbg_get_page_meta( get_the_ID() );

			$type = get_post_type( get_the_ID() );

			if ( $type === 'knowledge_base' ) {
				$type = 'single_kb';
			}

			if ( $type === 'post' ) {
				$type = 'single_post';
			}
			
			if ( $sidebar['settings'] === 'inherit' ) {
				$sidebar = array(
					'settings' => 'inherit',
					'layout'   => kbg_get_option( $type . '_layout' ),
					'sidebar'  => array(
						'position' => kbg_get_option( $type . '_sidebar_position' ),
						'classic'  => kbg_get_option( $type . '_sidebar_standard' ),
						'sticky'   => kbg_get_option( $type . '_sidebar_sticky' )
					)
				);
			}

			$displaySidebar = $sidebar['sidebar']['position'] != 'none';

			if ( $attributes['pageTemplate'] == 'template-knowledge-base-blocks' && !$displaySidebar ) {
				$layoutLoop = $attributes['layoutOptions'];
			}

			$loop = (object) $layoutLoop[$layout]->loop;

			if ( array_key_exists( $layout, $layoutLoop ) )  {
				$style = $loop->style;
			}
		
			return $style;
		}

		/**
		 * Get grid layout loop params
		 *
		 * @param array $attributes Array.
		 * @param int $layout
		 *
		 * @since 0.0.1
		 */
		public function get_grid_layout_loop_col_class( $attributes, $layout ) {

			$class = 'col-12';
			$layoutLoop = $attributes['layoutDefaultOptions'];

			$sidebar = kbg_get_page_meta( get_the_ID(), 'sidebar' );
			$displaySidebar = $sidebar['position'] != 'none';

			if ( $attributes['pageTemplate'] == 'template-knowledge-base-blocks' && !$displaySidebar ) {
				$layoutLoop = $attributes['layoutOptions'];
			}

			$loop = (object) $layoutLoop[$layout]->loop;

			if ( array_key_exists( $layout, $layoutLoop ) )  {
				$class = $loop->col;
			}
		
			return $class;
		}

		/**
		 * Renders the post grid block on server.
		 *
		 * @param array  $attributes Array of block attributes.
		 *
		 * @param object $query WP_Query object.
		 * @param string $layout post grid/masonry/carousel layout.
		 * @since 0.0.1
		 */
		public function get_knowledge_base_html( $attributes, $categories, $layout ) {

			$layout_style = $this->get_grid_layout_loop( $attributes, $attributes['layout'] );
			$layout_class = $this->get_grid_layout_loop_col_class( $attributes, $attributes['layout'] );
			
			/* TODO: maybe remove query set? */
			//set_query_var( 'kbg_cpt', $attributes );

			?>

				<section>
					<div class="row justify-content-center">
						
						<div class="col-12 kbg-order-1">
							<div class="row kbg-items kbg-load-items">

								<?php if ( !empty( $categories ) && !is_wp_error( $categories ) ) : ?>

									<?php foreach( $categories as $category ) : ?>

										<div class="mb--xxl <?php echo esc_attr( $layout_class ) ?>">
											<?php if ( $attributes['blockType'] == 'list' ) : ?>
												<?php include( Blocks_Helper::get_template( strtolower( $layout_style .'-'.'list' ) ) ); ?>
											<?php else: ?>
												<?php include( Blocks_Helper::get_template( strtolower( $layout_style ) ) ); ?>
											<?php endif; ?>
										</div>
									<?php endforeach; ?>

								<?php else: ?>
									<div class="mb--xxl col-12">
										<?php include( Blocks_Helper::get_template( 'empty' ) ); ?>
									</div>
								<?php endif; ?>

							</div>
						</div>

					</div>	
				</section>

			<?php

		}


	}

	/**
	 *  Prepare if class 'KnowledgeBaseBlocks' exist.
	 *  Kicking this off by calling 'get_instance()' method
	 */
	KnowledgeBaseBlocks::get_instance();
}
