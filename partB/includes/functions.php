<?php


	# Simple Query to Array (1 Element)
	function sqlToArray($sql, $element) {
	
		# Execute Query
		$resource = mysql_query($sql) or die(mysql_error()); 
 
		# Initliaze Empty Array
		$resultArray = array(); 
		
		# Store Results in Array
		while($array=mysql_fetch_assoc($resource)) 	{ 
			$resultArray[] = $array[$element];
		} 
		
		# Return Array
		return $resultArray;
	}