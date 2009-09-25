<?php

//  Register the scripts we need, and then enqueue them
function queueScripts () {
	wp_register_script ('sparkline', '/wp-content/plugins/hashmaskforwordpress/jquery.sparkline-1.4.2.js', array( 'jquery' ));
	wp_register_script ('jquery-sha1', '/wp-content/plugins/hashmaskforwordpress/jquery.sha1.js', array( 'jquery' ));
	wp_register_script ('hashmask', '/wp-content/plugins/hashmaskforwordpress/jquery.hashmask.js', array( 'sparkline', 'jquery-sha1' ));
	wp_enqueue_script ('hashmask');
}

//  We need to do different things depending on which page we're in
//  Trigger on login page
if ('wp-login.php' == substr (basename ($_SERVER['REQUEST_URI']), 0, 12)) {
	queueScripts();
	
	//  These are required until this ticket ( https://core.trac.wordpress.org/ticket/10630 ) has been applied
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
} elseif ('profile.php' == substr (basename ($_SERVER['REQUEST_URI']), 0, 11) || 'user-edit.php' == substr (basename ($_SERVER['REQUEST_URI']), 0, 13)) {
	queueScripts();
	
	function add_hashmask_script () {
		echo "<script language=\"JavaScript\" type=\"text/javascript\">
		jQuery(function () {
			//  Make the new password fields wider
			jQuery('#pass1, #pass2').attr ('size', 30);
			jQuery('#pass1, #pass2').hashmask();
			jQuery('#pass1-jquery-hashmask-sparkline').css ('top', parseInt (jQuery('#pass1-jquery-hashmask-sparkline').css ('top')) - 12);
			jQuery('#pass2-jquery-hashmask-sparkline').css ('top', parseInt (jQuery('#pass2-jquery-hashmask-sparkline').css ('top')) - 12);
			jQuery('.indicator-hint').append (' <strong>Also</strong>, if the two images in the password field don\'t match each other, your passwords aren\'t the matching.');
		});
		</script>";
	}
	
	add_action ('admin_head', add_hashmask_script);
}
?>