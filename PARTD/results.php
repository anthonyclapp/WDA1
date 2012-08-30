<?php

	# Includes
	require_once 'includes/db_connect.php';
	require_once 'includes/functions.php';

   try {$db = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME,DB_USER,DB_PW);}
    catch(PDOException $e) { echo $e->getMessage();}
	
   # GET Variables + Checks
   $error = 0;
	if ( ! securityCheck($_GET['wine_name'])) 		{ $error ++; } else { $wine_name 		= $_GET['wine_name']; }
	if ( ! securityCheck($_GET['winery_name'])) 	   { $error ++; } else { $winery_name 		= $_GET['winery_name']; }
	if ( ! securityCheck($_GET['region'])) 			{ $error ++; } else { $region 			= $_GET['region']; }
	if ( ! securityCheck($_GET['grape_variety'])) 	{ $error ++; } else { $grape_variety 	= $_GET['grape_variety']; }
	if ( ! securityCheck($_GET['year_min'])) 		   { $error ++; } else { $year_min 		= $_GET['year_min']; }	
	if ( ! securityCheck($_GET['year_max'])) 		   { $error ++; } else { $year_max 		= $_GET['year_max']; }	
	if ( ! securityCheck($_GET['stock_min'])) 		{ $error ++; } else { $stock_min 		= $_GET['stock_min']; }	
	if ( ! securityCheck($_GET['stock_max'])) 		{ $error ++; } else { $stock_max 		= $_GET['stock_max']; }	
	if ( ! securityCheck($_GET['cost_min'])) 		   { $error ++; } else { $cost_min 		= $_GET['cost_min']; }	
	if ( ! securityCheck($_GET['cost_max'])) 		   { $error ++; } else { $cost_max 		= $_GET['cost_max']; }	

   
	# Die on Error
	if ( $error != 0 ) {
		echo '<br /><br />
				<center>
					<p style="font-size: 36px; color: red;"> 
						Warning: Site Compromised <br /> <br/>
						BYE
					</p>
				</center>
				';
		die;
	}
	
	# Prepare Query
	$query =
      'SELECT DISTINCT wine.wine_id, wine_name, variety, year, winery_name, region_name, cost, item_id, qty, on_hand, sum(qty) ,sum(price)
      FROM wine
      JOIN wine_variety
      ON wine.wine_id = wine_variety.wine_id
      JOIN winery 
      ON wine.winery_id=winery.winery_id
      JOIN region
      ON winery.region_id=region.region_id
      JOIN inventory
      ON wine.wine_id=inventory.wine_id
      JOIN items 
      ON wine.wine_id = items.wine_id 
      JOIN grape_variety
      ON wine_variety.variety_id = grape_variety.variety_id';

   $pdoarray = array();
     
   # Append To Query
	if ( ! strlen($wine_name) == 0) {
		$query .= " AND wine.wine_name LIKE ?";
	   array_push($pdoarray, $wine_name);

   }
	if ( ! strlen($winery_name) == 0) {
		$query .= " AND winery_name LIKE ?";
	   array_push($pdoarray, $winery_name);
	}
   if (isset($region) && $region != "1"){
      $query .= " AND region.region_id = ?";
      array_push($pdoarray, $region);
   }
   if (isset($grape_variety) && $grape_variety != "All"){
      $query .= " AND grape_variety.variety_id = ?";
      array_push($pdoarray, $grape_variety);
   }   
   if (isset($stock_min)){
      $query .= " AND inventory.on_hand >= ?";
      array_push($pdoarray, $stock_min);
   }   
   if (isset($stock_max)){
      $query .= " AND inventory.on_hand <= ?";
      array_push($pdoarray, $stock_max);
   }
   if (isset($year_min)){
      $query .= " AND wine.year >= ?";
      array_push($pdoarray, $year_min);
   }   
   if (isset($year_max)){
      $query .= " AND wine.year <= ?";
      array_push($pdoarray, $year_max);
   }   
   if (isset($cost_min)){
      $query .= " AND inventory.cost >= ?";
      array_push($pdoarray, $cost_min);
   }   
   if (isset($cost_max)){
      $query .= " AND inventory.cost <= ?";
      array_push($pdoarray, $cost_max);
   }

   $query .= " GROUP BY wine.wine_id";
	echo '<pre>'.$query.'<pre>';
   	# Query to Array

	$statement = $db->prepare($query);
   $statement->execute($pdoarray);
   $results = $statement->fetchAll();
?>
<html>
	<head>
		<title>WDA - Assignment 1 - Part B - Results</title>	
	</head>
	<body>
		<table border = 1>
         <tr>
            <td colspan="8"></td>
            <th>Total</th>
            <td><?php
            if ($results[0] == NULL) {echo '0';}
            else {echo count($results);}
               ?></td>            
         </tr>
			<tr>
            <th>Wine ID</th>
				<th>Wine Name</th>
				<th>Grape Variety</th>
				<th>Year</th>
				<th>Winery</th>
				<th>Region</th>
				<th>Cost</th>
				<th>Stock</th>
            <th>Item ID</th>
            <th>Quantity</th>
				<th>Sales Revenue</th>
			</tr>
            <?php
	            if ($results[0] != NULL)                  
                {               
               foreach ($results as $result) {

                  # Variables
                  $wine_id = $result['wine_id'];
                  $wine_name = $result['wine_name'];
                  $variety = $result['variety'];
                  $year = $result['year'];
                  $winery_name = $result['winery_name'];
                  $region_name = $result['region_name'];
                  $cost = $result['cost'];
                  $on_hand = $result['on_hand'];
                  $item_id = $result['item_id'];
                  $qty = $result['qty'];
                  $price = $result['sum(price)'];

                  # Generate Rows
                  echo '<tr>
                           <td>'.$wine_id.'</td>
                           <td>'.$wine_name.'</td>
                           <td>'.$variety.'</td>
                           <td>'.$year.'</td>
                           <td>'.$winery_name.'</td>
                           <td>'.$region_name.'</td>
                           <td>'.$cost.'</td>
                           <td>'.$on_hand.'</td>
                           <td>'.$item_id.'</td>
                           <td>'.$qty.'</td>                           
                           <td>'.$price.'</td>
                        </tr>';                        

               }
               }
            ?>
      </table>
               <?if ($results[0] == NULL) {echo 'No records match your search criteria';}?>
	</body>
</html>
