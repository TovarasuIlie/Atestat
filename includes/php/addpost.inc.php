<?php 
	session_start();
	$username =  $_SESSION['username'];
	$iduser = $_SESSION['id'];

	if(isset($_POST['addpost-btn'])) {

		require 'connect.php';
		$title = $_POST['title'];
		$description = $_POST['description'];
		$textpost = $_POST['textpost'];
		$userip = $_SESSION['ip'];
		$publicdate = date("Y-m-d", time());

		if(empty($title) || empty($description) || empty($textpost)) {
			header("location: ../../forum.php?action=addpost&msg=emptyfields");
			exit();
		}
		$sql = "INSERT INTO posts (username, title, description, textpost, publicdate) VALUES (?, ?, ?, ?, ?)";
		$stmt = mysqli_stmt_init($con);
		if(!mysqli_stmt_prepare($stmt, $sql)){
			header("location: ../../forum.php?action=addpost&msg=stmtfail");
			exit();
		} else {
			mysqli_stmt_bind_param($stmt, "sssss", $username, $title, $description, $textpost, $publicdate);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
			$sql = "SELECT id, title FROM posts WHERE title = '$title'AND description = '$description'AND textpost = '$textpost'";
			$query = mysqli_query($con, $sql);
			$row = mysqli_fetch_assoc($query);
				$idpost = $row['id'];
				$pagename = 'Volvo FAN Topic "'.$row['title'].'"';

			$sqlviews = "INSERT INTO views (idpost, pagename) VALUES ('$idpost', '$pagename')";
			mysqli_query($con, $sqlviews);

			$textlog = '<b>'.$username.'</b> a creat topicul <b>'.$row['title'].'</b>.';
			$sqllog = "INSERT INTO logs (iduserlog, userlog, userip, logtext) VALUES ('$iduser', '$username', '$userip', '$textlog')";
			mysqli_query($con, $sqllog);

			mysqli_close($con);
			header("location: ../../forum.php?action=viewpost&idpost=".$idpost."msg=succes");
			exit();
		}
	}

	if(isset($_POST['edit-post-btn'])) {

		require 'connect.php';
		$idpost = $_POST['id_edit_post'];
		$titleedit = $_POST['edit-title'];
		$descriptionedit = $_POST['description'];
		$textpostedit = $_POST['edittext'];

		if(empty($titleedit) || empty($descriptionedit) || empty($textpostedit)) {
			header("location: ../../forum.php?action=viewpost&idpost=".$idpost."&msg=emptyfields");
			exit();
		}
		$sql = "UPDATE posts SET title = '$titleedit', description = '$descriptionedit', textpost = '$textpostedit' WHERE id = '$idpost'";
		$query = mysqli_query($con, $sql);
		header("location: ../../forum.php?action=viewpost&idpost=".$idpost."&msg=success");
		exit();
	}

	if(isset($_POST['like-post-btn'])) {

		$idpostlike = $_POST['id-post-liked'];
		require 'connect.php';
		$sql = "INSERT INTO likelogs (idpostlike, username) VALUES ('$idpostlike', '$username')";
		mysqli_query($con, $sql);
		$sqllike = "UPDATE posts SET likes = likes + 1 WHERE id = '$idpostlike'";
		mysqli_query($con, $sqllike);
		header("location: ../../forum.php?action=viewpost&idpost=".$idpostlike);

	}

	if(isset($_POST['report-post-btn'])) {

		require 'connect.php';

		$idtopicreported = $_POST['id-reported-post'];
		$titletopicreported = $_POST['title-report-post'];
		$usercreator = $_POST['user-report-post'];
		$details = $_POST['report-details'];

		$sql = "SELECT * FROM postreports WHERE topicid = '$idtopicreported' AND userreporter = '$username'";
		$result = mysqli_query($con, $sql);
		if(mysqli_num_rows($result) == 0) {

			$sql = "INSERT INTO postreports (topicid, topictitle, topiccreator, userreporter, details) VALUES (?, ?, ?, ?, ?)";
			$stmt = mysqli_stmt_init($con);
			if(!mysqli_stmt_prepare($stmt, $sql)) {
				header("location: ../../forum.php?action=viewpost&idpost=".$idtopicreported."&msg=stmtfail");
				exit();
			} else {
				mysqli_stmt_bind_param($stmt, "issss", $idtopicreported, $titletopicreported, $usercreator, $username, $details);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);

				header("location: ../../forum.php?action=viewpost&idpost=".$idtopicreported."&msg=success");
				exit();
				}
			} else {
				header("location: ../../forum.php?action=viewpost&idpost=".$idtopicreported."&msg=reported");
				exit();
			}
	}

		if(isset($_POST['submit-answear-report'])) {

	 		require 'connect.php';
	 		session_start();

	 		$usernameresponser = $_SESSION['username'];
	 		$idpost = $_POST['id-report'];
	 		$answear = $_POST['anwsear'];

	 		$sql = "UPDATE postreports SET usersolver = '$usernameresponser', response = '$answear' WHERE id = '$idpost'";
			 		$run = mysqli_query($con, $sql);
			 		if($run != false) {

			 			$sqlfindreport = "SELECT * FROM postreports WHERE id = '$idpost'";
			 			$resultreport = mysqli_query($con, $sqlfindreport);
			 			$rowinbox = mysqli_fetch_assoc($resultreport);
			 			$title = $rowinbox['topictitle'];
			 			$touser = $rowinbox['userreporter'];
			 			$inboxtext = 'Administratorul <b>'.$usernameresponser.'</b> a inchis reclamtia impotriva topicului <b>'.$title.'</b> ca si <b style="color: #33cc33;">Rezolvat</b>. <b>Raspuns:</b> '.$answear;
			 			$sqlinbox = "INSERT INTO inbox (touser, textinbox) VALUES ('$touser', '$inboxtext')";
			 			mysqli_query($con, $sqlinbox);

	 				header('Location: ../../dashboard.php?action=postreports&postreportview='.$idpost.'&msg=succes');
	 				exit();
		 		} else {
		 			header('Location: ../../dashboard.php?action=postreports&postreportview='.$idpost.'&msg=error');
		 			exit();
		 		}
		}

		if(isset($_POST['open-post-report'])) {

	 		require 'connect.php';
	 		session_start();

	 		$idpost = $_POST['id-report'];

	 		$sql = "UPDATE postreports SET status = 0 WHERE id = '$idpost'";
			$run = mysqli_query($con, $sql);
			 	if($run != false) {

			 		$adminid = $_SESSION['id'];
			 		$sqlraport = "UPDATE staff SET closedcomplaints = closedcomplaints - 1 WHERE adminid = '$adminid'";
 					mysqli_query($con, $sqlraport);

	 				header('Location: ../../dashboard.php?action=postreports&postreportview='.$idpost.'&msg=opened');
	 				exit();
		 		} else {
		 			header('Location: ../../dashboard.php?action=postreports&postreportview='.$idpost.'&msg=error');
		 			exit();
		 		}
		}

		if(isset($_POST['close-post-report'])) {

	 		require 'connect.php';
	 		session_start();

	 		$idpost = $_POST['id-report'];
	 		$sql = "UPDATE postreports SET status = 1 WHERE id = '$idpost'";
			$run = mysqli_query($con, $sql);
			if($run != false) {

				$adminid = $_SESSION['id'];
			 	$sqlraport = "UPDATE staff SET closedcomplaints = closedcomplaints + 1 WHERE adminid = '$adminid'";
 				mysqli_query($con, $sqlraport);

		 		header('Location: ../../dashboard.php?action=postreports&postreportview='.$idpost.'&msg=closed');
		 		exit();
		 	} else {
		 		header('Location: ../../dashboard.php?action=postreports&postreportview='.$idpost.'&msg=error');
		 		exit();
		 		}
		}