<?php

//Display all error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Includes functions and constants.
require_once('./config/constants.php');
require_once('./config/functions.php');

//Start a session and set up an empty cart if needed.
session_start();
if (!isset($_SESSION['content'])) {
	$_SESSION['content'] = array();
}

//Get session infos
$is_admin = isset($_SESSION['is_admin']) && ($_SESSION['is_admin'] == 1);
$is_logged = isset($_SESSION['login']) && $_SESSION['login'] !== '';

//Get query string filters or actions
$show_details = isset($_GET['product_id']);
$tag_filter = isset($_GET['category']);
$product_added_to_cart = isset($_POST['id']);

//A product has been added to cart. We add it to SESSION.
if ($product_added_to_cart) {
	$product_id = $_POST['id'];
	$product_quantity = $_POST['quantity'];
	$is_already_in_cart = false;
	foreach($_SESSION['content'] as &$product) {
		if ($product['id'] === $product_id) {
			$is_already_in_cart = true;
			$product['quantity'] += $product_quantity;
			break;
		}
	}
	if(!$is_already_in_cart) {
		array_push($_SESSION['content'], array(
			'id' => $product_id,
			'quantity' => $product_quantity
		));
	}
}

//Display all details about a product.
if ($show_details) {
	$product_id = $_GET['product_id'];
	$product_infos = getOne('products', $product_id);
}

//Display all product by category.
else if ($tag_filter) {
	$final_list = array();
	$filter = $_GET['category'];
	$product_list = getAll('products');
	foreach($product_list as $n) {
		$tags = explode(SEPARATOR, $n['tags']);
		if (in_array($filter, $tags)) {
			array_push($final_list, $n);
		}
	}
	$product_list = $final_list;
}

//Display all products.
else
	$product_list = getAll('products');

//Render page with templates
include('./templates/head.html');
include('./templates/header.php');
include('./templates/alert.php');
if ($show_details) {
	include('./templates/single_product.php');
} else {
	include('./templates/all_products.php');
}


?>