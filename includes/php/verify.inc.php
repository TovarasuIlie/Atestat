<?php 
	require 'connect.php';

	$username = $_GET['username'];
	$token = $_GET['token'];
	$userid = $_GET['userid'];

	$sql = "SELECT verified FROM users WHERE id = '$userid' AND username = '$username' AND token = '$token' AND verified = 0 LIMIT 1";
	$result = mysqli_query($con, $sql);
	if(mysqli_num_rows($result) > 0) {
		$sqlverify = "UPDATE users SET verified = 1, token = '' WHERE id = '$userid' AND username = '$username'";
		mysqli_query($con, $sqlverify);
		$inboxtext = 'Contul cu numele <b>'.$username.'</b> a fost <b style="color: #2eb82e;">ACTIVAT</b>. Acuma poti sa te bucuri de tot ce iti poate oferi <b>VolvoFAN.ro</b>.';
		$sqlinbox = "INSERT INTO inbox (touser, textinbox) VALUES ('$username', '$inboxtext')";
		mysqli_query($con, $sqlinbox);
		header("Location: ../../index.php");
		exit();
	} else {
		header("Location: ../../index.php?msg=alreadyverified");
		exit();
	}