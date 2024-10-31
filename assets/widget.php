<?php
/*
 * Plugin Name: Popular Posts Count Widget
 * Plugin URI: http://coderssociety.in
 * Description: A widget to show popular viewed posts with view counts in sidebar.
 * Version: 1.3
 * Author: Coders Society
 * Author URI: http://coderssociety.in
 */

if ( !defined( 'ABSPATH' ) ) exit;
//add function to widget_init to load
add_action( 'widgets_init', 'popular_posts_cs' );

//register widget
function popular_posts_cs() {
	register_widget( 'post_cs' );
}

class post_cs extends WP_Widget {
function __construct() {
		parent::__construct(
			'popular-posts-count', // Base ID
			'Popular Posts Count Widget', // Name
			array( 'description' => 'A widget to show popular viewed posts with view counts in sidebar.' ) // Args
		);
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		
		//get values from widget.
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Popular Posts Count' ) : $instance['title'], $instance, $this->id_base );
		$post_limits = empty( $instance['post_limits'] ) ? '' : $instance['post_limits'];
		$popular_days = empty( $instance['popular_days'] ) ? '' : $instance['popular_days'];
		$popular_skin = empty( $instance['popular_skin'] ) ? '' : $instance['popular_skin'];
		$popular_pby = empty( $instance['popular_pby'] ) ? '' : $instance['popular_pby'];
		$popular_show = empty( $instance['popular_show'] ) ? '' : $instance['popular_show'];
		$popular_tag = empty( $instance['post_trm'] ) ? '' : $instance['post_trm'];
		$post_pad = empty( $instance['post_pad'] ) ? '' : $instance['post_pad'];
		echo $before_widget; 
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];?>
        <?php if($popular_pby == 'views'){?>
        <ul id="posts-count" class="<?php echo $popular_skin; ?>">
         <?php
		 if($popular_days == '1'){
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-1 days')) . "'";
			return $where;
			}
		 } elseif ($popular_days == '2') {
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-2 days')) . "'";
			return $where;
			}
		 } elseif ($popular_days == '3') {
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-3 days')) . "'";
			return $where;
			}
		 } elseif ($popular_days == '7') {
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-7 days')) . "'";
			return $where;
			}
		 } elseif ($popular_days == '14') {
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-14 days')) . "'";
			return $where;
			}
		 } elseif ($popular_days == '21') {
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-21 days')) . "'";
			return $where;
			}
		 } elseif ($popular_days == '30') {
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-30 days')) . "'";
			return $where;
			}
		 } elseif ($popular_days == '60') {
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-60 days')) . "'";
			return $where;
			}
		 } else {
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-90 days')) . "'";
			return $where;
			}
		 }
		add_filter( 'posts_where', 'filter_where' );
			if($popular_show == 'posts'){
            $pop_post = new WP_Query('meta_key=post_views_count&orderby=meta_value_num&order=DESC&posts_per_page='.$post_limits.'');
			} else {
			$pop_post = new WP_Query('meta_key=post_views_count&orderby=meta_value_num&post_type=product&order=DESC&posts_per_page='.$post_limits.'');
			}
		remove_filter( 'posts_where', 'filter_where' );
            if ($pop_post->have_posts()) : while ($pop_post->have_posts()) : $pop_post->the_post(); ?>
            		<li>
					<a href="<?php the_permalink(); ?>" style="padding:<?php echo $post_pad; ?>">
                    <span><?php the_title(); ?></span> <small><?php echo getPostsCounts(get_the_ID()); ?> <span><?php echo $popular_tag; ?></span></small>
                    </a>
                    </li>
       
    
		<?php endwhile; endif; wp_reset_query();?>
    	<div class="clear"></div>
        </ul>
        <?php } else { ?>
        <ul id="posts-count" class="<?php echo $popular_skin; ?>">
         <?php
		 if($popular_days == '1'){
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-1 days')) . "'";
			return $where;
			}
		 } elseif ($popular_days == '2') {
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-2 days')) . "'";
			return $where;
			}
		 } elseif ($popular_days == '3') {
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-3 days')) . "'";
			return $where;
			}
		 } elseif ($popular_days == '7') {
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-7 days')) . "'";
			return $where;
			}
		 } elseif ($popular_days == '14') {
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-14 days')) . "'";
			return $where;
			}
		 } elseif ($popular_days == '21') {
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-21 days')) . "'";
			return $where;
			}
		 } elseif ($popular_days == '30') {
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-30 days')) . "'";
			return $where;
			}
		 } elseif ($popular_days == '60') {
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-60 days')) . "'";
			return $where;
			}
		 } else {
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-90 days')) . "'";
			return $where;
			}
		 }
		add_filter( 'posts_where', 'filter_where' );
			if($popular_show == 'posts'){
            $pop_post = new WP_Query('orderby=comment_count&order=DESC&posts_per_page='.$post_limits.'');
			} else {
            $pop_post = new WP_Query('orderby=comment_count&post_type=product&order=DESC&posts_per_page='.$post_limits.'');
			}
		remove_filter( 'posts_where', 'filter_where' );
            if ($pop_post->have_posts()) : while ($pop_post->have_posts()) : $pop_post->the_post(); ?>
            		<li>
					<a href="<?php the_permalink(); ?>" style="padding:<?php echo $post_pad; ?>">
                    <span><?php the_title(); ?></span> <small><?php comments_number( '0', '1', '%' ); ?> <span><?php echo $popular_tag; ?></span></small>
                    </a>
                    </li>
       
    
		<?php endwhile; endif; wp_reset_query();?>
    	<div class="clear"></div>
        </ul>
        <?php } ?>
        <?php
		echo $after_widget;
	
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['post_limits'] = strip_tags( $new_instance['post_limits'] );
		$instance['post_trm'] = strip_tags( $new_instance['post_trm'] );
		$instance['post_pad'] = strip_tags( $new_instance['post_pad'] );
		
		if ( in_array( $new_instance['popular_days'], array( '1', '2', '3', '7', '14', '21', '30', '60', '90' ) ) ) {
			$instance['popular_days'] = $new_instance['popular_days'];
		} else {
			$instance['popular_days'] = '';
		}
		if ( in_array( $new_instance['popular_skin'], array( 'Style-1', 'Style-2', 'Style-3', 'Style-4' ) ) ) {
			$instance['popular_skin'] = $new_instance['popular_skin'];
		} else {
			$instance['popular_skin'] = '';
		}
		if ( in_array( $new_instance['popular_pby'], array( 'views', 'comments' ) ) ) {
			$instance['popular_pby'] = $new_instance['popular_pby'];
		} else {
			$instance['popular_pby'] = '';
		}
		if ( in_array( $new_instance['popular_show'], array( 'posts', 'products' ) ) ) {
			$instance['popular_show'] = $new_instance['popular_show'];
		} else {
			$instance['popular_show'] = '';
		}
		return $instance;
		
	}	   
	

  function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array('post_limits' => '5', 'title' => 'Popular Posts Count', 'popular_days' => '', 'popular_skin' => '1', 'popular_pby' => 'views', 'popular_show' => 'posts', 'post_pad' => '5px 5px 5px 5px', 'post_trm' => 'views') );
		$title = esc_attr( $instance['title'] );
		$post_limits = esc_attr( $instance['post_limits'] );
		$popular_days = esc_attr( $instance['popular_days'] );
		$popular_skin = esc_attr( $instance['popular_skin'] );
		$popular_pby = esc_attr( $instance['popular_pby'] );
		$popular_show = esc_attr( $instance['popular_show'] );
		$popular_tag = esc_attr( $instance['post_trm'] );
		$post_pad = esc_attr( $instance['post_pad'] ); ?>
    
   		<!-- widget title -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
        <!-- show by  -->
		<p>
			<label for="<?php echo $this->get_field_id('popular_show'); ?>"><?php _e( 'Display:' ); ?></label>
			<select name="<?php echo $this->get_field_name('popular_show'); ?>" id="<?php echo $this->get_field_id('popular_show'); ?>" class="widefat">
				<option value="posts"<?php selected( $instance['popular_show'], 'posts' ); ?>><?php _e('Posts'); ?></option>
				<option value="products"<?php selected( $instance['popular_show'], 'products' ); ?>><?php _e('Products'); ?></option>
			</select>
		</p>
        <!-- post postby -->
		<p>
			<label for="<?php echo $this->get_field_id('popular_pby'); ?>"><?php _e( 'Display by:' ); ?></label>
			<select name="<?php echo $this->get_field_name('popular_pby'); ?>" id="<?php echo $this->get_field_id('popular_pby'); ?>" class="widefat">
				<option value="views"<?php selected( $instance['popular_pby'], 'views' ); ?>><?php _e('Views'); ?></option>
				<option value="comments"<?php selected( $instance['popular_pby'], 'comments' ); ?>><?php _e('Comments'); ?></option>
			</select>
		</p>
        <!-- post days -->
		<p>
			<label for="<?php echo $this->get_field_id('popular_days'); ?>"><?php _e( 'Days:' ); ?></label>
			<select name="<?php echo $this->get_field_name('popular_days'); ?>" id="<?php echo $this->get_field_id('popular_days'); ?>" class="widefat">
				<option value="1"<?php selected( $instance['popular_days'], '1' ); ?>><?php _e('1 day'); ?></option>
				<option value="2"<?php selected( $instance['popular_days'], '2' ); ?>><?php _e('2 days'); ?></option>
				<option value="3"<?php selected( $instance['popular_days'], '3' ); ?>><?php _e('3 days'); ?></option>
				<option value="7"<?php selected( $instance['popular_days'], '7' ); ?>><?php _e('7 days'); ?></option>
				<option value="14"<?php selected( $instance['popular_days'], '14' ); ?>><?php _e('14 days'); ?></option>
				<option value="21"<?php selected( $instance['popular_days'], '21' ); ?>><?php _e('21 days'); ?></option>
				<option value="30"<?php selected( $instance['popular_days'], '30' ); ?>><?php _e('30 days'); ?></option>
				<option value="60"<?php selected( $instance['popular_days'], '60' ); ?>><?php _e('2 months'); ?></option>
				<option value="90"<?php selected( $instance['popular_days'], '90' ); ?>><?php _e('3 months'); ?></option>
			</select>
		</p>
        <!-- post limits -->
		<p>
			<label for="<?php echo $this->get_field_id('post_limits'); ?>"><?php _e( 'Posts Limits:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'post_limits' ); ?>" name="<?php echo $this->get_field_name( 'post_limits' ); ?>" value="<?php echo $instance['post_limits']; ?>" />
		</p>
        <!-- post term -->
		<p>
			<label for="<?php echo $this->get_field_id('post_trm'); ?>"><?php _e( 'Tag: <small><i>(views / comments)</i></small>' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'post_trm' ); ?>" name="<?php echo $this->get_field_name( 'post_trm' ); ?>" value="<?php echo $instance['post_trm']; ?>" />
		</p>
        <!-- post padding -->
		<p>
			<label for="<?php echo $this->get_field_id('post_pad'); ?>"><?php _e( 'Padding: <small><i>(top / right / bottom / left)</i></small>' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'post_pad' ); ?>" name="<?php echo $this->get_field_name( 'post_pad' ); ?>" value="<?php echo $instance['post_pad']; ?>" />
		</p>
        <!-- post skins -->
		<p>
			<label for="<?php echo $this->get_field_id('popular_skin'); ?>"><?php _e( 'Skins:' ); ?></label>
			<select name="<?php echo $this->get_field_name('popular_skin'); ?>" id="<?php echo $this->get_field_id('popular_skin'); ?>" class="widefat">
				<option value="Style-1"<?php selected( $instance['popular_skin'], 'Style-1' ); ?>><?php _e('Skin 1'); ?></option>
				<option value="Style-2"<?php selected( $instance['popular_skin'], 'Style-2' ); ?>><?php _e('Skin 2'); ?></option>
				<option value="Style-3"<?php selected( $instance['popular_skin'], 'Style-3' ); ?>><?php _e('Skin 3'); ?></option>
				<option value="Style-4"<?php selected( $instance['popular_skin'], 'Style-4' ); ?>><?php _e('Skin 4'); ?></option>
			</select>
		</p>
	
	
<?php 	
 }
}; ?>
