<?php 
 	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	require 'connect.php';

 	if(isset($_POST['login-submit'])) {

 		session_start();
 		$username = mysqli_real_escape_string($con, $_POST['username']);
 		$pwd = mysqli_real_escape_string($con, $_POST['password']);
 		$pagename = $_SESSION['pagename'];
 		if($pagename == 'profile.php') {
 			$userprofil = $_POST['userprofil'];
 		} elseif($pagename == 'finduser.php') {
 			$finduser = $_POST['finduser'];
 		}

 		if(empty($_POST['username']) || empty($_POST['password'])) {
 			if($pagename != 'profile.php' && $pagename != 'finduser.php') {
	 			header("location: ../../".$pagename."?error=emptyfields");
	 			exit();
 			} elseif($pagename == 'profile.php') {
 				header("location: ../../".$pagename."?profil=".$userprofil."&error=emptyfields");
	 			exit();
 			} elseif($pagename == 'finduser.php') {
 				header("location: ../../".$pagename."?search=".$finduser."&error=emptyfields");
	 			exit();
 			}
 		}
 		else {

 			$sql = "SELECT * FROM users WHERE username = ? OR email = ?";
 			$stmt = mysqli_stmt_init($con);
 			if(!mysqli_stmt_prepare($stmt, $sql)) {
	 			header("location: ../../".$pagename."?error=stmtfail");
	 			exit(); 				
 			} else {

 				mysqli_stmt_bind_param($stmt, "ss", $username, $username);
 				mysqli_stmt_execute($stmt);
 				mysqli_stmt_bind_result($stmt, $id, $username, $password, $email, $ip, $token, $verified, $banned, $firstname, $lastname, $age, $country, $joindate, $function, $birthdate, $profileimgstatus, $profileimgname, $urlfacebook, $urlinstagram, $urltwitter);
 				if(mysqli_stmt_fetch($stmt)) {
 					$pwdcheck = password_verify($pwd, $password);
 					if($pwdcheck == false) {
 						if($pagename == 'profile.php') {
 							$pageprofil = $_POST['userprofil'];
 							header("location: ../../".$pagename."?profil=".$pageprofil."&error=wrongusernameorpwd");
	 						exit();
 						} elseif($pagename == 'finduser.php') {
		 					header("location: ../../".$pagename."?search=".$finduser."&error=wrongusernameorpwd");
		 					exit();
	 					} else {
							header("location: ../../".$pagename."?error=wrongusernameorpwd");
		 					exit();
	 					}
 					} elseif($pwdcheck == true) {
 						$_SESSION['id'] = $id;
 						$_SESSION['username'] = $username;
 						$_SESSION['email'] = $email;
 						$_SESSION['firstname'] = $firstname;
 						$_SESSION['lastname'] = $lastname;
 						$_SESSION['age'] = $age;
 						$_SESSION['country'] = $country;
 						$_SESSION['joindate'] = $joindate;
 						$_SESSION['function'] = $function;
 						$_SESSION['profileimgname'] = $profileimgname;

 						 		if(!empty($_SERVER["HTTP_CLIENT_IP"])) {
						            $ipchange = $_SERVER["HTTP_CLIENT_IP"];
						        }
						        else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
						            $ipchange = $_SERVER["HTTP_X_FORWARDED_FOR"];
						        } else {
						            $ipchange = $_SERVER["REMOTE_ADDR"];
						        }

						        if($ip != $ipchange) {
						        	require 'connect.php';
						        	$sqlip = "UPDATE users SET ip = '$ipchange' WHERE id = '$id'";
						        	mysqli_query($con, $sqlip);
						        }
						        
						$_SESSION['ip'] = $ip;
						$_SESSION['verified'] = $verified;
						$_SESSION['banned'] = $banned;
						$_SESSION['urlfacebook'] = $urlfacebook;
						$_SESSION['urlinstagram'] = $urlinstagram;
						$_SESSION['urltwitter'] = $urltwitter;

						if($_SESSION['banned'] == 1) {
							require 'connect.php';
							$sqldaysban = "SELECT * FROM banlist WHERE banneduserid = '$id'";
						    $result = mysqli_query($con, $sqldaysban);
						    $rowdays = mysqli_fetch_assoc($result);
						    $permanentbanned = $rowdays['permanentbanned'];
						    $date = $rowdays['unbandate'];

						    if($permanentbanned == 0) {
							    $dateunban = strtotime($date);
							    $now = date('Y-m-d', time());

							    if(strtotime($now) < strtotime($date)) {

								    $timeleft = $dateunban - time();
								    $daysleft = round((($timeleft/24)/60)/60)+1;
								    $sqldaysban = "UPDATE banlist SET banduration = '$daysleft' WHERE banneduserid = '$id'";
								    mysqli_query($con, $sqldaysban);
								 
								} else {
									require 'connect.php';
									$sqlunbanuser = "DELETE FROM banlist WHERE banneduserid = '$id'";
									if(mysqli_query($con, $sqlunbanuser)) {

										$sqlunbanuserstatus = "UPDATE users SET banned = 0 WHERE id = '$id'";
										mysqli_query($con, $sqlunbanuserstatus);

										$bannedid = $id;
										$bannedusername = $username;
										$logtext = "Utilizatorul <b>".$bannedusername."</b> a fost debanat automat de catre <b>AdmBot</b> pe motiv <b>Timpul banului s-a scurs</b>.";
										$sqllog = "INSERT INTO logs (iduserlog, userlog, userip, logtext)  VALUES ('$bannedid', '$bannedusername', '-', '$logtext')";
										mysqli_query($con, $sqllog);

										$inboxtext = "Ai fost debanat de catre <b>AdmBot</b>, pe motiv <b>Timpul banului s-a scurs</b>.";
										$sqlinbox = "INSERT INTO inbox (touser, textinbox) VALUES ('$bannedusername', '$inboxtext')";
										mysqli_query($con, $sqlinbox);
										$_SESSION['banned'] = 0;
									}
							}
						}
					}
						        

						if($pagename != 'profile.php' && $pagename != 'finduser.php') {
							mysqli_stmt_close($stmt);
							mysqli_close($con);
		 					header("location: ../../".$pagename);
		 					exit();
	 					} elseif($pagename == 'profile.php') {
	 						mysqli_stmt_close($stmt);
							mysqli_close($con);
	 						header("location: ../../".$pagename."?profil=".$userprofil);
	 						exit();
	 					} elseif($pagename == 'finduser.php') {
	 						mysqli_stmt_close($stmt);
							mysqli_close($con);
		 					header("location: ../../".$pagename."?search=".$finduser);
		 					exit();
	 					} 

 					} else {
	 					header("location: ../../".$pagename."?error=wrongusernameorpwd");
	 					exit();
 					}
 				} else {
 					 header("location: ../../index.php?error=usernotexist");
 					exit();
 				}
 			}
 		}

 	} else {
 		header("location: ../../index.php");
 		exit();
 	}

 ?>