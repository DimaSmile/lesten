<?php

require "../init.php";

only_for_admin();

$render_content = function(){
	$maker = get_name_from_post();

	if ($maker !== NULL) {
		save_maker($maker);
	}
	include '../tpl/category_form.html';
};


require "../tpl/base.html";