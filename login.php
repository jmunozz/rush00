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

//User is already loggin in, skip
if($is_logged) {
	header('Location: /');
	exit();
}

//An attempt to login has been submitted
if(isset($_POST['log'])) {

	$login = isset($_POST['login']) ? $_POST['login'] : null;
	$password = isset($_POST['login']) ? $_POST['login'] : nul;
	
	if(!$login || !$password) {
		$alert = "Field blank or missing";
	} else {
		$allUsers = getAll('users');
		foreach($allUsers as $user) {
			// Logs match !!
			if($user['login'] === $login && $user['password'] === hash('whirlpool', $password)) {
				// Update session.
				$_SESSION['login'] = $login;
				$_SESSION['is_admin'] = $user['is_admin'];
				$_SESSION['id'] = $user['id'];
				// Redirect.
				header('Location: /');
				exit();
			}
		}
		$alert = 'No match found for this user/password';
	}
}

//Render page with templates
include('./templates/head.html');
include('./templates/header.php');
include('./templates/alert.php');
include('./templates/login.php');
include('./templates/footer.html');
