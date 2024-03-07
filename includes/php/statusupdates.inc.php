<?php 
	require 'connect.php';
	session_start();
	$profileimgname = $_SESSION['profileimgname'];
	$username = $_SESSION['username'];

	if(isset($_POST['status-update-btn'])) {

		$text = $_POST['status-update-text'];

		if(empty($text)){
			header("location: ../../forum.php?msg=emptyfields");
			exit();
		}

		$sql = "INSERT INTO statusupdates (usernameposter, textstatus) VALUES (?, ?)";
		$stmt = mysqli_stmt_init($con);
		if(!mysqli_stmt_prepare($stmt, $sql)) {
			header("location: ../../forum.php?msg=stmtfailed");
			exit();
		} else {
			mysqli_stmt_bind_param($stmt, 'ss', $username, $text);
			mysqli_stmt_execute($stmt);
		}
		mysqli_stmt_close($stmt);
		mysqli_close($con);
		header("location: ../../forum.php?msg=success");
	}

	if(isset($_POST['reply-update-btn'])) {

		$text = $_POST['reply-text'];
		$idstatus = $_POST['id-reply-status'];

		if(empty($text)){
			header("location: ../../forum.php?msg=emptyfields");
			exit();
		}

		$sql = "INSERT INTO replystatusupdates (idstatusreply, usernamereply, textreply) VALUES (?, ?, ?)";
		$stmt = mysqli_stmt_init($con);
		if(!mysqli_stmt_prepare($stmt, $sql)) {
			header("location: ../../forum.php?msg=stmtfailed");
			exit();
		} else {
			mysqli_stmt_bind_param($stmt, 'iss', $idstatus, $username, $text);
			mysqli_stmt_execute($stmt);
		}
		mysqli_stmt_close($stmt);
		mysqli_close($con);
		header("location: ../../forum.php?msg=success");
	}


	if(isset($_POST['like-btn-status'])) {
		$id = $_POST['status-id-like'];
		$sql = "UPDATE statusupdates SET likes = likes +1 WHERE id = $id";
		mysqli_query($con, $sql);
		$sql1 = "INSERT INTO likelogs (idstatuslike, username) VALUES ('$id', '$username')";
		mysqli_query($con, $sql1);
		header("location: ../../forum.php");
	}

	if(isset($_POST['edit-status-btn'])) {

		$username = $_SESSION['username'];
		$text = $_POST['edit-status-text'];
		$idstatus = $_POST['status-id'];

		$sqlfind = "SELECT * FROM statusupdates WHERE id = '$idstatus'";
		$rowfind = mysqli_fetch_assoc(mysqli_query($con, $sqlfind));

		if(empty($text)){
			header("location: ../../forum.php?msg=emptyfields");
			exit();
		} else {
			$sql = "UPDATE statusupdates SET textstatus = ? WHERE id = '$idstatus'";
			$stmt =  mysqli_stmt_init($con);
			if(!mysqli_stmt_prepare($stmt, $sql)) {
				header("location: ../../forum.php?msg=stmtfailed");
				exit();
			} else {
				mysqli_stmt_bind_param($stmt, 's', $text);
				mysqli_stmt_execute($stmt);

				if($rowfind['usernameposter'] != $username) {

					$idediter = $_SESSION['id'];
					$ipeditor = $_SESSION['ip'];
					$textlog = "Administratorul <b>".$username."</b> a editat status update-ul lui <b>".$rowfind['usernameposter']."</b>.";
					$sqllogs = "INSERT INTO logs (iduserlog, userlog, userip, logtext) VALUES ('$idediter', '$username', '$ipeditor', '$textlog')";
					mysqli_query($con, $sqllogs);

					$sqlraport = "UPDATE staff SET editedstatusupdates = editedstatusupdates + 1 WHERE adminid = '$idediter'";
 					mysqli_query($con, $sqlraport);
				}
			}
			mysqli_stmt_close($stmt);
			mysqli_close($con);
			header("location: ../../forum.php?msg=successedited");
			exit();
		}
	}

	if(isset($_POST['reply-edit-btn'])) {

		$username = $_SESSION['username'];
		$text = $_POST['reply-edit-text'];
		$idreply = $_POST['reply-status-id'];

		$sqlfind = "SELECT * FROM replystatusupdates WHERE id = '$idreply'";
		$rowfind = mysqli_fetch_assoc(mysqli_query($con, $sqlfind));

		$idstatus = $rowfind['idstatusreply'];
		$sqlfind2 = "SELECT * FROM statusupdates WHERE id = '$idstatus'";
		$rowfind2 = mysqli_fetch_assoc(mysqli_query($con, $sqlfind2));

		if(empty($text)){
			header("location: ../../forum.php?msg=emptyfields");
			exit();
		} else {
			$sql = "UPDATE replystatusupdates SET textreply = ? WHERE id = '$idreply'";
			$stmt =  mysqli_stmt_init($con);
			if(!mysqli_stmt_prepare($stmt, $sql)) {
				header("location: ../../forum.php?msg=stmtfailed");
				exit();
			} else {
				mysqli_stmt_bind_param($stmt, 's', $text);
				mysqli_stmt_execute($stmt);

				if($rowfind['usernamereply'] != $username) {
					
					$idediter = $_SESSION['id'];
					$ipeditor = $_SESSION['ip'];
					$textlog = "Administratorul <b>".$username."</b> a editat raspunul lui <b>".$rowfind['usernamereply']."</b>, la status update-ul lui <b>".$rowfind2['usernameposter']."</b>.";
					$sqllogs = "INSERT INTO logs (iduserlog, userlog, userip, logtext) VALUES ('$idediter', '$username', '$ipeditor', '$textlog')";
					mysqli_query($con, $sqllogs);

					$sqlraport = "UPDATE staff SET editedstatusupdates = editedstatusupdates + 1 WHERE adminid = '$idediter'";
 					mysqli_query($con, $sqlraport);
				}
			}
			mysqli_stmt_close($stmt);
			mysqli_close($con);
			header("location: ../../forum.php?msg=successedited");
			exit();
		}
	}

	if(isset($_POST['like-btn-reply'])) {
		$id = $_POST['reply-id'];
		$sql = "UPDATE replystatusupdates SET likes = likes + 1 WHERE id = $id";
		mysqli_query($con, $sql);
		$sql1 = "INSERT INTO likelogs (idreplylike, username) VALUES ('$id', '$username')";
		mysqli_query($con, $sql1);
		header("location: ../../forum.php");
	}