<?php 
	
	if(isset($_POST['ban-user'])) {

		require 'connect.php';
		session_start();
		$adminusername = $_SESSION['username'];
		$bannedid = $_POST['banned-id'];
		$banneduser = $_POST['banned-username'];
		$bannedip = $_POST['banned-ip'];
		$unbandate = $_POST['banduration'];
		$reason = $_POST['banreason'];

		if($_SESSION['username'] == $banneduser && $_SESSION['id'] == $bannedid) {
			header("Location: ../../profile.php?profil=".$banneduser."&msg=cantbanyou");
			exit();
			} else {
				$sqlfindexit = "SELECT * FROM banlist WHERE banneduserid = '$bannedid' AND bannedusername = '$banneduser'";
				if(mysqli_query($con, $sqlfindexit)) {
					$sqldelete = "DELETE FROM banlist WHERE banneduserid = '$bannedid' AND bannedusername = '$banneduser'";
					mysqli_query($con, $sqldelete);
				}
				if($unbandate == 0) {
					$sqlbannedpermanent = "INSERT INTO banlist (banneduserid, bannedusername, bannedip, bannedby, reason, permanentbanned) VALUES ('$bannedid', '$banneduser', '$bannedip', '$adminusername', '$reason', 1)";
					$sqluserbanned = "UPDATE users SET banned = 1 WHERE id = '$bannedid' AND username = '$banneduser'";
					mysqli_query($con, $sqluserbanned);
					mysqli_query($con, $sqlbannedpermanent);

					$logtext = "Utilizatorul <b>".$banneduser."</b> a fost banat de administatorul <b>".$adminusername."</b> pe motiv <b>".$reason."</b>. Tipul banului <b>Permanent</b>. ";
					$sqllog = "INSERT INTO logs (iduserlog, userlog, userip, logtext)  VALUES ('$bannedid', '$banneduser', '-', '$logtext')";
					mysqli_query($con, $sqllog);

					$ip = $_SESSION['ip'];
					$adminid = $_SESSION['id'];
					$logtextadmin = "<b>".$adminusername."</b> l-a banat pe utilizatorul <b>".$banneduser."</b> pe motiv <b>".$reason."</b>. Tipul banului <b>Permanent</b>.";
					$sqllogadmin = "INSERT INTO logs (iduserlog, userlog, userip, logtext)  VALUES ('$adminid', '$adminusername', '$ip', '$logtextadmin')";
					mysqli_query($con, $sqllogadmin);

					$inboxtext = "Ai fost banat <b>PERMANENT</b> de catre <b>".$adminusername."</b>, pe motiv <b>".$reason."</b>. Daca consideri ca ai fost banat pe nedrept, poti face oricand o <b>Cerere de Debanare</b>.";
					$sqlinbox = "INSERT INTO inbox (touser, textinbox) VALUES ('$banneduser', '$inboxtext')";
					mysqli_query($con, $sqlinbox);

					$sqlraport = "UPDATE staff SET accountsbanned = accountsbanned + 1 WHERE adminid = '$adminid'";
 					mysqli_query($con, $sqlraport);

					header("Location: ../../profile.php?profil=".$banneduser."&msg=successfullbanned");
					exit();
				} elseif($unbandate != 0) {

					$unban = strtotime($unbandate);
					$timeleft = $unban-time();
					$daysleft = round((($timeleft/24)/60)/60)+1; 

					$sqlbannedtemporar = "INSERT INTO banlist (banneduserid, bannedusername, bannedip, bannedby, reason, permanentbanned, banduration, unbandate) VALUES ('$bannedid', '$banneduser', '$bannedip', '$adminusername', '$reason', 0, '$daysleft'+1, '$unbandate')";
					$sqluserbanned = "UPDATE users SET banned = 1 WHERE id = '$bannedid' AND username = '$banneduser'";
					mysqli_query($con, $sqluserbanned);
					mysqli_query($con, $sqlbannedtemporar);

					$logtext = "Utilizatorul <b>".$banneduser."</b> a fost banat de administatorul <b>".$adminusername."</b> pe motiv <b>".$reason."</b>. Tipul banului: <b>Temporar(".$daysleft." zile)</b>.";
					$sqllog = "INSERT INTO logs (iduserlog, userlog, userip, logtext)  VALUES ('$bannedid', '$banneduser', '-', '$logtext')";
					mysqli_query($con, $sqllog);

					$ip = $_SESSION['ip'];
					$adminid = $_SESSION['id'];
					$logtextadmin = "<b>".$adminusername."</b> l-a banat pe utilizatorul <b>".$banneduser."</b> pe motiv <b>".$reason."</b>. Tipul banului <b>Temporar(".$daysleft." zile)</b>.";
					$sqllogadmin = "INSERT INTO logs (iduserlog, userlog, userip, logtext)  VALUES ('$adminid', '$adminusername', '$ip', '$logtextadmin')";
					mysqli_query($con, $sqllogadmin);

					$inboxtext = "Ai fost banat <b>Temporar(".$daysleft." zile)</b> de catre <b>".$adminusername."</b>, pe motiv <b>".$reason."</b>. Daca consideri ca ai fost banat pe nedrept, poti face oricand o <b>Cerere de Debanare</b>.";
					$sqlinbox = "INSERT INTO inbox (touser, textinbox) VALUES ('$banneduser', '$inboxtext')";
					mysqli_query($con, $sqlinbox);

					$sqlraport = "UPDATE staff SET accountsbanned = accountsbanned + 1 WHERE adminid = '$adminid'";
 					mysqli_query($con, $sqlraport);

					header("Location: ../../profile.php?profil=".$banneduser."&msg=successfullbanned");
				} else {
					header("Location: ../../profile.php?profil=".$banneduser."&msg=banerror");
				}
		}
	}

	if(isset($_POST['unban-user-btn'])) {
		require 'connect.php';
		session_start();

		$adminusername = $_SESSION['username'];
		$idban = $_POST['ban-id'];
		$bannedusername = $_POST['banned-username'];
		$bannedid = $_POST['banned-id'];
		$reasonunban = $_POST['unban-reason'];

		if($_SESSION['id'] == $bannedid && $_SESSION['username'] == $bannedusername) {
			header("Location: ../../profile.php?profil=".$banneduser."&msg=youcantunbanyou");
			exit();
		} else {
			$sqlunbanuser = "DELETE FROM banlist WHERE id = '$idban'";
			if(mysqli_query($con, $sqlunbanuser)) {

					$sqlunbanuserstatus = "UPDATE users SET banned = 0 WHERE id = '$bannedid'";
					mysqli_query($con, $sqlunbanuserstatus);

					$logtext = "Utilizatorul <b>".$bannedusername."</b> a fost debanat de administatorul <b>".$adminusername."</b> pe motiv <b>".$reasonunban."</b>.";
					$sqllog = "INSERT INTO logs (iduserlog, userlog, userip, logtext)  VALUES ('$bannedid', '$bannedusername', '-', '$logtext')";
					mysqli_query($con, $sqllog);

					$ip = $_SESSION['ip'];
					$adminid = $_SESSION['id'];
					$logtextadmin = "<b>".$adminusername."</b> l-a debanat pe utilizatorul <b>".$bannedusername."</b> pe motiv <b>".$reasonunban."</b>.";
					$sqllogadmin = "INSERT INTO logs (iduserlog, userlog, userip, logtext)  VALUES ('$adminid', '$adminusername', '$ip', '$logtextadmin')";
					mysqli_query($con, $sqllogadmin);

					$inboxtext = "Ai fost debanat de catre <b>".$adminusername."</b>, pe motiv <b>".$reasonunban."</b>.  Daca consideri ca ai fost banat pe nedrept, poti face oricand o <b>Cerere de Debanare</b>";
					$sqlinbox = "INSERT INTO inbox (touser, textinbox) VALUES ('$bannedusername', '$inboxtext')";
					mysqli_query($con, $sqlinbox);

					header("Location: ../../profile.php?profil=".$bannedusername."&msg=successfullunbanned");
					exit();
			} else {
				header("Location: ../../profile.php?profil=".$bannedusername."&msg=unbanerror");
			}
		}
	}

	if(isset($_POST['edit-ban-user'])) {
		require 'connect.php';
		session_start();
		$editbanusername = $_POST['banned-username'];
		$editbanid = $_POST['banned-id'];
		$editbanip = $_POST['banned-ip'];
		$editreason = $_POST['banreason'];
		$editbanduration = $_POST['banduration'];
		$editbanlistid = $_POST['ban-list-id'];
		$adminusername = $_SESSION['username'];
		$idunbanrequest = $_POST['unbanlist-id'];
		$sqldelete = "DELETE FROM banlist WHERE id = '$editbanlistid' AND banneduserid = '$editbanid' AND bannedusername = '$editbanusername' AND bannedip = '$editbanip'";
		if(mysqli_query($con, $sqldelete)) {

			if($editbanduration == 0) {
					$sqlbannedpermanent = "INSERT INTO banlist (banneduserid, bannedusername, bannedip, bannedby, reason, permanentbanned) VALUES ('$editbanid', '$editbanusername', '$editbanip', '$adminusername', '$editreason', 1)";
					$sqluserbanned = "UPDATE users SET banned = 1 WHERE id = '$editbanid' AND username = '$editbanusername'";
					mysqli_query($con, $sqluserbanned);
					mysqli_query($con, $sqlbannedpermanent);

					$logtext = "Utilizatorul <b>".$editbanusername."</b> i-a fost actualizat banul de catre administatorul <b>".$adminusername."</b> pe motiv <b>".$editreason."</b>. Tipul banului <b>Permanent</b>.";
					$sqllog = "INSERT INTO logs (iduserlog, userlog, userip, logtext)  VALUES ('$editbanid', '$editbanusername', '-', '$logtext')";
					mysqli_query($con, $sqllog);

					$ip = $_SESSION['ip'];
					$adminid = $_SESSION['id'];
					$logtextadmin = "<b>".$adminusername."</b> i-a actualizat banul utilizatorul <b>".$editbanusername."</b> pe motiv <b>".$editreason."</b>. Tipul banului <b>Permanent</b>.";
					$sqllogadmin = "INSERT INTO logs (iduserlog, userlog, userip, logtext)  VALUES ('$adminid', '$adminusername', '$ip', '$logtextadmin')";
					mysqli_query($con, $sqllogadmin);

					$inboxtext = "Ti-a fost actualizat banul de catre <b>".$adminusername."</b>, in ban <b>PERMANENT</b> pe motiv <b>".$editreason."</b>.";
					$sqlinbox = "INSERT INTO inbox (touser, textinbox) VALUES ('$editbanusername', '$inboxtext')";
					mysqli_query($con, $sqlinbox);

					$sqlfindbanlistid = "SELECT id FROM banlist WHERE banneduserid = '$editbanid' AND bannedusername = '$editbanusername' AND bannedip = '$editbanip' AND permanentbanned = 1";
					$rowid = mysqli_fetch_assoc(mysqli_query($con, $sqlfindbanlistid));
					$banlistid = $rowid['id'];
					$date = date("Y-m-d H:i", time());
					$sqlupdate = "UPDATE unbanrequests SET banlistid = '$banlistid', reason = '$editreason', bannedby = '$adminusername', permanentbanned = 1, banduration = 0, unbandate = '0000-00-00', banneddate = '$date' WHERE id = '$idunbanrequest'";
					mysqli_query($con, $sqlupdate);
					header("Location: ../../dashboard.php?action=unbanrequests&unbanrequestview=".$idunbanrequest."&msg=successfulledit");
					exit();
				} elseif($editbanduration > 0) {

					$unban = strtotime($editbanduration);
					$timeleft = $unban-time();
					$daysleft = round((($timeleft/24)/60)/60)+1;

					$sqlbannedtemporar = "INSERT INTO banlist (banneduserid, bannedusername, bannedip, bannedby, reason, permanentbanned, banduration, unbandate) VALUES ('$editbanid', '$editbanusername', '$editbanip', '$adminusername', '$editreason', 0, '$daysleft'+1, '$editbanduration')";
					$sqluserbanned = "UPDATE users SET banned = 1 WHERE id = '$editbanid' AND username = '$editbanusername'";
					mysqli_query($con, $sqluserbanned);
					mysqli_query($con, $sqlbannedtemporar);

					$logtext = "Utilizatorul <b>".$editbanusername."</b> i-a fost actualizat banul de catre administatorul <b>".$adminusername."</b> pe motiv <b>".$editreason."</b>. Tipul banului <b>Temporar(".$daysleft." zile)</b>.";
					$sqllog = "INSERT INTO logs (iduserlog, userlog, userip, logtext)  VALUES ('$editbanid', '$editbanusername', '-', '$logtext')";
					mysqli_query($con, $sqllog);

					$ip = $_SESSION['ip'];
					$adminid = $_SESSION['id'];
					$logtextadmin = "<b>".$adminusername."</b> i-a actualizat banul utilizatorul <b>".$editbanusername."</b> pe motiv <b>".$editreason."</b>. Tipul banului <b>Temporar(".$daysleft." zile)</b>.";
					$sqllogadmin = "INSERT INTO logs (iduserlog, userlog, userip, logtext)  VALUES ('$adminid', '$adminusername', '$ip', '$logtextadmin')";
					mysqli_query($con, $sqllogadmin);

					$inboxtext = "Ti-a fost actualizat banul de catre <b>".$adminusername."</b>, in ban <b>Temporar(".$daysleft." zile)</b> pe motiv <b>".$editreason."</b>.";
					$sqlinbox = "INSERT INTO inbox (touser, textinbox) VALUES ('$editbanusername', '$inboxtext')";
					mysqli_query($con, $sqlinbox);

					$sqlfindbanlistid = "SELECT id FROM banlist WHERE banneduserid = '$editbanid' AND bannedusername = '$editbanusername' AND bannedip = '$editbanip' AND permanentbanned = 0";
					$rowid = mysqli_fetch_assoc(mysqli_query($con, $sqlfindbanlistid));
					$banlistid = $rowid['id'];
					$date = date("Y-m-d H:i", time());
					$sqlupdate = "UPDATE unbanrequests SET banlistid = '$banlistid', reason = '$editreason', bannedby = '$adminusername', permanentbanned = 0, banduration = '$daysleft', unbandate = '$editbanduration', banneddate = '$date' WHERE id = '$idunbanrequest'";
					mysqli_query($con, $sqlupdate);
					header("Location: ../../dashboard.php?action=unbanrequests&unbanrequestview=".$idunbanrequest."&msg=successfulledittime");
					exit();
				}
		} else {
			header("Location: ../../dashboard.php?action=unbanrequests&unbanrequestview=".$idunbanrequest."&msg=error");
			exit();
		}
	}

		if(isset($_POST['unban-request-btn'])) {
		require 'connect.php';
		session_start();

		$adminusername = $_SESSION['username'];
		$idban = $_POST['ban-id'];
		$bannedusername = $_POST['banned-username'];
		$bannedid = $_POST['banned-id'];
		$unbanrequestid = $_POST['unbanrequest-id'];
		$reasonunban = $_POST['unban-reason'];

			$sqlunbanuser = "DELETE FROM banlist WHERE id = '$idban'";
			if(mysqli_query($con, $sqlunbanuser)) {

					$sqlunbanuserstatus = "UPDATE users SET banned = 0 WHERE id = '$bannedid'";
					mysqli_query($con, $sqlunbanuserstatus);

					$logtext = "Utilizatorul <b>".$bannedusername."</b> a fost debanat de administatorul <b>".$adminusername."</b> pe motiv <b>".$reasonunban."</b>.";
					$sqllog = "INSERT INTO logs (iduserlog, userlog, userip, logtext)  VALUES ('$bannedid', '$bannedusername', '-', '$logtext')";
					mysqli_query($con, $sqllog);

					$ip = $_SESSION['ip'];
					$adminid = $_SESSION['id'];
					$logtextadmin = "<b>".$adminusername."</b> l-a debanat pe utilizatorul <b>".$bannedusername."</b> pe motiv <b>".$reasonunban."</b>.";
					$sqllogadmin = "INSERT INTO logs (iduserlog, userlog, userip, logtext)  VALUES ('$adminid', '$adminusername', '$ip', '$logtextadmin')";
					mysqli_query($con, $sqllogadmin);

					$inboxtext = "Ai fost debanat de catre <b>".$adminusername."</b>, pe motiv <b>".$reasonunban."</b>.";
					$sqlinbox = "INSERT INTO inbox (touser, textinbox) VALUES ('$bannedusername', '$inboxtext')";
					mysqli_query($con, $sqlinbox);

					header("Location: ../../dashboard.php?action=unbanrequests&unbanrequestview=".$unbanrequestid."&msg=successfullunbanned");
					exit();
			} else {
				header("Location: ../../dashboard.php?action=unbanrequests&unbanrequestview=".$unbanrequestid."&msg=unbanerror");
			}
		}

		if(isset($_POST['close-request'])) {
			require 'connect.php';
			$closerequestid = $_POST['close-request-id'];
			$closerequestuserid = $_POST['close-request-userid'];
			$sqlclose = "UPDATE unbanrequests SET status = 1 WHERE id = '$closerequestid' AND banneduserid = '$closerequestuserid'";
			mysqli_query($con, $sqlclose);

			session_start();
			$adminid = $_SESSION['id'];
			$sqlraport = "UPDATE staff SET closedunbanrequests = closedunbanrequests + 1 WHERE adminid = '$adminid'";
 			mysqli_query($con, $sqlraport);

			header("Location: ../../dashboard.php?action=unbanrequests&unbanrequestview=".$closerequestid."&msg=closed");
			exit();
		}

		if(isset($_POST['open-request'])) {
			require 'connect.php';
			$openrequestid = $_POST['open-request-id'];
			$openrequestuserid = $_POST['open-request-userid'];
			$sqlclose = "UPDATE unbanrequests SET status = 0 WHERE id = '$openrequestid' AND banneduserid = '$openrequestuserid'";
			mysqli_query($con, $sqlclose);

			session_start();
			$adminid = $_SESSION['id'];
			$sqlraport = "UPDATE staff SET closedunbanrequests = closedunbanrequests - 1 WHERE adminid = '$adminid'";
 			mysqli_query($con, $sqlraport);

			header("Location: ../../dashboard.php?action=unbanrequests&unbanrequestview=".$openrequestid."&msg=opened");
			exit();
		}

?>