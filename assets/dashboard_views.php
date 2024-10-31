<?php

if ( !defined( 'ABSPATH' ) ) exit;
Class Modify_Dashboard_Widgets {
    function __construct()
    {
        add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widgets' ) );
    }
    function add_dashboard_widgets()
	{
	    global $ppc_dashboard_views;
	    foreach ($ppc_dashboard_views as $widget_id => $options)
	    {
	        wp_add_dashboard_widget(
	            $widget_id,
	            $options['title'],
	            $options['callback']
	        );
	    }
	}
 
}
$wdw = new Modify_Dashboard_Widgets();

$ppc_dashboard_views = array(
    'popular-posts-count-views' => array(
        'title' => 'Popular Posts Count (Top 10)',
        'callback' => 'post_dashboard_widget_function'
    )
);
 
 
function post_dashboard_widget_function() {
$options = get_option( 'popular_posts_form' );
$popular_dash_days = $options['ppcdashdays'];
$popular_dash_dis = $options['ppcdashdis'];
 echo 	"<ul id='dash-post'>";
		 if($popular_dash_days == '1'){
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-1 days')) . "'";
			return $where;
			}
		 } elseif ($popular_dash_days == '2') {
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-2 days')) . "'";
			return $where;
			}
		 } elseif ($popular_dash_days == '3') {
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-3 days')) . "'";
			return $where;
			}
		 } elseif ($popular_dash_days == '7') {
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-7 days')) . "'";
			return $where;
			}
		 } elseif ($popular_dash_days == '14') {
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-14 days')) . "'";
			return $where;
			}
		 } elseif ($popular_dash_days == '21') {
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-21 days')) . "'";
			return $where;
			}
		 } elseif ($popular_dash_days == '30') {
			function filter_where( $where = '' ) {
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-30 days')) . "'";
			return $where;
			}
		 } elseif ($popular_dash_days == '60') {
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
			if($popular_dash_dis == 'Posts'){
            $pop_post = new WP_Query('meta_key=post_views_count&orderby=meta_value_num&order=DESC&posts_per_page=10');
			} else {
			$pop_post = new WP_Query('meta_key=post_views_count&orderby=meta_value_num&post_type=product&order=DESC&posts_per_page=10');
			}
		remove_filter( 'posts_where', 'filter_where' );
            if ($pop_post->have_posts()) : while ($pop_post->have_posts()) : $pop_post->the_post(); ?>
			<li>
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			<span><?php echo getPostsCounts(get_the_ID()); ?> Views</span>
            <div class="clear"></div>
            </li>
			
			<?php endwhile; endif; wp_reset_query();

    echo "<div class='clear'></div></ul>";
        } ;
