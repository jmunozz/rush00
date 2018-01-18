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

//User is not allowed to access this page.
if(!$is_admin) {
	include('./templates/access_denied.html');
	exit();
}

//Admin submit a new category
if(isset($_POST['add'])) {

	$name = isset($_POST['name']) ? $_POST['name'] : null;
	$description = isset($_POST['description']) ? $_POST['description'] : null;

	if (!$name || !$description) {
		$alert = "Field blank or missing";
	} else {
		// Add tag to DB.
		$success = addTag(array(
			'name' => preg_replace('/ +/', '-', $name),
			'description' => $description 
		));
		// Choose what alert to display.
		if ($success)
			$alert = 'A new category has been added!';
		else
			$alert = 'Impossible to add new category!';
	}
}

//Render page with templates
include('../templates/head.html');
include('../templates/header.php');
include('../templates/alert.php');
include('../templates/admin/menu.php');
include('../templates/admin/add_category.php');
include('../templates/footer.html');


?>