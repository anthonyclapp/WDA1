<?php
	# Simple Query to Array
	#
	#	Reference
	#		-> http://php.net/manual/en/function.mysql-fetch-array.php
	#
	#function sqlToArray($query) {
   #
	#	# Execute Query
	#	$resource = mysql_query($query) or die(mysql_error()); 
 	#
	#	# Save To Array
	#	while( $array[] = mysql_fetch_array($resource) );
	#
	#	# Return Array
	#	return $array;
	#}
	#
	# UPDATE	--- Made Redundant Due To PDO
	#
	
	# Security Fix
	#
	#	Reference
	#		-> http://stackoverflow.com/questions/1587695/sanitize-get-parameters-to-avoid-xss-and-other-attacks
	#
	function securityCheck($input) {
		$inputTest = preg_replace('/[^-a-zA-Z0-9_]/', '', $input);
		if ( $input != $inputTest ) {
			return false;
		} else {
			return true;
		}
	}