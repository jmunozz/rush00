<?php

// Display all error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Includes functions and constants.
require_once('./config/constants.php');
require_once('./config/functions.php');

// Get session infos
session_start();
$is_admin = isset($_SESSION['is_admin']) && ($_SESSION['is_admin'] == 1);
$is_logged = isset($_SESSION['login']) && $_SESSION['login'] !== '';

//A signin form has been submitted
if (isset($_POST['sign'])) {

	$alert = null;
	$email = isset($_POST['email']) ? $_POST['email'] : null;
	$login = isset($_POST['login']) ? $_POST['login'] : null;
	$pwd = isset($_POST['password']) ? $_POST['password'] : null;

	if (!$email || !$login || !$pwd) {
		$alert = "Field blank or missing";
	} else {
		$allUsers = getAll('users');
		foreach($allUsers as $user) {
			if($user['email'] === $email)  {
				$alert = "This email is already used.";
				break;
			}
			if ($user['login'] === $login) {
				$alert = "This login is already used.";
				break;
			}
		}
	}
	if (!$alert) {
		$success = addUser(array(
			'login' => $login,
			'email' => $email,
			'password' => hash('whirlpool', $_POST['password'])
		));
		if (!$success)
			$alert = "User could not been added to DB.";
		else 
			$alert = "User has been added successfully!";
	}

}

//Render page with templates
include('./templates/head.html');
include('./templates/header.php');
include('./templates/alert.php');
include('./templates/signin.php');
