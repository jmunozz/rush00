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

$unformatted_orders = getAll('carts');
$orders = array();
foreach($unformatted_orders as $u) {
	$formatted_cart = array();
	$formatted_cart['content'] = array();
	$formatted_cart['quantity'] = array();
	$formatted_cart['price'] = 0;
	$decoded_content = decodeCartContent($u['content']);
	foreach ($decoded_content as $d) {
		array_push($formatted_cart['content'], $d['name']);
		array_push($formatted_cart['quantity'], $d['quantity']);
		$formatted_cart['price'] +=  $d['quantity'] *  $d['price'];
	}
	$formatted_cart['content'] = preg_replace('/,/',', ',implode(SEPARATOR, $formatted_cart['content']));
	$formatted_cart['quantity'] = preg_replace('/,/',', ',implode(SEPARATOR, $formatted_cart['quantity']));
	$formatted_cart['hour'] = $u['updated_at'];
	$formatted_cart['user_login'] = getOne('users', $u['owner_id'])['login'];
	array_push($orders, $formatted_cart);
}

//Render page with templates
include('../templates/head.html');
include('../templates/header.php');
include('../templates/admin/menu.php');
include('../templates/admin/orders.php');
include('../templates/footer.html');



?>