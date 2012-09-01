<?php

	# Includes
	require_once 'includes/db_connect.php';
	require_once 'includes/functions.php';
   require_once 'twitteroauth.php';
   // keys/tokens
   $consumerKey = '935Kg2VH0hbngwQEpL2MkA';
   $consumerSecret = 'p2ogqMeOrrpjmpGrrMDmDk1fJUNi2S0LXDNudaHThg';
   $oAuthToken = '782182495-0czjWYZ1dmiHYuE4Q2SzKc4Q9Hwj6h2GTfc2Rifm';
   $oAuthSecret = 'ySl1pypu5HQabte011OrfV4sPRB8jgMiUGfZJV6UM';

   # GET Variables + Checks
   $error = 0;
	if ( ! securityCheck($_GET['wine_name'])) 		{ $error ++; } else { $wine_name 		= $_GET['wine_name']; }
	if ( ! securityCheck($_GET['winery_name'])) 	   { $error ++; } else { $winery_name 		= $_GET['winery_name']; }
	if ( ! securityCheck($_GET['region'])) 			{ $error ++; } else { $region 			= $_GET['region']; }
	if ( ! securityCheck($_GET['grape_variety'])) 	{ $error ++; } else { $grape_variety 	= $_GET['grape_variety']; }
	if ( ! securityCheck($_GET['year_min'])) 		   { $error ++; } else { $year_min 		   = $_GET['year_min']; }	
	if ( ! securityCheck($_GET['year_max'])) 		   { $error ++; } else { $year_max 		   = $_GET['year_max']; }	
	if ( ! securityCheck($_GET['stock_min'])) 		{ $error ++; } else { $stock_min 		= $_GET['stock_min']; }	
	if ( ! securityCheck($_GET['stock_max'])) 		{ $error ++; } else { $stock_max 		= $_GET['stock_max']; }	
	if ( ! securityCheck($_GET['cost_min'])) 		   { $error ++; } else { $cost_min 		   = $_GET['cost_min']; }	
	if ( ! securityCheck($_GET['cost_max'])) 		   { $error ++; } else { $cost_max 		   = $_GET['cost_max']; }	

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
	$query ='SELECT DISTINCT wine.wine_id, wine_name, variety, year, winery_name, region_name, cost, item_id, qty, on_hand, sum(qty) ,sum(price)
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
            ON wine_variety.variety_id = grape_variety.variety_id
				';

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

  	# Query to Array [PDO]
	$statement = $db->prepare($query);
   $statement->execute($pdoarray);
   $results = $statement->fetchAll();

	# Save wine_name(s) to sessions
	if (isset($_SESSION['state'])) {
		$wine_names = array();
		foreach($results as $r) {
			$wine_names[] = $r['wine_name'];
		}
		$_SESSION['searches'][] = $wine_names;
   #   
      $str = '';
      foreach($wine_names as $wn) {
      $str .= $wn. ', ';
      }
      $str =  substr($str, 0, 137).'...';
   #  http://www.internoetics.com/2011/01/12/post-to-twitter-using-oauth/ 
      // create new instance
      $tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
      // Send tweet 
      $tweet->post('statuses/update', array('status' => $str));
      $searches = count($_SESSION['searches']);
		$sessions = TRUE;
	} else {
		$sessions = FALSE;
	}	

?>
<html>
	<head>
		<title>WDA - Assignment 1 - Part B - Results</title>	
	</head>
	<body>
		<center>
			<h1>Results</h1>
			<table border = 1 style="text-align: center">
		      <tr>
					<td>
						<a href="home.php">Back</a>
					</td>
					<td colspan="4">
						<?php
							if ($sessions) {
								echo '<span style="color:red">Sessions Active:</span> 
										<span>Warning Wine Names Being Saved </span>';
							}
						?>
					</td>
					<td colspan="2">
						<?php	if ($sessions) { echo '<a href="view.php">View Search History ('.$searches.')</a>'; }	?>
					</td>
					<td colspan="2">
						<?php	if ($sessions) {	echo '<a href="sessions.php?sessions=off">Deactivate</a>'; }	?>
					</td>
		         <th>Total</th>
		         <td>
						<?php
				         if ($results == NULL) {               
								echo '0';
							} else {
								echo count($results);
							}
		            ?>
					</td>
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
			         if ($results != NULL) {               
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
		   <?if ($results == NULL) {echo '<h2> No records match your search criteria <h2>';};?>
		</center>
		<h3>Query</h3>
		<?php	 echo $query; ?>	
	</body>
</html>