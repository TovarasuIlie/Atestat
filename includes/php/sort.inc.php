<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1'); 
	session_start();

	if(isset($_POST['sort-log-data'])) {
		$sortdatalog = $_POST['sortdates'];
		$username = $_POST['usernamelog'];
		$_SESSION['sortdates'] = " AND datesort = '".$sortdatalog."'";
		header("Location: ../../profile.php?profil=".$username."&action=viewlogs");
		exit();
	}

	if(isset($_POST['reset-log-data'])) {
		$username = $_POST['usernamelog'];
		unset($_SESSION['sortdates']);
		header("Location: ../../profile.php?profil=".$username."&action=viewlogs");
		exit();
	}

	if(isset($_POST['sort-dashboard-users'])) {
		unset($_SESSION['searchusername']);
		$_SESSION['sorttext'] = "SELECT * FROM users WHERE username != ''";
		if(isset($_POST['sort-function'])) {
			$sortfarray = implode("','", $_POST['sort-function']);
			$_SESSION['sorttext'] .= "AND function IN('".$sortfarray."')";
		}
		if(isset($_POST['sort-joindate']) && $_POST['sort-joindate'] != 0) {
			$sortjoindate = $_POST['sort-joindate'];
			$_SESSION['sorttext'] .= "AND DATE(joindate) = '$sortjoindate'";
		}
		if(isset($_POST['sort-countries']) && $_POST['sort-countries'] != 0) {
			$sortcountries = $_POST['sort-countries'];
			$_SESSION['sorttext'] .= "AND country = '$sortcountries'";
		}
		if(isset($_POST['sort-ord'])) {
			if($_POST['sort-ord'] == 'sort-asc') {
				$_SESSION['sorttext'] .= " ORDER by id ASC, function DESC";
			} else {
				$_SESSION['sorttext'] .= " ORDER by id DESC, function DESC";
			}
		}
		header("Location: ../../dashboard.php?action=users");
		exit();
	} 

	if(isset($_POST['reset-dashboard-users'])) {
		unset($_SESSION['sorttext']);
		unset($_SESSION['searchusername']);
		header("Location: ../../dashboard.php?action=users");
		exit();
	}

	if(isset($_POST['search-dashboard-user'])) {
		unset($_SESSION['sorttext']);
		if(!empty($_POST['search-username'])) {
			if(strlen($_POST['search-username']) > 2) {
				$_SESSION['searchusername'] = $_POST['search-username'];
				header("Location: ../../dashboard.php?action=users");
				exit();
			} else {
				header("Location: ../../dashboard.php?action=users&error=toofewchars");
				exit();
			}
		} else {
			header("Location: ../../dashboard.php?action=users&error=emptyfield");
			exit();
		}
	}
?>	