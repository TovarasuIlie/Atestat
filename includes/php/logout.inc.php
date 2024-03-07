<?php
	session_start();
	$pagename = $_SESSION['pagename'];
	session_unset();
	session_destroy();

	if(isset($_GET['search']) && $pagename == 'finduser.php') {
		header("Location: ../../".$pagename."?search=".$_GET['search']);
		exit();
	} else {
		if(!isset($_GET['profil'])) {
			header("location: ../../".$pagename);
			exit();
		}
		else {
			header("Location: ../../".$pagename."?profil=".$_GET['profil']);
			exit();
		}
	}
?>