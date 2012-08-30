<?php
	session_start();
	if (!isset($_SESSION['searches'])) {
		header('Location: home.php');
	}	
?>
<html>
	<head></head>
	<body>
		<pre>
         <a href="home.php">Return Home Now</a>
			<?php
				print_r($_SESSION['searches']);
			?>
		</pre>
	</body>
</html>
