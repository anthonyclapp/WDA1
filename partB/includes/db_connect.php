<?php
/**
* MySQL connection check
*
* Checks the connection to the local install of MySQL
*
*/

	/**
	 * Hostname and port mysql is running on (can't use localhost)
	 */
	define('DB_HOST',   'yallara.cs.rmit.edu.au:54931');
	/**
	 * Name of database to connect to
	 */
	define('DB_NAME',   'winestore');
	/**
	 * Username to connect with
	 */
	define('DB_USER',   'wda');

	/**
	 * Password to connect with
	 */
	define('DB_PW',     'password');

	/**
		Connect To Database
	*/
	if (!$dbconn = mysql_connect(DB_HOST, DB_USER, DB_PW)) {
	  echo 'Could not connect to mysql on ' . DB_HOST . "\n";
	  exit;
	}

	echo 'Connected to mysql on ' . DB_HOST . "\n";

	if (!mysql_select_db(DB_NAME, $dbconn)) {
	  echo 'Could not use database ' . DB_NAME . "\n";
	  echo mysql_error() . "\n";
	  exit;
	}

	echo 'Connected to database ' . DB_NAME . "\n";

?>