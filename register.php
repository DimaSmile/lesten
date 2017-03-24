<?php 
require_once 'init.php';


$user_array = handle_user_request();

if($user_array){
	register_user($user_array);
}

$render_content = function(){
	$submit_label = 'Register';
	include 'tpl/user_form.html';
};



require 'tpl/base.html';