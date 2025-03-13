<?php

/**
 * CPT Post widget
 *
 * @package KB_CPT
 */

namespace Kbg\KB_CPT;


/**
 * 
 * Posts widget with image
 * 
 */

class KBG_Posts_Widget extends \WP_Widget {

	var $defaults;

	function __construct() {
		$widget_ops = array( 'classname' => 'kbg_posts_widget related-posts', 'description' => esc_html__( 'Display posts with thumbnail image', 'kbg' ) );
		$control_ops = array( 'id_base' => 'kbg_posts_widget' );
		parent::__construct( 'kbg_posts_widget', esc_html__( 'Knowledge Base Posts', 'kbg' ), $widget_ops, $control_ops );

		$this->defaults = array(
			'title' => esc_html__( 'Posts', 'kbg' ),
			'numposts' => 5,
			'category' => array(),
			'auto_detect_category' => false,
			'meta' => array( 'date'),
			'auto_detect' => 0,
			'orderby' => 0,
			'time' => 0,
			'manual' => array(),
			'tag' => array(),
		);
	}


	function widget( $args, $instance ) {
		extract( $args );
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		echo wp_kses_post( $before_widget );

		$title = apply_filters( 'widget_title', $instance['title'] );

		
		if ( !empty( $title ) ) {
			$title =  $before_title . $title . $after_title;

			echo wp_kses_post( $title );
		}
	
		$current_post_id = get_the_ID();

		$q_args = array(
			'post_type'=> 'post',
			'posts_per_page' => $instance['numposts'],
			'ignore_sticky_posts' => 1,
			'orderby' => $instance['orderby'],
			'post__not_in' => array($current_post_id)
		);


		if ( !empty( $instance['manual'] ) && !empty( $instance['manual'][0] ) ) {
			$q_args['posts_per_page'] = absint( count( $instance['manual'] ) );
			$q_args['orderby'] =  'post__in';
			$q_args['post__in'] =  $instance['manual'];
			$q_args['post_type'] = 'post'; 

		} else {


			if ( !empty( $instance['tag'] ) ) {
				$q_args['tag_slug__in'] = $instance['tag'];
			}

			if ( !empty( $instance['auto_detect_category'] ) && is_single() ) {

				$cats = get_the_category();
				
				if ( !empty( $cats ) ) {
					foreach ( $cats as $k => $cat ) {
						$q_args['category__in'][] = $cat->term_id;
					}
				}
				
			} else {

				if ( !empty( $instance['category'] ) ) {
					$q_args['category__in'] = $instance['category'];
				}
			}


			if($q_args['orderby'] == 'title'){
				$q_args['order'] = 'ASC';
			}


			if ( !empty( $instance['time'] ) ) {
				$q_args['date_query'] = array(
					'after' => date( 'Y-m-d', kbg_cpt_calculate_time_diff( $instance['time'] ) )
				);
			}
		}		
		
		$kbg_posts = new \WP_Query( $q_args );

		if ( $kbg_posts->have_posts() ): ?>

			<?php while ( $kbg_posts->have_posts() ) : $kbg_posts->the_post(); ?>
				
				<?php $format =  get_post_format() ? : 'standard'; ?>

				<article <?php post_class('kbg-post d-flex align-items-center'); ?>>
	
                        <?php $fimg = get_the_post_thumbnail( get_the_ID(), 'thumbnail' ); ?>
						<div class="entry-media">
							<a href="<?php the_permalink(); ?>"><?php echo kbg_wp_kses( $fimg ); ?></a>
						</div>

                        <div class="entry-header">

                            <?php the_title( sprintf( '<a href="%s" class="entry-title paragraph-small">', esc_url( get_permalink() ) ), '</a>' ); ?>
                            
                            <div class="entry-meta">
                                <?php echo kbg_get_meta_data( array( 'date' ) ); ?>  
                            </div>

                        </div>

                </article>
				
			<?php endwhile; ?>

		<?php endif; 

		wp_reset_postdata();

		echo wp_kses_post( $after_widget );

	}


	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['orderby'] = $new_instance['orderby'];
		$instance['numposts'] = absint( $new_instance['numposts'] );
		$instance['category'] = $new_instance['category'];;
		$instance['auto_detect_category'] = isset( $new_instance['auto_detect_category'] ) ? 1 : 0;
		$instance['meta'] = !empty($new_instance['meta']) ? $new_instance['meta'] : array();
		$instance['manual'] = !empty( $new_instance['manual'] ) ? explode( ",", $new_instance['manual'] ) : array();
		$instance['tag'] = kb_get_tax_term_slug_by_name( $new_instance['tag'] );
		
		return $instance;
	}

	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, $this->defaults ); ?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title', 'kbg' ); ?>:</label>
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" type="text" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>

		<p>
	   	 	<label for="<?php echo esc_attr($this->get_field_id( 'numposts' )); ?>"><?php esc_html_e( 'Number of posts to show', 'kbg' ); ?>:</label>
		 	<input id="<?php echo esc_attr($this->get_field_id( 'numposts' )); ?>" type="text" name="<?php echo esc_attr($this->get_field_name( 'numposts' )); ?>" value="<?php echo absint( $instance['numposts'] ); ?>" class="small-text" />
	  	</p>

		<p>
	  		<?php $this->widget_meta( $this, $instance['meta'] ); ?>
		</p>


	  	<p>
	  	 <?php $this->widget_orderby( $this, $instance['orderby'] ); ?>
	    </p>

	   <p>
	   	 <label for="<?php echo esc_attr($this->get_field_id( 'manual' )); ?>"><?php esc_html_e( 'Or choose manually', 'kbg' ); ?>:</label>
		 <input id="<?php echo esc_attr($this->get_field_id( 'manual' )); ?>" type="text" name="<?php echo esc_attr($this->get_field_name( 'manual' )); ?>" value="<?php echo esc_attr(implode( ",", $instance['manual'] )); ?>" class="widefat" />
		 <small class="howto"><?php esc_html_e( 'Specify post ids separated by comma if you want to select only those articles. i.e. 213,32,12,45 Note: you can also choose pages as well as custom post types', 'kbg' ); ?></small>
	   </p>

		
		  <p>
		  	<?php $this->widget_category( $this, 'category', $instance['category'] ); ?>
		  </p>

		  <p>
			<input id="<?php echo esc_attr($this->get_field_id( 'auto_detect_category' )); ?>" type="checkbox" name="<?php echo esc_attr($this->get_field_name( 'auto_detect_category' )); ?>" value="1" <?php checked( 1, $instance['auto_detect_category'] ); ?>/>
			<label for="<?php echo esc_attr($this->get_field_id( 'auto_detect_category' )); ?>"><?php esc_html_e( 'Auto detect category', 'kbg' ); ?></label>
			<small class="howto"><?php esc_html_e( 'If sidebar is used on single post template, display post from current post category', 'kbg' ); ?></small>
		  </p>

	  <p>
	   	<label for="<?php echo esc_attr($this->get_field_id( 'tag' )); ?>"><?php esc_html_e( 'Tagged with', 'kbg' ); ?>:</label>
		<input id="<?php echo esc_attr($this->get_field_id( 'tag' )); ?>" type="text" name="<?php echo esc_attr($this->get_field_name( 'tag' )); ?>" value="<?php echo esc_attr(kb_get_tax_term_name_by_slug($instance['tag'])); ?>" class="widefat" />
		<small class="howto"><?php esc_html_e( 'Specify one or more tags separated by comma. i.e. life, cooking, funny moments', 'kbg' ); ?></small>
	  </p>


	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'time' )); ?>"><?php esc_html_e( 'Only select posts which are not older than', 'kbg' ); ?>:</label>
		<select id="<?php echo esc_attr($this->get_field_id( 'time' )); ?>" type="text" name="<?php echo esc_attr($this->get_field_name( 'time' )); ?>" class="widefat">
			<?php $time = kb_get_time_diff_opts(); ?>
			<?php foreach ( $time as $key => $value ): ?>
				<option value="<?php echo esc_attr($key); ?>" <?php selected( $instance['time'], $key, true ); ?>><?php echo esc_html( $value );?></option>
			<?php endforeach; ?>
		</select>
	</p>	

	<?php
	}


	function widget_orderby( $widget_instance = false, $orderby = false ) {

		$orders = kbg_get_post_order_opts();

		if ( !empty( $widget_instance ) ) { ?>
				<label for="<?php echo esc_attr($widget_instance->get_field_id( 'orderby' )); ?>"><?php esc_html_e( 'Order by:', 'kbg' ); ?></label>
				<select id="<?php echo esc_attr($widget_instance->get_field_id( 'orderby' )); ?>" name="<?php echo esc_attr($widget_instance->get_field_name( 'orderby' )); ?>" class="widefat">
					<?php foreach ( $orders as $key => $order ) { ?>
						<option value="<?php echo esc_attr($key); ?>" <?php selected( $orderby, $key );?>><?php echo esc_html( $order ); ?></option>
					<?php } ?>
				</select>
		<?php }
	}

	function widget_category( $widget_instance, $category, $selected_category = false ) {
		if ( !empty( $widget_instance ) && !empty( $category ) ) {
			$taxonomies = get_terms( 'category', 'orderby=name&hide_empty=0' );
			?>
				<label for="<?php echo esc_attr($widget_instance->get_field_id( 'category' )); ?>"><?php esc_html_e( 'Choose from category:', 'kbg' ); ?></label><br/>
					<?php foreach ( $taxonomies as $category ) { ?>
						<input type="checkbox" name="<?php echo esc_attr($widget_instance->get_field_name( 'category' )); ?>[]" value="<?php echo esc_attr($category->term_id); ?>" <?php echo in_array( $category->term_id, (array)$selected_category ) ? 'checked': ''?> /> <?php echo esc_html( $category->name ); ?><br/>
					<?php }
		}
	}

	function widget_meta( $widget_instance = false, $current = false ) {

		$meta = kbg_get_meta_opts();

		if ( !empty( $widget_instance ) ) : ?>
				<label for="<?php echo esc_attr($widget_instance->get_field_id( 'meta' )); ?>"><?php esc_html_e( 'Display meta data:', 'kbg' ); ?></label><br/>
				<?php foreach ( $meta as $id => $title ) : ?>
				<?php $checked = in_array($id, $current ) ? 'checked="checked"' : ''; ?>
				<input type="checkbox" id="<?php echo esc_attr($widget_instance->get_field_id( 'meta' )); ?>" name="<?php echo esc_attr($widget_instance->get_field_name( 'meta' )); ?>[]" value="<?php echo esc_attr($id); ?>" <?php echo esc_attr( $checked ); ?>> <?php echo esc_html( $title ); ?><br/>
				<?php endforeach; ?>
		<?php endif; ?>
	<?php }


}
