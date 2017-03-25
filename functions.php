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
		header('Location: /kolyanphp/lesson10/');
		exit();
	}
}
function logout_user(){
	unset($_SESSION['user']);
	$_SESSION['messages'][]=['danger', 'You are logged out'];
	header('Location: /kolyanphp/lesson10/');
	exit();
}

