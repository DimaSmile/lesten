<?php

require "../init.php";

only_for_admin();

$render_content = function(){
	global $conn;
	$item = get_item_from_post();

	$base_query = "SELECT * FROM ";

	$makers = mysqli_query($conn, $base_query . 'makers');

	$categories = mysqli_query($conn, $base_query . 'categories');

	if ($item !== NULL) {
		save_item($item);
	}
	include '../tpl/item_form.html';
};


require "../tpl/base.html";