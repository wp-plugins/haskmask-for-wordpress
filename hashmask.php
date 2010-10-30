<?php

/**
Plugin Name: Hashmask for WordPress
Plugin URI: http://wordpress.org/extend/plugins/haskmask-for-wordpress/
Description: Adds arc90's hashmask to the admin log in field.
Author: Shamess
Version: 0.9.1
Author URI: http://shamess.info/
*/

//  Register the scripts we need, and then enqueue them
function queueScripts () {
	$base_url = WP_PLUGIN_URL.'/'.str_replace (basename ( __FILE__), "" ,plugin_basename(__FILE__));
	
	wp_register_script ('sparkline', $base_url.'jquery.sparkline-1.4.2.js', array( 'jquery' ));
	wp_register_script ('jquery-sha1', $base_url.'jquery.sha1.js', array( 'jquery' ));
	wp_register_script ('hashmask', $base_url.'jquery.hashmask.js', array( 'sparkline', 'jquery-sha1' ));
	wp_enqueue_script ('hashmask');
}

//  We need to do different things depending on which page we're in
//  Trigger on login page
if ('wp-login.php' == substr (basename ($_SERVER['REQUEST_URI']), 0, 12)) {
	queueScripts();
	
	add_action('login_head', 'wp_print_head_scripts', 1);
	add_action('login_head', 'wp_enqueue_scripts', 1);
	
	function add_hashmask_script () {
		echo "<script language=\"JavaScript\" type=\"text/javascript\">
		jQuery(function () {
			jQuery('#user_pass').hashmask();
		});
		</script>";
	}

	add_action ('login_head', add_hashmask_script);
//  Trigger on user profile change pages
} elseif ('profile.php' == substr (basename ($_SERVER['REQUEST_URI']), 0, 11) || 'user-edit.php' == substr (basename ($_SERVER['REQUEST_URI']), 0, 13) || 'user-new.php' == substr (basename ($_SERVER['REQUEST_URI']), 0, 12)) {
	queueScripts();
	
	function add_hashmask_script () {
		echo "<script language=\"JavaScript\" type=\"text/javascript\">
		jQuery(function () {
			//  Make the new password fields wider
			jQuery('#pass1, #pass2').attr ('size', 30);
			jQuery('#pass1, #pass2').hashmask();
			jQuery('.indicator-hint').append (' <strong>Also</strong>, if the two images in the password field don\'t match each other, your passwords don\'t match each other. You should retype them.');
		});
		</script>";
	}
	
	add_action ('admin_head', add_hashmask_script);
}
?>