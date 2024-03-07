<?php 
	if(isset($_POST['search-404error-btn'])) {
		$usersearch = $_POST['usersearch'];
		header("Location: ../../profile.php?profil=".$usersearch);
		exit();
	}

	if(isset($_POST['find-user-submit'])) {
		session_start();
		$pagename = $_SESSION['pagename'];
		$finduser = str_replace(' ', '', $_POST['find-user']);
		if(strlen($finduser) <= 2) {
			if($pagename != 'profile.php') {
				header("Location: ../../".$pagename."?error=toofewchars");
				exit();
			} else {
				$gouser = $_POST['gouser'];
				header("Location: ../../".$pagename."?profil=".$gouser."&error=toofewchars");
			}
		} else {
			header("Location: ../../finduser.php?search=".$finduser);
			exit();
		}
	}

	if(isset($_POST['search-topic'])) {
		$topcicsearch = preg_replace('/[^a-z0-9]+/i', '_', $_POST['topic-search']);
		if(strlen($topcicsearch) > 2) {
			header("Location: ../../forum.php?search=".$topcicsearch);
			exit();
		} else {
			header("Location: ../../forum.php?error=toofewchars");
			exit();
		}
	}