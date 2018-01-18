<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('./constants.php');
require_once('./functions.php');


/*
** CREATE DDB QUERY
*/ 

$create_db = "CREATE DATABASE testDB;";

/*
** CREATE TABLE QUERIES
*/ 

$create_table_carts = "CREATE TABLE `carts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `is_completed` tinyint(1) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$create_table_products = "CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `picture` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `tags` varchar(10000) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$create_table_tags = "CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$create_table_users = "CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_admin` tinyint(1) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";


$insert_default_product1 = "INSERT INTO 
	`testDB`.`products` (`id`, `name`, `description`, `picture`, `price`, `tags`, `updated_at`, `is_active`) 
	VALUES (NULL, 'Knife', 'Sharp', 'knife.png', '162', '1', CURRENT_TIMESTAMP, '1');
";

$insert_default_product2 = "INSERT INTO 
  `testDB`.`products` (`id`, `name`, `description`, `picture`, `price`, `tags`, `updated_at`, `is_active`) 
  VALUES (NULL, 'Axe', 'Behading', 'axe.png', '195', '1', CURRENT_TIMESTAMP, '1');
";

$insert_default_product3 = "INSERT INTO 
  `testDB`.`products` (`id`, `name`, `description`, `picture`, `price`, `tags`, `updated_at`, `is_active`) 
  VALUES (NULL, 'Sniper', 'Accurate', 'sniper.png', '650', '1', CURRENT_TIMESTAMP, '1');
";


$admin_password = hash('whirlpool', 'admin');
$insert_default_user = "INSERT INTO 
	`testDB`.`users` (`id`, `login`, `email`, `password`, `updated_at`, `is_admin`) 
	VALUES (NULL, 'admin', 'admin@admin.com', '" . $admin_password ."', CURRENT_TIMESTAMP, '1');";

$insert_default_tag = "INSERT INTO 
	`testDB`.`tags` (`id`, `name`, `description`, `updated_at`, `is_active`) 
	VALUES (NULL, 'Basics', 'must have', CURRENT_TIMESTAMP, '1');";

$all_sql_queries = array(	
	$create_table_carts,
	$create_table_products,
 	$create_table_tags,
 	$create_table_users,
 	$insert_default_product1,
  $insert_default_product2,
  $insert_default_product3,
 	$insert_default_user,
 	$insert_default_tag
);


$connexion = getSQLConnexion();


// Create DB
if (!mysqli_query($connexion, $create_db))
	die('Impossible create DBB');


// Create TABLES and POPULATE
$connexion = getDBConnexion('testDB');
foreach($all_sql_queries as $query) {
	if (!mysqli_query($connexion, $query))
		die('Query ' . $query . ' failed...' );
}

?>