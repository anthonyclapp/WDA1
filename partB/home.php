<?php

	# Includes
	require_once 'includes/db_connect.php';
	require_once 'includes/functions.php';
	
	# Code
	
		# Year
		$query = 'SELECT year FROM wine ORDER BY year ASC';
		$array = sqlToArray($query, 'year');
		
		# Display
		echo '<br> Year Min -'.$array[0];
		echo '<br> Year Max -'.$array[(count($array) - 1)];
		
		/**
		  ^ - Example Loop
			
			$count = $year_min;
			while ($count != $year_max) {
				echo "<select>".$year_min."</select>";
				$count ++;
			}
		**/
		
	
	