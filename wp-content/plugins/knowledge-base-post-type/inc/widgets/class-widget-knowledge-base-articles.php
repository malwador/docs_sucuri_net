<?php

/**
 * CPT Article widget
 *
 * @package KB_CPT
 */

namespace Kbg\KB_CPT;


/**
 * 
 * CPT posts
 * 
 */

class KBG_CPT_Knowledge_Base_Posts_Widget extends \WP_Widget {

	var $defaults;

	function __construct() {
		$widget_ops = array( 'classname' => 'kbg_cpt_article_widget related-posts-kb', 'description' => esc_html__( 'Display Knowledge Base articles with this widget', 'kbg' ) );
		$control_ops = array( 'id_base' => 'kbg_cpt_article_widget' );
		parent::__construct( 'kbg_cpt_article_widget', esc_html__( 'Knowledge Base Articles', 'kbg' ), $widget_ops, $control_ops );

		$this->defaults = array(
			'title' => esc_html__( 'Articles', 'kbg' ),
			'numposts' => 5,
			'taxonomy' => array(),
			'auto_detect_taxonomy' => false,
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
			'post_type'=> 'knowledge_base',
			'posts_per_page' => $instance['numposts'],
			'ignore_sticky_posts' => 1,
			'orderby' => $instance['orderby'],
			'post__not_in' => array($current_post_id)
		);


		if ( !empty( $instance['manual'] ) && !empty( $instance['manual'][0] ) ) {
			$q_args['posts_per_page'] = absint( count( $instance['manual'] ) );
			$q_args['orderby'] =  'post__in';
			$q_args['post__in'] =  $instance['manual'];
			$q_args['post_type'] = 'knowledge_base'; 

		} else {


			if ( !empty( $instance['tag'] ) ) {
				$q_args['tag_slug__in'] = $instance['tag'];
			}

			if ( !empty( $instance['auto_detect_taxonomy'] ) && is_single() ) {

				$taxonomies = get_terms( array('taxonomy' => 'kbg_category', 'hide_empty' => false ) );;

				foreach ($taxonomies as $taxonomy ) {
				 	$taxonomy_ids[] = $taxonomy->term_id;
				}
				 
				$q_args['tax_query'][] = array(
					'taxonomy' => 'kbg_category',
					'field'    => 'term_id',
					'terms'    => $taxonomy_ids
				);
				
			} else {

				if ( !empty( $instance['taxonomy'] ) ) {
					
					$q_args['tax_query'][] = array(
						'taxonomy' => 'kbg_category',
						'field'    => 'term_id',
						'terms'    => $instance['taxonomy']
					);
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

				<article <?php post_class( 'paragraph-small kbg-tax-list-type-standard' ); ?>>
					<?php the_title( sprintf( '<a class="d-flex" href="%s">', esc_url( get_permalink() ) ), '</a>' ); ?>
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
		$instance['taxonomy'] = $new_instance['taxonomy'];;
		$instance['auto_detect_taxonomy'] = isset( $new_instance['auto_detect_taxonomy'] ) ? 1 : 0;
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
	  	 <?php $this->widget_orderby( $this, $instance['orderby'] ); ?>
	    </p>

	   <p>
	   	 <label for="<?php echo esc_attr($this->get_field_id( 'manual' )); ?>"><?php esc_html_e( 'Or choose manually', 'kbg' ); ?>:</label>
		 <input id="<?php echo esc_attr($this->get_field_id( 'manual' )); ?>" type="text" name="<?php echo esc_attr($this->get_field_name( 'manual' )); ?>" value="<?php echo esc_attr(implode( ",", $instance['manual'] )); ?>" class="widefat" />
		 <small class="howto"><?php esc_html_e( 'Specify post ids separated by comma if you want to select only those articles. i.e. 213,32,12,45 Note: you can also choose pages as well as custom post types', 'kbg' ); ?></small>
	   </p>

		
		  <p>
		  	<?php $this->widget_taxonomy( $this, 'kbg_category', $instance['taxonomy'] ); ?>
		  </p>

		  <p>
			<input id="<?php echo esc_attr($this->get_field_id( 'auto_detect_taxonomy' )); ?>" type="checkbox" name="<?php echo esc_attr($this->get_field_name( 'auto_detect_taxonomy' )); ?>" value="1" <?php checked( 1, $instance['auto_detect_taxonomy'] ); ?>/>
			<label for="<?php echo esc_attr($this->get_field_id( 'auto_detect_taxonomy' )); ?>"><?php esc_html_e( 'Auto detect taxonomy', 'kbg' ); ?></label>
			<small class="howto"><?php esc_html_e( 'If sidebar is used on single template, display article from current post taxonomy | category', 'kbg' ); ?></small>
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

	function widget_taxonomy( $widget_instance, $taxonomy, $selected_taxonomy = false ) {
		if ( !empty( $widget_instance ) && !empty( $taxonomy ) ) {
			$taxonomies = get_terms( 'kbg_category', 'orderby=name&hide_empty=0' );
			?>
				<label for="<?php echo esc_attr($widget_instance->get_field_id( 'taxonomy' )); ?>"><?php esc_html_e( 'Choose from taxonomy:', 'kbg' ); ?></label><br/>
					<?php foreach ( $taxonomies as $taxonomy ) { ?>
						<input type="checkbox" name="<?php echo esc_attr($widget_instance->get_field_name( 'taxonomy' )); ?>[]" value="<?php echo esc_attr($taxonomy->term_id); ?>" <?php echo in_array( $taxonomy->term_id, (array)$selected_taxonomy ) ? 'checked': ''?> /> <?php echo esc_html( $taxonomy->name ); ?><br/>
					<?php }
		}
	}


}
