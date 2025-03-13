<?php
/**
 * CTP Knowledge Base
 *
 * @package KB_CPT
 */

namespace Kbg\KB_CPT;


/**
 * Create Taxonomy - Knowledge base category
 *
 * @return void 
 * @since  1.0
 */
add_action( 'init',  __NAMESPACE__ . '\add_taxonomy_kbg_category' );

function add_taxonomy_kbg_category() {

	register_taxonomy( 'kbg_category', array( 'knowledge_base' ), array(
			'labels' => array(
				'name' => __( 'KB Category', 'kbg' ),
				'singular_name' => __( 'KB Category', 'kbg' ),
				'search_items' =>  __( 'KB Category' , 'kbg' ),
				'all_items' => __( 'All KB Categories', 'kbg' ),
				'parent_item' => __( 'Parent KB Category', 'kbg' ),
				'parent_item_colon' => __( 'KB Category:', 'kbg' ),
				'edit_item' => __( 'Edit KB Category', 'kbg' ),
				'update_item' => __( 'Update KB Category', 'kbg' ),
				'add_new_item' => __( 'Add New KB Category', 'kbg' ),
				'new_item_name' => __( 'New KB Category Name', 'kbg' ),
				'menu_name' => __( 'KB Categories' ),
			),
			// Control the slugs used for this taxonomy
			'rewrite' => array(
				'slug' => 'kb-category',
				'with_front' => false,
			),
            'hierarchical' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
		) );

}

/**
 * Create Taxonomy - Knowledge base tags
 *
 * @return void 
 * @since  1.0
 */
add_action( 'init',  __NAMESPACE__ . '\add_taxonomy_kbg_tags' );

function add_taxonomy_kbg_tags() {

	register_taxonomy( 'kbg_tags', array( 'knowledge_base' ), array(
			'labels' => array(
				'name' => __( 'KB Tags', 'kbg' ),
				'singular_name' => __( 'KB Tag', 'kbg' ),
				'search_items' =>  __( 'KB Tags' , 'kbg' ),
				'all_items' => __( 'All KB Tags', 'kbg' ),
				'parent_item' => __( 'Parent KB Tag', 'kbg' ),
				'parent_item_colon' => __( 'KB Tag:', 'kbg' ),
				'edit_item' => __( 'Edit KB Tag', 'kbg' ),
				'update_item' => __( 'Update KB Tag', 'kbg' ),
				'add_new_item' => __( 'Add New KB Tag', 'kbg' ),
				'new_item_name' => __( 'New KB Tag Name', 'kbg' ),
				'menu_name' => __( 'KB Tags' ),
			),
			// Control the slugs used for this taxonomy
			'rewrite' => array(
				'slug' => 'kb-tag',
				'with_front' => false,
			),
			'hierarchical' => false,
            'show_in_rest' => true,
            'show_admin_column' => true,
		) );

}

/**
 * Create CPT Knowledge Base
 *
 * @return void 
 * @since  1.0
 */
add_action( 'init', __NAMESPACE__ . '\create_cpt_knowledge_base' );

function create_cpt_knowledge_base() {

	$labels = array(
		'name' => __( 'Knowledge Base', 'kbg' ),
		'singular_name' => __( 'Knowledge Base', 'kbg' ),
		'add_new' => __( 'Add New', 'kbg' ),
		'all_items' => __( 'All Articles', 'kbg' ),
		'add_new_item' => __( 'Add New Docs', 'kbg' ),
		'edit_item' => __( 'Edit Article', 'kbg' ),
		'new_item' => __( 'New Article', 'kbg' ),
		'view_item' => __( 'View Article', 'kbg' ),
		'search_items' => __( 'Search Article', 'kbg' ),
		'not_found' => __( 'No Article found', 'kbg' ),
		'not_found_in_trash' => __( 'No Article Found In Trash', 'kbg' ),
		'parent_item_colon' => '',
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'rewrite' => array( 'slug' => 'knowledge-base', 'with_front' => false ),
		'has_archive' => true,
		'capability_type' => 'post',
		'hierarchical' => true,
		'menu_position' => 33,
        'show_ui'       => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'query_var'         => true,
		'taxonomies' => array( 'kbg_category', 'kbg_tag' ),
		'supports' => array( 'title', 'editor', 'thumbnail', 'author', 'excerpt', 'post-formats' ),
		'menu_icon' => 'dashicons-welcome-learn-more'
	);

	register_post_type( 'knowledge_base' , $args );

}


/**
 * Save taxonomy meta 
 * 
 * Callback function to save taxonomy meta data
 * 
 * @since  1.0
 */

add_action( 'edited_kbg_category', __NAMESPACE__ . '\kbg_save_kbg_category_fields', 10, 2 );
add_action( 'create_kbg_category', __NAMESPACE__ . '\kbg_save_kbg_category_fields', 10, 2 );

if ( !function_exists( 'kbg_save_kbg_category_fields' ) ) :
	function kbg_save_kbg_category_fields( $term_id ) {

		if ( isset( $_POST['kbg_buddy'] ) ) {

			$meta = array();

			
			if ( isset( $_POST['kbg_buddy']['imageUrl'] ) ) {
				$meta['imageUrl'] = $_POST['kbg_buddy']['imageUrl'];
			}
			
			if ( isset( $_POST['kbg_buddy']['iconUrl'] ) ) {
				$meta['iconUrl'] = $_POST['kbg_buddy']['iconUrl'];
			}

			if( !empty( $meta) ){
				update_term_meta( $term_id, '_kbg_buddy_meta', $meta);
			} else {
				delete_term_meta( $term_id, '_kbg_buddy_meta');
			}
			
		}

	}
endif;
	

/**
 * Add taxonomy meta 
 * 
 * Callback function to load taxonomy meta fields on new screen
 * 
 * @since  1.0
 */

add_action( 'kbg_category_add_form_fields', __NAMESPACE__ . '\kbg_buddy_category_add_meta_fields', 10, 2 );

if( !function_exists('kbg_buddy_category_add_meta_fields') ) :
	function kbg_buddy_category_add_meta_fields() { 

		$meta = kb_get_meta();

		?>
	
		<div class="form-field">
            <label><?php esc_html_e( 'Image', 'kbg' ); ?></label>
			<?php $display = $meta['imageUrl'] ? 'initial' : 'none'; ?>
            <p>
                <img id="kbg-buddy-image-preview" src="<?php echo esc_url( $meta['imageUrl'] ); ?>" style="display:<?php echo esc_attr( $display ); ?>;">
            </p>

            <p>
                <input type="hidden" name="kbg_buddy[imageUrl]" id="kbg-buddy-image-url" value="<?php echo esc_attr( $meta['imageUrl'] ); ?>"/>
                <input type="button" id="kbg-buddy-image-upload" class="button-secondary" value="<?php esc_html_e( 'Upload', 'kbg' ); ?>"/>
                <input type="button" id="kbg-buddy-image-clear" class="button-secondary" value="<?php esc_html_e( 'Clear', 'kbg' ); ?>" style="display:<?php echo esc_attr( $display ); ?>"/>
            </p>

            <p class="description"><?php esc_html_e( 'Upload image', 'kbg' ); ?></p>
        </div>

		<div class="form-field">
            <label><?php esc_html_e( 'Icon', 'kbg' ); ?></label>
			<?php $display = $meta['iconUrl'] ? 'initial' : 'none'; ?>
            <p>
                <img id="kbg-buddy-icon-preview" src="<?php echo esc_url( $meta['iconUrl'] ); ?>" style="display:<?php echo esc_attr( $display ); ?>;">
            </p>

            <p>
                <input type="hidden" name="kbg_buddy[iconUrl]" id="kbg-buddy-icon-url" value="<?php echo esc_attr( $meta['iconUrl'] ); ?>"/>
                <input type="button" id="kbg-buddy-icon-upload" class="button-secondary" value="<?php esc_html_e( 'Upload', 'kbg' ); ?>"/>
                <input type="button" id="kbg-buddy-icon-clear" class="button-secondary" value="<?php esc_html_e( 'Clear', 'kbg' ); ?>" style="display:<?php echo esc_attr( $display ); ?>"/>
            </p>

            <p class="description"><?php esc_html_e( 'Upload icon', 'kbg' ); ?></p>
        </div>
		

<?php }
endif;


/**
 * Edit taxonomy meta 
 * 
 * Callback function to load taxonomy meta fields on edit screen
 * 
 * @since  1.0
 */

add_action( 'kbg_category_edit_form_fields', __NAMESPACE__ . '\kbg_buddy_category_edit_meta_fields', 10, 2 );

if( !function_exists('kbg_buddy_category_edit_meta_fields') ) : 
	function kbg_buddy_category_edit_meta_fields($term) { 
		
		$meta = kb_get_meta( $term->term_id );

		?>

		<tr class="form-field">
            <th scope="row" valign="top">
				<?php esc_html_e( 'Image', 'kbg' ); ?>
            </th>
            <td>
				<?php $display = $meta['imageUrl'] ? 'initial' : 'none'; ?>
				<p>
					<img width="150" height="150" id="kbg-buddy-image-preview" src="<?php echo esc_url( $meta['imageUrl'] ); ?>" style="display:<?php echo esc_attr( $display ); ?>;">
				</p>
				<p>
					<input type="hidden" name="kbg_buddy[imageUrl]" id="kbg-buddy-image-url" value="<?php echo esc_attr( $meta['imageUrl'] ); ?>"/>
					<input type="button" id="kbg-buddy-image-upload" class="button-secondary" value="<?php esc_html_e( 'Upload', 'kbg' ); ?>"/>
					<input type="button" id="kbg-buddy-image-clear" class="button-secondary" value="<?php esc_html_e( 'Clear', 'kbg' ); ?>" style="display:<?php echo esc_attr( $display ); ?>"/>
				</p>
				<p class="description"><?php esc_html_e( 'Upload image', 'kbg' ); ?></p>
			</td>
		</tr>

		<tr class="form-field">
            <th scope="row" valign="top">
				<?php esc_html_e( 'Icon', 'kbg' ); ?>
            </th>
            <td>
				<?php $display = $meta['iconUrl'] ? 'initial' : 'none'; ?>
				<p>
					<img width="150" height="150" id="kbg-buddy-icon-preview" src="<?php echo esc_url( $meta['iconUrl'] ); ?>" style="display:<?php echo esc_attr( $display ); ?>;">
				</p>
				<p>
					<input type="hidden" name="kbg_buddy[iconUrl]" id="kbg-buddy-icon-url" value="<?php echo esc_attr( $meta['iconUrl'] ); ?>"/>
					<input type="button" id="kbg-buddy-icon-upload" class="button-secondary" value="<?php esc_html_e( 'Upload', 'kbg' ); ?>"/>
					<input type="button" id="kbg-buddy-icon-clear" class="button-secondary" value="<?php esc_html_e( 'Clear', 'kbg' ); ?>" style="display:<?php echo esc_attr( $display ); ?>"/>
				</p>
				<p class="description"><?php esc_html_e( 'Upload icon', 'kbg' ); ?></p>
			</td>
		</tr>


<?php } 
endif;
