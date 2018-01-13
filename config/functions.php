<?php

$mysql_connexion = null;

function root($path) {
	echo "\"" . ROOT . $path . "\"";
}

function stringToArray($string) {
	return explode(SEPARATOR, $string);
}

function arrayToString($array) {
	return implode(SEPARATOR, $array);
}

function calculateTotalPrice($cart_content) {
	$total = 0;
	foreach($cart_content as $cart_product) {
		$total += $cart_product['price'] * $cart_product['quantity'];
	}
	return $total;
}

/*
** Take array. Return String
*/
function encodeCartContent($cart_content) {

	$midArray = [];
	$finalString = '';

	foreach($cart_content as $cart_product) {
		array_push($midArray, $cart_product['id'] . SEPARATOR2 . $cart_product['quantity']);
	}
	$finalString = arrayToString($midArray);
	return $finalString;

}

/*
** Take string. Return array
*/
function decodeCartContent($cart_content) {

	if(!$cart_content)
		return array();

	$final_cart_content = array();
	$midArray = explode(SEPARATOR, $cart_content);
	foreach ($midArray as $product) {
		$basic_infos = explode(SEPARATOR2, $product);
		$product_id = $basic_infos[0];
		$product_qty = $basic_infos[1];
		$product_infos = getOne('products', $product_id);
		$product_infos['quantity'] = $product_qty;
		array_push($final_cart_content, $product_infos);
	}
	return $final_cart_content;
}

/*
** Content is transformed into a string according to the following pattern id;qty,id:qty...
*/
function archiveCart($cart_content, $owner_id) {

	$content = encodeCartContent($cart_content);

	return addCart(array(
		'owner_id' => $owner_id,
		'content' => $content,
		'is_completed' => 1
	));	
}

/*
** Queries
*/


/*
** Get one object from DB
*/
function getOne($object, $id) {

	$query = "SELECT * FROM " . $object . " WHERE id = " . $id . ";";
	$connexion = getDBConnexion();
	$result = mysqli_query($connexion, $query);
	return mysqli_fetch_assoc($result);
}

/*
** Get several objects from DBB sort with a filter.
*/
function getByFilter($object, $filter, $value) {

	$query = "SELECT * FROM " . $object . " WHERE " . $filter . "=" . $value . ";";
	echo $query;
	$connexion = getDBConnexion();
	$result = mysqli_query($connexion, $query);
	$final_result = array();
	while ($row = mysqli_fetch_assoc($result)) {
		array_push($final_result, $row);
	}
	return $final_result;
}

/*
** Get all objects from one table.
*/
function getAll($object) {

	$query = "SELECT * FROM " . $object . ";";
	$connexion = getDBConnexion();
	$result = mysqli_query($connexion, $query);
	$final_result = array();
	while ($row = mysqli_fetch_assoc($result)) {
		array_push($final_result, $row);
	}
	return $final_result;
}

// -- Users -- 

/*
** return Boolean
*/
function addUser($array) {

	$query = "INSERT INTO 
		`users` (`id`, `login`, `email`, `password`, `updated_at`, `is_admin`) 
		VALUES (NULL, ?, ?, ?, CURRENT_TIMESTAMP, 0);";

	$connexion = getDBConnexion();
	$statement = mysqli_prepare($connexion, $query);
	mysqli_stmt_bind_param($statement, 'sss',
		$array['login'], 
		$array['email'], 
		$array['password']);
	return mysqli_stmt_execute($statement);

}


/*
** We can edit login, email, is_admin but no password. Return Boolean
*/
function editUser($array) {
	
	$query = "UPDATE `users`
		SET `login` = ?, `email` = ?, `is_admin` = ?, `updated_at` = CURRENT_TIMESTAMP
		WHERE `users`.`id` = ? ;";	

	$connexion = getDBConnexion();

	$statement = mysqli_prepare($connexion, $query);
	mysqli_stmt_bind_param($statement, 
			$array['login'], 
			$array['email'], 
			$array['is_admin'],
			$array['id']);
	return mysqli_stmt_execute($statement);
}


/*
** Return Boolean
*/
function deleteUser($id) {

	$query = "DELETE `users`
		WHERE `users`.`id` = ? ;";

	$connexion = getDBConnexion();

	$statement = mysqli_prepare($connexion, $query);
	mysqli_stmt_bind_param($statement, $id);
	return mysqli_stmt_execute($statement);
	
}


// -- Tags --
function addTag($array) {

	$query = "INSERT INTO 
		`tags` (`id`, `name`, `description`, `updated_at`, `is_active`) 
		VALUES (NULL, ?, ?, CURRENT_TIMESTAMP, true);";

	$connexion = getDBConnexion();

	echo $query;
	$statement = mysqli_prepare($connexion, $query);
	mysqli_stmt_bind_param($statement, 'ss',
			$array['name'], 
			$array['description']);
	return mysqli_stmt_execute($statement);	

}


/*
** We can edit name, description, and is_active. Return Boolean.
*/
function editTag($array) {
	
	$query = "UPDATE `tags`
		SET `name` = ?, `description` = ?, `updated_at` = CURRENT_TIMESTAMP, `is_active` = 1
		WHERE `tags`.`id` = ? ;";	

	$connexion = getDBConnexion();

	$statement = mysqli_prepare($connexion, $query);
	mysqli_stmt_bind_param($statement, 'ssi',
			$array['name'], 
			$array['description'], 
			$array['id']);
	return mysqli_stmt_execute($statement);	

}


/*
** Return Boolean.
*/
function deleteTag($id) {

	$query = "DELETE FROM `tags` WHERE `tags`.`id` = ?;";

	$connexion = getDBConnexion();

	$statement = mysqli_prepare($connexion, $query);
	mysqli_stmt_bind_param($statement, 'i', $id);
	return mysqli_stmt_execute($statement);
	
}

// -- Products --
function addProduct($array) {

	

	$query = "INSERT INTO 
	`products` (`id`, `name`, `description`, `picture`, `price`, `tags`, `updated_at`, `is_active`) 
	VALUES (NULL, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP, 1);";

	$connexion = getDBConnexion();

	print_r($array);
	$statement = mysqli_prepare($connexion, $query);
	mysqli_stmt_bind_param($statement, 'sssis',
			$array['name'], 
			$array['description'], 
			$array['picture'],
			$array['price'],
			$array['tags']);
	return mysqli_stmt_execute($statement);	

}


/*
** We can edit name, description, picture path, price, tags. Return boolean.
*/
function editProduct($array) {

	

	$query = "UPDATE `products`
		SET `name` = ?, `description` = ?, `picture` = ?, `price` = ?, `tags` = ?, `updated_at` = CURRENT_TIMESTAMP, `is_active` = 1
		WHERE `products`.`id` = ? ;";	

	$connexion = getDBConnexion();
	$statement = mysqli_prepare($connexion, $query);
	mysqli_stmt_bind_param($statement, 'sssisi',
			$array['name'], 
			$array['description'],
			$array['picture'],
			$array['price'],
			$array['tags'],
			$array['id']);
	return mysqli_stmt_execute($statement);	
	
}

function deleteProduct($id) {
	
	$query = "DELETE FROM `products`
	WHERE `products`.`id` = ? ;";

	$connexion = getDBConnexion();

	$statement = mysqli_prepare($connexion, $query);
	mysqli_stmt_bind_param($statement, 'i', $id);
	return mysqli_stmt_execute($statement);
}


// -- Carts --

/*
** Return Boolean
*/
function addCart($array) {

	$query = "INSERT INTO 
		`carts` (`id`, `owner_id`, `is_completed`, `content`, `updated_at`) 
		VALUES (NULL, ?, 1, ?, CURRENT_TIMESTAMP);";

	$connexion = getDBConnexion();

	$statement = mysqli_prepare($connexion, $query);
	mysqli_stmt_bind_param($statement, 'is',
			$array['owner_id'], 
			$array['content']);
	return mysqli_stmt_execute($statement);	

}

/*
** We can only edit is_completed and content. Return Boolean
*/
function editCart($array) {

	$content = arrayToString($array['content']);

	$query = "UPDATE `carts`
		SET `is_completed` = ?, `content` = ?, `updated_at` = CURRENT_TIMESTAMP
		WHERE `carts`.`id` = ? ;";	

	$connexion = getDBConnexion();

	$statement = mysqli_prepare($connexion, $query);
	mysqli_stmt_bind_param($statement, 
			$array['is_completed'], 
			$content, 
			$array['id']);
	return mysqli_stmt_execute($statement);
	
}

/*
** Return Boolean
*/
function deleteCart($id) {

	$query = "DELETE `carts`
	WHERE `carts`.`id` = ? ;";

	$connexion = getDBConnexion();

	$statement = mysqli_prepare($connexion, $query);
	mysqli_stmt_bind_param($statement, $id);
	return mysqli_stmt_execute($statement);
}

/*
** Connexion to DB.
*/
function getSQLConnexion() {

	global $mysql_connexion;

	if ($mysql_connexion)
		return $mysql_connexion;	

	$mysql_connexion = mysqli_connect(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD);
	if (!$mysql_connexion) {
	    die("Connexion failed: " . mysqli_connect_error());
	}
	return $mysql_connexion;
}

function getDBConnexion($db_name = DB_NAME) {

	global $mysql_connexion;

	if (!$mysql_connexion)
		$mysql_connexion = getSQLConnexion();

	if (mysqli_select_db($mysql_connexion, $db_name))
		return $mysql_connexion;
	else 
		die("Impossible to switch to ".$db_name);
}

/*
** Files
*/

function img_check_errors($file)
{
	$error = NULL;
	preg_match('/\.(.*)/', $file['name'], $ext);
	$valid_extensions = array('jpeg', 'jpg', 'gif', 'png');
	if (!$file)
		$error = "file does not exist";
	else if ($file['error'])
		$error = "transfer error";
	else if (!isset($file['tmp_name']))
		$error = "invalid tmp_name";
	else if ($file['size'] > IMG_MAX_SIZE)
		$error = "file oversize";
	else if (!in_array($ext[1], $valid_extensions))
		$error = "extension is not valid";
	return($error);
}	


function img_upload($file, $img_name) 
{
	if (!file_exists('img_products'))
		mkdir('img_products');
	$res = move_uploaded_file($file['tmp_name'], 'img_products/'.$img_name);
	if (!$res)
		return (FALSE);
	return (TRUE);
}


function img_rename($file)
{
	preg_match('/\.(.*)/', $file['name'], $ext);
	$img_name = "prod_".uniqid(rand(), false).".".$ext[1];
	return ($img_name);
}

function img_delete($img)
{
	echo 'img_products/'.$img;
	return (unlink('img_products/'.$img));
}

?>