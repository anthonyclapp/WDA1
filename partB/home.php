<?php

	# Includes
	require_once 'includes/db_connect.php';
	require_once 'includes/functions.php';
	
	# Variables
		
		# Regions
		$query   = 'SELECT * FROM region';
		$regions = sqlToArray($query);

		# Grape Varieties
		$query = 'SELECT * FROM grape_varienty';
		$grape_varieties = sqlToArray($query);
		
		# Year - Min
		$query   = 'SELECT year FROM wine ORDER BY year ASC limit 1';
		$results = sqlToArray($query);
		$year_min = $results[0]['year'];
		
		# Year - Max
		$query   = 'SELECT year FROM wine ORDER BY year DESC limit 1';
		$results = sqlToArray($query);
		$year_max = $results[0]['year'];

		# Stock - Min
		$query   = 'SELECT on_hand FROM inventory ORDER BY on_hand ASC limit 1';
		$results = sqlToArray($query);
		$stock_min = $results[0]['on_hand'];
		
		# Stock - Max
		$query   = 'SELECT on_hand FROM inventory ORDER BY on_hand DESC limit 1';
		$results = sqlToArray($query);
		$stock_max = $results[0]['on_hand'];		

		# Cost - Min
		$query   = 'SELECT cost FROM inventory ORDER BY cost ASC limit 1';
		$results = sqlToArray($query);
		$cost_min = $results[0]['cost'];
		
		# Cost - Max
		$query   = 'SELECT cost FROM inventory ORDER BY cost DESC limit 1';
		$results = sqlToArray($query);
		$cost_max = $results[0]['cost'];		
				
		
		
	# Code
	
?>

	<table>
		<tr>
			<th>Wine Name:</th>
			<td>
				<input type="text" name="wine_name" value="" />
			</td>
			<td>
			
			</td>
		</tr>
		<tr>
			<th>Winery Name:</th>
			<td>
				<input type="text" name="winery_name" value="" />
			</td>
		</tr>
		<tr>
			<th>Region:</th>
			<td>
			</td>
		</tr>
		<tr>
			<td>
			</td>
		</tr>
		<tr>
			<td>
			</td>
		</tr>
		<tr>
			<td>
			</td>
		</tr>
		<tr>
			<td>
			</td>
		</tr>
		<tr>
			<td>
			</td>
		</tr>
		<tr>
			<td>
			</td>
		</tr>
		<tr>
			<td>
			</td>
		</tr>
	</table>
	
	
