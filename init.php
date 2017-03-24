<?php 
session_start();
$conn = mysqli_connect('localhost', 'root', 'dimasql', 'lesten');
// function create_connection()
// {
// 	$conn = mysqli_connect('localhost', 'root', 'dimasql', 'lesten');
// 	$get_connection = function() use ($conn){
// 		return $conn;
// 	};
// 	return $get_connection;
// }

// $GET_CONN = create_connection();

$user = isset($_SESSION['user']) ? $_SESSION['user'] : NULL;

require 'functions.php';