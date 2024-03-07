<?php 
  session_start();
  require 'includes/php/connect.php';

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

    if(isset($_SESSION['username'])) {
      $userto = $_SESSION['username'];
      $sqlinbox = "SELECT id FROM inbox WHERE touser = '$userto' AND status = 0";
      $queryinbox = mysqli_query($con, $sqlinbox);
      $nrnotifications = mysqli_num_rows($queryinbox);
    }
  unset($_SESSION["pagename"]);
  $_SESSION['pagename'] = basename($_SERVER['PHP_SELF']);
  unset($_SESSION['sortdates']);

  if (isset($_SESSION['loggedtime']) && (time() - $_SESSION['loggedtime'] > 1800)) {
      session_destroy();
      session_unset();
      header('location: contact.php');
      } else {
        $_SESSION['loggedtime'] = time();
      }
if(!empty($_SERVER["HTTP_CLIENT_IP"])) {
    $ipfinder = $_SERVER["HTTP_CLIENT_IP"];
}
  else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
    $ipfinder = $_SERVER["HTTP_X_FORWARDED_FOR"];
} else {
    $ipfinder = $_SERVER["REMOTE_ADDR"];
}

$sqlfindbannedip = "SELECT * FROM banlist WHERE bannedip = '$ipfinder'";
$results = mysqli_query($con, $sqlfindbannedip);
if(mysqli_num_rows($results) > 0) {
  $find = TRUE;
} else {
  $find = FALSE;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Contact -  VolvoFAN.ro</title>

	    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="refresh" content="1800;url=includes/php/logout.inc.php" />
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">

        <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">    
    <script src="https://kit.fontawesome.com/0c4d35ef60.js" crossorigin="anonymous"></script>
    <link href="includes/style.css" rel="stylesheet">

   		<!-- Boostrap JavaScript -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

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

<script type="text/javascript">
  //Get the button:
  mybutton = document.getElementById("gotop");

  // When the user clicks on the button, scroll to the top of the document
  function goTop() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
  }
</script>
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
             <li class="nav-item active">
              <a class="nav-link" href="contact.php">Contact<span class="sr-only">(current)</span></a>
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
                                <a class="dropdown-item" href=includes/php/logout.inc.php><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
                              </div>
                            </div>
                            </div>';
                        }
                        ?>
                    </div>
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
                    <small><b><label class="mr-sm-2">Username sau Email:</label></b></small>               
                    <input type="text" name="username" class="form-control" placeholder="Username sau Email" required><br>
                    <small><b><label class="mr-sm-2">Parola: </label><a href="#">Ti-ai uitat parola?</a></b></small>
                    <input type="password" name="password" class="form-control" placeholder="Parola" required><br>
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
                  <div class="modal-body">
                    <?php if(isset($_GET['error']) && $_GET['error'] = 'toofewchars') { ?>
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
        <td style="padding-bottom: 10px; padding-top: 10px;"><?php echo $textinbox; ?></td>
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
        <td><a href="<?php echo 'includes/php/inbox.inc.php?idmark='.$idinbox; ?>" class="btn <?php echo $buttonclass; ?> btn-sm btn-block"><?php echo $buttonname; ?></div></td>
      </tr>
      <?php } } else { ?>
        <td style="text-align: center">Momentan nu ai nici o notificare</td>
      <?php } ?>
      </table>
      </div>
      </div>
    </div>
  </div>
</div>

<!-- END INBOX MODAL -->
<?php } ?>

<main role="main"><br><br>
<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
     <?php if(!isset($_SESSION['username'])) { ?>
    <div class="carousel-item active">
      <img src="img/slide3.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block opacity-background">
        <h5>Bun venit pe VolvoFAN.ro</h5>
        <p>Daca doresti sa intri in familia noastra, poti sa iti creezi unul <a href="register.php" style="font-weight: bold;" class="btn btn-outline-primary btn-sm">Chiar Acum</a></p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/slide1.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block opacity-background">
        <h5>Detii un cont pe VolvoFAN.ro?</h5>
        <p>Atunci <a href="#loginmodal" data-toggle="modal" class="btn btn-outline-primary btn-sm" style="font-weight: bold;">apasa aici</a> pentru a te loga pe cont!</p>
      </div>
    </div>
    <div class="carousel-item" >
      <img src="img/slide2.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block opacity-background">
        <h5>Bun venit pe VolvoFAN.ro</h5>
        <p>Incercam sa cream o comunitate unita pe baza intereselor comune. Poti accesa forumul <a href="forum.php" class="btn btn-sm btn-outline-primary" style="font-weight: bold;">Apasand aici</a></p>
      </div>
    </div>
    <?php } else { ?>
    <div class="carousel-item active" >
      <img src="img/slide2.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block opacity-background">
        <h5>Bun venit pe VolvoFAN.ro</h5>
        <p>Incercam sa cream o comunitate unita pe baza intereselor comune. Poti accesa forumul <a href="forum.php" class="btn btn-sm btn-outline-primary" style="font-weight: bold;">Apasand aici</a></p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/slide3.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block opacity-background">
        <h5>Doresti sa afli mai multe despre "Volvo"?</h5>
        <p>Poti accesa sectiunea "Istoria Volvo" <a href="history.php" style="font-weight: bold;" class="btn btn-outline-primary btn-sm">Apasand Aici</a> in care este prezentata istoria marcii.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/slide1.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block opacity-background">
        <h5>Vrei sa vezi masinile care i-au consacrat pe cei de la Volvo?</h5>
        <p>La sectiunea <a href="gallery.php" class="btn btn-outline-primary btn-sm" style="font-weight: bold;">Galerie</a> poti admira niste modele remarcabile a celor de la Volvo.</p>
      </div>
    </div>
  <?php } ?>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div><br>

      <!-- Marketing messaging and featurettes
      ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->

     <div class="container marketing">

      <hr class="featurette-divider">

      <?php if(!isset($_SESSION['username']) && $find == FALSE) { ?>
        <div class="container-sm" style="background-color: #4d4d4d; height: 80px; border-top-left-radius: 6px; border-top-right-radius: 6px; border: 1px solid #4d4d4d;"><center><img src="img/logo.png" height="30px" width="140px" title="VolvoFAN.ro" style="margin-top: 15px;"><p><small style="color: white;">Formular de Contact</small></p></center></div>
            <div class="container-sm" style="background-color: #fff; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px; border: 1px solid #4d4d4d;"><br>
              <?php if(isset($_GET['msg']) && $_GET['msg'] == 'emptyfields') {
               echo '<div class="alert alert-danger alert-dismissible" id="alert">
                        Toate campurile trebuie completate!
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                      </button>
                </div>';
              }
              ?>
              <?php if(isset($_GET['msg']) && $_GET['msg'] == 'notchecked') {
               echo '<div class="alert alert-danger alert-dismissible" id="alert">
                        Trebuie sa accepti Termeni si conditiile!
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                      </button>
                </div>';
              }
              ?>
              <?php if(isset($_GET['msg']) && $_GET['msg'] == 'invalidmail') {
               echo '<div class="alert alert-danger alert-dismissible" id="alert">
                        Email-ul nu este unul valid!
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                      </button>
                </div>';
              }
              ?>
              <?php if(isset($_GET['msg']) && $_GET['msg'] == 'emaildontmatch') {
               echo '<div class="alert alert-danger alert-dismissible" id="alert">
                        Email-urile nu se potrivesc!
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                      </button>
                </div>';
              }
              ?>
              <?php if(isset($_GET['msg']) && $_GET['msg'] == 'error') {
               echo '<div class="alert alert-danger alert-dismissible" id="alert">
                        A aparut o eroare in trimiterea forumului de contact. Va rog reincercati!
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                      </button>
                </div>';
              }
              ?>
              <?php if(isset($_GET['msg']) && $_GET['msg'] == 'success') {
               echo '<div class="alert alert-success alert-dismissible" id="alert">
                        Infomatiile din forumul de contact au fost trimise cu succes!
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                      </button>
                </div>';
              }
              ?>
              <form class="form-group" method="POST" action="includes/php/sendmail.inc.php">
                <small><b><label class="mr-sm-2" for="username">Nume: </label></b></small>
                <input type="text" name="firstname" class="form-control" placeholder="Nume"><br>
                <small><b><label class="mr-sm-2" for="email">Prenume: </label></b></small>
                <input type="text" name="lastname" class="form-control" placeholder="Prenume"><br>
             <div class="row">
              <div class="col">
                    <small><b><label for="password">Email: </label></b></small>
                    <input type="text" name="email" class="form-control" placeholder="Email">
              </div>
                  <div class="col">
                    <small><b><label class="mr-sm-2" for="pwdrepeat">Confirma Email: </label></b></small>
                    <input type="text" name="emailrepeat" class="form-control" placeholder="Confirma Email">
              </div>
            </div><br>
                <small><b><label class="mr-sm-2" for="pwdrepeat">Subiect: </label></b></small>
                <input type="text" name="subject" class="form-control" placeholder="Subiectul..."><br>
                <small><b><label class="mr-sm-2" for="age">Mesaj: </label></b></small>
                <textarea class="form-control" name="message" placeholder="Scrie mesajul aici mesaj..." rows="5"></textarea>
                <div class="row">
                              <div class="col">
                              <div class="checkbox mb-3"><br>
                                <small>
                                <label>
                                     <input type="checkbox" name="conditions[]" id="conditions" value="checked"> Sunt deacord cu <a href="#">Termeni si conditiile</a>.
                                </label>
                              </small>
                         </div>
                       </div>
                      </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="sendmail-logout"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Trimite!</button><br>
          </form>      
        </div>
      <?php } elseif (!isset($_SESSION['username']) && $find == TRUE) { ?>
        <div class="alert alert-danger alert-dismissible" id="alert">
            Din pacate unul sau mai multe conturi create pe IP-ul <b><?php echo $ipfinder ?></b> sunt banate si nu poti accesa Contacts!
        </div>
      <?php } ?>

            <?php if(isset($_SESSION['username']) && $_SESSION['banned'] == 0) { ?>
        <div class="container-sm" style="background-color: #4d4d4d; height: 80px; border-top-left-radius: 6px; border-top-right-radius: 6px; border: 1px solid #4d4d4d;"><center><img src="img/logo.png" height="30px" width="140px" title="VolvoFAN.ro" style="margin-top: 15px;"><p><small style="color: white;">Formular de Contact</small></p></center></div>
            <div class="container-sm" style="background-color: #fff; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px; border: 1px solid #4d4d4d;"><br>
                            <?php if(isset($_GET['msg']) && $_GET['msg'] == 'emptyfields') {
               echo '<div class="alert alert-danger alert-dismissible" id="alert">
                        Toate campurile trebuie completate!
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                      </button>
                </div>';
              }
              ?>
              <?php if(isset($_GET['msg']) && $_GET['msg'] == 'notchecked') {
               echo '<div class="alert alert-danger alert-dismissible" id="alert">
                        Trebuie sa accepti Termeni si conditiile!
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                      </button>
                </div>';
              }
              ?>
              <?php if(isset($_GET['msg']) && $_GET['msg'] == 'error') {
               echo '<div class="alert alert-danger alert-dismissible" id="alert">
                        A aparut o eroare in trimiterea forumului de contact. Va rog reincercati!
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                      </button>
                </div>';
              }
              ?>
              <?php if(isset($_GET['msg']) && $_GET['msg'] == 'success') {
               echo '<div class="alert alert-success alert-dismissible" id="alert">
                        Infomatiile din forumul de contact au fost trimise cu succes!
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                      </button>
                </div>';
              }
              ?>
              <form class="form-group" method="POST" action="includes/php/sendmail.inc.php">
                <small><b><label class="mr-sm-2" for="username">Username: </label></b></small>
                <p><?php echo $_SESSION['username']; ?></p>
                <small><b><label class="mr-sm-2" for="email">Nume complet: </label></b></small>
                <p><?php echo $_SESSION['firstname'].' '.$_SESSION['lastname']; ?></p>
                <small><b><label for="password">Email: </label></b></small>
                <p><?php echo $_SESSION['email']; ?></p>
                <small><b><label class="mr-sm-2" for="pwdrepeat">Subiect: </label></b></small>
                <input type="text" name="subject" class="form-control" placeholder="Subiectul..."><br>
                <small><b><label class="mr-sm-2" for="age">Mesaj: </label></b></small>
                <textarea name="message" class="form-control" placeholder="Mesaj..." rows="5"></textarea>
               <div class="row">
                              <div class="col">
                              <div class="checkbox mb-3"><br>
                                <small>
                                <label>
                                     <input type="checkbox" name="conditions[]" id="conditions" value="checked"> Sunt deacord cu <a href="#">Termeni si conditiile</a>.
                                </label>
                              </small>
                         </div>
                       </div>
                      </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="sendmail-login"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Trimite!</button><br>
          </form>      
        </div>
      <?php } ?>

          <?php 
          if(isset($_SESSION['username']) && $_SESSION['banned'] == 1) {
              require 'includes/php/connect.php';
              $id = $_SESSION['id'];
              $sqlbanned = "SELECT * FROM banlist WHERE banneduserid = '$id'";
              $resultbanned = mysqli_query($con, $sqlbanned);
              $rowbanned = mysqli_fetch_assoc($resultbanned);
              $bannedby = $rowbanned['bannedby'];
              $reason = $rowbanned['reason'];
              $permanent = $rowbanned['permanentbanned'];
              $banduration = $rowbanned['banduration'];
              $bandate = $rowbanned['banneddate'];
              $unbandate = $rowbanned['unbandate'];
              ?><div class="alert alert-danger" role="alert">
                      <i class="fa fa-ban" aria-hidden="true"></i> <b>Acest cont este banat!</b><br>
                      Deoarece acest cont este banat, nu poti avea acces la Contact!<br><br>
                      Banat de: <b><?php echo $bannedby; ?></b>.<br>
                      Data acordari:  <b><?php echo $bandate; ?></b>.<br>
                      Motiv:  <b><?php echo $reason; ?></b>.<br>
                      <?php if(isset($permanent) && $permanent = 0 ) { ?>
                      Durata Banului:<br>
                    <?php } else { ?>
                      Durata Banului: <b>Permanent</b>.
                    <?php } ?>
                    </div>
                  <?php } ?>

        <hr class="featurette-divider"><br><br>

        <!-- /END THE FEATURETTES -->

      </div><!-- /.container -->


      <!-- FOOTER -->
   <div class="footer fixed-bottom" style="background-color: rgb(0, 0, 0, 0.6);">
      <footer class="container">
        <div class="row">
            <div class="col">
                <p style="color: white; font-weight: bold; font-size: 13px;">&copy; 2020-<?php echo date('Y'); ?> Copyright. All Rights Reseved | by Niculai Ilie-Traian &copy;</p>
            </div>
            <div class="col">
                <p class="float-right"><button class="btn btn-sm btn-outline-primary" style="font-weight: bold; margin-top: 9px; margin-bottom: -9px;" id="gotop" onclick="goTop()"> <i class="fas fa-chevron-up"></i> Back to Top</button></p>
            </div>
        </div>
      </footer>
    </div>
    </main>
	</body>
</html>