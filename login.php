<?php 
require_once 'init.php';

$user_array = handle_user_request();

if($user_array){
	login_user($user_array);
}

$render_content = function(){
	$submit_label = 'login';
	include 'tpl/user_form.html';
};



require 'tpl/base.html';
