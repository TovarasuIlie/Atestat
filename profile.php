<?php
	session_start();
	require 'includes/php/connect.php';
	$username = $_GET['profil'];
	$query = mysqli_query($con, "SELECT * FROM users WHERE username = '$username'");
  if(mysqli_num_rows($query) > 0) {
    $resultfound = TRUE;
  	while($row = mysqli_fetch_array($query)) {
      $username = $row['username'];
  	  $id = $row['id'];
      $ip = $row['ip'];
  	  $email = $row['email'];
      $verified = $row['verified'];
      $banned = $row['banned'];
  		$firstname = $row['firstname'];
  		$lastname = $row['lastname'];
  		$age = $row['age'];
      $birthdate = $row['birthdate'];
      $birthdate = strtotime($birthdate);
      $birthdate = date('d.m.Y', $birthdate);
      $birthdateeplode = explode('.', $birthdate);
      $year = $birthdateeplode[2];
      $month = $birthdateeplode[1];
      $day = $birthdateeplode[0];
  		$country = $row['country'];
  		$function = $row['function'];
  		$joindate = $row['joindate'];
  		$joindate = strtotime($joindate);
  		$joindate = date('d.M.Y H:i', $joindate);
      $profileimgstatus = $row['profileimgstatus'];
      $profileimgname = $row['profileimgname'];
      $urlfb = $row['urlfacebook'];
      $urlinsta = $row['urlinstagram'];
      $urltwitter = $row['urltwitter'];
      }
    } else {
        $resultfound = FALSE;
    }

    if(isset($id)) {
      $sqldaysban = "SELECT * FROM banlist WHERE banneduserid = '$id'";
      $result = mysqli_query($con, $sqldaysban);
      if(mysqli_num_rows($result) > 0) {
        
        $rowdays = mysqli_fetch_array($result);
        $date = $rowdays['unbandate'];
        $banduration = $rowdays['banduration'];
        $date = strtotime($date);
        $timeleft = $date-time();
        $daysleft = round((($timeleft/24)/60)/60)+1;

        $sqldaysban = "UPDATE banlist SET banduration = '$daysleft' WHERE banneduserid = '$id'";
        mysqli_query($con, $sqldaysban);

        $sqldaysban = "SELECT * FROM banlist WHERE banneduserid = '$id'";
        $result = mysqli_query($con, $sqldaysban);
        $rowdays = mysqli_fetch_array($result);
        $unbandate = $rowdays['unbandate'];
        $permanentbanned = $rowdays['permanentbanned'];
        $now = date('Y-m-d', time());
        if ($unbandate <= $now && $permanentbanned == 0) {
            $banned = 0;
        } elseif($permanentbanned == 1) {
            $banned = 1;
        }
     }
   }

   if(!isset($_GET['action'])) {
        unset($_SESSION['sortdates']);
   }

    $countries = array('Alege Judet', 'Alba', 'Arad', 'Arges','Bacau','Bihor','Bistrita-Nasaud','Botosani','Brasov','Braila','Buzau','Caras-Severin','Calarasi','Cluj','Constanta','Covasna','Dambovita','Dolj','Galati','Giurgiu','Gorj','Harghita','Hunedoara','Ialomita','Iasi','Ilfov','Maramures','Mehedinti','Mures','Neamt','Olt','Prahova','Satu Mare','Salaj','Sibiu','Suceava','Teleorman','Timis','Tulcea','Vaslui','Valcea','Vrancea');

    $functions = array('Utilizator Normal', 'Moderator', 'Administrator', 'Owner');

    $luni = array('Alege Luna','Ianuarie', 'Februarie', 'Martie', 'Aprilie', 'Mai', 'Iunie', 'Iulie', 'August', 'Septembrie','Octombre', 'Noiembrie', 'Decembrie');

  if(isset($_SESSION['username'])) {
      $userto = $_SESSION['username'];
      $sqlinbox = "SELECT id FROM inbox WHERE touser = '$userto' AND status = 0";
      $queryinbox = mysqli_query($con, $sqlinbox);
      $nrnotifications = mysqli_num_rows($queryinbox);
    }
  unset($_SESSION["pagename"]);
  $_SESSION['pagename'] = basename($_SERVER['PHP_SELF']);

  if (isset($_SESSION['loggedtime']) && (time() - $_SESSION['loggedtime'] > 1800)) {
      session_destroy();
      session_unset();
      header('location: profile.php?profil='.$username);
      } else {
        $_SESSION['loggedtime'] = time();
      }

if(isset($_SESSION['id'])) {
  $banneduserid = $_SESSION['id'];
  $bannedusername = $_SESSION['username'];

  $sqlbanned = "SELECT * FROM banlist WHERE banneduserid = '$banneduserid' AND bannedusername = '$bannedusername'";
  $results = mysqli_query($con, $sqlbanned);
  if(mysqli_num_rows($results) > 0) {
    $_SESSION['banned'] = 1;
  } else {
    $_SESSION['banned'] = 0;
  }
}

?>
<!DOCTYPE html>
<html>
<head>
<?php if(isset($_GET['profil']) && isset($_SESSION['username']) && $_GET['profil'] == $_SESSION['username']) { ?>
	<title>Profilul tau - VolvoFAN.ro</title>
<?php }elseif((isset($_GET['profil']) && isset($_SESSION['username']) && $_GET['profil'] != $_SESSION['username']) || (isset($_GET['profil']) && !isset($_SESSION['username'])) && $resultfound == TRUE) { ?>
  <title>Profilul lui <?php echo $_GET['profil']; ?> - VolvoFAN.ro</title>
<?php }else { ?>
  <title>Profilul nu a fost gasit - VolvoFAN.ro</title>
<?php } ?>
		    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="1800;url=includes/php/logout.inc.php?profil=<?php echo $username; ?>" />
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">

        <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">    
    <script src="https://kit.fontawesome.com/0c4d35ef60.js" crossorigin="anonymous"></script>
    <link href="includes/style.css" rel="stylesheet">

        <!-- Boostrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <style>
       .image-preview {
          width: 300px;
          height: 200px;
          border: 3px solid black;
          border-radius: 3px;
          margin-top: 15px;

          display: flex;
          align-items: center;
          justify-content: center;
          font-weight: bold;
          color: #cccccc;
       }

       .image-prewiew-img {
          width: 100%; /* width of container */
          height: 100%; /* height of container */
          object-fit: cover;
          object-position: 70% 30%;
}

       .image-preview-image {
          display: none;
          width: 100%;
       }

    </style>

    <?php if((isset($_GET['status']) && $_GET['status'] == 'loggedout') || (isset($_GET['error']) && $_GET['error'] != 'toofewchars')) { ?>
    <script>
      $(document).ready(function(){
          $("#loginmodal").modal('show');
      });
    </script>
  <?php } ?>

    <?php if(isset($_GET['error']) && $_GET['error'] == 'toofewchars') { ?>
      <script>
        $(document).ready(function(){
            $("#findusermodal").modal('show');
        });
    </script>
  <?php } ?>
</head>
<body>
	<header>
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-gray">
        <a class="navbar-brand" href="index.php"><img scr="img/logo.png"><img src="img/logo.png" height="30px" width="140px" title="VolvoFAN.ro"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Acasa</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="history.php">Istoria Volvo</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="gallery.php">Galerie</a>
            </li>
             <li class="nav-item">
              <a class="nav-link" href="contact.php">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="forum.php">Forum VolvoFAN.ro</a>
            </li>
          </ul>
            <div class="nav-link" style="color: white;">
            	<div class="dropdown">
            		  <?php  if(!isset($_SESSION['username'])){
                            echo '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Welcome <i style="font-size: 14px;" class="fa fa-question-circle-o" aria-hidden="true"></i> Guest</button>
                              <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                <a class="dropdown-item" href="#loginmodal" data-toggle="modal"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a>
                                <a class="dropdown-item" href="#findusermodal" data-toggle="modal"><i class="fas fa-search"></i> Cauta utilizator</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="register.php"> <i class="fa fa-plus-square" aria-hidden="true"></i> Register</a>
                              </div>
                            </div>';
                        }

                         if(isset($_SESSION['username'])){
                            echo '<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                      <a href="#inboxmodal" data-toggle="modal" class="btn btn-secondary"><i class="fa fa-envelope" aria-hidden="true"></i> <span class="badge badge-danger">'.$nrnotifications.'</span></a>
                                  <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Welcome <i class="fa fa-user" aria-hidden="true"></i> '.$_SESSION['username'].'</button>
                                      <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                        <a class="dropdown-item" name="profile-page" href="profile.php?profil='.$_SESSION['username'].'"><i class="fa fa-user" aria-hidden="true"></i> Profilul tau</a>
                                        <a class="dropdown-item" href="#findusermodal" data-toggle="modal"><i class="fas fa-search"></i> Cauta utilizator</a>
                                        <a class="dropdown-item" href="#bugreportmodal" data-toggle="modal"><i class="fas fa-bug"></i> Raporteaza o problema</a>';
                          if($_SESSION['function'] !=0 ) { 
                            echo '<a class="dropdown-item" href="dashboard.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a>'; 
                          }
                                echo '<a class="dropdown-item active" style="background-color: #ff3300; border: 1px solid #ff3300; border-radius: 2px; font-weight: 600;" href="unbanrequest.php"><i class="fa fa-unlock" aria-hidden="true"></i> Cerere de Debanare</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href=includes/php/logout.inc.php?profil='.$_GET['profil'].'><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
                              </div>
                            </div>
                            </div>';
                        }
                        ?>
                    </div>
        </div>
      </nav>
    </header>

<?php if(!isset($_SESSION['username'])) { ?>
    <!--------------LOGIN MODAL--------------->

            <div class="modal fade" id="loginmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content" style="border-radius: 5px;">
                <div class="modal-header" style="background-color: #4d4d4d;">
                  <div class="modal-title" id="exampleModalLabel"><img src="img/logo.png" height="30px" width="140px" title="VolvoFAN.ro"></div>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                  </button>
                </div>
                <form method="POST" action="includes/php/login.inc.php">
                  <div class="modal-body">
                    <?php if(isset($_GET['error']) && $_GET['error'] == 'emptyfields') { ?>
                      <div class="alert alert-danger">Toate campurile trebuie completate.</div>
                    <?php } ?>
                    <?php if(isset($_GET['error']) && $_GET['error'] == 'stmtfail') { ?>
                      <div class="alert alert-danger">A aparut o eroarea, va rugam sa incercati din nou.</div>
                    <?php } ?>
                    <?php if(isset($_GET['error']) && $_GET['error'] == 'wrongusernameorpwd') { ?>
                      <div class="alert alert-danger"><b>Username-ul</b> sau <b>Parola</b> sunt gresite.</div>
                    <?php } ?>
                    <?php if(isset($_GET['error']) && $_GET['error'] == 'usernotexist') { ?>
                      <div class="alert alert-danger">Datele introduse nu au putut fi gasite in baza de date.</div>
                    <?php } ?>
                    <small><b><label class="mr-sm-2">Username sau Email:</label></b></small>               
                    <input type="text" name="username" class="form-control" placeholder="Username sau Email"><br>
                    <small><b><label class="mr-sm-2">Parola: </label><a href="#">Ti-ai uitat parola?</a></b></small>
                    <input type="password" name="password" class="form-control" placeholder="Parola"><br>
                    <input type="hidden" name="userprofil" value=<?php if(isset($_GET['profil'])) echo $_GET['profil']; ?>>
                    <div class="row">
                    <div class="col">
                    <div class="checkbox mb-3">
                      <small>
                      <label>
                           <input type="checkbox" value="remember-me"> Tine-ma minte!
                      </label>
                    </small>
                         </div>
                       </div>
                         <div class="col">
                          <small class="float-right">Nu ai un cont inca? <a href="register.php">Apasa aici</a></small>
                        </div>
                      </div>
                      </label>
                    </div>
                    <center>
                        <button type="submit" class="btn btn-primary btn-block" style="width: 80%" name="login-submit">Logheaza-te</button>
                    </center><br>
                  </div>
                </form>
              </div>
            </div>
          </div>
    <!--END OF LOGIN MODAL -->
<?php } ?>

    <!--------------FIND USER MODAL--------------->

            <div class="modal fade" id="findusermodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content" style="border-radius: 5px;">
                <div class="modal-header" style="background-color: #4d4d4d;">
                  <div class="modal-title" id="exampleModalLabel"><img src="img/logo.png" height="30px" width="140px" title="VolvoFAN.ro"></div>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                  </button>
                </div>
                <form method="POST" action="includes/php/search.inc.php">
                    <input type="hidden" name="gouser" value="<?php echo $_GET['profil']; ?>">
                  <div class="modal-body">
                    <?php if(isset($_GET['error']) && $_GET['error'] == 'toofewchars') { ?>
                      <div class="alert alert-danger">Trebuie sa introduceti minim 3 caractere.</div>
                    <?php } ?>
                    <small><b><label class="mr-sm-2">Username-ul celui cautat:</label></b></small>               
                    <input type="text" name="find-user" class="form-control" placeholder="Introduce-ti aici..." required><br>
                    <center>
                        <button type="submit" class="btn btn-info btn-sm btn-block" style="width: 80%" name="find-user-submit"><i class="fas fa-search"></i> Cauta!</button>
                    </center><br>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!--END OF FIND USER MODAL -->

<?php if(isset($_SESSION['username'])) { ?>
  <!--------------BUG REPORT FORM MODAL--------------->

            <div class="modal fade" id="bugreportmodal" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <?php 
                if(isset($_SESSION['banned']) && $_SESSION['banned'] == 0) {
              ?>
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
                <div class="modal-header" style="background-color: #4d4d4d; height: 80px;">
                  <div class="modal-title" id="exampleModalLabel"><img src="img/logo.png" height="30px" width="140px" title="VolvoFAN.ro">
                    <small style="color: white;"><p>Report a Bug</p></small>
                  </div>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                  </button>
                </div>
                <form class="form-group" method="POST" action="includes/php/bugreport.inc.php">
                  <div class="modal-body">
                    <small><label><b>Titlu: </b></label></small>
                    <input class="form-control" name="title" required placeholder="Titlul"><br>
                    <small><label><b>Detalii bug-ul: </b></label></small>
                    <textarea class="form-control" name="details" required placeholder="Detaliaza aici....."></textarea><br>
                    <center>
                        <button class="btn btn-info btn-block" style="max-width: 80%" type="submit" name="bugreport-submit">Trimite</button>
                    </center>
                  </div>
                </form>
              </div>
            </div>
            <?php 
             } elseif(isset($_SESSION['banned']) && $_SESSION['banned'] == 1) {
              require 'includes/php/connect.php';
              $bannedid = $_SESSION['id'];
              $bannedusername = $_SESSION['username'];
              $sqlbanned = "SELECT * FROM banlist WHERE banneduserid = '$bannedid' AND bannedusername = '$bannedusername'";
              $result = mysqli_query($con, $sqlbanned);
              $rowbanned = mysqli_fetch_assoc($result);
              $bannedby = $rowbanned['bannedby'];
              $reason = $rowbanned['reason'];
              $permanent = $rowbanned['permanentbanned'];
              $banduration = $rowbanned['banduration'];
              $bandate = $rowbanned['banneddate'];
            ?>
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cont Banat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                      <i class="fa fa-ban" aria-hidden="true"></i> <b>Acest cont este banat!</b><br>
                      Deoarece acest cont este banat, nu poti avea acces la Bug Report!<br><br>
                      Banat de: <b><?php echo $bannedby; ?></b>.<br>
                      Data acordari:  <b><?php echo $bandate; ?></b>.<br>
                      Motiv:  <b><?php echo $reason; ?></b>.<br>
                      <?php if($permanent == 0 ) { ?>
                      Durata Banului: <b>Temporar(<?php echo $banduration; ?> zile)</b><br>
                    <?php } else { ?>
                      Durata Banului: <b>Permanent</b>.
                    <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
          </div>
          <script src="includes/ckeditor/ckeditor.js"></script>
          <script>
              CKEDITOR.replace('details');
          </script>
          <!--END OF BUG REPORT MODAL -->
<?php } ?>

<?php if(isset($_SESSION['function']) && $_SESSION['function'] == 3 && $resultfound == TRUE) { ?>
          <!-- DELETE CONFIRMATION MODAL -->

            <!-- Modal -->
            <div id="deletemodal" class="modal fade" data-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Confirmare stergere cont <?php echo $username; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="includes/php/delete.inc.php" method="POST">
                  <div class="modal-body">
                    <input type="hidden" name="delete_id" value="<?php echo $id; ?>">
                    <input type="hidden" name="delete_username" value="<?php echo $username; ?>">
                    <p>Esti sigur ca doresti sa stergi contul <b><?php echo $username; ?></b> ?</p>
                    <p class="text-secondary"><small>Dupa ce apesi butonul <span class="badge badge-danger">Delete</span>, contul se va sterge. Acest proces este ireversibil, odata sters nu se mai poate recupera.</small></p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger btn-sm" name="deleteprofile">Sterge cont!</button>
                  </div>
                </form>
                </div>
              </div>
            </div>
  <!-- DELETE CONFIRMATION MODAL END -->
<?php } ?>
<?php if((isset($_SESSION['username']) && $_SESSION['username'] == $username && $resultfound == TRUE) || (isset($_SESSION['function']) && $_SESSION['function'] > 1 && $resultfound == TRUE)) { ?>
   <!-- EDIT MODAL -->
<div id="editmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <?php if(isset($_SESSION['username']) && $_SESSION['username'] == $username) { ?>
        <h5 class="modal-title" id="staticBackdropLabel">Editeaza-ti informatiile contului</h5>
        <?php } elseif(isset($_SESSION['function']) && $_SESSION['function'] > 1) { ?>
        <h5 class="modal-title" id="staticBackdropLabel">Editeaza informatiile contului <?php echo $username; ?></h5>
        <?php } ?>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="includes/php/update.inc.php" method="POST">
      <div class="modal-body">
        <input type="hidden" name="edit_id" value="<?php echo $id; ?>">
        <?php if($_SESSION['function'] == 3) { ?>
        <label><small><b>Username</b></small></label>
        <input class="form-control" type="<?php if(isset($_SESSION['function']) && $_SESSION['function'] == 3) { echo "text"; } else { echo "hidden"; } ?>" name="username" value="<?php echo $username; ?>">
        <?php } ?>
        <?php if($_SESSION['function'] == 3) { ?>
        <label><small><b>Email</b></small></label>
        <input class="form-control" type="<?php if(isset($_SESSION['function']) && $_SESSION['function'] == 3) echo 'text'; else echo 'hidden'; ?>" name="email" value="<?php echo $email; ?>">
        <?php } ?>
        <?php if($_SESSION['function'] == 3) { ?>
        <label><small><b>Stare cont:</b></small></label>
        <select class="custom-select" name="verified-status">
          <option value="0" <?php if($verified == 0) echo "selected"; ?>>Cont Neverificat</option>
          <option value="1" <?php if($verified == 1) echo "selected"; ?>>Cont Verificat</option>
        </select>
        <?php } else ?>
        <div class="row">
          <div class="col">
            <label><small><b>Nume</b></small></label>
            <input class="form-control" type="text" name="firstname" value="<?php echo $firstname; ?>">
          </div>
          <div class="col">
            <label><small><b>Prenume</b></small></label>
            <input class="form-control" type="text" name="lastname" value="<?php echo $lastname; ?>">
          </div>
        </div>
        <?php if((isset($_SESSION['username']) && $_SESSION['username'] == $username) || (isset($_SESSION['function']) && $_SESSION['function'] == 3)) { ?>
        <label><small><b>Ani</b></small></label>
        <input class="form-control" type="text" name="age" value=<?php echo $age; ?>>
        <?php } ?>
        <?php if((isset($_SESSION['username']) && $_SESSION['username'] == $username) || (isset($_SESSION['function']) && $_SESSION['function'] == 3)) { ?>
         <div class="row">
             <div class="col">
                  <label class="mr-sm-2" for="day"><small><b>Zi: </b></small></label>
                  <select name="day" class="custom-select">
                    <option value="0" selected>Alege Ziua</option>
                      <?php
                          for ($i=1; $i<=31; $i++)
                          { 
                              ?>
                                  <option value="<?php echo $i;?>" <?php if($i > 0) { if($day == $i ) echo 'selected';}?> ><?php echo $i;?></option>
                              <?php
                          }
                      ?>
                </select>   
            </div>
                <div class="col">
                  <label class="mr-sm-2" for="month"><small><b>Luna: </b></small></label>
                  <select name="month" class="custom-select">
                      <?php
                          for ($i=0; $i<=12; $i++)
                          {
                              ?>
                                  <option value="<?php echo $i;?>" <?php if($i != 0) {if($month == $i ) echo 'selected';}?> ><?php echo $luni[$i];?></option>
                              <?php
                          }
                      ?>
                </select>
            </div>
            <div class="col">
                <label class="mr-sm-2" for="year"><small><b>An: </b></small></label>
                  <select name="year" class="custom-select">
                    <option value="0">Alege Anul</option>
                      <?php
                          for ($i=1950; $i<=date('Y'); $i++)
                          {
                              ?>
                                  <option value="<?php echo $i;?>" <?php if($i != 0) {if($year == $i ) echo 'selected';}?> ><?php echo $i;?></option>
                              <?php
                          }
                      ?>
                </select>
            </div>
          </div>
        <?php } ?>
        <?php if((isset($_SESSION['username']) && $_SESSION['username'] == $username) || (isset($_SESSION['function']) && $_SESSION['function'] == 3)) { ?>
        <label><small><b>Judet</b></small></label>
        <select name="country" class="form-control">
              <option value="0">Alege Judetul</option>
              <?php
                  for ($i=1; $i<=41; $i++)
                  {
                      ?>
                          <option value=<?php echo $i;?> <?php if($i !=0) {if($country == $countries[$i] ) echo 'selected';}?> ><?php echo $countries[$i];?></option>
                      <?php
                  }
              ?>
        </select>
        <?php } ?>
        <label><small><b>Profilul tau de Facebook</b></small></label>
        <input class="form-control" type="text" name="urlfacebook" value="<?php echo $urlfb; ?>">
        <label><small><b>Profilui tau de Instragram</b></small></label>
        <input class="form-control" type="text" name="urlinstagram" value="<?php echo $urlinsta; ?>">
        <label><small><b>Profilul tau de Twitter</b></small></label>
        <input class="form-control" type="text" name="urltwitter" value="<?php echo $urltwitter; ?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success btn-sm" name="editprofile">Editeaza</button>
      </div>
    </form>
    </div>
  </div>
</div>
  <!-- EDIT MODAL END -->
<?php } ?>

<?php if(isset($_SESSION['function']) && $_SESSION['function'] > 1 && $resultfound == TRUE) { ?>
<!-- GIVE FUNCTION  MODAL -->

<div id="functionmodal" class="modal fade" data-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Schimba rolul utilizatorului <?php echo $username; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="includes/php/update.inc.php" method="POST">
      <div class="modal-body">
        <label for="function">Alege un rol din lista de ma jos:</label>
        <input type="hidden" name="function_id"  value=<?php echo $id; ?>>
        <input type="hidden" name="function_username"  value=<?php echo $username; ?>>
        <select name="function" class="form-control" id="function">
              <?php
                  for ($i=0; $i<=3; $i++)
                  {
                      ?>
                          <option value=<?php echo $i;?> <?php if($function == $i ) echo 'selected';?> ><?php echo $functions[$i];?></option>
                      <?php
                  }
              ?>
         </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-warning btn-sm" name="functionedit">Seteaza rol!</button>
      </div>
    </form>
    </div>
  </div>
</div>
  <!-- GIVE FUNCTION MODAL END -->
<?php } ?>
<?php if(isset($_SESSION['function']) && $_SESSION['function'] > 1 && $resultfound == TRUE) { ?>
<!-- BAN  MODAL -->
<div id="banmodal" class="modal fade" data-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Baneaza-l pe <b><?php echo $username; ?></b> de pe VolvoFAN.ro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="includes/php/ban.inc.php" method="POST">
      <div class="modal-body">
        <input type="hidden" name="banned-id"  value="<?php echo $id; ?>">
        <input type="hidden" name="banned-username"  value="<?php echo $username; ?>">
        <input type="hidden" name="banned-ip"  value="<?php echo $ip; ?>">
        <small><b><label>Motivul Ban-ului:</label></b></small>
        <input class="form-control" type="text" name="banreason" placeholder="Introdu motivul (Obligatoriu)" required><br>
        <small><b><label>Durata Ban-ului:</label></b></small>
         <select class="custom-select" name="banduration" id="banduration[]">
                            <optgroup label="Ban Temporar"> 
                            <option value="<?php echo date('Y-m-d', time()+((60*60)*24)) ?>">1 zi (<?php echo date("d.m.Y", time()+((60*60)*24)); ?> 12:00 AM)</option> 
                            <option value="<?php echo date('Y-m-d', time()+((60*60)*48)) ?>">2 zile (<?php echo date("d.m.Y", time()+((60*60)*48)); ?> 12:00 AM)</option> 
                            <option value="<?php echo date('Y-m-d', time()+((60*60)*72)) ?>">3 zile (<?php echo date("d.m.Y", time()+((60*60)*72)); ?> 12:00 AM)</option> 
                            <option value="<?php echo date('Y-m-d', time()+((60*60)*96)) ?>">4 zile (<?php echo date("d.m.Y", time()+((60*60)*96)); ?> 12:00 AM)</option> 
                            <option value="<?php echo date('Y-m-d', time()+((60*60)*120)) ?>">5 zile (<?php echo date("d.m.Y", time()+((60*60)*120)); ?> 12:00 AM)</option> 
                            <option value="<?php echo date('Y-m-d', time()+((60*60)*144)) ?>">6 zile (<?php echo date("d.m.Y", time()+((60*60)*144)); ?> 12:00 AM)</option> 
                            <option value="<?php echo date('Y-m-d', time()+((60*60)*168)) ?>">1 saptamana (<?php echo date("d.m.Y", time()+((60*60)*168)); ?> 12:00 AM)</option>
                            <option value="<?php echo date('Y-m-d', time()+((60*60)*336)) ?>">2 saptamani (<?php echo date("d.m.Y", time()+((60*60)*336)); ?> 12:00 AM)</option>
                            <option value="<?php echo date('Y-m-d', time()+((60*60)*720)) ?>">1 luna (<?php echo date("d.m.Y", time()+((60*60)*720)); ?> 12:00 AM)</option> 
                            <option value="<?php echo date('Y-m-d', time()+((60*60)*1440)) ?>">2 luni (<?php echo date("d.m.Y", time()+((60*60)*1440)); ?> 12:00 AM)</option> 
                            </optgroup> 
                            <optgroup label="Ban Permanent"> 
                            <option value="0">Permanent - Nu va expira niciodata</option> 
                            </optgroup> 
                            </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger btn-sm" name="ban-user">Baneaza utilizator!</button>
      </div>
    </form>
    </div>
  </div>
</div>
    <!-- BAN  MODAL END -->
<?php } ?>
<?php if(isset($_SESSION['username']) && $username == $_SESSION['username'] && $resultfound == TRUE) { ?>
<!--------------CHANGE PICTURE MODAL--------------->

            <div class="modal fade" id="changepicturemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Schimba Poza de Profil</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="DeleteSRC()">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form class="form-group" method="POST" action="includes/php/upload.inc.php" enctype="multipart/form-data">
                    <p><small><b>Imaginea selectata va arata:</b></small></p>
                    <center>
                      <div class="image-preview" id="imagePreview">
                    <img  alt="hai ca" class="image-preview-image image-prewiew-img">
                    <span class="image-preview-default-text">Incarca o Imagine</span>
                  </div><br>
                    <label for="profile-picture" class="custom-file-upload btn-info btn btn-block" style="max-width: 300px;">
                      <i class="fa fa-cloud-upload"></i> Incarca Imagine
                      <input type="file" accept="image/*" name="profile-picture" id="profile-picture">
                    </label>
                  </center>
                </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="DeleteSRC()">Close</button>
                      <button type="submit" class="btn btn-success" name="profilepicture">Aplica Poza</button>
                  </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
<!--END OF CHANGE PICTURE  MODAL -->
<?php } ?>
<?php if(isset($_SESSION['username'])) { ?>
<!-- INBOX MODAL -->

  <div class="modal fade" id="inboxmodal" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #4d4d4d; height: 80px;">
        <div class="modal-title"><img src="img/logo.png" height="30px" width="140px" title="VolvoFAN.ro">
          <small style="color: white;"><p>Inbox-ul lui <?php echo $_SESSION['username']; ?></p></small>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: white;">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-hover table-borderless">
        <tbody>
      <?php 
      require 'includes/php/connect.php';
      $touser = $_SESSION['username'];
      $sql = "SELECT * FROM inbox WHERE touser = '$touser' ORDER BY status ASC, id DESC";
      $query = mysqli_query($con, $sql);
      if(mysqli_num_rows($query) > 0) {
        while($row = mysqli_fetch_assoc($query)) {
          $textinbox = $row['textinbox'];
          $idinbox = $row['id'];
          $status = $row['status'];
      ?>
      <tr>
        <td><?php echo $textinbox; ?></td>
        <?php 
        if($status == 1) {
          $buttonclass = 'btn-success disabled';
          $buttonname = '<i class="fa fa-eye" aria-hidden="true"></i> VAZUT';
        }
        if ($status == 0 ) {
          $buttonclass = 'btn-info';
          $buttonname = '<i class="fa fa-eye-slash" aria-hidden="true"></i> NEDESCHIS';
        }
        ?>
        <td><a href="<?php echo 'includes/php/inbox.inc.php?idmark='.$idinbox; ?>" class="btn <?php echo $buttonclass; ?> btn-sm btn-block"><?php echo $buttonname; ?></div></a></td>
      </tr>
      <?php } } else { ?>
        <td style="text-align: center">Momentan nu ai nici o notificare</td>
      <?php } ?>
      </tbody>
      </table>
      </div>
      </div>
    </div>
  </div>
</div>

<!-- END INBOX MODAL -->
<?php } ?>
<?php if(isset($_SESSION['function']) && isset($function) && $_SESSION['function'] >= $function && $_SESSION['function'] > 1 && $resultfound == TRUE) { ?>
<!-- IP MODAL -->
<div class="modal fade" id="ipmodal" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #4d4d4d; height: 80px;">
        <div class="modal-title"><img src="img/logo.png" height="30px" width="140px" title="VolvoFAN.ro">
          <small style="color: white;"><p>Conturile de pe IP-ul <?php echo $ip; ?></p></small>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: white;">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Username</th>
                <th>IP</th>
                <th>Banned</th>
                <th>Functie</th>
                <th>Profil</th>
              </tr>
            </thead>
            <tbody>
      <?php 
      require 'includes/php/connect.php';
      $sql = "SELECT * FROM users WHERE ip = '$ip'";
      $query = mysqli_query($con, $sql);
      if(mysqli_num_rows($query) > 0) {
        while($row = mysqli_fetch_assoc($query)) {
          $usernameip = $row['username'];
          $functionip  = $row['function'];
          $idip = $row ['id'];
          $bannedip = $row['banned'];
      ?>
              <tr>
                <td><?php echo $idip; ?></td>
                <td><?php echo $usernameip; ?></td>
                <?php if(isset($_SESSION['function']) && $_SESSION['function'] >= $functionip && $_SESSION['function'] > 1) { ?>
                <td><?php echo $ip; ?></td>
                <?php } else { ?>
                <td><span class=" badge badge-danger">IP-ul este ascuns</span></td>
                <?php } ?>
                <?php if($bannedip == 0) 
                        echo '<td><span class="badge badge-secondary">No</span></td>';
                      elseif($bannedip == 1)
                        echo '<td><span class="badge badge-danger">Yes</span></td>';
                ?>
                <?php 
                        if($functionip == 0)
                          echo '<td><span class=" badge badge-secondary">Utilizatorul Normal</span></td>';
                        elseif($functionip == 1)
                          echo '<td><span class="badge badge-primary">Moderator</span></td>';
                        elseif($functionip == 2)
                          echo '<td><span class="badge badge-success">Administrator</span></td>';
                        elseif($functionip == 3)
                          echo '<td><span class="badge badge-danger">Owner</span></td>';
                ?>
                <td><a href="<?php echo 'profile.php?profil='.$usernameip; ?>" class="btn btn-secondary"><i class="fa fa-external-link" aria-hidden="true"></i></a></td>
              </tr>
      <?php } }  ?>
            </tbody>
          </table>
      </div>
      </div>
    </div>
  </div>
</div>

<!-- END IP MODAL -->
<?php } ?>
<?php if(isset($_SESSION['function']) && $_SESSION['function'] > 1 && $resultfound == TRUE) { ?>
 <!-- UNBAN CONFIRMATION MODAL -->

            <div id="unbanmodal" class="modal fade" data-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Confirmare debanare cont <?php echo $username; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="includes/php/ban.inc.php" method="POST">
                  <div class="modal-body">
                    <?php 
                        require 'includes/php/connect.php';
                        $sqlbanned = "SELECT * FROM banlist WHERE banneduserid = '$id'";
                        $resultbanned = mysqli_query($con, $sqlbanned);
                        $rowbanned = mysqli_fetch_assoc($resultbanned);
                        $idban = $rowbanned['id'];
                        $bannedid= $rowbanned['banneduserid'];
                        $bannedby = $rowbanned['bannedby'];
                        $reason = $rowbanned['reason'];
                        $permanent = $rowbanned['permanentbanned'];
                        $banduration = $rowbanned['banduration'];
                        $banneddate = $rowbanned['banneddate'];
                        $banneddate = strtotime($banneddate);
                        $banneddate = date('d.m.Y H:i', $banneddate);
                        $unbandate = $rowbanned['unbandate'];
                    ?>
                    <input type="hidden" name="ban-id" value=<?php echo $idban; ?>>
                    <input type="hidden" name="banned-username" value=<?php echo $username; ?>>
                    <input type="hidden" name="banned-id" value=<?php echo $bannedid; ?>>
                    <p>Esti pe cale sa debanezi acest utilizator, esti sigur?</p>
                    <p><small><b>Detalii:</b></small></p>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item">Utilizatorul: <b><?php echo $username; ?></b></li>
                      <li class="list-group-item">Banat de: <b><?php echo $bannedby; ?></b></li>
                      <li class="list-group-item">Data banari: <b><?php echo $banneddate; ?></b></li>
                      <li class="list-group-item">Motivul banari: <b><?php echo $reason; ?></b></li>
                      <li class="list-group-item">Tipul banului: <b><?php if($permanent == 1) {echo 'Permanent';} else { echo 'Temporar('.$banduration.' zile)'; } ?></b></li>
                    </ul>
                    <p><small><b>Motivul debanari:</b></small></p>
                    <input type="text" class="form-control" name="unban-reason" placeholder="Introdu motivul (Obligatoriu)" required>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger btn-sm" name="unban-user-btn">Debaneaza utilizator!</button>
                  </div>
                </form>
                </div>
              </div>
            </div>
  <!-- UNBAN CONFIRMATION MODAL END -->
<?php } ?>

<?php if($resultfound == TRUE) { ?>
<?php if(!isset($_GET['action'])) { ?>
    <main role="main"><br>
    	<div class="container emp-profile">
            <div class="container">
          <?php if(isset($_GET['msg']) && $_GET['msg'] == 'errorlevel') {
                echo '<div class="alert alert-warning alert-dismissible" id="alert">
                           <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <b>Nu poti acorda o functie mai mare decat deti tu!</b>                     
                      </div>';
          }
          ?>
          <?php if(isset($_GET['msg']) && $_GET['msg'] == 'succesfunction') {
                echo '<div class="alert alert-success alert-dismissible" id="alert">
                            <i class="fa fa-check-square-o" aria-hidden="true"></i> <b>Rolul a fost actualizata cu succes!</b>                      
                      </div>';
          }
          ?>
          <?php if(isset($_GET['msg']) && $_GET['msg'] == 'errordown') {
                echo '<div class="alert alert-warning alert-dismissible" id="alert">
                           <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <b>Nu deti nivelul necesar de administrator pentru al elimina pe '.$username.' din echipa administrativa!<b>                    
                      </div>';
          }
          ?>
          <?php if(isset($_GET['msg']) && $_GET['msg'] == 'succesdown') {
                echo '<div class="alert alert-success alert-dismissible" id="alert">
                            <i class="fa fa-check-square-o" aria-hidden="true"></i> <b>L-ai scos pe '.$username.' din echipa administrativa cu succes!</b>                       
                      </div>';
          }
          ?>
          <?php if(isset($_GET['msg']) && $_GET['msg'] == 'errorselfgive') {
                echo '<div class="alert alert-danger alert-dismissible" id="alert">
                           <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <b>Nu iti poti seta singur un rol. Rolurile pot fi acordate doar de un Administrator sau Owner!</b>                     
                      </div>';
          }
          ?>
          <?php if(isset($_GET['msg']) && $_GET['msg'] == 'succesupload') {
                echo '<div class="alert alert-success alert-dismissible" id="alert">
                           <i class="fa fa-check-square-o" aria-hidden="true"></i> <b>Poza de profil a fost actualizata cu succes!</b>                   
                      </div>';
          }
          ?>
          <?php if(isset($_GET['msg']) && $_GET['msg'] == 'errortoupload') {
                echo '<div class="alert alert-danger alert-dismissible" id="alert">
                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <b>A aparut o eroare la incarcarea pozei. Te rog incearca din nou.</b>                    
                      </div>';
          }
          ?>
          <?php if(isset($_GET['msg']) && $_GET['msg'] == 'toobig') {
                echo '<div class="alert alert-warning alert-dismissible" id="alert">
                           <i class="fa fa-file-image-o" aria-hidden="true"></i> <b>Imaginea aleasa de tine este prea mare!</b>                    
                      </div>';
          }
          ?>
          <?php if(isset($_GET['msg']) && $_GET['msg'] == 'isntimg') {
                echo '<div class="alert alert-warning alert-dismissible" id="alert">
                            <i class="fa fa-picture-o" aria-hidden="true"></i> <b>Fisierul incarcat nu este o imagine de tip "PNG", "JPEG" sau "JPG"!</b>                     
                      </div>';
          }
          ?>
          <?php if(isset($_GET['msg']) && $_GET['msg'] == 'cantbanyou') {
                echo '<div class="alert alert-warning alert-dismissible" id="alert">
                           <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <b>Nu iti poti bana singur contul</b>                  
                      </div>';
          }
          ?>
          <?php if(isset($_GET['msg']) && $_GET['msg'] == 'successedited') {
                echo '<div class="alert alert-success alert-dismissible" id="alert">
                           <i class="fa fa-check-square-o" aria-hidden="true"></i> <b>Datele utilizatorului au fost actualizate cu succes!</b>                     
                      </div>';
          }
          ?>
          <?php if(isset($_GET['msg']) && $_GET['msg'] == 'erroredited') {
                echo '<div class="alert alert-warning alert-dismissible" id="alert">
                           <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <b>A aparut o eroare la editarea datelor. Va rugam sa incercati din nou.</b>                     
                      </div>';
          }
          ?>
          <?php if(isset($_GET['msg']) && $_GET['msg'] == 'nothaveacces') {
                echo '<div class="alert alert-danger alert-dismissible" id="alert">
                           <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <b>Nu ai nivelul de Administrator suficient pentru a edita conturi.</b>                     
                      </div>';
          }
          ?>
          <?php if(isset($_GET['msg']) && $_GET['msg'] == 'noverifed') {
                echo '<div class="alert alert-danger alert-dismissible" id="alert">
                           <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <b>Acest cont nu este verificat. Pentru a seta unui utilizator acesta trebuie sa aiba contul VERIFICAT!</b>                     
                      </div>';
          }
          ?>
          <?php 
            if($banned == 1) {
              require 'includes/php/connect.php';
              $sqlbanned = "SELECT * FROM banlist WHERE banneduserid = '$id'";
              $resultbanned = mysqli_query($con, $sqlbanned);
              $rowbanned = mysqli_fetch_assoc($resultbanned);
              $bannedby = $rowbanned['bannedby'];
              $reason = $rowbanned['reason'];
              $permanent = $rowbanned['permanentbanned'];
              $banduration = $rowbanned['banduration'];
              $banneddate = $rowbanned['banneddate'];
              $banneddate = strtotime($banneddate);
              $banneddate = date('d.m.Y H:i', $banneddate);
              $unbandate = $rowbanned['unbandate'];
              $unbandate = strtotime($unbandate);
              $unbandate = date('d.m.Y', $unbandate);

                if($permanent == 1) {
                    echo '<div class="alert alert-danger alert-dismissible" id="alert">
                            <i class="fa fa-ban" aria-hidden="true"></i> <b>Acest cont este banat!</b><br>
                            Banat de <b>'.$bannedby.'</b> pe data de <b>'.$banneddate.'</b>, motivul banului <b>'.$reason.'</b>.<br>
                            Acest cont este banat <b>permanent</b>. Banul nu va expira niciodata.                       
                          </div>';
                } else {
                    echo '<div class="alert alert-danger alert-dismissible" id="alert">
                            <i class="fa fa-ban" aria-hidden="true"></i> <b>Acest cont este banat!</b><br>
                            Banat de <b>'.$bannedby.'</b> pe data de <b>'.$banneddate.'</b>, motivul banului <b>'.$reason.'</b>.<br>
                            Banul va expira in <b>'.$banduration.' zile</b>, pe data de <b>'.$unbandate.'</b>.                      
                          </div>'; 
                }
            } 
          ?>
                      </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="profile-img">
                                <?php 
                                    if($profileimgstatus == 0) {
                                    if(isset($_SESSION['username']) && $username == $_SESSION['username'])
                                        echo '<a href="#changepicturemodal" data-toggle="modal">';
                                ?>
                                <img style="border: 3px solid black; border-radius: 3px;" src="includes/php/profilepictures/default.png" alt="">
                                <?php if(isset($_SESSION['username']) && $username == $_SESSION['username']) echo '</a>'?>
                                <?php 
                                    } elseif($profileimgstatus == 1) {
                                      if(isset($_SESSION['username']) && $username == $_SESSION['username'])
                                        echo '<a href="#changepicturemodal" data-toggle="modal">';
                                ?>
                                <img style="border: 3px solid black; border-radius: 3px;" <?php echo "src=includes/php/profilepictures/".$profileimgname; ?> alt="">
                                <?php if(isset($_SESSION['username']) && $username == $_SESSION['username']) echo '</a>'?>
                                <?php 
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-head">
                                        <h5>
                                            <?php echo '<p>'.$username.'</p>'; ?>
                                        </h5>
                                        <?php
                                        if($verified == 1)
                                          echo '<span class="badge badge-secondary">Cont Verificat</span>';
                                        		if($function == 0)
                                        			echo '<br><br>';
              								              elseif($function == 1)
              								                echo '<h6><span class="badge badge-primary">Moderator</span></h6>';
              								              elseif($function == 2)
              								                echo '<h6><span class="badge badge-success">Administrator</span></h6>';
              								              elseif($function == 3)
              								                echo '<h6><span class="badge badge-danger">Owner</span> <span class="badge" style="background-color: #9370db; color: #fff">Scripter</span></h6>';
                                        ?>
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="information-tab" data-toggle="tab" href="#information" role="tab" aria-controls="information" aria-selected="true">Despre</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="topic-tab" data-toggle="tab" href="#topics" role="tab" aria-controls="topics" aria-selected="false">Topicurile postate</a>
                                    </li>
                                    <?php if(isset($_SESSION['function']) && $_SESSION['function'] > 1) { ?>
                                      <li class="nav-item">
                                        <a class="nav-link" id="logs-tab" data-toggle="tab" href="#logs" role="tab" aria-controls="logs" aria-selected="false">Loguri</a>
                                      </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-2">
                        	<?php 
                            if(isset($_SESSION['username'])){
                        		if($username == $_SESSION['username'])
                            		echo '<a href="#editmodal" data-toggle="modal" class="btn btn-sm" style="background-color: #d9d9d9; color: #333333; font-weight: 600;">Editeaza-ti profilul</a>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="profile-work">
                              <hr class="featurette-divider">
                                    <table style="width:100%;">
                                      <tr>
                                        <th><center><h5><i class="fa fa-address-card-o" aria-hidden="true"></i> SOCIAL MEDIA</h5></center></th>
                                      </tr>
                                      <tr>
                                        <?php if($urlfb != NULL) { ?>
                                        <td><a target="_blank" href="<?php echo $urlfb; ?>" class="btn btn-block" style="color: #fff; background-color: #4267B2;"><i class="fa fa-facebook-square" aria-hidden="true"></i> Facebook</a></td>
                                      <?php } elseif(isset($_SESSION['username']) && $_SESSION['username'] == $username) { ?>
                                        <td><a class="btn btn-block disabled" style="color: #fff; background-color: #4267B2;"><i class="fa fa-facebook-square" aria-hidden="true"></i> Facebook</a></td>
                                      <?php } ?>
                                      </tr>
                                      <tr>
                                        <?php if($urlinsta != NULL) { ?>
                                        <td><a target="_blank" href="<?php echo $urlinsta; ?>" class="btn btn-block" style="color: #fff; background-image: linear-gradient(to right, #8a3ab9, #e95950, #bc2a8d, #fccc63, #fbad50, #cd486b, #4c68d7);"><i class="fa fa-instagram" aria-hidden="true"></i> Instagram</a></td>
                                        <?php } elseif(isset($_SESSION['username']) && $_SESSION['username'] == $username) { ?>
                                        <td><a class="btn btn-block disabled" style="color: #fff; background-image: linear-gradient(to right, #8a3ab9, #e95950, #bc2a8d, #fccc63, #fbad50, #cd486b, #4c68d7);"><i class="fa fa-instagram" aria-hidden="true"></i> Instagram</a></td>
                                      <?php } ?>
                                      </tr>
                                      <tr>
                                        <?php if($urltwitter != NULL) { ?>
                                        <td><a target="_blank" href="<?php echo $urltwitter; ?>" class="btn btn-block" style="color: #fff; background-color: #1DA1F2;"><i class="fa fa-twitter-square" aria-hidden="true"></i> Twitter</a></td>
                                        <?php } elseif(isset($_SESSION['username']) && $_SESSION['username'] == $username) { ?>
                                        <td><a class="btn btn-block disabled" style="color: #fff; background-color: #1DA1F2;"><i class="fa fa-twitter-square" aria-hidden="true"></i> Twitter</a></td>
                                      <?php } ?>
                                      </tr>
                                    </table>
                                    <hr class="featurette-divider">
                        	<?php
                            if(isset($_SESSION['username'])){
                            	if($_SESSION['function'] >= 2 && $_SESSION['banned'] == 0) {
                                ?>
                                    <table style="width:100%;">
                                      <tr>
                                        <th><center><h5><i class="fa fa-sliders" aria-hidden="true"></i> ADMIN TOOLS</h5></center></th>
                                      </tr>
                                      <tr>
                                        <td><a href=#editmodal data-toggle="modal"><button tyoe="button" class="btn btn-success btn-block"><i class="fa fa-fw fa-edit"></i> Editeaza profil</button></a></td>
                                      </tr>
                                      <tr>
                                        <td><a href=#functionmodal data-toggle="modal"><button tyoe="button" class="btn btn-warning btn-block" style="color: #fff;"><i class="fa fa-arrow-up" aria-hidden="true"></i> Schimba Rol</button></td>
                                      </tr>
                                      <tr>
                                        <td><a href=#deletemodal data-toggle="modal"><button tyoe="button" class="btn btn-danger btn-block" <?php if(isset($_SESSION['function']) && $_SESSION['function'] != 3) echo "disabled"; ?>><i class="fa fa-times" aria-hidden="true"></i> Sterge cont</button></td>
                                      </tr>
                                      <tr>
                                        <?php if($banned == 0) { ?>
                                            <td><a href=#banmodal data-toggle="modal"><button tyoe="button" class="btn btn-danger btn-block"><i class="fa fa-minus-circle" aria-hidden="true"></i> Baneaza cont</button></td>
                                        <?php
                                        } elseif($banned == 1) {
                                        ?>
                                            <td><a href=#unbanmodal data-toggle="modal"><button tyoe="button" class="btn btn-success btn-block"><i class="fa fa-minus-circle" aria-hidden="true"></i> Debaneaza cont</button></td>
                                        <?php } ?>
                                      </tr>
                                    </table>
                            <?php 
                            	}
                            }
                            ?>
                        </div>
                        </div>
                        <div class="col-md-8">
                            <div class="tab-content profile-tab" id="myTabContent">
                                <div class="tab-pane fade show active" id="information" role="tabpanel" aria-labelledby="information-tab">
                                     <table class="editpostable">
                                      <?php if(isset($_SESSION['function']) && $_SESSION['function'] >= $function && $_SESSION['function'] > 1) { ?>
                                            <tr>
                                              <td>IP</td>
                                              <td class="dbinfo"><a href="#ipmodal" data-toggle="modal"><?php echo $ip; ?></a></td>
                                            </tr>
                                          <?php } ?>
                                      <?php if(isset($_SESSION['function']) && $_SESSION['function'] > 0) { ?>
                                            <tr>
                                              <td>ID</td>
                                              <td class="dbinfo"><?php echo $id; ?></td>
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                              <td>Numele complet</td>
                                              <td class="dbinfo"><?php echo $firstname.' '.$lastname; ?></td>
                                            </tr>
                                      <?php if(isset($_SESSION['function']) && $_SESSION['function'] >= 1 or isset($_SESSION['username']) && $username == $_SESSION['username']) { ?>
                                            <tr>
                                              <td>Email</td>
                                              <td class="dbinfo"><?php echo $email; ?></td>
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                              <td>Ani</td>
                                              <td class="dbinfo"><?php echo $age; ?></td>
                                            </tr>
                                            <tr>
                                              <td>Data Nasteri</td>
                                              <td class="dbinfo"><?php echo $birthdate; ?></td>
                                            </tr>
                                            <tr>
                                              <td>Judet</td>
                                              <td class="dbinfo"><?php echo $country; ?></td>
                                            </tr>
                                            <tr>
                                              <td>Data Inregistrari</td>
                                              <td class="dbinfo"><?php echo $joindate; ?></td>
                                            </tr>
                                          </table>
                                		</div>
                                        <div class="tab-pane fade" id="topics" role="tabpanel" aria-labelledby="topics-tab">
                                            <table class="table table-sm editposlog table-hover">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th style="width: 65%; text-align: center;">Titlul</th>
                                                        <th>Data postari</th>
                                                        <th style="text-align: center;">Vezi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    require 'includes/php/connect.php';
                                                    $sqltopics = "SELECT * FROM posts WHERE username = '$username'";
                                                    $topicsresults = mysqli_query($con, $sqltopics);
                                                    if(mysqli_num_rows($topicsresults) > 0) {
                                                        while($rowtopic = mysqli_fetch_assoc($topicsresults)) {
                                                    ?>
                                                    <tr>
                                                        <td style="font-size: 15px;"><?php echo $rowtopic['title']; ?></td>
                                                        <td style="font-size: 15px;"><?php echo date("d.M.Y", strtotime($rowtopic['publicdate'])); ?></td>
                                                        <?php if($rowtopic['suspended'] == 0) { ?>
                                                        <td style="text-align: center;"><a href="forum.php?action=viewpost&idpost=<?php echo $rowtopic['id']; ?>" class="btn btn-success btn-sm"><i class="fas fa-external-link-alt"></i></a></td>
                                                    <?php } else { ?>
                                                        <?php if((isset($_SESSION['username']) && $username == $_SESSION['username']) ||(isset($_SESSION['function']) && $_SESSION['function'] > 0)) { ?>
                                                            <td style="text-align: center;"><a href="forum.php?action=viewpost&idpost=<?php echo $rowtopic['id']; ?>" class="btn btn-danger btn-sm"><i class="fas fa-external-link-alt"></i></a></td>
                                                        <?php } else { ?>
                                                        <td><span class="badge badge-danger">Suspendat</span></td>
                                                    <?php } } ?>
                                                    </tr>
                                                <?php } } else { ?>
                                                    <tr>
                                                        <td colspan="3" style="font-size: 15px;">Momentan utilizatorul nu a postat nici un topic.</td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                          <?php if(isset($_SESSION['function']) && $_SESSION['function'] >1 ) { ?>
                                          <div class="tab-pane fade" id="logs" role="tabpanel" aria-labelledby="logs-tab">
                                            <table class="table table-sm editposlog table-hover">
                                              <thead class="thead-dark">
                                                <tr>
                                                  <th style="width: 70%;">Actiune</th>
                                                  <th>IP</th>
                                                  <th>Data</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                              <?php 
                                                require 'includes/php/connect.php';
                                                $sql = "SELECT * FROM logs WHERE iduserlog = '$id' ORDER BY id DESC LIMIT 9";
                                                $result = mysqli_query($con, $sql);
                                                if(mysqli_num_rows($result) > 0) {
                                                  while ($row = mysqli_fetch_assoc($result)) {
                                                    $logtext = $row['logtext'];
                                                    $userip = $row['userip'];
                                                    $date = $row['logdate'];
                                                    $date = strtotime($date);
                                                    $date = date('d.m.Y H:i', $date);
                                              ?>
                                                <tr>
                                                  <td style="font-size: 15px;"><?php echo $logtext; ?></td>
                                                  <?php if(isset($_SESSION['function']) && $_SESSION['function'] >= $function && $_SESSION['function'] > 1) { ?>
                                                  <td style="font-size: 15px;"><?php echo $userip; ?></td>
                                                  <?php } else { ?>
                                                    <td style="font-size: 15px;">***.***.*.**</td>
                                                  <?php } ?>
                                                  <td style="font-size: 15px;"><?php echo $date; ?></td>
                                                </tr>
                                                <?php
                                              }
                                            ?>
                                            <tr>
                                                <td colspan="3"><a href="profile.php?profil=<?php echo $username;?>&action=viewlogs" class="btn  btn-success btn-block btn-sm"><i class="fas fa-info-circle"></i> Vezi mai mult</a></td>
                                            </tr>
                                        <?php } else { ?>
                                            <tr>
                                                <td colspan="3" style="font-size: 15px;">Momentan utilizatorul nu a executat nici o actiune.</td>
                                            </tr>
                                        <?php } ?>
                                              </tbody>
                                            </table>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
            </div>
    </main>
<?php } else { ?>
    <br><br><br><br>
    <div class="container">
        <h6><i class="fas fa-clipboard-list"></i> Logurile utilizatorului <a style="font-size: 20px; font-weight: 700;" href="profile.php?profil=<?php echo $username; ?>"><?php echo $username; ?></a>         
        <?php 
                        if($function == 0)
                          echo '<td><span class="badge badge-secondary">Utilizator Normal</span></td>';
                        elseif($function == 1)
                          echo '<td><span class="badge badge-primary">Moderator</span></td>';
                        elseif($function == 2)
                          echo '<td><span class="badge badge-success">Administrator</span></td>';
                        elseif($function == 3)
                          echo '<td><span class="badge badge-danger">Owner</span></td>';
                ?></h6>
        <br>
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col-md">
                        <font style="font-weight: 600;">Afiseaza logurile din data de:</font>
                    </div>
                    <div class="col-md">
                <form class="form-group input-group-sm" action="includes/php/sort.inc.php" method="POST">
                    <input type="hidden" name="usernamelog" value="<?php echo $username; ?>">
                <select class="form-control" name="sortdates" id="sortdates">
                    <option hidden>Alege data</option>
                   <?php 
                    require 'includes/php/connect.php';
                    $sql = "SELECT datesort FROM logs WHERE iduserlog = '$id' GROUP by datesort ORDER by id DESC";
                    $result = mysqli_query($con, $sql);
                        if(mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                   ?>
                   <option <?php if(isset($_SESSION['sortdates']) && $_SESSION['sortdates'] == " AND datesort = '".$row['datesort']."'") echo 'selected'; ?> value="<?php echo $row['datesort']; ?>"><?php echo date("d.m.Y", strtotime($row['datesort'])); ?></option>
               <?php } } else { ?>
                <option disabled>Momentan nu s-a executat nici o actiune.</option>
               <?php } ?>
                </select>
            </div>
        </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col-md">
                        <button type="submit" class="btn btn-outline-warning btn-block btn-sm" name="sort-log-data"><i class="fas fa-search"></i> Cauta</button>
                    </div>
                    <div class="col-md">
                        <button type="submit" class="btn btn-outline-secondary btn-block btn-sm" name="reset-log-data"><i class="fa fa-refresh" aria-hidden="true"></i> Reseteaza</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th style="width: 70%;">Actiune</th>
                    <th>IP</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(!isset($_GET['page']))
                        $page = 1;
                    else
                        $page = $_GET['page'];

                    if(!isset($_SESSION['sortdates']))
                        $_SESSION['sortdates'] = "";

                    $pagenumber = "SELECT * FROM logs WHERE iduserlog = '$id'".$_SESSION['sortdates'];
                    $pagenumber = mysqli_query($con, $pagenumber);
                    $numberofresults = mysqli_num_rows($pagenumber);
                    $resultsperpage = 15;
                    $numberofpage = ceil($numberofresults/$resultsperpage);
                    if($numberofpage == 0)
                        $numberofpage ++;
                    $thispageresults = ($page - 1) * $resultsperpage;

                    require 'includes/php/connect.php';
                    $sql = "SELECT * FROM logs WHERE iduserlog = '$id'".$_SESSION['sortdates']." ORDER BY id DESC LIMIT ".$thispageresults.', '.$resultsperpage;
                    $result = mysqli_query($con, $sql);
                    if(mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $logtext = $row['logtext'];
                            $userip = $row['userip'];
                            $date = $row['logdate'];
                            $date = strtotime($date);
                            $date = date('d.m.Y H:i', $date);
                ?>
                <tr>
                    <td style="font-size: 15px;"><?php echo $logtext; ?></td>
                    <?php if(isset($_SESSION['function']) && $_SESSION['function'] >= $function && $_SESSION['function'] > 1) { ?>
                    <td style="font-size: 15px;"><?php echo $userip; ?></td>
                    <?php } else { ?>
                    <td style="font-size: 15px;">***.***.*.**</td>
                    <?php } ?>
                    <td style="font-size: 15px;"><?php echo $date; ?></td>
                </tr>
                <?php
                    }
                } else {
                ?>
                <tr>
                    <td colspan="3">Momentan acest utilizator nu a executat nici o actiune.</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <hr>
        <nav aria-label="Page navigation example">
          <ul class="pagination">
            <li class="page-item <?php if((isset($_GET['page']) && $_GET['page'] == 1) || !isset($_GET['page'])) echo 'disabled'; ?>"><a class="page-link" href="profile.php?profil=<?php echo $username; ?>&action=viewlogs&page=<?php echo $page - 1; ?>">Previous</a></li>
            <?php for($i = 1; $i <= $numberofpage; $i++) { ?>
                <li class="page-item <?php if((isset($_GET['page']) && $_GET['page'] == $i) || (!isset($_GET['page']) && $i == 1)) echo 'active'; ?>"><a class="page-link" href="profile.php?profil=<?php echo $username; ?>&action=viewlogs&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php } ?>
            <li class="page-item <?php if((isset($_GET['page']) && $_GET['page'] == $numberofpage) || (!isset($_GET['page']) && $page == $numberofpage)) echo 'disabled'; ?>"><a class="page-link" href="profile.php?profil=<?php echo $username; ?>&action=viewlogs&page=<?php echo $page + 1; ?>">Next</a></li>
          </ul>
        </nav>
        <br><br>
    </div>
<?php } ?>
<?php } elseif(isset($_GET['profil']) && $resultfound == FALSE) { ?>
 <main role="main"><br><br><br><br>
    <div class="container">
      <div class="card">
        <div class="card-header" style="background-color: #4d4d4d; height: 80px;">
          <center><img src="img/logo.png" height="30px" width="140px" title="VolvoFAN.ro" style="margin-top: 5px;">
            <small style="color: white;"><p>Utilizatorul nu a fost gasit</p></small>
          </center>
        </div>
        <div class="card-body">
            <center>
              <img src="img/404.png">
            </center>
            <center><br>
              <div class="container" style="background-color: #4d4d4d; height: 120px; border-radius: 4px;">
                <p style="color:#fff; font-size: 20px; font-weight: 700;">UTILIZATORUL "<b style="color: #cc0000;"><?php echo $_GET['profil']; ?></b>" NU A FOST GASIT! INTRODU MAI JOS USERNAME-UL CORECT</p>
                <div class="row">
                  <div class="col">
                    <form class="form-group" method="POST" action="includes/php/search.inc.php">
                      <input class="form-control" type="text" name="usersearch" placeholder="Introdu username-ul">
                </div>
                <div class="col">
                  <button class="btn btn-success" name="search-404error-btn" type="submit" style="width: 300px;"><i class="fa fa-search" aria-hidden="true"></i> CAUTA</button>
                </form>
                </div>
              </div>
              </div>
            </center>
        </div>
      </div>
    </div>
  </main>
  <?php } ?>

<?php if(isset($_SESSION['username']) && $username == $_SESSION['username']) { ?>
    <script>
      const inpFile = document.getElementById("profile-picture");
      const previewContainer = document.getElementById("imagePreview");
      const previewImage = previewContainer.querySelector(".image-preview-image");
      const previewDefaultText = previewContainer.querySelector(".image-preview-default-text");

      inpFile.addEventListener("change", function() {
        const file = this.files[0];

        if (file) {
          const reader = new FileReader();

          previewDefaultText.style.display = "none";
          previewImage.style.display = "block";

          reader.addEventListener("load", function () {
            console.log(this);
            previewImage.setAttribute("src", this.result);
          });
          reader.readAsDataURL(file);
        } else {
            previewDefaultText.style.display = null;
            previewImage.style.display = null;
            previewImage.setAttribute("src", "");
        }
      });

        function DeleteSRC() {
            previewDefaultText.style.display = null;
            previewImage.style.display = null;
        };   
    </script>
  <?php } ?>
          <!-- FOOTER -->
   <div class="footer fixed-bottom" style="background-color: rgb(0, 0, 0, 0.6);">
      <footer class="container">
          <p style="color: white; font-weight: bold; font-size: 13px;">&copy; 2020-<?php echo date('Y'); ?> Copyright. All Rights Reseved | by Niculai Ilie-Traian &copy;</p>
      </footer>
    </div>
</body>
</html>