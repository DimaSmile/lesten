<?php
require_once 'init.php';

$render_content = function(){
	global $conn;

	$comment_array = get_comment_from_post();
	save_comment($comment_array);

	$id = $_GET['id'];

	$item = mysqli_fetch_assoc(mysqli_query($conn, "SELECT model, image_path, categories.name AS category, makers.name AS maker 
			FROM items JOIN categories ON items.category_id = categories.id
			JOIN makers ON items.maker_id = makers.id WHERE items.id = {$id}"));
	
	$comments = mysqli_query($conn, 
		"SELECT content, name AS author
		FROM comments JOIN users ON author_id = users.id WHERE item_id = {$id} ");
	include 'tpl/item.html';
	include 'tpl/comments.html';
	include 'tpl/comment_form.html';
};

require 'tpl/base.html';
