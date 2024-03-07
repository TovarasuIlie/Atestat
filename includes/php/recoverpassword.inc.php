<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	if(isset($_POST['recoverpwd-btn'])) {

		$recoverdates = $_POST['recover-dates'];

		if(empty($recoverdates)) {
			header("Location: ../../recoverpassword.php?error=emptyfields");
			exit();
		} else {

			require 'connect.php';

			$sql = "SELECT * FROM users WHERE email = '$recoverdates' OR username = '$recoverdates'";
			$results = mysqli_query($con, $sql);
			if(mysqli_num_rows($results) == 0) {
				header("Location: ../../recoverpassword.php?error=invalidmailorusername");
				exit();
			} else {
				$row = mysqli_fetch_assoc($results);

				$id = $row['id'];
 				$username = $row['username'];
 				$email = $row['email'];
				if(empty($row['token'])) {
					$token = bin2hex(random_bytes(64));
 					$token = substr($token, 0, 25);
 					mysqli_query($con, "UPDATE users SET token = '$token' WHERE id = '$id' AND username = '$username' AND email = '$email'");
				} else {
					$token = $row['token'];
				}
				session_start();
				$_SESSION['resetusername'] = $row['username'];
				$_SESSION['resetemail'] = $row['email'];

				if($HOST_TYPE == 'LOCALHOST') {
				// Load Composer's autoloader
								require 'PHPMailer/PHPMailer.php';
			                    require 'PHPMailer/SMTP.php';
			                    require 'PHPMailer/Exception.php';


								// Instantiation and passing `true` enables exceptions
								$mail = new PHPMailer(true);

							    //Server settings
							    $mail->SMTPDebug = 0;                      // Enable verbose debug output
							    $mail->isSMTP();                                            // Send using SMTP
							    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
							    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
							    $mail->Username   = 'noreplyvolvofan.ro@gmail.com';                     // SMTP username
							    $mail->Password   = 'Nilietraian!';                               // SMTP password
							    $mail->SMTPSecure = "TLS";         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
							    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

							    //Recipients
							    $mail->setFrom('noreplyvolvofan.ro@gmail.com', 'VolvoFAN.ro');
							    $mail->addAddress($row['email']);     // Add a recipient

							    // Content
							    $mail->isHTML(true);                                  // Set email format to HTML
							    $mail->Subject = 'Resetare parola cont '.$row['username'];
							    $mail->Body    = 'Pentru ati reseta parola de la contul <b>'.$row['username'].'</b> de pe <b>VolvoFAN.ro</b> trebuie sa dai <a href=http://localhost/Atestat/includes/php/recoverpassword.inc.php?action=resetpwd&id='.$row['id'].'&username='.$row['username'].'&token='.$token.'>Click aici</a>.';

							    if($mail->send()) {
							    	header("Location: ../../recoverpassword.php?action=emailsend");
									exit();
							    }
							} else {
								$mailsubject = 'Resetare parola cont '.$row['username'];
								$mailbody    = 'Pentru ati reseta parola de la contul <b>'.$row['username'].'</b> de pe <b>VolvoFAN.ro</b> trebuie sa dai <a href=http://host.solomonhalita.ro/probleme/12A/NICULAIILIE-TRAIAN/includes/php/recoverpassword.inc.php?action=resetpwd&id='.$row['id'].'&username='.$row['username'].'&token='.$token.'>Click aici</a>.';
								    
								$headers = "MIME-Version: 1.0" . "\r\n";
	                    		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

								if(mail($row['email'], $mailsubject, $mailbody, $headers)) {
									header("Location: ../../recoverpassword.php?action=emailsend");
									exit();
								}
							}

			}
		}
	}

	if(isset($_GET['action']) && $_GET['action'] == 'resetpwd' && isset($_GET['id']) && isset($_GET['username']) && isset($_GET['token'])) {
		session_start();
		$_SESSION['idreset'] = $_GET['id'];
		$_SESSION['usernamereset'] = $_GET['username'];
		$_SESSION['tokenreset'] = $_GET['token'];
		header("Location: ../../recoverpassword.php?action=resetpwd");
		exit();
	}

	if(isset($_POST['resetpwd-btn'])) {
		
		$idreset = $_POST['id-reset'];
		$usernamereset = $_POST['username-reset'];
		$tokenreset = $_POST['token-reset'];
		$pwdreset = $_POST['pwd'];
		$repeatpwdreset = $_POST['repeat-pwd'];

		if(empty($pwdreset) || empty($repeatpwdreset)) {
			header("Location: ../../recoverpassword.php?action=resetpwd&error=emptyfields");
			exit();
		} else {
			if($pwdreset != $repeatpwdreset) {
				header("Location: ../../recoverpassword.php?action=resetpwd&error=pwdnotmatch");
				exit();
			} else {
				require 'connect.php';
				$sqlnum = "SELECT * FROM users WHERE token = '$tokenreset'";
				$resultsfind = mysqli_query($con, $sqlnum);
				if(mysqli_num_rows($resultsfind) > 0) {
					require 'connect.php';
					$pwdreset = password_hash($pwdreset, PASSWORD_DEFAULT);
					$sqlreset = "UPDATE users SET password = '$pwdreset' WHERE id = '$idreset' AND username = '$usernamereset' AND token = '$tokenreset'";
					mysqli_query($con, $sqlreset);
					header("Location: ../../index.php");
					exit();
				} else {
					header("Location: ../../recoverpassword.php?action=resetpwd&error=notreset");
					exit();
				}
			}
		}
	}
?>