<?php
	require 'includes/php/connect.php'; 
	$sql = "INSERT INTO staff (adminid, username, function) VALUES (1, 'niculai_ilie', 3)";
	mysqli_query($con, $sql);
?>