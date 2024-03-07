<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();
$iduserlog = $_SESSION['id'];
$userlog = $_SESSION['username'];
$userip  = $_SESSION['ip'];
if(isset($_POST['functionedit'])) {
 		require 'connect.php';

 		$id = $_POST['function_id'];
 		$function = $_POST['function'];
 		$functionusername = $_POST['function_username'];

 		$query = mysqli_query($con, "SELECT * FROM users WHERE id = '$id'");
 		$row = mysqli_fetch_array($query);
 		$functionold = $row['function'];
 		$verifiedfunction = $row['verified'];

 		if($_SESSION['function'] < $function) {
 			header('Location: ../../profile.php?profil='.$functionusername.'&msg=errorlevel');
 			exit();
 		} elseif($_SESSION['function'] <= 1 && $functionold > $function) { 
 			header('Location: ../../profile.php?profil='.$functionusername.'&msg=errordown');
 			exit();	
 		} elseif($verifiedfunction == 0) {
 			header('Location: ../../profile.php?profil='.$functionusername.'&msg=noverifed');
 			exit();
 		} elseif($_SESSION['function'] > 1 && $function == 0 && $_SESSION['id'] != $id) {

 		 	$sql = "UPDATE users SET function = '$function' WHERE id = '$id'";
	 		$run = mysqli_query($con, $sql);
	 		if($run != false) {
	 			$sqlraport = "DELETE FROM staff WHERE adminid = '$id'";
		 		mysqli_query($con, $sqlraport);

	 			$textinbox = 'Administratorul <b>'.$_SESSION['username'].'</b> te-a eliminat din echipa administrativa.';
	 			$sqlinbox = "INSERT INTO inbox (touser, textinbox) VALUES ('$functionusername', '$textinbox')";
	 			mysqli_query($con, $sqlinbox);

	 			$textlog = '<b>'.$_SESSION['username'].'</b> l-a eliminat din echipa administrativa pe <b>'.$functionusername.'</b>.';
				$sqllog = "INSERT INTO logs (iduserlog, userlog, userip, logtext) VALUES ('$iduserlog', '$userlog', '$userip', '$textlog')";
				mysqli_query($con, $sqllog);
	 			
 				header('Location: ../../profile.php?profil='.$functionusername.'&msg=succesdown');
 				exit();
	 		} else {
	 			header('Location: ../../profile.php?profil='.$functionusername.'&msg=errordown');
	 			exit();
	 		}

 		 } elseif($_SESSION['id'] == $id && $_SESSION['function'] > 1) {

 			header('Location: ../../profile.php?profil='.$functionusername.'&msg=errorselfgive');
 			exit();	

 		 } else {
 		 	
	 		$sql = "UPDATE users SET function = '$function' WHERE id = '$id'";
	 		$run = mysqli_query($con, $sql);
	 		if($run != false) {
	 			$sqlfindraport = "SELECT * FROM staff WHERE adminid = '$id'";
	 			if(mysqli_num_rows(mysqli_query($con, $sqlfindraport)) == 0) {
		 			$sqlraport = "INSERT INTO staff (adminid, username, function) VALUES ('$id', '$functionusername', '$function')";
		 			mysqli_query($con, $sqlraport);
	 			} else {
	 				$sqlraport = "UPDATE staff SET function = '$function' WHERE adminid = '$id'";
		 			mysqli_query($con, $sqlraport);
	 			}
	 			if($function == 1 ){
	 				$textinbox = 'Administratorul <b>'.$_SESSION['username'].'</b> ti-a acordat functia de <span class="badge badge-primary">Moderator</span>. Felicitari!';
	 			} elseif ($function == 2) {
	 				$textinbox = 'Administratorul <b>'.$_SESSION['username'].'</b> ti-a acordat functia de <span class="badge badge-success">Administrator</span>. Felicitari!';
	 			} elseif ($function == 3) {
	 				$textinbox = 'Administratorul <b>'.$_SESSION['username'].'</b> ti-a acordat functia de <span class="badge badge-danger">Owner</span>. Felicitari!';
	 			}
	 			$sqlinbox = "INSERT INTO inbox (touser, textinbox) VALUES ('$functionusername', '$textinbox')";
	 			mysqli_query($con, $sqlinbox);

	 			if($function == 1) {
	 				$functionname = '<span class="badge badge-primary">Moderator<span>';
	 			} elseif ($function == 2) {
	 				$functionname = '<span class="badge badge-success">Administrator</span>';
	 			} elseif ($function == 3 ) {
	 				$functionname = '<span class="badge badge-danger">Owner</span>';
	 			}

	 			$textlog = '<b>'.$_SESSION['username'].'</b> l-a promovat pe <b>'.$functionusername.'</b> la functia de '.$functionname.'.';
				$sqllog = "INSERT INTO logs (iduserlog, userlog, userip, logtext) VALUES ('$iduserlog', '$userlog', '$userip', '$textlog')";
				mysqli_query($con, $sqllog);

				$textlog = 'Administratorul <b>'.$_SESSION['username'].'</b> te-a promovat pe la functia de '.$functionname.'.';
				$sqllog = "INSERT INTO logs (iduserlog, userlog, userip, logtext) VALUES ('$id', '$functionusername', '-', '$textlog')";
				mysqli_query($con, $sqllog);

	 			header('Location: ../../profile.php?profil='.$functionusername.'&msg=succesfunction');
	 			exit();	
	 		} else {
	 			header('Location: ../../profile.php?profil='.$functionusername.'&msg=errorfunction');
	 			exit();	
	 		}
	 	}
	 }

	if(isset($_POST['editprofile'])) {
 		require 'connect.php';

 		$countries = array('Alege Judet', 'Alba', 'Arad', 'Arges','Bacau','Bihor','Bistrita-Nasaud','Botosani','Brasov','Braila','Buzau','Caras-Severin','Calarasi','Cluj','Constanta','Covasna','Dambovita','Dolj','Galati','Giurgiu','Gorj','Harghita','Hunedoara','Ialomita','Iasi','Ilfov','Maramures','Mehedinti','Mures','Neamt','Olt','Prahova','Satu Mare','Salaj','Sibiu','Suceava','Teleorman','Timis','Tulcea','Vaslui','Valcea','Vrancea');

 		$id = $_POST['edit_id'];
 		$username = $_POST['username'];
 		if(!isset($username)) {
 			$sqlusername = "SELECT username FROM users WHERE id = '$id'";
	 		$row = mysqli_fetch_assoc(mysqli_query($con, $sqlusername));
	 		$username = $row['username'];
 		}
 		$verified = $_POST['verified-status'];
 		if(!isset($verified)) {
 			$sqlstatus = "SELECT verified FROM users WHERE id = '$id'";
	 		$row = mysqli_fetch_assoc(mysqli_query($con, $sqlusername));
	 		$verified = $row['verified'];
 		}
 		$email = $_POST['email'];
 		$firstname = $_POST['firstname'];
 		$lastname = $_POST['lastname'];
 		$age = $_POST['age'];
 		$country = $_POST['country'];
 		$urlfb = $_POST['urlfacebook'];
 		$urlinsta = $_POST['urlinstagram'];
 		$urltwitter = $_POST['urltwitter'];
 		$year = $_POST['year'];
 		$month = $_POST['month'];
 		$day = $_POST['day'];
 		$birthdate = $year.'-'.$month.'-'.$day;
 		
	 	if($_SESSION['function'] < 1 && $_SESSION['username'] != $username) {
	 		header('Location: ../../profile.php?profil='.$username.'&msg=nothaveacces');
 				exit();
	 	} elseif(empty($firstname) || empty($lastname) || empty($age) || empty($country)) { 
	 		header('Location: ../../profile.php?profil='.$username.'&msg=emptyfields');
 				exit();
	 	} else {

	 	if($_SESSION['function'] > 2)
	 		$sql = "UPDATE users SET username = '$username', email = '$email', verified = '$verified', firstname = '$firstname', lastname = '$lastname', age = '$age', country = '$countries[$country]', birthdate = '$birthdate', urlfacebook = '$urlfb', urlinstagram = '$urlinsta', urltwitter = '$urltwitter' WHERE id = '$id'";
	 	else {
	 		$sql = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', age = '$age', country = '$countries[$country]', birthdate = '$birthdate', urlfacebook = '$urlfb', urlinstagram = '$urlinsta', urltwitter = '$urltwitter' WHERE id = '$id'";
	 	}
	 		if(mysqli_query($con, $sql)) {
	 			if($_SESSION['username'] != $username) {
		 			$textlog = 'Administratorul <b>'.$_SESSION['username'].'</b> a editat informatiile contul <b>'.$username.'</b>.';
					$sqllog = "INSERT INTO logs (iduserlog, userlog, userip, logtext) VALUES ('$iduserlog', '$userlog', '$userip', '$textlog')";
					mysqli_query($con, $sqllog);
				}
 				header('Location: ../../profile.php?profil='.$username.'&msg=successedited');
 				exit();
	 		} else {
	 			header('Location: ../../profile.php?profil='.$username.'&msg=erroredited');
	 			exit();
	 		}
	 	}
	 }