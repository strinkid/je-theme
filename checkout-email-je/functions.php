<?php
	function email_check(){
		return "test";
		die();
	};
	add_action('wp_ajax_email_check' , 'email_check');
	add_action('wp_ajax_nopriv_email_check','email_check');
?>