<?php

	require 'connect.php';

	if(isset($_POST['send-unbanrequest'])) {
		$banlistid = $_POST['banlist-id'];
		$bannedid = $_POST['banned-id'];
		$bannedusername = $_POST['banned-username'];
		$unbanrequestmsg = $_POST['unbanrequest-text'];

		if(empty($unbanrequestmsg)) {
			header("Location: ../../unbanrequest.php?msg=error");
			exit();
		} else {
			$sql = "SELECT * FROM unbanrequests WHERE banneduserid = '$bannedid' AND bannedusername = '$bannedusername' AND status = 0";
			$results = mysqli_query($con, $sql);
			if(mysqli_num_rows($results) > 0) {
				header("Location: ../../unbanrequest.php?msg=haveone");
				exit();
			} else {

				$sqltransfer = "SELECT * FROM banlist WHERE id = '$banlistid' AND banneduserid = '$bannedid'";
				$resultstransfer = mysqli_query($con, $sqltransfer);
				if(mysqli_num_rows($resultstransfer) > 0) {
					$rowtransfer = mysqli_fetch_assoc($resultstransfer);
					$permanentbanned = $rowtransfer['permanentbanned'];
					$ipban = $rowtransfer['bannedip'];
					$banduration = $rowtransfer['banduration'];
					$unbandate = $rowtransfer['unbandate'];
					$banneddate = $rowtransfer['banneddate'];
					$reason = $rowtransfer['reason'];
					$bannedby = $rowtransfer['bannedby'];
				}
				$sql = "INSERT INTO unbanrequests (banlistid, banneduserid, bannedusername, bannedip, reason, bannedby, permanentbanned, banduration, unbandate,
				banneddate, unbanrequesttext) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$stmt = mysqli_stmt_init($con);
				if(!mysqli_stmt_prepare($stmt, $sql)) {
					header("Location: ../../unbanrequest.php?msg=stmtfail");
					exit();
				} else {
					mysqli_stmt_bind_param($stmt, "iissssiisss", $banlistid, $bannedid, $bannedusername, $ipban, $reason, $bannedby, $permanentbanned, $banduration, $unbandate, $banneddate, $unbanrequestmsg);
					mysqli_stmt_execute($stmt);
				}
				mysqli_stmt_close($stmt);
				mysqli_close($con);
				header("Location: ../../unbanrequest.php?msg=succes");
				exit();
			}
		}

	}

	if(isset($_POST['unbanrequest-comm-btn'])) {

		session_start();
		$unbanrequestid = $_POST['unbanrequest-id'];
		$text = $_POST['unbanrequest-comm-text'];
		$username = $_SESSION['username'];
		$pagename = $_SESSION['pagename'];

		if($pagename == 'dashboard.php') {
			if(empty($text)) {
				header("Location: ../../dashboard.php?action=unbanrequests&unbanrequestview=".$unbanrequestid."&msg=emptyfields");
				exit();
			} else {
				$sqlcomm = "INSERT INTO unbanrequestscomments (unbanrequestid, usernamecomm, commtext) VALUES (?, ?, ?)";
				$stmt = mysqli_stmt_init($con);
				if(!mysqli_stmt_prepare($stmt, $sqlcomm)) {
					header("Location: ../../dashboard.php?action=unbanrequests&unbanrequestview=".$unbanrequestid."&msg=stmtfail");
					exit();
				} else {
					mysqli_stmt_bind_param($stmt, "iss", $unbanrequestid, $username, $text);
					mysqli_stmt_execute($stmt);
				}
				mysqli_stmt_close($stmt);
				mysqli_close($con);
				header("Location: ../../dashboard.php?action=unbanrequests&unbanrequestview=".$unbanrequestid."&msg=success");
				exit();
			}
		} else {
			if(empty($text)) {
				header("Location: ../../unbanrequest.php?action=unbanrequests&unbanrequestview=".$unbanrequestid."&msg=emptyfields");
				exit();
			} else {
				$sqlcomm = "INSERT INTO unbanrequestscomments (unbanrequestid, usernamecomm, commtext) VALUES (?, ?, ?)";
				$stmt = mysqli_stmt_init($con);
				if(!mysqli_stmt_prepare($stmt, $sqlcomm)) {
					header("Location: ../../unbanrequest.php?action=view&unbanrequestview=".$unbanrequestid."&msg=stmtfail");
					exit();
				} else {
					mysqli_stmt_bind_param($stmt, "iss", $unbanrequestid, $username, $text);
					mysqli_stmt_execute($stmt);
				}
				mysqli_stmt_close($stmt);
				mysqli_close($con);
				header("Location: ../../unbanrequest.php?action=view&unbanrequestview=".$unbanrequestid."&msg=success");
				exit();
			}
		}
}