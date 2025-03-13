<?php

/* Define theme version */
define( 'KBG_THEME_VERSION', '1.0.3' );

/* Helpers and utility functions */
include_once get_parent_theme_file_path( '/core/helpers.php' );

/* Include translation strings */
include_once get_parent_theme_file_path( '/core/translate.php' );

/* Default options */
include_once get_parent_theme_file_path( '/core/default-options.php' );

/* Load frontend scripts */
include_once get_parent_theme_file_path( '/core/enqueue.php' );

/* Template functions */
include_once get_parent_theme_file_path( '/core/template-functions.php' );

/* Menus */
include_once get_parent_theme_file_path( '/core/menus.php' );

/* Sidebars */
include_once get_parent_theme_file_path( '/core/sidebars.php' );

/* Extensions (hooks and filters to add/modify specific features ) */
include_once get_parent_theme_file_path( '/core/extensions.php' );



/* Main theme setup hook and init functions */
include_once get_parent_theme_file_path( '/core/setup.php' );


if ( is_admin() || is_customize_preview() ) {

	/* Admin helpers and utility functions  */
	include_once get_parent_theme_file_path( '/core/admin/helpers.php' );

	/* Load admin scripts */
	include_once get_parent_theme_file_path( '/core/admin/enqueue.php' );

	if ( is_customize_preview() ) {
		/* Theme Options */
		include_once get_parent_theme_file_path( '/core/admin/options.php' );
	}

	/* Include plugins - TGM init */
	include_once get_parent_theme_file_path( '/core/admin/plugins.php' );

	/* Include AJAX action handlers */
	include_once get_parent_theme_file_path( '/core/admin/ajax.php' );

	/* Extensions ( hooks and filters to add/modify specific features ) */
	include_once get_parent_theme_file_path( '/core/admin/extensions.php' );

	/* Custom metaboxes */
	include_once get_parent_theme_file_path( '/core/admin/metaboxes.php' );

	/* Demo importer panel */
	include_once get_parent_theme_file_path( '/core/admin/demo-importer.php' );

}

add_theme_support( 'custom-logo' );


/*
* Creating a function to create our CPT
*/
  
function custom_post_type() {
  
	// Set UI labels for Custom Post Type
		$labels = array(
			'name'                => _x( 'docs', 'Post Type General Name', 'twentytwentyone' ),
			'singular_name'       => _x( 'doc', 'Post Type Singular Name', 'twentytwentyone' ),
			'menu_name'           => __( 'docs', 'twentytwentyone' ),
			'parent_item_colon'   => __( 'Parent doc', 'twentytwentyone' ),
			'all_items'           => __( 'All docs', 'twentytwentyone' ),
			'view_item'           => __( 'View doc', 'twentytwentyone' ),
			'add_new_item'        => __( 'Add New doc', 'twentytwentyone' ),
			'add_new'             => __( 'Add New', 'twentytwentyone' ),
			'edit_item'           => __( 'Edit doc', 'twentytwentyone' ),
			'update_item'         => __( 'Update doc', 'twentytwentyone' ),
			'search_items'        => __( 'Search doc', 'twentytwentyone' ),
			'not_found'           => __( 'Not Found', 'twentytwentyone' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwentyone' ),
		);
		  
	// Set other options for Custom Post Type
		  
		$args = array(
			'label'               => __( 'docs', 'twentytwentyone' ),
			'description'         => __( 'doc news and reviews', 'twentytwentyone' ),
			'labels'              => $labels,
			// Features this CPT supports in Post Editor
			'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
			// You can associate this CPT with a taxonomy or custom taxonomy. 
			'taxonomies'          => array( 'tags' ),
			/* A hierarchical CPT is like Pages and can have
			* Parent and child items. A non-hierarchical CPT
			* is like Posts.
			*/
			'hierarchical'        => true,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest' => true,
	  
		);
		  
		// Registering your Custom Post Type
		register_post_type( 'docs', $args );
	  
	}
	  
	/* Hook into the 'init' action so that the function
	* Containing our post type registration is not 
	* unnecessarily executed. 
	*/
	  
	add_action( 'init', 'custom_post_type', 0 );



/**
 * Upload SVG	
 */

 function cc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
  }
  add_filter('upload_mimes', 'cc_mime_types');


  function show_knowledge_base_posts_single( $atts ) {
	$a = shortcode_atts( array(
		'category' => '',
		'posts_per_page' => 5,
	), $atts );

	$args = array(
		'post_type' => 'knowledge_base',
		'posts_per_page' => $a['posts_per_page'],
		'tax_query' => array(
			array(
				'taxonomy' => 'kbg_category',
				'field'    => 'slug',
				'terms'    => $a['category'],
			),
		),
	);

	$category = get_term_by( 'slug', $a['category'], 'kbg_category' );

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) :
		ob_start();
		?>
		<div class="knowledge-base-posts">
			<h2><?php echo $category->name; ?></h2>
			<p><?php echo $category->description; ?></p>

            <ul>
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<li>
                    <a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a>
                </li>
			<?php endwhile; ?>
            </ul>
		</div>
		<?php
		$output = ob_get_clean();
		wp_reset_postdata();
	endif;

	return $output;
}
add_shortcode( 'knowledge_base_posts_single', 'show_knowledge_base_posts_single' );



/////


function kb_get_meta( $term_id = false, $field = false ) {

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


function show_knowledge_base_posts( $atts ) {
	$a = shortcode_atts( array(
		'category_1' => '',
		'category_2' => '',
		'category_3' => '',
        'category_4' => '',
        'category_5' => '',
        'category_6' => '',
        'category_7' => '',
        'category_8' => '',
		'posts_per_page' => 5,
	), $atts );

	$args = array(
		'post_type' => 'knowledge_base',
		'posts_per_page' => $a['posts_per_page'],
		'tax_query' => array(
			'relation' => 'OR',
			array(
				'taxonomy' => 'kbg_category',
				'field'    => 'slug',
				'terms'    => $a['category_1'],
			),
			array(
				'taxonomy' => 'kbg_category',
				'field'    => 'slug',
				'terms'    => $a['category_2'],
			),
			array(
				'taxonomy' => 'kbg_category',
				'field'    => 'slug',
				'terms'    => $a['category_3'],
			),
            array(
				'taxonomy' => 'kbg_category',
				'field'    => 'slug',
				'terms'    => $a['category_4'],
			),
            array(
				'taxonomy' => 'kbg_category',
				'field'    => 'slug',
				'terms'    => $a['category_5'],
			),
            array(
				'taxonomy' => 'kbg_category',
				'field'    => 'slug',
				'terms'    => $a['category_6'],
			),
            array(
				'taxonomy' => 'kbg_category',
				'field'    => 'slug',
				'terms'    => $a['category_7'],
			),
            array(
				'taxonomy' => 'kbg_category',
				'field'    => 'slug',
				'terms'    => $a['category_8'],
			),
		),
	);

	$category_1 = get_term_by( 'slug', $a['category_1'], 'kbg_category' );
	$category_2 = get_term_by( 'slug', $a['category_2'], 'kbg_category' );
	$category_3 = get_term_by( 'slug', $a['category_3'], 'kbg_category' );
    $category_4 = get_term_by( 'slug', $a['category_4'], 'kbg_category' );
    $category_5 = get_term_by( 'slug', $a['category_5'], 'kbg_category' );
    $category_6 = get_term_by( 'slug', $a['category_6'], 'kbg_category' );
    $category_7 = get_term_by( 'slug', $a['category_7'], 'kbg_category' );
    $category_8 = get_term_by( 'slug', $a['category_8'], 'kbg_category' );

	$query = new WP_Query( $args );

    $counts = array(
        $category_1->term_id => 0,
        $category_2->term_id => 0,
        $category_3->term_id => 0,
        $category_4->term_id => 0,
        $category_5->term_id => 0,
        $category_6->term_id => 0,
        $category_7->term_id => 0,
        $category_8->term_id => 0,
    );

    while ( $query->have_posts() ) : $query->the_post();
        $terms = get_the_terms( get_the_ID(), 'kbg_category' );
        foreach( $terms as $term ) {
            if ( isset( $counts[$term->term_id] ) ) {
                $counts[$term->term_id]++;
            }
        }
    endwhile;

	if ( $query->have_posts() ) :
		ob_start();
		?>
            <h2 class="wp-block-heading has-text-align-center">Browse By Product</h2>
            <div class="knowledge-base-posts row">
                <div class="mb--xxl col-sm-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="single-list">
                        <?php if ( $category_1 ) : ?>
                            <h2><?php echo $category_1->name; ?></h2>
                            <span class="meta-count"><?php echo esc_html( $counts[ $category_1->term_id ] ) ?> articles</span>
                            
                            <ul class="posts-lists">
                                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                                    <?php if ( has_term( $category_1->slug, 'kbg_category' ) ) : ?>
                                        <li><a href="<?php echo get_permalink(); ?>"><?php echo esc_html( get_the_title() ); ?></a></li>
                                    <?php endif; ?>
                                <?php endwhile; ?>
                            </ul>

                            <a class="kbg-button button-primary button-small mt--lg" href="<?php echo get_term_link( $category_1 ); ?>">VIEW ALL</a>

                        <?php  
                        wp_reset_postdata();
                        endif;
                        wp_reset_query();
                        ?>
                        
                    </div>
                </div>

                <div class="mb--xxl col-sm-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="single-list">
                        <?php if ( $category_2 ) : ?>
                            <h2><?php echo $category_2->name; ?></h2>
                            <span class="meta-count"><?php echo esc_html( $counts[ $category_2->term_id ] ) ?> articles</span>

                            <ul class="posts-lists">
                                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                                    <?php if ( has_term( $category_2->slug, 'kbg_category' ) ) : ?>
                                        <li><a href="<?php echo get_permalink(); ?>"><?php echo esc_html( get_the_title() ); ?></a></li>
                                        <?php endif; ?>
                                <?php endwhile; ?>
                            </ul>

                            <a class="kbg-button button-primary button-small mt--lg" href="<?php echo get_term_link( $category_2 ); ?>">VIEW ALL</a>

                            <?php  
                            wp_reset_postdata();
                            endif;
                            wp_reset_query();
                        ?>
                    </div>
                </div>        

                <div class="mb--xxl col-sm-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="single-list">
                        <?php if ( $category_3 ) : ?>
                            <h2><?php echo $category_3->name; ?></h2>
                            <span class="meta-count"><?php echo $counts[$category_3->term_id] ?> articles</span>

                            <ul class="posts-lists">
                                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                                    <?php if ( has_term( $category_3->slug, 'kbg_category' ) ) : ?>
                                        <li><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></li>
                                    <?php endif; ?>
                                    <?php endwhile;
                                // Reset the query after the loop
                                wp_reset_query();
                                ?>
                            </ul>

                            <a class="kbg-button button-primary button-small mt--lg" href="<?php echo get_term_link( $category_3 ); ?>">VIEW ALL</a>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb--xxl col-sm-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="single-list">
                        <?php if ( $category_4 ) : ?>
                            <h2><?php echo $category_4->name; ?></h2>
                            <!-- <p><?php echo $category_4->description; ?></p> -->
                            <span class="meta-count"><?php echo $counts[$category_4->term_id] ?> articles</span>

                            <ul class="posts-lists">
                                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                                    <?php if ( has_term( $category_4->slug, 'kbg_category' ) ) : ?>
                                        <li><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></li>
                                    <?php endif; ?>
                                    <?php endwhile;
                                // Reset the query after the loop
                                wp_reset_query();
                                ?>
                            </ul>

                            <a class="kbg-button button-primary button-small mt--lg" href="<?php echo get_term_link( $category_4 ); ?>">VIEW ALL</a>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb--xxl col-sm-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="single-list">
                        <?php if ( $category_5 ) : ?>
                            <h2><?php echo $category_5->name; ?></h2>
                            <!-- <p><?php echo $category_5->description; ?></p> -->
                            <span class="meta-count"><?php echo $counts[$category_5->term_id] ?> articles</span>

                            <ul class="posts-lists">
                                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                                    <?php if ( has_term( $category_5->slug, 'kbg_category' ) ) : ?>
                                        <li><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></li>
                                    <?php endif; ?>
                                    <?php endwhile;
                                // Reset the query after the loop
                                wp_reset_query();
                                ?>
                            </ul>

                            <a class="kbg-button button-primary button-small mt--lg" href="<?php echo get_term_link( $category_5 ); ?>">VIEW ALL</a>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb--xxl col-sm-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="single-list">
                        <?php if ( $category_6 ) : ?>
                            <h2><?php echo $category_6->name; ?></h2>
                            <!-- <p><?php echo $category_6->description; ?></p> -->
                            <span class="meta-count"><?php echo $counts[$category_6->term_id] ?> articles</span>

                            <ul class="posts-lists">
                                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                                    <?php if ( has_term( $category_6->slug, 'kbg_category' ) ) : ?>
                                        <li><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></li>
                                    <?php endif; ?>
                                    <?php endwhile;
                                // Reset the query after the loop
                                wp_reset_query();
                                ?>
                            </ul>

                            <a class="kbg-button button-primary button-small mt--lg" href="<?php echo get_term_link( $category_6 ); ?>">VIEW ALL</a>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb--xxl col-sm-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="single-list">
                        <?php if ( $category_7 ) : ?>
                            <h2><?php echo $category_7->name; ?></h2>
                            <!-- <p><?php echo $category_7->description; ?></p> -->
                            <span class="meta-count"><?php echo $counts[$category_7->term_id] ?> articles</span>

                            <ul class="posts-lists">
                                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                                    <?php if ( has_term( $category_7->slug, 'kbg_category' ) ) : ?>
                                        <li><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></li>
                                    <?php endif; ?>
                                <?php endwhile;
                                // Reset the query after the loop
                                wp_reset_query();
                                ?>
                            </ul>


                            <a class="kbg-button button-primary button-small mt--lg" href="<?php echo get_term_link( $category_7 ); ?>">VIEW ALL</a>


                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb--xxl col-sm-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="single-list">
                        <?php if ( $category_8 ) : ?>
                            <h2><?php echo $category_8->name; ?></h2>
                            <!-- <p><?php echo $category_8->description; ?></p> -->
                            <span class="meta-count"><?php echo $counts[$category_8->term_id] ?> articles</span>

                            <ul class="posts-lists">
                                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                                    <?php if ( has_term( $category_8->slug, 'kbg_category' ) ) : ?>
                                        <li><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></li>
                                    <?php endif; ?>
                                    <?php endwhile;
                                // Reset the query after the loop
                                wp_reset_query();
                                ?>
                            </ul>

                            <a class="kbg-button button-primary button-small mt--lg" href="<?php echo get_term_link( $category_8 ); ?>">VIEW ALL</a>

                        <?php endif; ?>
                    </div>
                </div>

            </div>
		<?php
		$output = ob_get_clean();
		wp_reset_postdata();
	endif;

	return $output;
}
add_shortcode( 'knowledge_base_posts', 'show_knowledge_base_posts' );



/**
 * Callback function for the [category_post_lists] shortcode.
 *
 * @param array $atts Array of shortcode attributes.
 *
 * @return string HTML output for the shortcode.
 */
function category_post_lists_shortcode( $atts ) {
	// Set up the shortcode attributes and default values
	$atts = shortcode_atts( array(
		'category_1' => '',
		'category_2' => '',
		'category_3' => '',
        'category_4' => '',
        'category_5' => '',
        'category_6' => '',
        'category_7' => '',
        'category_8' => '',
	), $atts );

	// Start the output buffer
	ob_start();

	// Start the parent div with the row class
	echo '<h2 class="wp-block-heading has-text-align-center">Browse by Category</h2>
    <div class="knowledge-base-posts row">';

	// Loop through each category
	for ( $i = 1; $i <= 8; $i++ ) {
		// Get the category name from the shortcode attributes
		$category = $atts[ 'category_' . $i ];
		if ( empty( $category ) ) {
			continue;
		}

		// Get the category object to retrieve the category name and URL
		$category_obj = get_term_by( 'slug', $category, 'kbg_category' );
		if ( ! $category_obj ) {
			continue;
		}

		// Set up the query arguments
		$args = array(
			'post_type'      => 'knowledge_base',
			'posts_per_page' => 5,
            'order' => 'DESC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'kbg_category',
					'field'    => 'slug',
					'terms'    => array( $category ),
				),
			),
		);
		$query = new WP_Query( $args );

		// Check if there are posts for this category
		if ( $query->have_posts() ) {
			// Get the total post count for this category
			$count = $query->found_posts;

			// Start the category output buffer
			ob_start(); ?>

            <div class="mb--xxl col-sm-12 col-md-6 col-lg-4 col-xl-3">
                <div class="single-list">
                    <h2><a href="<?php echo get_term_link( $category_obj ); ?>"><?php echo esc_html( $category_obj->name ); ?></a></h2>
                    <span class="meta-count"><?php echo $count; ?> articles</span>

                    <ul class="posts-lists">
                        <?php while ( $query->have_posts() ) {
                            $query->the_post(); ?>
                            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                        <?php } ?>
                    </ul>

                    <a class="abs-btn kbg-button button-primary button-small mt--lg" href="<?php echo get_term_link( $category_obj ); ?>">View all</a>
                </div>

			</div>

			<?php
			// Get the category output buffer and append it to the main output buffer
			$category_output = ob_get_clean();
			echo $category_output;

			// Reset the post data
			wp_reset_postdata();
		}
	}

	// Close the parent div
	echo '</div>';

	// Get the main output buffer and return it
	$output = ob_get_clean();
	return $output;
}
add_shortcode( 'category_post_lists', 'category_post_lists_shortcode' );



function custom_search_form_shortcode() {
    ob_start();
    ?>
    <form role="search" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="Search..." />
        <input type="submit" id="searchsubmit" value="Search" />
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('custom_search_form', 'custom_search_form_shortcode');

function enqueue_load_fa() {
    wp_enqueue_style( 'load-fa', 'https://use.fontawesome.com/releases/v5.5.0/css/all.css' );
}  
add_action( 'wp_enqueue_scripts', 'enqueue_load_fa');


function display_category_hierarchy() {
    $output = '';

    // Get the current category
    $category = get_queried_object();

    // Query posts within the current category and its subcategories
    $args = array(
			'post_type'      => 'knowledge_base',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
				'taxonomy' => 'kbg_category',
                'field' => 'term_id',
                'terms' => $category->term_id,
                'include_children' => true,
            ),
        ),
    );

    $query = new WP_Query($args);

    // Check if posts are found
    if ($query->have_posts()) {
		$output .= '<div class="dropdown-lateral-menu">';

        // Start the loop
        while ($query->have_posts()) {
            $query->the_post();
			$output .= '<div class="tab">';
            $output .= '<input id="' . get_the_ID() .'" type="checkbox">';
            $output .= '<label for="' . get_the_ID() . '"><i class="far fa-folder-open"></i> <a href="'. get_permalink() .'">' . get_the_title() . '</a></label>';

            // Query child posts (subposts) of the current post
            $child_args = array(
        			'post_type'      => 'knowledge_base',
                'posts_per_page' => -1,
                'post_parent' => get_the_ID(),
            );

            $child_query = new WP_Query($child_args);

            // Check if child posts are found
            if ($child_query->have_posts()) {
                $output .= '<span></span>';
                $output .= '<div class="content">';
                $output .= '<ul>';

                // Start the child loop
                while ($child_query->have_posts()) {
                    $child_query->the_post();
                    $output .= '<li> <a href="'.get_permalink() .'">' . get_the_title() . '</a></li>';
                }

                // End the child loop
                wp_reset_postdata();

                $output .= '</ul>';
                $output .= '</div>';
            }
            $output .= '</div>';

        }

        // End the loop
        wp_reset_postdata();


        $output .= '</div>';
    }

    return $output;
}
add_shortcode('display_category_hierarchy', 'display_category_hierarchy');



function display_related_posts_hierarchy() {
    $output = '';

    // Get the current post
    $post = get_queried_object();

    // Get the post's categories
    $categories = wp_get_post_terms($post->ID, 'kbg_category', array('fields' => 'ids'));

    // Check if categories are found
    if ($categories) {
        // Query posts within the same categories as the current post
        $args = array(
            'post_type' => 'knowledge_base',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'kbg_category',
                    'field' => 'term_id',
                    'terms' => $categories,
                ),
            ),
            'post__not_in' => array($post->ID),
        );

        $query = new WP_Query($args);

        // Check if related posts are found
        if ($query->have_posts()) {
            $output .= '<div class="dropdown-lateral-menu">';

            // Start the loop
            while ($query->have_posts()) {
                $query->the_post();
                $output .= '<div class="tab">';
                $output .= '<input id="' . get_the_ID() .'" type="checkbox">';
                $output .= '<label for="' . get_the_ID() . '"><i class="far fa-folder-open"></i> <a href="'. get_permalink() .'">' . get_the_title() . '</a></label>';

                // Query child posts (subposts) of the current post
                $child_args = array(
                    'post_type' => 'knowledge_base',
                    'posts_per_page' => -1,
                    'post_parent' => get_the_ID(),
                );

                $child_query = new WP_Query($child_args);

                // Check if child posts are found
                if ($child_query->have_posts()) {
                    $output .= '<span></span>';
                    $output .= '<div class="content">';
                    $output .= '<ul>';

                    // Start the child loop
                    while ($child_query->have_posts()) {
                        $child_query->the_post();
                        $output .= '<li> <a href="'.get_permalink() .'">' . get_the_title() . '</a></li>';
                    }

                    // End the child loop
                    wp_reset_postdata();

                    $output .= '</ul>';
                    $output .= '</div>';
                }

                $output .= '</div>';
            }

            // End the loop
            wp_reset_postdata();

            $output .= '</div>';
        }
    }

    return $output;
}
add_shortcode('display_related_posts_hierarchy', 'display_related_posts_hierarchy');


function exclude_home_page_from_search( $query ) {
    if ( $query->is_search && ! is_admin() ) {
        $query->set( 'post__not_in', array( get_option( 'page_on_front' ) ) );
    }
}
add_action( 'pre_get_posts', 'exclude_home_page_from_search' );