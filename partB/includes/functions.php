<?php


	# Simple Query to Array
	#
	#	Reference
	#		-> http://php.net/manual/en/function.mysql-fetch-array.php
	#
	function sqlToArray($query) {

		# Execute Query
		$resource = mysql_query($query) or die(mysql_error()); 
 
		# Save To Array
		while( $array[] = mysql_fetch_array($resource) );

		# Return Array
		return $array;
	}
