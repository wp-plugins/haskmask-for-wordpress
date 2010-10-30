<?php
/**
Plugin Name: Hashmask for WordPress
Plugin URI: http://wordpress.org/extend/plugins/haskmask-for-wordpress/
Description: Adds arc90's hashmask to the admin log in field.
Author: Shamess
Version: 0.9.1
Author URI: http://shamess.info/
*/

//  By default these aren't on the default filters, so we add them here
add_action ('login_head', 'wp_print_head_scripts', 1);
add_action ('login_head', 'wp_enqueue_scripts', 1);

// we only need to load the scripts if we're on the login page...
if('wp-login.php' == substr (basename ($_SERVER[ 'REQUEST_URI' ]), 0, 12)) {
	$base_url = WP_PLUGIN_URL.'/'.str_replace (basename ( __FILE__), "" ,plugin_basename(__FILE__));
	
	wp_register_script ('sparkline', $base_url.'jquery.sparkline-1.4.2.js', array( 'jquery' ));
	wp_register_script ('jquery-sha1', $base_url.'jquery.sha1.js', array( 'jquery' ));
	wp_register_script ('hashmask', $base_url.'jquery.hashmask.js', array( 'sparkline', 'jquery-sha1' ));
	wp_enqueue_script ('hashmask');
}

function add_hashmask_script () {
	echo "<script language=\"JavaScript\" type=\"text/javascript\">jQuery(document).ready ( function () { jQuery('#user_pass').hashmask(); } );</script>";
}

add_action ('login_head', add_hashmask_script);

?>