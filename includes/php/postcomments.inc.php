<?php 

	session_start();
	require 'connect.php';
	if(isset($_POST['post-comment-btn'])) {

		$idpostcomm = $_POST['id_post_comment'];
		$userpost = $_SESSION['username'];
		$textcomm = $_POST['postcomment'];

		if(empty($textcomm)) {
			header("Location: ../../forum.php?action=viewpost&idpost=".$idpostcomm."&msg=emptyfields");
			exit();
		} else {

			$sql = "INSERT INTO postcomments (idpost, usernamecommpost, postcomment) VALUES (?, ?, ?)";
			$stmt = mysqli_stmt_init($con);
			if(!mysqli_stmt_prepare($stmt, $sql)) {
				header("Location: ../../forum.php?action=viewpost&idpost=".$idpostcomm."&msg=stmtfail");
				exit();
			} else {
				$sqlnumbercomm = "UPDATE posts SET comments = comments + 1 WHERE id = '$idpostcomm'";
				mysqli_query($con, $sqlnumbercomm);
				mysqli_stmt_bind_param($stmt , "iss", $idpostcomm, $userpost, $textcomm);
				mysqli_stmt_execute($stmt);
			}
			mysqli_stmt_close($stmt);
			mysqli_close($con);
			header("Location: ../../forum.php?action=viewpost&idpost=".$idpostcomm."&msg=success");
			exit();
		}
	}

	if(isset($_POST['submit-edit-text-comm'])) {

		$idpostcomm = $_POST['id-edit-post-comm'];
		$textcomm = $_POST['edit-text-comm'];

		if(empty($textcomm)) {
			header("Location: ../../forum.php?action=viewpost&idpost=".$idpostcomm."&msg=emptyfields");
			exit();
		} else {

			$sql = "UPDATE postcomments SET postcomment = ? WHERE id = '$idpostcomm'";
			$stmt = mysqli_stmt_init($con);
			if(!mysqli_stmt_prepare($stmt, $sql)) {
				header("Location: ../../forum.php?action=viewpost&idpost=".$idpostcomm."&msg=stmtfail");
				exit();
			} else {
				mysqli_stmt_bind_param($stmt , "s", $textcomm);
				mysqli_stmt_execute($stmt);
			}
			mysqli_stmt_close($stmt);
			mysqli_close($con);
			header("Location: ../../forum.php?action=viewpost&idpost=".$idpostcomm."&msg=success");
			exit();
		}
	}