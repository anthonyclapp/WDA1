<?php

	# Start Session
	session_start();

	# Options On|Off|None
	if ( $_GET['sessions'] == "on") {
		$_SESSION['state'] = "on";
		$display="On";
		header('Refresh:10 ; URL=home.php');
	} else if ($_GET['sessions'] == "off") {
		session_destroy();
		$display="Off";
		header('Refresh:10 ; URL=home.php');
	} else {
		$display="Error";
		header('Location: home.php');
	}

?>
<html>
	<head></head>
	<body>
		<center>
			<h1>Sessions are <?php echo $display; ?> </h1>
			<h3>(You will be automatically redirected to home.php in 10 seconds...)</h3>
         <a href="home.php">Return Home Now</a>
		</center>
	</body>
</html>
