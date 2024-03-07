<?php 
	require 'connect.php';

	session_start();
	$usernamemark = $_SESSION['username'];
	$idmark = $_GET['idmark'];
	$pagename = $_SESSION['pagename'];

	$sqlmark = "UPDATE inbox SET status = 1 WHERE id = '$idmark' AND touser = '$usernamemark'";
	mysqli_query($con, $sqlmark);

	if($pagename != 'profile.php') {
		header("Location: ../../".$pagename);
		exit();
	} else {
		header("Location: ../../".$pagename."?profil=".$usernamemark);
		exit();
	}