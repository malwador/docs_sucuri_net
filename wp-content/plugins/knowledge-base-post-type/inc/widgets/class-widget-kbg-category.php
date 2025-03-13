<?php

/**
 * CPT Category widget
 *
 * @package KB_CPT
 */

namespace Kbg\KB_CPT;


/**
 * 
 * Extend default widget to create custom CPT taxonomy category
 * 
 */

class KBG_Category_Widget extends \WP_Widget {

	var $defaults;

	function __construct() {

		$widget_ops = array( 
			'classname' => 'widget_categories', 
			'description' => esc_html__( 'Display your knowledge base categories with this widget', 'kbg' ) 
		);

		$control_ops = array( 'id_base' => 'kbg_category_widget' );

		parent::__construct( 'kbg_category_widget', esc_html__( 'Knowledge Base Categories', 'kbg' ), $widget_ops, $control_ops );

		$this->defaults = array(
			'title' => esc_html__( 'Categories', 'kbg' ),
			'categories' => array(),
			'count' => 1
		);
	}


	function widget( $args, $instance ) {
		extract( $args );
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		echo wp_kses_post( $before_widget );

		$title = apply_filters( 'widget_title', $instance['title'] );

		if ( !empty($title) ) {
			echo wp_kses_post( $before_title . $title . $after_title );
		}

		?>

		<ul>
		    <?php $cats = get_terms( array('taxonomy' => 'kbg_category', 'include'	=> $instance['categories']) ); ?>
		    <?php $cats = kb_sort_option_items( $cats,  $instance['categories']); ?>
		    <?php foreach($cats as $cat): ?>
		    	<?php $count = !empty($instance['count']) ? '<span class="count">'.$cat->count.'</span>' : ''; ?>
		    	<?php $cat_class = empty($instance['count']) ? 'category-text mr--reset' : 'category-text'; ?>
		    	<li><a href="<?php echo esc_url(get_term_link($cat)); ?>"><span class="<?php echo esc_attr( $cat_class ) ?>"><?php echo esc_html( $cat->name ); ?></span><?php echo wp_kses_post( $count ); ?></a></li>
		    <?php endforeach; ?> 
		</ul>

		<?php
		echo wp_kses_post( $after_widget );
	}


	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['categories'] = !empty($new_instance['categories']) ? $new_instance['categories'] : array();
		$instance['count'] = isset($new_instance['count']) ? 1 : 0;
		
		return $instance;
	}

	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, $this->defaults ); ?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title', 'kbg' ); ?>:</label>
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" type="text" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>

		<?php $cats = get_terms( array('taxonomy' => 'kbg_category', 'hide_empty' => false, 'number' => 0 ) ); ?>
		<?php $cats = kbg_sort_option_items( $cats,  $instance['categories']); ?>

		<p class="kbg-widget-content-sortable">
		<?php foreach ( $cats as $cat ) : ?>
		   	<?php $checked = in_array( $cat->term_id, $instance['categories'] ) ? 'checked' : ''; ?>
		   	<label><input type="checkbox" name="<?php echo esc_attr($this->get_field_name( 'categories' )); ?>[]" value="<?php echo esc_attr($cat->term_id); ?>" <?php echo esc_attr($checked); ?> /><?php echo esc_html( $cat->name );?></label>
		<?php endforeach; ?>
		</p>

		<p>
			<label><input type="checkbox" name="<?php echo esc_attr($this->get_field_name( 'count' )); ?>" value="1" <?php echo checked($instance['count'], 1, true); ?> /><?php esc_html_e( 'Show post count?', 'kbg' ); ?></label>
		</p>

		<?php
	}

}
