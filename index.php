<?php
/*
Plugin Name: Popular Posts Count
Plugin URI: http://coderssociety.in
Description:  A light weight first of its kind plugin, Popular Posts Count is a highly customizable widget plugin which displays the total count of posts view on your blog without creating extra TABLE or DATABASE.
Version: 1.3
Author: Coders Society
Author URI: http://coderssociety.in
License: GPL2
*/
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
/* ---- plugin head ---- */
//add settings page to menu
function data_add_options_posts() {
add_menu_page( 'Popular Posts Count', 'Popular Posts Count', 'manage_options', 'popular-posts-counts.php', 'plugin_options_page_posts', plugins_url( 'popular-posts-count/assets/img/icon1.png' ), '99');
}
add_action( 'admin_menu', 'data_add_options_posts' );
//add actions
function popular_posts_count_register(){
    register_setting( 'popular_posts_get', 'popular_posts_form' );
}
add_action( 'admin_init', 'popular_posts_count_register' );
// Add settings link on plugin page
function popular_posts_link($links) { 
  $settings_link = '<a href="admin.php?page=popular-posts-counts.php">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'popular_posts_link' );
/* ---- plugin head end ---- */


function my1_init() {
	if (!is_admin()){	
		wp_register_style('post-counts-style', plugins_url( '/assets/css/posts-style.css' , __FILE__ ));
		wp_enqueue_style('post-counts-style');
  }
	else {
		wp_register_style('counts-style', plugins_url( '/assets/css/admin-style.css' , __FILE__ ));
		wp_enqueue_style('counts-style');
	}
}
add_action('init', 'my1_init');
include_once( plugin_dir_path( __FILE__ ) . "assets/widget.php");
include_once( plugin_dir_path( __FILE__ ) . "assets/main.php");
