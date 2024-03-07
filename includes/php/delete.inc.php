<?php
	session_start();
	$iduserlog = $_SESSION['id'];
	$admin = $_SESSION['username'];
	$iplog = $_SESSION['ip'];

 	if(isset($_POST['deleteprofile'])) {
 		require 'connect.php';
 		$deleteid = $_POST['delete_id'];
 		$deleteusername = $_POST['delete_username'];
 		if($deleteid == $_SESSION['id']) {
 			header("Location: ../../profile.php?profile=".$deleteusername."&msg=cantdeleteyouraccount");
 			exit();
 		}
 		if($_SESSION['function'] < 3) {
 			header("Location: ../../profile.php?profile=".$deleteusername."&msg=lowlevel");
 			exit();
 		} else {
 		$sql = "DELETE FROM users WHERE id = '$deleteid'";
 		$run = mysqli_query($con, $sql);
 		if($run != false) {

 			$sqlraport = "UPDATE raport SET accountsdeleted = accountsdeleted + 1 WHERE adminid = '$iduserlog'";
 			mysqli_query($con, $sqlraport);
 			$textlog = 'Administratorul <b>'.$_SESSION['username'].'</b> a sters contul <b>'.$deleteusername.'</b>.';
			$sqllog = "INSERT INTO logs (iduserlog, userlog, userip, logtext) VALUES ('$iduserlog', '$userlog', '$userip', '$textlog')";
			mysqli_query($con, $sqllog);
			header('Location: ../../index.php?msg=success');
			exit();
 		} else {
 			 header("Location: ../../index.php?msg=error");
 			 exit();

 		}
 	 }
 	}

 	if(isset($_POST['deletedashboard'])) {
 		require 'connect.php';
 		$deleteid = $_POST['delete_id'];
 		$deleteusername = $_POST['delete_username'];
 		if($deleteid == $_SESSION['id']) {
 			header("Location: ../../dashboard.php?action=users&msg=cantdeleteyouraccount");
 			exit();
 		}
 		if($_SESSION['function'] != 3) {
 			header("Location: ../../dashboard.php?action=users&msg=lowlevel");
 			exit();
 		} else {

 		$sql = "DELETE FROM users WHERE id = '$deleteid' AND username = '$deleteusername'";
 		$run = mysqli_query($con, $sql);
 		if($run != false) {
 			$logtext = "Administratorul <b>".$admin."</b> a sters contul <b>".$deleteusername."</b>.";
 			$sqllogs = "INSERT INTO logs (iduserlog, userlog, userip, logtext) VALUES ('$iduserlog', '$admin', '$iplog', '$logtext')";
 			mysqli_query($con, $sqllogs);
 			$sqlraport = "UPDATE raport SET accountsdeleted = accountsdeleted + 1 WHERE adminid = '$iduserlog'";
 			mysqli_query($con, $sqlraport);
			header('Location: ../../dashboard.php?action=users&msg=succes');
			exit();
 		} else {
 			 header("Location: ../../dashboard.php?action=users&msg=error");
 			 exit();
 		}
 	 }
 	}

 	if(isset($_POST['deletetopic'])) {
 		require 'connect.php';

 		$deleteidtopic = $_POST['deletetopicid'];
 		$touser = $_POST['deletetopicuser'];
 		$deletetopictitle = $_POST['deletetopictitle'];

 		$sql = "DELETE FROM posts WHERE id = '$deleteidtopic'";
 		if(mysqli_query($con, $sql)) {
 			$inboxtext = "Topicul <b>".$deletetopictitle."</b> a fost sters de Administratorul <b>".$admin."</b> deoarece nu respecta termeni si conditiile platforme.";
 			$sqlinbox = "INSERT INTO inbox (touser, textinbox) VALUES ('$touser', '$inboxtext')";
 			mysqli_query($con, $sqlinbox);

 			$logtext = "Administratorul <b>".$admin."</b> a sters topicul <b>".$deletetopictitle."</b> creat de <b>".$touser."</b>.";
 			$sqllogs = "INSERT INTO logs (iduserlog, userlog, userip, logtext) VALUES ('$iduserlog', '$admin', '$iplog', '$logtext')";
 			mysqli_query($con, $sqllogs);

 			$sqlraport = "UPDATE raport SET deletedtopics = deletedtopics + 1 WHERE adminid = '$iduserlog'";
 			mysqli_query($con, $sqlraport);

 			header("Location: ../../forum.php?msg=success");
 			exit();
 		} else {
 			header("Location: ../../forum.php?action=viewpost&idpost=".$deleteidtopic."&msg=error");
 			exit();
 		}
 	}

 	if(isset($_POST['suspend-topic'])) {
 		require 'connect.php';

 		session_start();
 		$suspendtopicid = $_POST['suspendtopicid'];
 		$touser = $_POST['suspendtopicuser'];
 		$suspendtopictitle = $_POST['suspendtopictitle'];

 		$sql = "UPDATE posts SET suspended = 1, usersuspender = '$admin' WHERE id = '$suspendtopicid'";

 		if(mysqli_query($con, $sql)) {
 			$inboxtext = "Topicul <b>".$suspendtopictitle."</b> a fost ascuns de catre Administratorul <b>".$admin."</b> deoarece nu respecta termeni si conditiile VolvoFAN.ro.";
 			$sqlinbox = "INSERT INTO inbox (touser, textinbox) VALUES ('$touser', '$inboxtext')";
 			mysqli_query($con, $sqlinbox);

 			$logtext = "Administratorul <b>".$admin."</b> a ascuns topicul <b>".$suspendtopictitle."</b> creat de <b>".$touser."</b>.";
 			$sqllogs = "INSERT INTO logs (iduserlog, userlog, userip, logtext) VALUES ('$iduserlog', '$admin', '$iplog', '$logtext')";
 			mysqli_query($con, $sqllogs);

 			$sqlraport = "UPDATE raport SET suspendedtopics = suspendedtopics + 1 WHERE adminid = '$iduserlog'";
 			mysqli_query($con, $sqlraport);

 			header("Location: ../../forum.php?action=viewpost&idpost=".$suspendtopicid."&msg=success");
 			exit();
 		} else {
 			header("Location: ../../forum.php?action=viewpost&idpost=".$suspendtopicid."&msg=error");
 			exit();
 		}
 	}

 	if(isset($_POST['unsuspended-topic'])) {
 		require 'connect.php';

 		$unsuspendtopicid = $_POST['unsuspendtopicid'];
 		$touser = $_POST['unsuspendtopicuser'];
 		$unsuspendtopictitle = $_POST['unsuspendtopictitle'];

 		$sql = "UPDATE posts SET suspended = 0, usersuspender = '' WHERE id = '$unsuspendtopicid'";

 		if(mysqli_query($con, $sql)) {
 			$inboxtext = "Topicul <b>".$unsuspendtopictitle."</b> a fost reafisat de catre Administratorul <b>".$admin."</b>.";
 			$sqlinbox = "INSERT INTO inbox (touser, textinbox) VALUES ('$touser', '$inboxtext')";
 			mysqli_query($con, $sqlinbox);

 			$logtext = "Administratorul <b>".$admin."</b> a afisat topicul <b>".$unsuspendtopictitle."</b> creat de <b>".$touser."</b>.";
 			$sqllogs = "INSERT INTO logs (iduserlog, userlog, userip, logtext) VALUES ('$iduserlog', '$admin', '$iplog', '$logtext')";
 			mysqli_query($con, $sqllogs);

 			$sqlraport = "UPDATE raport SET suspendedtopics = suspendedtopics - 1 WHERE adminid = '$iduserlog'";
 			mysqli_query($con, $sqlraport);

 			header("Location: ../../forum.php?action=viewpost&idpost=".$unsuspendtopicid."&msg=success");
 			exit();
 		} else {
 			header("Location: ../../forum.php?action=viewpost&idpost=".$unsuspendtopicid."&msg=error");
 			exit();
 		}
 	}

 	if(isset($_POST['delete-status-update'])) {

 		require 'connect.php';
 		$id = $_POST['delete-status-update'];
 		$sqlfind = "SELECT * FROM statusupdates WHERE id = '$id'";
 		$rowresult = mysqli_fetch_assoc(mysqli_query($con, $sqlfind));
 		if($rowresult['usernameposter'] != $_SESSION['username']) {
 			$usernamedelete = $rowresult['usernameposter'];
 			$sqldelete = "DELETE FROM statusupdates WHERE id = '$id' AND usernameposter = '$usernamedelete'";
 			if(!mysqli_query($con, $sqldelete)) {
 				header("Location: ../../forum.php?msg=deletefailed");
 				exit();
 			} else {
 				$logtext = "Administratorul <b>".$admin."</b> a sters status update-ul lui <b>".$usernamedelete."</b>.";
 				$sqllogs = "INSERT INTO logs (iduserlog, userlog, userip, logtext) VALUES ('$iduserlog', '$admin', '$iplog', '$logtext')";
 				mysqli_query($con, $sqllogs);

 				header("Location: ../../forum.php?msg=successstatusdeleted");
 				exit();
 			}
 		} else {
 			$usernamedelete = $_SESSION['username'];
 			$sqldelete = "DELETE FROM statusupdates WHERE id = '$id' AND usernameposter = '$usernamedelete'";
 			if(!mysqli_query($con, $sqldelete)) {
 				header("Location: ../../forum.php?msg=deletefailed");
 				exit();
 			} else {
 				header("Location: ../../forum.php?msg=successstatusdeleted");
 				exit();
 			}
 		}
 	}

 	if(isset($_POST['delete-reply'])) {

 		require 'connect.php';
 		$id = $_POST['delete-reply'];
 		$sqlfind = "SELECT * FROM replystatusupdates WHERE id = '$id'";
 		$rowresult = mysqli_fetch_assoc(mysqli_query($con, $sqlfind));

 		$idstatus = $rowresult['idstatusreply'];
 		$sqlfind2 = "SELECT * FROM statusupdates WHERE id = '$idstatus'";
 		$rowresult2 = mysqli_fetch_assoc(mysqli_query($con, $sqlfind2));

 		if($rowresult['usernamereply'] != $_SESSION['username']) {

 			$usernamedelete = $rowresult['usernamereply'];
 			$sqldelete = "DELETE FROM replystatusupdates WHERE id = '$id' AND usernamereply = '$usernamedelete'";
 			if(!mysqli_query($con, $sqldelete)) {
 				header("Location: ../../forum.php?msg=deletefailed");
 				exit();
 			} else {
 				$logtext = "Administratorul <b>".$admin."</b> a sters raspunsul lui <b>".$usernamedelete."</b> la status update-ul lui <b>".$rowresult2['usernameposter']."</b>.";
 				$sqllogs = "INSERT INTO logs (iduserlog, userlog, userip, logtext) VALUES ('$iduserlog', '$admin', '$iplog', '$logtext')";
 				mysqli_query($con, $sqllogs);

 				header("Location: ../../forum.php?msg=successstatusdeleted");
 				exit();
 			}
 		} else {
 			$usernamedelete = $_SESSION['username'];
 			$sqldelete = "DELETE FROM replystatusupdates WHERE id = '$id' AND usernamereply = '$usernamedelete'";
 			if(!mysqli_query($con, $sqldelete)) {
 				header("Location: ../../forum.php?msg=deletefailed");
 				exit();
 			} else {
 				header("Location: ../../forum.php?msg=successstatusdeleted");
 				exit();
 			}
 		}
 	}

 	if(isset($_POST['delete-comm-post'])) {

 		require 'connect.php';
 		$id = $_POST['delete-comm-post'];
 		$idpost = $_POST['delete-id-post-comm'];
 		$namepost = $_POST['delete-name-post-comm'];
 		$sqlfind = "SELECT * FROM postcomments WHERE id = '$id' AND idpost = '$idpost'";
 		$rowresult = mysqli_fetch_assoc(mysqli_query($con, $sqlfind));
 		$sqlcomm = "UPDATE posts SET comments = comments - 1 WHERE id = '$idpost'";
 		mysqli_query($con, $sqlcomm);
 		if($rowresult['usernamecommpost'] != $_SESSION['username']) {
 			$usernamedelete = $rowresult['usernamecommpost'];
 			$sqldelete = "DELETE FROM postcomments WHERE id = '$id' AND idpost = '$idpost' AND usernamecommpost = '$usernamedelete'";
 			if(!mysqli_query($con, $sqldelete)) {
 				header("Location: ../../forum.php?action=viewpost&idpost=".$idpost."&msg=deletefailed");
 				exit();
 			} else {
 				$logtext = "Administratorul <b>".$admin."</b> a sters comentariul lui <b>".$usernamedelete."</b> de la topicul <b>".$namepost."</b>.";
 				$sqllogs = "INSERT INTO logs (iduserlog, userlog, userip, logtext) VALUES ('$iduserlog', '$admin', '$iplog', '$logtext')";
 				mysqli_query($con, $sqllogs);

 				header("Location: ../../forum.php?action=viewpost&idpost=".$idpost."&msg=successcommentdelete");
 				exit();
 			}
 		} else {
 			$usernamedelete = $_SESSION['username'];
 			$sqldelete = "DELETE FROM postcomments WHERE id = '$id' AND idpost = '$idpost' AND usernamecommpost = '$usernamedelete'";
 			if(!mysqli_query($con, $sqldelete)) {
 				header("Location: ../../forum.php?action=viewpost&idpost=".$idpost."&msg=deletefailed");
 				exit();
 			} else {
 				header("Location: ../../forum.php?action=viewpost&idpost=".$idpost."&msg=successcommentdelete");
 				exit();
 			}
 		}
 	}
