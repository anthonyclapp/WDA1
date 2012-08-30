<?php
/**
* MySQL connection check
*
* Checks the connection to the local install of MySQL
*
*/
  define('DB_HOST', 'localhost');
  define('DB_PORT', '3306');
  define('DB_NAME', 'winestore');
  define('DB_USER', 'wda');
  define('DB_PW',   'password');
  try {
    $db = new PDO(
      "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME,
      DB_USER,
      DB_PW
    );
    $sql = "select region_id, region_name from region";
    foreach ($db->query($sql) as $row) {
      print $row['region_id'] .' - '. $row['region_name'] . '<br />';
    }
    $db = null; // close the database connection
  } catch(PDOException $e) {
    echo $e->getMessage();
  }?>
