<?php
/**
* MySQL connection check
*
* Checks the connection to the local install of MySQL
*
*/

	# Database - Constants
	define('DB_HOST', 'localhost');
	define('DB_PORT', '3306');
	define('DB_NAME', 'winestore');
	define('DB_USER', 'wda');
	define('DB_PW',   'password');

	# Connect [PDO]
	try {
		$db = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PW);
	} 
	catch(PDOException $e) {
		echo $e->getMessage();
	}

	# Sessions
	session_start();

?>

