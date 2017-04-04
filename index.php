<?php
require_once 'init.php';

$render_content = function(){
	global $conn;

	$category = isset($_GET['category']) ? $_GET['category'] : NULL;
	$maker = isset($_GET['maker']) ? $_GET['maker'] : NULL;
	$where_condition = [];

	if ($category) {
		$where_condition[] = " categories.name = '{$category}'";
	}
	if ($maker) {
		$where_condition[] = " makers.name = '{$maker}'";
	}

	$final_condition = count($where_condition) ? "WHERE "  . implode("AND ", $where_condition) : '';
	$items = mysqli_query($conn, "SELECT model, image_path, categories.name AS category, makers.name AS maker 
		FROM items JOIN categories ON items.category_id = categories.id
		JOIN makers ON items.maker_id = makers.id " . $final_condition);
	
	include 'tpl/items.html';
};

require 'tpl/base.html';
