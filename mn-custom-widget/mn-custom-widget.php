<?php
/**
* Plugin Name: MN Custom Widget
* Description: This is MN Custom Widget plugin, which gives idea about widget basics
* Author: Abdur Rahman
* Version: 1.0
* Author URI: https://github.com/devabdurrahman
* 
**/

if(!defined("ABSPATH")){
	exit;
}

add_action("widgets_init", "mn_register_widget");

include_once plugin_dir_path(__FILE__) . "/Mn_Custom_Widget.php";

function mn_register_widget(){
	register_widget("Mn_Custom_Widget");
}

// Add admin scripts
add_action( "admin_enqueue_scripts", "mn_add_script_file" );
function mn_add_script_file(){
	//js
	wp_enqueue_script("mn-script-js", plugin_dir_url( __FILE__ ) . "assets/js/script.js", array("jquery"));
	//css
	wp_enqueue_style("mn-style-css", plugin_dir_url( __FILE__ ) . "assets/css/style.css");

}