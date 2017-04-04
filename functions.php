<?php
function handle_user_request (){
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['password'])) {
		return  [
			'name' => $_POST['name'],
			'pass' => $_POST['password']
		];
	}
	return NULL;
}

function register_user($user_array){
	global $conn;
	$name = $user_array['name'];
	$is_admin = $name === 'admin' ? 1 : 0;
	$pass = password_hash($user_array['pass'], PASSWORD_DEFAULT);

	mysqli_query($conn, 
		"INSERT INTO users(name, pass, is_admin) VALUES('{$name}', '{$pass}', {$is_admin})");
	if (!mysqli_error($conn)) {
		login_user([
			'name' => $name,
			'pass' => $user_array['pass']
			]);
	} else {
		echo  mysqli_error($conn);
	}
}
function login_user ($user_array){
	global $conn;
	$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE name = '{$user_array['name']}'"));
	if ($user && password_verify($user_array['pass'], $user['pass'])){
		$_SESSION['messages'][]=['success', 'You are successfully logged in'];
		unset($user['pass']);
		$_SESSION['user'] = $user;
		end_and_home();
	}
}
function logout_user(){
	unset($_SESSION['user']);
	$_SESSION['messages'][]=['success', 'You are logged out'];
	end_and_home();
}

function only_for_admin(){
	global $user;
	if (!$user || !$user['is_admin']) {
		$_SESSION['messages'][]=['danger', 'Only admins allowed to visible this page'];
		end_and_home();
	}
}

function end_and_home(){
	header('Location: /kolyanphp/lesson10/index.php');
	exit();
}

function get_name_from_post(){
	if (isset($_POST['name'])) {
		return $_POST['name'];
	}
	return NULL;
}

function save_category($name){
	global $conn;
	if(strlen($name)){
		mysqli_query($conn, "INSERT INTO categories(name) VALUE('{$name}')");
		if (mysqli_error($conn)){
			$_SESSION['messages'][]=['warning', "Category '{$name}' already exists"];	
		}else{
			$_SESSION['messages'][]=['success', "Category '{$name}' has been saved"];
		}
	}else{
		$_SESSION['messages'][]=['danger', 'Name too short'];	
	}
	header('Location: ' . $_SERVER['REQUEST_URI']);
	exit();
}

function save_maker($name){
	global $conn;
	if(strlen($name)){
		mysqli_query($conn, "INSERT INTO makers(name) VALUE('{$name}')");
		if (mysqli_error($conn)) {
			$_SESSION['messages'][]=['warning', "Maker '{$name}' already exists"];	
		}else{
			$_SESSION['messages'][]=['success', "Maker '{$name}' has been saved"];	
		}
	}else{
		$_SESSION['messages'][]=['danger', 'Name too short'];	
	}
	header('Location: ' . $_SERVER['REQUEST_URI']);
	exit();
}



function get_item_from_post(){
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		foreach (['model', 'category', 'maker'] as $var) {
			if(isset($_POST[$var])){
				$$var = $_POST[$var];
			}else{
				$$var = NULL;
			}
		}

		if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
			$destination = "/kolyanphp/lesson10/public/" . time() . str_replace(' ','',$_FILES['image']['name']);
			move_uploaded_file($_FILES['image']['tmp_name'], "../../.." . $destination);
		}else{
			$destination = NULL;
		}
		return [
				'model' => $model,
				'category' => $category,
				'maker' => $maker,
				'image_path' => $destination,
		];
	}
}


function save_item($item){
	global $conn;
	mysqli_query($conn,
		"INSERT INTO items(model, image_path, category_id, maker_id)
		VALUES('{$item['model']}','{$item['image_path']}','{$item['category']}','{$item['maker']}')");
	if (mysqli_error($conn)) {
		$_SESSION['messages'][]=['danger', mysqli_error($conn)];	
	}else{
		$_SESSION['messages'][]=['success', 'Item has been saved'];	
	}
	header('Location: ' . $_SERVER['REQUEST_URI']);
	exit();
}

function get_comment_from_post(){
	global $user;
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$content = isset($_POST['content']) ? $_POST['content'] : '';
		$user_id = $user['id'];
		return[
			'content' => $content,
			'author' => $user_id,
			'item' =>  $_GET['id']
		]; 
	}
}

function save_comment($c){
	global $conn;
	if ($c) {
		mysqli_query($conn, "INSERT INTO comments(content, author_id, item_id)
			VALUES('{$c['content']}', {$c['author']}, {$c['item']})");
			if (mysqli_error($conn)) {
					$_SESSION['messages'][]=['danger', mysqli_error($conn)];	
				}else{
					$_SESSION['messages'][]=['success', 'Comment added'];	
				}
				header('Location: ' . $_SERVER['REQUEST_URI']);
				exit();
	}
}