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

//Admin has submitted a new product
if(isset($_POST['add'])) {

	// Get and format tags for product.
	$tags = array();
	$keys = array_keys($_POST);
	foreach($keys as $key) {
		if (strpos($key, 'tag_') !== false)
			array_push($tags, substr($key, 4));
	}
	$tags = arrayToString($tags);

	// A file has been added
	$file_name = DEFAULT_IMG_NAME;
	if (!img_check_errors($_FILES['picture'])) {
		$file_name = img_rename($_FILES['picture']);
		img_upload($_FILES['picture'], $file_name);
	}

	//Add product to DB.
	$success = addProduct(array(
		'name' => $_POST['name'],
		'description' => $_POST['description'],
		'tags' => $tags, 
		'price' => $_POST['price'],
		'picture' => $file_name
	));

	//hoose what alert to display.
	if ($success)
		$alert = 'A new product has been added!';
	else
		$alert = 'Impossible to add new product!';
}

$allTags = getAll('tags');

//Render page with templates
include('../templates/head.html');
include('../templates/header.php');
include('../templates/alert.php');
include('../templates/admin/menu.php');
include('../templates/admin/add_product.php');
include('../templates/footer.html');
?>