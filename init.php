<?php session_start();
$conn = mysqli_connect('localhost', 'root', 'dimasql', 'lesten');
$user = isset(($_SESSION['uaser']) ? $_SESSION['uaser'] : NULL);
// TPL_DIR = 'tpl';
include 'tpl/base.php';