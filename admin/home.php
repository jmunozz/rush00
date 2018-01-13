<?php

//Display all error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Includes functions and constants.
require_once('../config/constants.php');
require_once('../config/functions.php');
	
//Get session infos
session_start();
$is_admin = isset($_SESSION['is_admin']) && ($_SESSION['is_admin'] == 1);
$is_logged = isset($_SESSION['login']) && $_SESSION['login'] !== '';

//User is not allowed to access this page
if(!$is_admin) {
	include('./templates/access_denied.html');
	exit();
}

//Render page with templates
include('../templates/head.html');
include('../templates/header.php');
include('../templates/admin/menu.php');

?>