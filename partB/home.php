<?php

	# Includes
	require_once 'includes/db_connect.php';
	require_once 'includes/functions.php';
	
	# Variables
		
		# Regions
		$query   = 'SELECT * FROM region';
		$regions = sqlToArray($query);
		unset($regions[count($regions)-1]);

		# Grape Varieties
		$query = 'SELECT * FROM grape_variety';
		$grape_varieties = sqlToArray($query);
		unset($grape_varieties[count($grape_varieties)-1]);

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
<html>
	<head>
		<title>WDA - Assignment 1 - Part B - Home</title>
		<script type="text/javascript" language="javascript">
			function range_check(min, max) {
				if ( min > max ) {
					return false;
				} else {
					return true;
				}
			}
			function validate() {
				var wine_name		= document.forms["form"]["wine_name"].value;
				var winery_name 	= document.forms["form"]["winery_name"].value;
				var region 			= document.forms["form"]["region"].value;
				var grape_variety 	= document.forms["form"]["grape_variety"].value;
				var year_min 		= parseInt(document.forms["form"]["year_min"].value);
				var year_max 		= parseInt(document.forms["form"]["year_max"].value);				
				var stock_min 		= parseInt(document.forms["form"]["stock_min"].value);
				var stock_max		= parseInt(document.forms["form"]["stock_max"].value);
				var cost_min 		= parseInt(document.forms["form"]["cost_min"].value);
				var cost_max 		= parseInt(document.forms["form"]["cost_max"].value);
				
				var error = 0;
				
				if ( ! range_check(year_min, year_max)) {
					error = error + 1;
					var e = document.getElementById('year_error');
					e.style.display = "block";
				}
				
				if ( ! range_check(stock_min, stock_max)) {
					error = error + 1;
					var e = document.getElementById('stock_error');
					e.style.display = "block";					
				}
				
				if ( ! range_check(cost_min, cost_max)) {
					error = error + 1;
					var e = document.getElementById('cost_error');
					e.style.display = "block";
				}

				if ( error != 0 ) {
					return false;
				} else {
					return true;
				}
			}
		</script>
	</head>
	<body>
		<p id="a" style="display: none">
			So eh
		</p>
		<form name="form" method="get" action="results.php" onsubmit="return validate()">
			<table>
				<tr>
					<th>Wine Name:</th>
					<td>
						<input type="text" name="wine_name" value="" />
					</td>
					<td id="wine_name_error" style="display: none; color: red;">
						Error: Invalid Input (A-z)
					</td>
				</tr>
				<tr>
					<th>Winery Name:</th>
					<td>
						<input type="text" name="winery_name" value="" />
					</td>
					<td id="winery_error" style="display: none; color: red;">
						Error: Invalid Input (A-z)
					</td>
				</tr>
				<tr>
					<th>Region:</th>
					<td>
						<select name="region">
							<?php
								foreach ($regions as $region) {
									$id 	= $region['region_id'];
									$name 	= $region['region_name'];
									echo '<option value="'.$id.'">'.$name.'</option>';
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<th>Grape Variety:</th>
					<td>
						<select name="grape_variety">
							<option id='0'>All</option>
							<?php
								foreach ($grape_varieties as $g) {
									$id 	= $g['variety_id'];
									$name 	= $g['variety'];
									echo '<option value="'.$id.'">'.$name.'</option>';
								}
							?>
						</select>			
					</td>
				</tr>
				<tr>
					<th>Year (Range):</th> 
					<td>
						<select name="year_min">
							<?php
								$count = $year_min;
								while ($count != $year_max) {
									echo '<option value="'.$count.'">'.$count.'</option>';
									$count ++;
								}
							?>
						</select>			
						<select name="year_max">
							<?php
								$count = $year_max;
								while ($count != $year_min) {
									echo '<option value="'.$count.'">'.$count.'</option>';
									$count --;
								}
							?>
						</select>			
					</td>
					<td id="year_error" style="display: none; color: red;">
						Error: Invalid Input (Minimun can not exceed or be equal to Maxmimum)
					</td>
				</tr>
				<tr>
					<th>Stock (Range):</th> 
					<td>
						<select name="stock_min">
							<?php
								$count = $stock_min;
								while ($count != $stock_max) {
									echo '<option value="'.$count.'">'.$count.'</option>';
									$count ++;
								}
							?>
						</select>			
						<select name="stock_max">
							<?php
								$count = $stock_max;
								while ($count != $stock_min) {
									echo '<option value="'.$count.'">'.$count.'</option>';
									$count --;
								}
							?>
						</select>			
					</td>
					<td id="stock_error" style="display: none; color: red;">
						Error: Invalid Input (Minimun can not exceed or be equal to Maxmimum)
					</td>
				</tr>
				<tr>
					<th>Cost (Range):</th> 
					<td>
						<select name="cost_min">
							<?php
								$count = round($cost_min);
								while ($count <= $cost_max) {
									echo '<option value="'.$count.'">$'.$count.'</option>';
									$count ++;
								}
							?>
						</select>			
						<select name="cost_max">
							<?php
								$count = round($cost_max);
								while ($count >= $cost_min) {
									echo '<option value="'.$count.'">$'.$count.'</option>';
									$count --;
								}
							?>
						</select>			
					</td>
					<td id="cost_error" style="display: none; color: red;">
						Error: Invalid Input (Minimun can not exceed or be equal to Maxmimum)
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" />
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>