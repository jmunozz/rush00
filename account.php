<?php

//Display all error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Includes functions and constants.
require_once('./config/constants.php');
require_once('./config/functions.php');

//Get session infos
session_start();
$is_admin = isset($_SESSION['is_admin']) && ($_SESSION['is_admin'] == 1);
$is_logged = isset($_SESSION['login']) && $_SESSION['login'] !== '';

if(!$is_logged)
	exit();
if (isset($_POST['delaccount']))
{
deleteUser($_SESSION['id']);
$_SESSION['login'] = '';
$_SESSION['is_admin'] = '';
$_SESSION['id'] = '';
session_destroy();
header("Location: /");
}
else
{
include('./templates/head.html');
include('./templates/header.php');
include('./templates/account.php');
include('./templates/footer.html');
}