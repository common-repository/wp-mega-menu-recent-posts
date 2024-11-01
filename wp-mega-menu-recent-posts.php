<?php
/*
Plugin Name: WP Mega Menu Recent Posts 
Description: Show Recent Posts in Submenu of Max Mega Menu.
Author: K. Kumar
Author URI: https://profiles.wordpress.org/krishna121
Version: 1.0.4
WC tested up to: 4.4.1
WC requires at least: 2.6
Text Domain: wp-mega-menu-recent-posts
*/
if(!class_exists('WP_Mega_Menu_Recent_Posts')){

	/**
	*  Main Class file of plugin
	*/
	class WP_Mega_Menu_Recent_Posts 
	{
		
		function __construct()
		{	
			$this->hook_init();
			$this->load_widget_file();
			
		}

		function hook_init(){

			add_action( 'widgets_init', array($this,'wp_mega_menu_widget'));
			add_action( 'wp_enqueue_scripts', array($this,'wpmm_include_scripts'));

		}

		function wpmm_include_scripts() {
			wp_enqueue_style( 'wpmm-custom-css',plugins_url( '/assests/css/custom.css', __FILE__ ));
		}

		function wp_mega_menu_widget(){
			register_widget("mega_menu_recent_posts");
		}

		function load_widget_file(){
			include("inc/recent_posts_widget.php");
		}
		
	}

	return new WP_Mega_Menu_Recent_Posts();

}


?>