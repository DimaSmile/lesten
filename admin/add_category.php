<?php

require "../init.php";

only_for_admin();

$render_content = function(){
	$category = get_name_from_post();

	if ($category !== NULL) {
		save_category($category);
	}
	include '../tpl/category_form.html';
};


require "../tpl/base.html";