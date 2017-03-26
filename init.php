<?php
session_start();
$conn = mysqli_connect('localhost', 'root', 'dimasql', 'lesten');
$user = isset($_SESSION['user']) ? $_SESSION['user'] : NULL;

if(!isset($_SESSION['messages'])){
	$_SESSION['messages'] = [];
}
require 'functions.php';
?>