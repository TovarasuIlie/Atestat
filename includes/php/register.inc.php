<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	if(isset($_POST['register-submit'])) {


		if(!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }

		require 'connect.php';

		 $username = $_POST['username'];
		 $username = str_replace(" ", "", $username); //niculai ilie -> niculaiilie
		 $email = $_POST['email'];
		 $pwd = $_POST['password'];
		 $pwdrepeat = $_POST['pwdrepeat'];
		 $firstname = $_POST['firstname'];
		 $lastname = $_POST['lastname'];
		 $day = $_POST['day'];
		 $month = $_POST['month'];
		 $year = $_POST['year'];
		 $birthdate = $year.'-'.$month.'-'.$day;
		 $age = $_POST['age'];
		 $country = $_POST['country'];

		 $countries = array('Alege Judet', 'Alba', 'Arad', 'Arges','Bacau','Bihor','Bistrita-Nasaud','Botosani','Brasov','Braila','Buzau','Caras-Severin','Calarasi','Cluj','Constanta','Covasna','Dambovita','Dolj','Galati','Giurgiu','Gorj','Harghita','Hunedoara','Ialomita','Iasi','Ilfov','Maramures','Mehedinti','Mures','Neamt','Olt','Prahova','Satu Mare','Salaj','Sibiu','Suceava','Teleorman','Timis','Tulcea','Vaslui','Valcea','Vrancea');

		 if(empty($username) || empty($email) || empty($pwd) || empty($pwdrepeat) || empty($firstname) || empty($lastname) || empty($day) || empty($month) || empty($year) || empty($age) || empty($country)) {
		 	header("Location: ../../register.php?error=emptyfields&username=".$username."&email=".$email."&firstname=".$firstname."&lastname=".$lastname."&day=".$day."&month=".$month."&year=".$year."&age=".$age."&country=".$country);
		 	exit();
		 }
		 else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		 	header("Location: ../../register.php?error=invalidmail&username=".$username."&email=&firstname=".$firstname."&lastname=".$lastname."&day=".$day."&month=".$month."&year=".$year."&age=".$age."&country=".$country);
		 	exit();
		 }
		 else if($pwd != $pwdrepeat) {
		 	header("Location: ../../register.php?error=pwdnotmatch&username=".$username."&email=".$email."&firstname=".$firstname."&lastname=".$lastname."&day=".$day."&month=".$month."&year=".$year."&age=".$age."&country=".$country);
		 	exit();
		 }
		 else {

		 	$sql = "SELECT * FROM users WHERE username = ? OR email = ?";
		 	$stmt = mysqli_stmt_init($con);
		 	if(!mysqli_stmt_prepare($stmt, $sql)) {
		 		header("Location: ../../register.php?error=stmtfail&username=".$username."&email=".$email."&firstname=".$firstname."&lastname=".$lastname."&day=".$day."&month=".$month."&year=".$year."&age=".$age."&country=".$country);
		 		exit();
		 	}
		 	else {
		 		mysqli_stmt_bind_param($stmt , "ss", $username, $email);
		 		mysqli_stmt_execute($stmt);
		 		mysqli_stmt_store_result($stmt);
		 		$results = mysqli_stmt_num_rows($stmt);
		 		if($results > 0) {
		 			header("Location: ../../register.php?error=usernameormailtaken&username=&email=&firstname=".$firstname."&lastname=".$lastname."&day=".$day."&month=".$month."&year=".$year."&age=".$age."&country=".$country);
		 			exit();
		 	}
		 	else {
		 		$slqfindpermanentbannedip = "SELECT * FROM banlist WHERE permanentbanned = 1 AND bannedip = '$ip'";
		 		$findresults = mysqli_query($con, $slqfindpermanentbannedip);
		 		if(mysqli_num_rows($findresults) > 1) {
		 			header("Location: ../../register.php?error=findipbannedpermanent&username=".$username."&email=".$email."&firstname=".$firstname."&lastname=".$lastname."&day=".$day."&month=".$month."&year=".$year."&age=".$age."&country=".$country);
		 			exit();
		 		}
		 		$token = bin2hex(random_bytes(64));
 				$token = substr($token, 0, 25);
		 		$sql = "INSERT INTO users (username, password, email, ip, token, firstname, lastname, birthdate, age, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		 		$stmt = mysqli_stmt_init($con);
		 		if(!mysqli_stmt_prepare($stmt, $sql)) {
		 		header("Location: ../../register.php?error=stmtfail&username=".$username."&email=".$email."&firstname=".$firstname."&lastname=".$lastname."&day=".$day."&month=".$month."&year=".$year."&age=".$age."&country=".$country);
		 		exit();
		 		} else {
		 				$hashedpwd = password_hash($pwd, PASSWORD_DEFAULT);

				 		mysqli_stmt_bind_param($stmt , "ssssssssis", $username, $hashedpwd, $email, $ip, $token, $firstname, $lastname, $birthdate, $age, $countries[$country]);
				 		mysqli_stmt_execute($stmt);
				 		session_start();
				 		$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$hashedpwd'";
				 		$query = mysqli_query($con, $sql);
				 		if($row = mysqli_fetch_assoc($query)) {
	 						$_SESSION['id'] = $row['id'];
	 						$_SESSION['username'] = $row['username'];
	 						$_SESSION['email'] = $row['email'];
	 						$_SESSION['ip'] = $row['ip'];
	 						$_SESSION['verified'] = $row['verified'];
	 						$_SESSION['token'] = $row['token'];
	 						$_SESSION['profileimgstatus'] = $row['profileimgstatus'];
	 						$_SESSION['profileimgname'] = $row['profileimgname'];
	 						$_SESSION['firstname'] = $row['firstname'];
	 						$_SESSION['lastname'] = $row['lastname'];
	 						$_SESSION['birthdate'] = $row['birthdate'];
	 						$_SESSION['age'] = $row['age'];
	 						$_SESSION['country'] = $row['country'];
	 						$_SESSION['joindate'] = $row['joindate'];
	 						$_SESSION['function'] = $row['function'];
	 						$_SESSION['urlfacebook'] = $row['urlfacebook'];
	 						$_SESSION['urlinstagram'] = $row['urlinstagram'];
	 						$_SESSION['urltwitter'] = $row['urltwitter'];

									// Load Composer's autoloader
	 						if($HOST_TYPE == "LOCALHOST") {

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
								    $mail->Subject = 'Activeaza contul '.$row['username'];
								    $mail->Body    = 'Pentru ati activa contul pe <b>VolvoFAN.ro</b> trebuie sa dai <a href=http://localhost/Atestat/includes/php/verify.inc.php?userid='.$row['id'].'&username='.$row['username'].'&token='.$row['token'].'>Click aici</a>.';

								    if($mail->send()) {
								    	$touser = $row['username'];
									    $inboxtext = 'Pentru a avea acces complet pe <b>VolvoFAN.ro</b>, trebuie sa iti verifici email-ul. Un email a fost trimis la adresa de email <b>'.$row['email'].'</b>.';
									    $sqlinbox = "INSERT INTO inbox (touser, textinbox) VALUES ('$touser', '$inboxtext')";
									    mysqli_query($con, $sqlinbox); 
								    } else {
								    	$touser = $row['username'];
									    $inboxtext = 'Link-ul de verificare nu a fost trimis.';
									    $sqlinbox = "INSERT INTO inbox (touser, textinbox) VALUES ('$touser', '$inboxtext')";
									    mysqli_query($con, $sqlinbox); 
								    }
								} else {
								    

								    $mailsubject = 'Activeaza contul '.$row['username'];
								    $mailbody    = 'Pentru ati activa contul pe <b>VolvoFAN.ro</b> trebuie sa dai <a href=http://host.solomonhalita.ro/probleme/12A/NICULAIILIE-TRAIAN/includes/php/verify.inc.php?userid='.$row['id'].'&username='.$row['username'].'&token='.$row['token'].'>Click aici</a>.';
								    
									$headers = "MIME-Version: 1.0" . "\r\n";
	                    			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

								    if(mail($row['email'], $mailsubject, $mailbody, $headers)) {

									    $touser = $row['username'];
									    $inboxtext = 'Pentru a avea acces complet pe <b>VolvoFAN.ro</b>, trebuie sa iti verifici email-ul. Un email a fost trimis la adresa de email <b>'.$row['email'].'</b>.';
									    $sqlinbox = "INSERT INTO inbox (touser, textinbox) VALUES ('$touser', '$inboxtext')";
									    mysqli_query($con, $sqlinbox);
									} else {
										$touser = $row['username'];
									    $inboxtext = 'Link-ul de verificare nu a fost trimis.';
									    $sqlinbox = "INSERT INTO inbox (touser, textinbox) VALUES ('$touser', '$inboxtext')";
									    mysqli_query($con, $sqlinbox); 
									}
								}
							} else {
								header("location: ../../index.php?status=error");
								exit();
							}
			 		}
			 	}
			}
		}	 
		mysqli_stmt_close($stmt);
		mysqli_close($con);
		header("location: ../../index.php");
		exit();
	} else {
		header("location: ../../index.php");
		exit();
	}

 ?>