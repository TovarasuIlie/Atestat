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
      header('location: history.php');
      } else {
        $_SESSION['loggedtime'] = time();
      }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Istoria Volvo - VolvoFAN.ro</title>

	    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="refresh" content="1800;url=includes/php/logout.inc.php" />
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">

        <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">    
    <link href="includes/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/0c4d35ef60.js" crossorigin="anonymous"></script>

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
            <li class="nav-item active">
              <a class="nav-link" href="history.php">Istoria Volvo<span class="sr-only">(current)</span></a>
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

     <div class="container marketing" style="margin-bottom: 70px;">

        <!-- START THE FEATURETTES -->
    <b>
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link <?php if(isset($_GET['view']) && $_GET['view'] != 'inovations') { echo 'active'; } if(!isset($_GET['view'])) {echo 'active'; }?>" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="true">Istoria Volvo</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if(isset($_GET['view']) && $_GET['view'] == 'inovations') { echo 'active'; }?>" id="inovations-tab" data-toggle="tab" href="#inovations" role="tab" aria-controls="inovations" aria-selected="false">Inovatii in domeniu</a>
            </li>
          </ul>
    </b>

          <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade <?php if(isset($_GET['view']) && $_GET['view'] != 'inovations') { echo 'show active'; } if(!isset($_GET['view'])) {echo 'show active'; }?>" id="history" role="tabpanel" aria-labelledby="history">
        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">Volvo Personvagnar AB <span class="text-muted">Volvo Car Corporation</span></h2>
            <p class="lead">Volvo Cars (Volvo, latină pentru "mă rostogolesc", ca referință la rulmenți) sau Volvo Personvagnar AB, este o companie producătoare de mașini din Suedia fondată pe 14 aprilie 1927 când prima mașină, poreclită "Jakob", a părăsit porțile fabricii din Göteborg, Suedia.</p>
            <p class="lead">Numele Volvo a fost considerat un bun trademark pentru o companie de rulmenți și pentru o companie de automobile.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" src="img/volvologo2.png" style="height: 15%; width: 100%; position: absolute; bottom: 30%;" alt="Volvo LOGO">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading">Simbolul Volvo. <span class="text-muted">Origine.</span></h2>
            <p class="lead">Simbolul Volvo este un semn străvechi pentru fier. Semnul fierului a fost folosit pentru a simboliza puterea fierului folosit pentru a construi mașinile, Suedia este cunoscută pentru calitatea fierului. Bara diagonală de fier a fost folosită în principiu pentru a fixa simbolul cercului cu săgeată pe radiator.</p>
          </div>
          <div class="col-md-5 order-md-1">
            <img class="featurette-image img-fluid mx-auto" src="img/volvologo.png" style="height: 100%; width: 100%;" alt="Muie">
          </div>
        </div>

        <hr class="featurette-divider">
        <button class="btn btn-outline-secondary btn-sm" type="button" data-toggle="collapse" data-target="#collapse" aria-expanded="false" aria-controls="collapseExample">
            Arata mai mult
         </button>
        <hr class="featurette-divider">

    <div class="collapse" id="collapse">
        <div class="row featurette">
          <div class="col-md-7 edittextboxright">
            <h2 class="featurette-heading">Assar Thorvald <span class="text-muted">Nathanael Gabrielsson</span></h2>
            <p class="lead">Assar Thorvald Nathanael Gabrielsson (1891 - 1962) este industriaşul suedez la iniţiativa căruia s-a lansat compania producătoare de autovehicule Volvo (cuvântul ”volvo„ înseamnă în latină ”mă rostogolesc„). El a colaborat cu inginerul Gustaf Larson (1887 – 1968) pentru a dezvolta primul model al autoturismului suedez. Anul trecut, compania a vândut 503.127 de autoturisme şi a avut un profit operaţional de 6,62 miliarde de coroane suedeze (778 de milioane de dolari).</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto fondatorvolvo" src="img/fondatorvolvo.jpg" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 order-md-2 edittextboxleft">
            <h2 class="featurette-heading">AB <span class="text-muted">SKF</span></h2>
            <p class="lead">Volvo a fost creată în 1915, ca subsidiară a companiei AB SKF, axată pe producţia de rulmenţi cu bile. Assar Gabrielsson şi-a luat licenţa în economie şi a lucrat ca director de vânzări al companiei de producţie de rulmenţi SKF din Göteborg la începutul anilor 1900. Assar Gabrielsson şi-a întâlnit vechiul prieten Gustaf Larson în Stockholm, în 1924, prilej cu care i-a dezvăluit planurile sale de a lansa un nou autorism.</p>
          </div>
          <div class="col-md-5 order-md-1">
            <img class="featurette-image img-fluid mx-auto skf" src="img/skf.jpg" alt="Muie">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 edittextboxright">
            <h2 class="featurette-heading">Primul camion <span class="text-muted">VOLVO</span></h2>
            <p class="lead">Volvo a aparut in anul 1928 iar primul camion produs de ei avea doar 28 hp. Pare bizar ca in urma cu 90 ani produceau o conserva de camion cu 28 hp iar in acest moment produc cel mai puternic camion de serie din Europa, FH 16 750 hp. Simbolul celor de la Volvo provine din vechile legende suedeze unde acesta reprezenta fierul.</p>
          </div>
          <div class="col-md-5 order-md-1">
            <img class="featurette-image img-fluid mx-auto truck1st" src="img/1sttruck.png" alt="Muie">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 order-md-2 edittextboxleft">
            <h2 class="featurette-heading">Globetrotter <span class="text-muted">XL</span></h2>
            <p class="lead">Gama cea mai iubita si cea mai cunoscuta produsa de cei de la Volvo este Globetrotter, apare in anii 70′ si odata cu lansarea ei se implementeaza o serie de noi tehnologii precum rabatarea cabinei, centura de siguranta, etc, tehnologii pilot in constructia de camioane pentru acele vremuri .</p>
          </div>
          <div class="col-md-5 order-md-1">
            <img class="featurette-image img-fluid mx-auto globetrotter" src="img/globetrotter.png" alt="Globetrotter XL">
          </div>
        </div>

        <hr class="featurette-divider">

      </div>
    </div>

      <div class="tab-pane fade <?php if(isset($_GET['view']) && $_GET['view'] == 'inovations') { echo 'show active'; }?>" id="inovations" role="tabpanel" aria-labelledby="inovations"><br>
         <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">1959 <span class="text-muted">Centura de siguranță în trei puncte</span></h2>
            <p class="lead">Nu există mulți oameni care au salvat atâtea vieți ca inginerul Volvo, Nils Bohlin – el a introdus centura de siguranță în trei puncte în producția de serie PV544. De atunci, se estimează că peste un milion de vieți au fost salvate ca urmare a faptului că Volvo Cars a renunțat la drepturile sale asupra brevetului, astfel încât toată lumea să poată beneficia de invenție.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" style="border-radius: 4px;" src="img/seatbelt.jpg" alt="Volvo LOGO">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 order-md-2 edittextboxleft">
            <h2 class="featurette-heading">1972 <span class="text-muted">Scaunul pentru copii orientat spre spate</span></h2>
            <p class="lead">Îți amintești acele imagini timpurii ale astronauților întinși pe spate în timpul decolării, pentru a uniformiza puterea energiei produse de mișcare asupra corpului? Ei bine, acesta a fost principiul după care ne-am ghidat atunci când am creat primele scaune pentru copii orientate spre spate. Cu scopul de a aloca în mod egal energia și a minimiza posibilele leziuni cauzate de un impact.</p>
          </div>
          <div class="col-md-5 order-md-1">
            <img class="featurette-image img-fluid mx-auto childseat" src="img/childseat.jpg">
          </div>
        </div>

        <hr class="featurette-divider">
        <button class="btn btn-outline-secondary btn-sm" type="button" data-toggle="collapse" data-target="#collapse1" aria-expanded="false" aria-controls="collapse">
            Arata mai mult
         </button>
        <hr class="featurette-divider">

        <div class="collapse" id="collapse1">

        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">1978 <span class="text-muted">Perna de înălțare</span></h2>
            <p class="lead">Am inventat perna de înălțare pentru o mai bună poziționare a centurii, care a permis copiilor cu vârsta de cel puțin 4 ani să călătorească îndreptați spre fața mașinii, beneficiind de protecție și confort sporit.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" style="border-radius: 4px;" src="img/boosterseat.jpg" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 order-md-2 edittextboxleft">
            <h2 class="featurette-heading">1990 <span class="text-muted">O premieră la nivel mondial: prima pernă de înălțare integrată</span></h2>
            <p class="lead">Introducerea primei perne de înălțare integrate în scaun a fost un alt progres uriaș în ceea ce privește siguranța copiilor. Pe lângă sporirea siguranței și a confortului, perna de înălțare integrată oferă și o poziție mai bună de așezare a copilului, permițându-i să privească pe geamul mașinii.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto integratedboosterseat" src="img/integratedboosterseat.jpg" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

         <div class="row featurette">
          <div class="col-md-7 edittextboxright">
            <h2 class="featurette-heading">1991 <span class="text-muted">Sistemul de protecție în caz de impact lateral (SIPS)</span></h2>
            <p class="lead">O altă etapă importantă în materie de siguranță a fost atinsă odată cu dezvoltarea sistemul nostru de protecție în caz de impact lateral. Această funcție a fost o parte integrantă a designului mașinii și a inclus o structură foarte puternică și materiale absorbante de energie la interior, o traversă în podea și chiar scaune întărite. Am mers mai departe în 1994 cu încă o premieră mondială: airbag-uri laterale.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto sideimpactprotection" src="img/sideimpactprotection.jpg" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 order-md-2 edittextboxleft">
            <h2 class="featurette-heading">1998 <span class="text-muted">Sistemul de protecție împotriva leziunilor Whiplash Protection System (WHIPS)</span></h2>
            <p class="lead">Leziunile la nivelul capului sunt cele mai frecvente răni în cazul accidentelor de mașină și pot avea efecte precum durerile pe termen lung sau chiar dizabilitățile. WHIPS oferă sprijin uniform și absorbție de energie în zona spatelui, atenuând impactul datorită unui design inteligent al scaunului și al tetierei. Rezultatul constă în înjumătățirea riscului de probleme medicale pe termen lung.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto whiplashprotection" src="img/whiplashprotection.jpg" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 edittextboxright">
            <h2 class="featurette-heading">1998 <span class="text-muted">Cortina gonflabilă</span></h2>
            <p class="lead">Cortina gonflabilă a reprezentat pentru Volvo Cars încă un pas mare în domeniul siguranței. Airbag-ul este ascuns în căptușeala plafonului și se umflă rapid, pentru a ajuta la protejarea capului ocupantului în timpul unui impact lateral sau în situația în care mașina se rostogolește. A fost primul sistem airbag care a oferit o protecție îmbunătățită atât pentru ocupanții scaunelor din față, cât și pentru pasagerii din spate.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto inflatablecurtain" src="img/inflatablecurtain.jpg" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 order-md-2 edittextboxleft">
            <h2 class="featurette-heading">2002 <span class="text-muted">Sistemul de protecție în caz de răsturnare, Roll-Over Protection System (ROPS)</span></h2>
            <p class="lead">Odată cu creșterea popularității SUV-urilor, am considerat că este timpul să lansăm următoarea noastră inovație în materie de siguranță - protecția în caz de răsturnare. Am abordat problema din două direcții. În primul rând, am îmbunătățit stabilitatea SUV-urilor noastre cu un sistem sofisticat de control electronic al stabilității și, în al doilea rând, am îmbunătățit designul și structura caroseriei, pentru a proteja mai bine șoferul și pasagerii în cazul răsturnării mașinii.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto rollover" src="img/rollover.jpg" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 edittextboxright">
            <h2 class="featurette-heading">2003 <span class="text-muted">Blind Spot Information System (BLIS)</span></h2>
            <p class="lead">Atunci când șoferii schimbă banda, o scăpare de moment poate avea consecințe catastrofale dacă șoferul nu a observat o altă mașină în punctul mort. Prin urmare, am decis că mașinile noastre ne vor ajuta și ele să evităm problemele. Sistemul nostru BLIS folosește camere sau radare pentru a detecta vehiculele aflate în unghiul mort al mașinilor Volvo. Când o mașină intră în zona punctului mort, o lumină de avertizare se aprinde lângă oglinda retrovizoare, oferindu-i șoferului mai mult timp de reacție.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto blis" src="img/blis.jpg" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 order-md-2 edittextboxleft">
            <h2 class="featurette-heading">2008 <span class="text-muted">City Safety</span></h2>
            <p class="lead">Începând cu prima generație de Volvo XC60, am lansat sistemul autonom de frânare în situații de urgență, City Safety, ca echipare standard în toate mașinile noi. Sistemul detectează mișcarea cu ajutorul unui radar și a fost dezvoltat pentru a reduce riscurile și consecințele coliziunilor la viteze de până la 30 km/h.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto citysafety" src="img/citysafety.jpg" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 edittextboxright">
            <h2 class="featurette-heading">2010 <span class="text-muted">Detectarea pietonilor cu frânare automată</span></h2>
            <p class="lead">Ne dorim ca inovațiile noastre în materie de siguranță să fie benefice și pentru oamenii aflați în afara mașinilor. Prin urmare, am dezvoltat un sistem – folosind radarul și camerele de luat vederi – pentru a avertiza șoferul dacă în fața mașinii apare cineva, urmând să se efectueze frânarea automată dacă șoferul nu reușește să o facă.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto pedestrian" src="img/pedestrian.jpg" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 order-md-2 edittextboxleft">
            <h2 class="featurette-heading">2014 <span class="text-muted">Protecție împotriva ieșirii de pe drum</span></h2>
            <p class="lead">Volvo a fost pionier în folosirea testelor pentru accidente cauzate de derapaje – și cauzate de obicei de oboseală, condiții meteo nefavorabile sau lipsa atenției șoferului. Ne-am concentrat pe menținerea pasagerilor pe poziția pe care se află, întărind centura de siguranță și dezvoltând funcții unice de absorbție a energiei la nivelul scaunelor pentru a evita leziunile coloanei vertebrale.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto runoffroadprotection" src="img/runoffroadprotection.jpg" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 edittextboxright">
            <h2 class="featurette-heading">2016 <span class="text-muted">Siguranță prin conectare</span></h2>
            <p class="lead">Volvo Cars definește un nou tip de sistem de siguranță rutieră într-o lume a mașinilor conectate. Inovațiile conectate – Slippery Road Alert - alerta pentru drumuri alunecoase și Hazard Light Alert - alerta luminoasă pentru pericole – utilizează Cloud-ul pentru a partaja date esențiale între vehicule, avertizând șoferul cu privire la secțiunile de drum alunecos sau la vehiculele care și-au activat luminile de avarie, oferindu-i șoferului suficient timp pentru a încetini.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto cloud" src="img/cloud.jpg" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 order-md-2 edittextboxleft">
            <h2 class="featurette-heading">2018 <span class="text-muted">Evitarea pericolelor prin frânare</span></h2>
            <p class="lead">Funcția Oncoming mitigation by braking - evitarea pericolelor prin frânare este o altă caracteristică unică Volvo. Sistemul te poate ajuta să acționezi frânele în cazul unui vehicul care se apropie pe banda ta de mers. Dacă un alt vehicul se apropie de tine pe aceeași bandă și coliziunea este inevitabilă, sistemul te poate ajuta să reduci viteza mașinii, pentru a încerca să atenuezi forța coliziunii.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto oncomingmitigationbybreaking" src="img/oncomingmitigationbybreaking.jpg" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 edittextboxright">
            <h2 class="featurette-heading">2020 <span class="text-muted">Limitarea vitezei maxime</span></h2>
            <p class="lead">Pentru a lansa un semnal de alarmă asupra pericolelor vitezei în exces, am limitat în 2020 viteza maximă a tuturor mașinilor noastre noi la 180 km/h. Această inițiativă demonstrează modul în care ne putem asuma activ responsabilitatea, pentru a reuși să ajungem la zero decese în trafic, prin sprijinirea unui comportament mai responsabil al conducătorului auto.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto xc40onabridge" src="img/xc40onabridge.jpg" alt="Generic placeholder image">
          </div>
        </div>

        <hr class="featurette-divider"><br><br>
      </div>
    </div>
  </div>

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