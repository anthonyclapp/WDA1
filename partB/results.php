<?php

	# Includes
	require_once 'includes/db_connect.php';
	require_once 'includes/functions.php';

	# GET Variables + Checks
	if ( ! securityCheck($_GET['wine_name'])) 		{ $error ++; } else { $wine_name 		= $_GET['wine_name']; }
	if ( ! securityCheck($_GET['winery_name'])) 	{ $error ++; } else { $winery_name 		= $_GET['winery_name']; }
	if ( ! securityCheck($_GET['region'])) 			{ $error ++; } else { $region 			= $_GET['region']; }
	if ( ! securityCheck($_GET['grape_variety'])) 	{ $error ++; } else { $grape_variety 	= $_GET['grape_variety']; }
	if ( ! securityCheck($_GET['year_min'])) 		{ $error ++; } else { $year_min 		= $_GET['year_min']; }	
	if ( ! securityCheck($_GET['year_max'])) 		{ $error ++; } else { $year_max 		= $_GET['year_max']; }	
	if ( ! securityCheck($_GET['stock_min'])) 		{ $error ++; } else { $stock_min 		= $_GET['stock_min']; }	
	if ( ! securityCheck($_GET['stock_max'])) 		{ $error ++; } else { $stock_max 		= $_GET['stock_max']; }	
	if ( ! securityCheck($_GET['cost_min'])) 		{ $error ++; } else { $cost_min 		= $_GET['cost_min']; }	
	if ( ! securityCheck($_GET['cost_max'])) 		{ $error ++; } else { $cost_max 		= $_GET['cost_max']; }	
	
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
	$query = 'SELECT * FROM wine';
	if ( ! strlen($wine_name) == 0) {
		$query .= ' WHERE wine_name LIKE %'.$wine_name.'%';
	}
	if ( ! strlen($winery_name) == 0) {
		$query .= ',winery WHERE winery_name LIKE %'.$winery_name.'%';
	}

	echo $query;
	
	# Query to Array
	#$results = sqlToArray($query);
	
?>
<html>
	<head>
		<title>WDA - Assignment 1 - Part B - Results</title>	
	</head>
	<body>
		<table>
			<tr>
				<th>Wine Name</th>
				<th>Grape Variety</th>
				<th>Year</th>
				<th>Winery</th>
				<th>Region</th>
				<th>Cost</th>
				<th>Stock</th>
				<th>Sales Revenue</th>
			</tr>
			<?php
				
			?>
		</table>
	</body>
</html>