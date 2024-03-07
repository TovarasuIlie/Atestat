<?php

if(isset($_POST['bugreport-submit'])) {

 		require 'connect.php';
 		session_start();

 		$usernamecreator = $_SESSION['username'];
 		$title = $_POST['title'];
 		$details = $_POST['details'];
 		$pagename = $_SESSION['pagename'];

 		if(empty($details) || empty($title)) {
 			header('Location: ../../'.$page.'?msg=emptyfielts');
 			exit();
 		}

 		$sql = "INSERT INTO bugreport (usernamecreator, title, details) VALUES (?, ?, ?)";
		 		$stmt = mysqli_stmt_init($con);
		 		if(!mysqli_stmt_prepare($stmt, $sql)) {
		 		header("Location: ../../".$page."?error=stmtfail&title=".$title."&details=".$details);
		 		exit();
		 		}
		 		else {

				 		mysqli_stmt_bind_param($stmt , "sss", $usernamecreator, $title, $details);
				 		mysqli_stmt_execute($stmt);
				 		header("location: ../../".$pagename."?msg=success");
				 		exit();
		 		}
		 myslqli_stmt_close($stmt);
		 mysqli_close($con);
	}

		if(isset($_POST['mark-solved'])) {

	 		require 'connect.php';
	 		session_start();

	 		$usernameresponser = $_SESSION['username'];
	 		$id = $_POST['id-bug-report'];

	 		$sql = "UPDATE bugreport SET usernameresponser = '$usernameresponser', status = 1 WHERE id = '$id'";
			 		$run = mysqli_query($con, $sql);
			 		if($run != false) {

			 			$sqlfindreport = "SELECT * FROM bugreport WHERE id = '$id'";
			 			$resultsreportedbug = mysqli_query($con, $sqlfindreport);
			 			$rowbug = mysqli_fetch_assoc($resultsreportedbug);
			 			$touser = $rowbug['usernamecreator'];
			 			$titlereport = $rowbug['title'];

			 			$inboxtext = 'Administratorul <b>'.$usernameresponser.'</b> ti-a marcat Bug Report-ul <b>'.$titlereport.'</b> ca si <b style="color: #33cc33;">Rezolvat</b>. Multumim pentru ajutorul acordat!';
			 			$sqlinbox = "INSERT INTO inbox (touser, textinbox) VALUES ('$touser', '$inboxtext')";
			 			mysqli_query($con, $sqlinbox);

						$adminid = $_SESSION['id'];
						$sqlraport = "UPDATE staff SET 	bugreportmarked = bugreportmarked + 1 WHERE adminid = '$adminid'";
			 			mysqli_query($con, $sqlraport);

	 				header('Location: ../../dashboard.php?action=bugreports&bugreportview='.$id.'&msg=marksolved');
	 				exit();
		 		} else {
		 			header('Location: ../../dashboard.php?action=bugreports&bugreportview='.$id.'&msg=error');
		 			exit();
		 		}
		}

		if(isset($_POST['mark-unsolved'])) {

	 		require 'connect.php';
	 		session_start();

	 		$usernameresponser = "";
	 		$id = $_POST['id-bug-report'];

	 		$sql = "UPDATE bugreport SET usernameresponser = '$usernameresponser', status = 0 WHERE id = '$id'";
			 $run = mysqli_query($con, $sql);
			 if($run != false) {

			 	$adminid = $_SESSION['id'];
				$sqlraport = "UPDATE staff SET 	bugreportmarked = bugreportmarked - 1 WHERE adminid = '$adminid'";
			 	mysqli_query($con, $sqlraport);

	 			header('Location: ../../dashboard.php?action=bugreports&bugreportview='.$id.'&msg=markunsolved');
	 			exit();
		 	} else {
		 			header('Location: ../../dashboard.php?action=bugreports&bugreportview='.$id.'&msg=error');
		 		exit();
		 		}
		}

		if(isset($_POST['submit-notes'])) {

	 		require 'connect.php';
	 		session_start();

	 		$usernote = $_SESSION['username'];
	 		$id = $_POST['id-bug-report-note'];
	 		$notes = $_POST['notes'];

	 		$sql = "UPDATE bugreport SET usernote = '$usernote', notes = '$notes' WHERE id = '$id'";
			 $run = mysqli_query($con, $sql);
			 if($run != false) {
	 			header('Location: ../../dashboard.php?action=bugreports&bugreportview='.$id.'&msg=succes');
	 			exit();
		 	} else {
		 			header('Location: ../../dashboard.php?action=bugreports&bugreportview='.$id.'&msg=error');
		 		exit();
		 		}
		}
	?>