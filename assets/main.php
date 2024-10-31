<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
// fuction to get counts
$options = get_option( 'popular_posts_form' );
function getPostsCounts($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count.'';
}
function setPostsCounts($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
// Remove issues with prefetching adding extra views
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
add_filter('the_content', 'set_post_counts');
function set_post_counts($content) {
	if (is_single()) {
		$content .= setPostsCounts(get_the_ID());
	return $content;
	}
	if (is_page()) {
		$content .= setPostsCounts(get_the_ID());
	return $content;
	}
	if (is_product()) {
		$content .= setPostsCounts(get_the_ID());
	return $content;
	}
}
/*--- columns ---*/
if($options["ppccolumn"] == "Yes"){
add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views',5,2);
function posts_column_views($defaults){
    $defaults['post_views_count'] = __('Total Views');
    return $defaults;
}
function posts_custom_column_views($column_name, $id){
        if($column_name === 'post_views_count'){
        echo getPostsCounts(get_the_ID());
    }
}
// Register the column as sortable
function posts_custom_column_views_sortable( $defaults ) {
    $defaults['post_views_count'] = 'post_views_count';

    return $defaults;
}
add_filter( 'manage_edit-post_sortable_columns', 'posts_custom_column_views_sortable' );
function posts_custom_column_views_orderby( $vars ) {
    if ( isset( $vars['orderby'] ) && 'post_views_count' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'post_views_count',
            'orderby' => 'meta_value_num'
        ) );
    }
 
    return $vars;
}
add_filter( 'request', 'posts_custom_column_views_orderby' );
}
/*--- shortcode ---*/
function popular_post_shortcode(){
ob_start();
	echo getPostsCounts(get_the_ID());
return ob_get_clean();
}
add_shortcode('post-views','popular_post_shortcode');

/*---- dashboard ---*/
if($options["ppcdash"] == "Yes"){
include_once( plugin_dir_path( __FILE__ ) . "dashboard_views.php");
}
$posts_columns = array('Yes','No');
$posts_dash = array('Yes','No');
$posts_dash_dis = array('Posts','Products');
$posts_dash_days = array('1', '2', '3', '7', '14', '21', '30', '60', '90');

//start settings page
function plugin_options_page_posts() {
if ( ! isset( $_REQUEST['updated'] ) )
$_REQUEST['updated'] = false;
global $posts_columns,$posts_dash,$posts_dash_days,$posts_dash_dis;
?>
<?php if( isset($_GET['settings-updated']) ) { ?>
    <div id="message" class="updated">
        <p><strong><?php _e('Settings saved.') ?></strong></p>
    </div>
<?php }
?>
<div id="ppc">
<div class="main-ppc">

<div class="main-hlf">
<form method="post" action="options.php" class="forms1">
<?php settings_fields( 'popular_posts_get' ); ?>
<?php $options = get_option( 'popular_posts_form' ); ?>
<h2>Popular Posts Count</h2>
<h3>Settings:</h3>
<div class="form-left">
<label for="popular_posts_form[ppccolumn]"><?php _e( 'Show Total Views column in POST Dashboard menu:' ); ?></label>
<select name="popular_posts_form[ppccolumn]">
<?php foreach ($posts_columns as $option) { ?>
<option <?php if ($options['ppccolumn'] == $option ){ echo 'selected="selected"'; } ?>><?php echo htmlentities($option); ?></option>
<?php } ?>
</select> 
</div> 
<div class="form-left">
<label for="popular_posts_form[ppcdash]"><?php _e( 'Show Total Views column in Admin Dashboard:' ); ?></label>
<select name="popular_posts_form[ppcdash]">
<?php foreach ($posts_dash as $option) { ?>
<option <?php if ($options['ppcdash'] == $option ){ echo 'selected="selected"'; } ?>><?php echo htmlentities($option); ?></option>
<?php } ?>
</select> 
</div> 
<div class="form-left">
<label for="popular_posts_form[ppcdashdis]"><?php _e( 'Display (Admin Dashboard):' ); ?></label>
<select name="popular_posts_form[ppcdashdis]">
<?php foreach ($posts_dash_dis as $option) { ?>
<option <?php if ($options['ppcdashdis'] == $option ){ echo 'selected="selected"'; } ?>><?php echo htmlentities($option); ?></option>
<?php } ?>
</select> 
</div> 
<div class="form-left">
<label for="popular_posts_form[ppcdashdays]"><?php _e( 'Days (Admin Dashboard):' ); ?></label>
<select name="popular_posts_form[ppcdashdays]">
<?php foreach ($posts_dash_days as $option) { ?>
<option <?php if ($options['ppcdashdays'] == $option ){ echo 'selected="selected"'; } ?>><?php echo htmlentities($option); ?></option>
<?php } ?>
</select> 
</div> 
<input name="submit" id="submit" value="Save Settings" type="submit"></p>
</form>
</div>

<div class="main-hlf-second">
<a href="<?php echo site_url(); ?>/wp-admin/widgets.php" class="plugin-link">Popular Posts Count Widget</a>
</div>

<h2>Shortcode to display view count</h2>
<p>For Post or Page or Products: <strong>[post-views] views/visits</strong></p>
<p>For PHP: <strong>&lt;?php echo do_shortcode('[post-views] views/visits'); ?&gt;</strong></p>
</div>

<div id="count-features">
<div class="getpro">
<h2>If you like this plugin then please rate us</h2>
<p><a href="https://wordpress.org/support/view/plugin-reviews/popular-posts-count" class="pros" target="_blank">Rate this Plugin</a></p>
</div>
</div>
<div class="clear"></div>
</div>
<?php
}
?>