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

//Admin has modified a product
if (isset($_POST['modify'])) {

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

	// Edit product in DB.
	$success = editProduct(array(
		'name' => $_POST['name'],
		'description' => $_POST['description'],
		'picture' => $file_name,
		'price' => $_POST['price'],
		'tags' => $tags,
		'id' => $_POST['id']
	));

	// Choose what alert to display.
	if ($success)
		$alert = 'The product has been modified!';
	else
		$alert = 'Impossible to modify the product!';

}

//Admin has deleted a product
if (isset($_POST['delete'])) {

	//Delete product id DB.
	$success = deleteProduct($_POST['id']);

	//Choose what alert to display.
	if ($success)
		$alert = 'The product has been deleted!';
	else
		$alert = 'Impossible to delete the product!';

}


$has_product_selected = isset($_GET['product_id']);

//Will display product form.
if ($has_product_selected) {
	$product_id = $_GET['product_id'];
	$product_infos = getOne('products', $product_id );
	$product_infos['tags'] = stringToArray($product_infos['tags']);

	//Get list of all tags and add attribute selected for each.
	$allTags = getAll('tags');
	foreach($allTags as &$tag) {
		$tag['selected'] = false;
		foreach($product_infos['tags'] as $tag_in_product) {
			if ($tag['name'] === $tag_in_product) {
				$tag['selected'] = true;
			}
		}
	}
}
//Will display search bar an all products.
if (!$has_product_selected) {
	$product_list = getAll('products');
}

//Render page with templates
include('../templates/head.html');
include('../templates/header.php');
include('../templates/alert.php');
include('../templates/admin/menu.php');
include('../templates/admin/modify_product.php');
include('../templates/footer.html');

?>