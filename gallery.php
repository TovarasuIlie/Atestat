<?php 
  session_start();
  require 'includes/php/connect.php';

  if(isset($_SESSION['username'])) {
      $userto = $_SESSION['username'];
      $sqlinbox = "SELECT id FROM inbox WHERE touser = '$userto' AND status = 0";
      $queryinbox = mysqli_query($con, $sqlinbox);
      $nrnotifications = mysqli_num_rows($queryinbox);
    }
      unset($_SESSION['pagename']);
      $_SESSION['pagename'] = basename($_SERVER['PHP_SELF']);
      unset($_SESSION['sortdates']);

      if (isset($_SESSION['loggedtime']) && (time() - $_SESSION['loggedtime'] > 1800)) {
        session_destroy();
        session_unset();
        header('location: gallery.php');
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
<html lang="en">
<head>
	<title>Galerie - VolvoFAN.ro</title>

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
    <?php if((isset($_GET['status']) && $_GET['status'] == 'loggedout') || (isset($_GET['error']))) { ?>
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
            <li class="nav-item active">
              <a class="nav-link" href="gallery.php">Galerie<span class="sr-only">(current)</span></a>
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
                        <button type="submit" class="btn btn-info btn-block btn-sm" style="width: 80%" name="find-user-submit"><i class="fas fa-search"></i> Cauta!</button>
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
                        <button class="btn btn-outline-info btn-block" style="max-width: 80%" type="submit" name="bugreport-submit">Trimite</button>
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

    <!--INBOX MODAL -->

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
        <td><a href="<?php echo 'includes/php/inbox.inc.php?idmark='.$idinbox; ?>" class="btn <?php echo $buttonclass; ?> btn-block btn-sm"><?php echo $buttonname; ?></div></td>
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
        <hr>
        <img src="img/gallery.png" class="center" style="max-width: 400px;">
        <hr>
        <?php if(!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] == 1)) { ?>
       <div class="row row-cols-1 row-cols-md-3 g-4">
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/p130amazon.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">P130 AMAZON 2-D<small class="text-muted"> (1961 - 1970)</small></h5>
                <p class="card-text">În septembrie 1961, a fost prezentată încă o versiune bazată pe 121 / 122S - un salon cu 2 uși. Această versiune a fost un model așteptat cu nerăbdare, în special pe piața suedeză, deoarece Suedia era o piață tipică pentru mașinile cu 2 uși în acel moment.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/p1800.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">P1800/1800<small class="text-muted"> (1961 - 1972)</small></h5>
                <p class="card-text">La începutul anului 1959, Volvo a prezentat o nouă mașină sport, la doi ani după încercarea anterioară cu Volvo Sport, cu o caroserie din poliester armat cu fibră de sticlă.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/142.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">142<small class="text-muted"> (1967 - 1974)</small></h5>
                <p class="card-text">Versiunea cu două uși din seria 140, Volvo 142, a fost introdusă la începutul verii lui 1967 - cu alte cuvinte, la mai puțin de un an după 144. Acest model avea același design tehnic ca și modelul cu 4 uși, în afară de numărul de uși. Ușile erau în mod natural mai lungi, iar spătarele din față puteau fi pliate înainte pentru a facilita accesul pe scaunul din spate.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4">
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/145.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">145<small class="text-muted"> (1967 - 1974)</small></h5>
                <p class="card-text">La sfârșitul lunii noiembrie 1967, Volvo a prezentat a treia versiune, în ceea ce se dezvolta acum într-o familie completă de mașini cunoscută sub numele de Seria 140, Volvo 145.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/1800es.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">1800ES<small class="text-muted"> (1971 - 1973)</small></h5>
                <p class="card-text">În toamna anului 1971, a fost prezentată o nouă versiune a celebrului model 1800 Volvo. Noua versiune a fost numită 1800ES. 1800ES avea un capăt spate nou proiectat în comparație cu versiunile anterioare ale lui 1800. Linia acoperișului fusese extinsă, iar mașina avea un profil care amintea mai mult de o proprietate.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/242.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">242<small class="text-muted"> (1974 - 1984)</small></h5>
                <p class="card-text">În august 1974, Volvo a prezentat o nouă generație de mașini numite Seria 240 și 260. Aceste noi modele fuseseră dezvoltate din seria 140 și erau foarte asemănătoare cu predecesorii lor. Modificările au inclus o nouă față, bare de protecție mari și un șasiu dezvoltat în continuare, cu un sistem de suspensie cu roți față de tipul McPherson</p>
              </div>
            </div>
          </div>
        </div>

         <div class="row row-cols-1 row-cols-md-3 g-4">
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/245.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">245<small class="text-muted"> (1974 - 1993)</small></h5>
                <p class="card-text">În august 1974, Volvo a prezentat o nouă generație de mașini numite Seria 240 și 260. Aceste noi modele fuseseră dezvoltate din seria 140 și erau foarte asemănătoare cu predecesorii lor. Modificările au inclus o nouă față, bare de protecție mari și un șasiu dezvoltat în continuare, cu un sistem de suspensie pe roți față de tip McPherson.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/262.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">262<small class="text-muted"> (1975 - 1977)</small></h5>
                <p class="card-text">Volvo 262 era o versiune rară în familia Volvo 260. Se baza pe același corp cu 2 uși folosit pentru modelul 242, dar avea în mod natural componentele din seria 260 și aspectul frontal.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/264.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">264<small class="text-muted"> (1975 - 1982)</small></h5>
                <p class="card-text">Volvo 264 a fost introdus în toamna anului 1974 ca succesor al Volvo 164, care a fost produs simultan cu 264 în 1975. 164 se bazase pe 144 și, în același mod, 264 se baza pe 244. Cea mai izbitoare schimbare a fost designul frontului cu stilul său mai orientat spre prestigiu.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4">
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/265.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">265<small class="text-muted"> (1975 - 1985)</small></h5>
                <p class="card-text">Când Volvo și-a prezentat noutățile pentru anul 1976 în august 1975, programul a inclus o nouă versiune - Volvo 265. Pentru prima dată, Volvo a putut acum să ofere o proprietate cu un motor cu 6 cilindri. Volvo 265 s-a bazat pe designul de bază al modelului 245, dar în combinație cu confortul unui motor cu 6 cilindri.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/360sedan.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">360 SEDAN<small class="text-muted"> (1983 - 1989)</small></h5>
                <p class="card-text">Anul model 1983 a anunțat o nouă adăugire la gama Volvo - seria 360. Volvo 360 a apărut în modelele 340 și a fost propulsat de un motor cu 4 cilindri de 2 litri. Noua mașină a fost mai bine echipată, iar denumirea „360” a fost introdusă pentru a oferi noului model un profil mai puternic în gama Volvo.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/760sedan.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">760 SEDAN<small class="text-muted"> (1975 - 1982)</small></h5>
                <p class="card-text">Cu berlina 760, introdusă la începutul anului 1982, Volvo a intrat în numărul mic de producători de vehicule de prestigiu cu confort superior și niveluri ridicate de performanță. Modelul 760 a fost o mașină foarte distinsă, care datorită designului său destul de unghiular, oferă un spațiu interior bun. Nivelul de siguranță a fost superior atât mașinilor Volvo anterioare, cât și majorității concurenților.</p>
              </div>
            </div>
          </div>
        </div>
      <?php } elseif(isset($_GET['page']) && $_GET['page'] == 2) { ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/760estate.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">760 ESTATE<small class="text-muted"> (1985 - 1990)</small></h5>
                <p class="card-text">Cu proprietatea 760, introdusă la începutul anului 1985, Volvo a introdus ceea ce a fost practic cea mai bună mașină imobiliară din lume. Versiunea „de bază” a proprietății 760GLE a fost condusă de o versiune dezvoltată a motorului francez V6 utilizat anterior în seria 260, dar aceasta a fost completată de un 4 in linie foarte rapid.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/740sedan.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">740 SEDAN<small class="text-muted"> (1984 - 1992)</small></h5>
                <p class="card-text">Volvo 760 GLE de mare succes a fost dezvoltat și extins pentru a da naștere Volvo 740 GLE în 1984. Acest nou model Volvo a fost o alternativă cu 4 cilindri față de 760. Mașina imobiliară Volvo 740 își datorează imensul succes în primul rând unor factori precum fiabilitatea sa și nivelurile de siguranță renumite.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/740estate.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">740 ESTATE<small class="text-muted"> (1985 - 1992)</small></h5>
                <p class="card-text">Volvo 760 GLE de mare succes a fost dezvoltat și extins pentru a da naștere Volvo 740 GLE în 1984. Acest nou model Volvo a fost o alternativă cu 4 cilindri față de 760. Versiunea modelului 740 a fost introdusă în 1985 și a fost o extindere mult așteptată a gamei.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4">
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/780.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">780<small class="text-muted"> (1985 - 1990)</small></h5>
                <p class="card-text">Volvo 780 a fost un coupé exclusiv cu 2 uși. A fost proiectat de casa de stil italiană Bertone, care a fost, de asemenea, responsabilă cu producția acestor mașini excepționale, după ce a acumulat experiență anterioară cu fabricarea Volvo 264TE (o versiune limuzină a modelului 264) și a Volvo 262C, versiunea coupé a modelului 260 al Volvo.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/460.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">460<small class="text-muted"> (1989 - 1996)</small></h5>
                <p class="card-text">Volvo 460 a fost lansat în 1989 ca versiune berlină a modelului 440 hatchback cu tracțiune față. Volvo 460 avea aceeași structură și structură tehnică de bază ca și modelul 480 sport coupé. Aceasta înseamnă că a împărtășit motorul transversal al modelului sportiv și tracțiunea față și, bineînțeles, a profitat de avantajele manevrabilității excelente a vehiculului 480 și a deținerii drumului.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/940sedan.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">940 SEDAN<small class="text-muted"> (1990 - 1998)</small></h5>
                <p class="card-text">Gama Volvo 940/960 a fost introdusă în toamna anului 1990. Noul 940 a înlocuit modelul 740, care a rămas însă în producție ca model de bază 740 GL. Un Volvo 940, un motor pe benzină cu 4 cilindri sau un turbo-diesel cu 6 cilindri, care semăna cu 960.</p>
              </div>
            </div>
          </div>
        </div>

         <div class="row row-cols-1 row-cols-md-3 g-4">
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/940estate.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">940 ESTATE<small class="text-muted"> (1990 - 1998)</small></h5>
                <p class="card-text">Gama Volvo 940/960 a fost introdusă în toamna anului 1990. Noul 940 a înlocuit modelul 740, care a rămas însă în producție ca model de bază 740 GL. Un Volvo 940, un motor pe benzină cu 4 cilindri sau un turbo-diesel cu 6 cilindri, care semăna cu 960.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/960sedan.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">960 SEDAN<small class="text-muted"> (1990 - 1997)</small></h5>
                <p class="card-text">Volvo 960 a fost propulsat de un nou motor cu 6 cilindri în linie, cu o cilindree de 3 litri. A fost o unitate de putere avansată, cu un bloc de cilindri din aluminiu și arbori cu came dubli, aliați la 4 supape pe cilindru. Acest motor a reprezentat prima etapă dintr-o generație complet nouă de motoare în linie, care s-a extins în cele din urmă la crearea unei noi serii de motoare Volvo cu 5 cilindri și 4 cilindri.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/960estate.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">960 ESTATE<small class="text-muted"> (1990 - 1997)</small></h5>
                <p class="card-text">Volvo 960 Estate a fost introdus în toamna anului 1990, împreună cu o serie de modele noi pentru anul 1991. Volvo 960 Estate a preluat tradiția modelelor Estate cu 6 cilindri din programul Volvo de la 760./p>
              </div>
            </div>
          </div>
        </div>

                 <div class="row row-cols-1 row-cols-md-3 g-4">
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/v90.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">V90<small class="text-muted"> (1997 - 1998)</small></h5>
                <p class="card-text">Volvo V90 Estate a fost introdus în anul model 1997 ca înlocuitor pentru Volvo 960 Estate. Când comparăm cele două modele, găsim doar diferențe minore. Printre noile caracteristici ale modelului V90 s-au numărat câteva culori noi pentru interior și exterior. Era vorba mai mult de alinierea acestor modele cu noua strategie de nume de model introdusă pentru prima dată în 1995 cu Volvo S40 și V40.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/s90.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">S90<small class="text-muted"> (1997 - 1998)</small></h5>
                <p class="card-text">Volvo V90 Estate a fost introdus în anul model 1997 ca înlocuitor pentru Volvo 960 Estate. Când comparăm cele două modele, găsim doar diferențe minore. Printre noile caracteristici ale modelului V90 s-au numărat câteva culori noi pentru interior și exterior. Era vorba mai mult de alinierea acestor modele cu noua strategie de nume de model introdusă pentru prima dată în 1995 cu Volvo S40 și V40.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/s70.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">S70<small class="text-muted"> (1996 - 2000)</small></h5>
                <p class="card-text">Când 1996 se apropia de sfârșit, a fost introdus un nou model Volvo, Volvo S70.Volvo S70 a fost dezvoltat din modelele de succes 850, care se aflau pe piață din 1991. Exteriorul noului S70 a arătat un stil mai moale decât predecesorul său, dar avea încă o puternică identitate Volvo. În interiorul mașinii, tabloul de bord era nou, la fel ca majoritatea interiorului. În domeniul siguranței au fost aduse o serie de îmbunătățiri.</p>
              </div>
            </div>
          </div>
        </div>
      <?php } elseif(isset($_GET['page']) && $_GET['page'] == 3) { ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/s40.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">S40<small class="text-muted"> (1995 - 2004)</small></h5>
                <p class="card-text">Cu modelul S40, Volvo a oferit aceleași niveluri de confort și siguranță în dimensiuni compacte, pe care șoferii celor mai mari 850 le-au bucurat deja de câțiva ani. În curând, cele două versiuni originale (cu motoare de 1,8 și 2,0 litri) au fost completate cu noi modele economice și interesante. De la versiunea turbodiesel cu consum redus de combustibil până la modelul S40 de înaltă performanță T4 (200 CP), un succesor demn al modelelor Volvo de performanță clasică precum PV544 Sport, P1800 și 240 Turbo.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/v40.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">V40<small class="text-muted"> (1995 - 2004)</small></h5>
                <p class="card-text">Volvo V40 este identic mecanic cu modelul S40, dar (în stilul tradițional Volvo) a fost dezvoltat în continuare într-o mașină compactă, oferind aceleași niveluri de confort, siguranță și performanță ca și S40, dar cu flexibilitatea suplimentară obținută printr-o proprietate caroserie. La fel ca S40, V40 este disponibil într-un număr foarte mare de versiuni, adaptate cerințelor individuale ale clientului care se bucură de caracteristicile Volvo într-o mașină compactă.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/c70.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">C70 COUPE<small class="text-muted"> (1996 - 2002)</small></h5>
                <p class="card-text">De-a lungul anilor, Volvo a oferit mașini coupé exclusive clienților cu discernământ care doresc să combine exclusivitatea cu confortul, siguranța, performanța ridicată și caracteristicile bune de păstrare a drumului. P1800, 262C și 780 merită menționate ca predecesori ai C70 Coupé</p>
              </div>
            </div>
          </div>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4">
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/c70cabriolet.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">C70 CABRIOLET / CONVERTIBLE<small class="text-muted"> (1997 - 2013)</small></h5>
                <p class="card-text">Povestea decapotabilelor Volvo este la fel de veche ca și mașina Volvo în sine. În 1927, prima mașină Volvo era o mașină deschisă, ÖV4. În anii 1930, o serie de decapotabile au fost construite pe șasiu Volvo diferit de caroseri specialiști independenți. În 1956 - 57, faimosul Volvo Sport (P1900) a fost produs într-un număr foarte limitat de 67 de exemplare, dintre care cele mai multe au fost păstrate până în prezent.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/s402003.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">S40<small class="text-muted"> (2003 - 2012)</small></h5>
                <p class="card-text">La Salonul Auto de la Frankfurt din septembrie 2003 a debutat un nou Volvo, S40. Această a doua generație Volvo S40 are un stil modern, cu un patrimoniu clar Volvo. În interiorul mașinii, găsim un nou limbaj de design cu o influență scandinavă clară. Volvo S40 vine cu o gamă largă de motoare, cu patru cilindri și pentru prima dată și cu cinci cilindri pe benzină pentru autovehiculele Volvo de dimensiuni medii. Un turbo diesel cu patru cilindri face, de asemenea, parte din program.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/v50.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">V50<small class="text-muted"> (2003 - 2012)</small></h5>
                <p class="card-text">Chiar înainte de sfârșitul anului 2003, încă un nou Volvo a fost lansat, Volvo V50. Volvo V50 este înlocuitorul Volvo V40 care a fost lansat în 1995. Designul exterior al noului Volvo V50 are o identitate clară Volvo, iar interiorul prezintă o influență a designului scandinav curat și clar./p>
              </div>
            </div>
          </div>
        </div>

         <div class="row row-cols-1 row-cols-md-3 g-4">
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/c30.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">C30<small class="text-muted"> (2006 - 2012)</small></h5>
                <p class="card-text">Cu C30, Volvo și-a făcut debutul pe segmentul mașinilor premium cu două uși. Designul sportiv, cu două uși, patru scaune individuale și un hayon din sticlă, a oferit unui grup tânăr și dinamic de clienți „un Volvo propriu”. Mașina a oferit cumpărătorilor un aspect contemporan, cu o moștenire mândră, deoarece Volvo C30 afișa elemente clare ale altor modele clasice Volvo cu un pedigree sportiv, cum ar fi Volvo 1800 ES. Oricine își amintește renumitul Volvo SCC (Safety Concept Car) va recunoaște hayonul din sticlă exclusiv și convenabil.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/xc90.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">XC90 1ST GENERATION<small class="text-muted"> (2002 - 2006)</small></h5>
                <p class="card-text">De exemplu, compania suedeză a vândut peste 85.000 de unități în 2005, ceea ce reprezintă un număr destul de mare ținând cont de valoarea unei astfel de mașini. SUV-ul de dimensiuni medii a fost prezentat pentru prima dată la ediția din 2002 a Salonului Auto de la Detroit, bazându-se în întregime pe platforma P2, care a oferit, de asemenea, un număr important de alte mașini Volvo. Versiunea din 2002 a fost disponibilă în două ediții, 2.5 T și T6.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/xc60.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">XC60 1ST GENERATION<small class="text-muted"> (2008 - 2013)</small></h5>
                <p class="card-text">Noul XC60 de atunci era o combinație între o proprietate, un monovolum și un SUV, oferind multă versatilitate și practic. Din punct de vedere estetic, XC60 avea un design frumos cu umerii săi groși și cu poziția ridicată. În interior, cabina confortabilă era prevăzută cu scaune extrem de confortabile și un design scandinav general, plăcut la vedere. O mulțime de spații de depozitare erau disponibile.</p>
              </div>
            </div>
          </div>
        </div>

                 <div class="row row-cols-1 row-cols-md-3 g-4">
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/xc602015.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">XC60 2ND GENERATION<small class="text-muted"> (2013 - 2017)</small></h5>
                <p class="card-text">XC60 nu a fost doar un SUV mic de lux, ci a oferit și utilitate și siguranță. Nu este o surpriză pentru mașinile Volvo în general, XC60 a obținut cinci stele perfecte în testele de impact. Și înainte de a vorbi despre o coliziune, Volvo s-a asigurat că modelul lor este echipat cu cele mai noi tehnologii de siguranță menite să prevină producerea unui accident. SUV-ul mic oferea locuri pentru cinci persoane și era disponibil în trei niveluri: 3.2, T6 și T6 R-Design. Fiecare nivel de finisare a fost disponibil în standard, Premier Plus și Platinum sub-trims, în timp ce pentru 3.2 3.2, Volvo a oferit Premier-sub-trim.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/xc902015.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">XC90 2ND GENERATION<small class="text-muted"> (2014 - 2019)</small></h5>
                <p class="card-text">Prima generație a XC90 a fost un amestec de motoare, tehnologii și piese de la Ford, Volvo și chiar Yamaha (motorul pe benzină V8). Această nouă generație este însă cu totul diferită. Cu propriile sale motoare turbo de 2 litri, diesel sau benzină, și o versiune hibridă pentru vârful T8, 2014 XC90 este un SUV de dimensiuni medii construit pentru lux și durabilitate. Hibridul plug-in oferă o putere totală combinată de 400 CP, în timp ce consumul de combustibil conform normelor WLTP este de doar 2,5 l / 100 km (94 mpg).</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/xc701st.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">XC70 <small class="text-muted"> (2000 - 2004)</small></h5>
                <p class="card-text">Dezvoltat pe aceeași bază ca și break-ul V70, XC70 avea o gardă la sol mai mare și bare de protecție din plastic negru. Mulajele laterale din plastic negru au fost rezistente la zgârieturi și au fost bine manipulate împotriva tufișurilor, cărucioarelor și a mușcăturilor de câine. Nu au rezistat prea bine la soare, dar în afară de asta au fost ok. Volvo a oferit mașina cu șine de acoperiș standard, iar hayonul ușor încastrat a fost protejat în partea inferioară de bara groasă de plastic.</p>
              </div>
            </div>
          </div>
        </div>
      <?php } elseif(isset($_GET['page']) && $_GET['page'] == 4) { ?>
                <div class="row row-cols-1 row-cols-md-3 g-4">
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/xc702nd.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">XC70<small class="text-muted"> (2007 - 2016)</small></h5>
                <p class="card-text">Echipat deja cu mai multe caracteristici de siguranță, baza V70 s-a transformat din nou într-un crossover offroad. Acest nou XC70 vine cu controlul stabilității și al tracțiunii ca o caracteristică standard, dar Volvo a pus la dispoziție și un pachet de opțiuni noi și utile. De exemplu, un client poate personaliza mașina cu un sistem de control al coborârii dealului, cel mai util atunci când coborâți dealul pe o pantă alunecoasă.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/v60cross.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">S60 CROSS COUNTRY<small class="text-muted"> (2015 - 2018)</small></h5>
                <p class="card-text">În 1997, Volvo a introdus XC70 CrossCountry și a fost considerat un pionier pentru acest segment. AMC a introdus crossover-ul Eagle în 1980 și asta a fost înainte de vremurile sale. XC70 a venit în momentul potrivit când piața era pregătită pentru aceasta. Constructorul auto suedez a fost mulțumit de vânzările sale și a continuat să introducă de atunci, dar S60 CrossCountry a fost o poveste diferită. Volvo nu știa dacă noua mașină va primi prea multă atenție de la clienți, așa că a oferit-o într-o ediție limitată.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/v40cross.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">V40 CROSS COUNTRY<small class="text-muted"> (2016 - 2019)</small></h5>
                <p class="card-text">În timp ce stilul a fost îmbunătățit pentru a oferi mașinii un aspect mai îndrăzneț, robust și un aspect 4x4, este dezamăgitor să spunem că un sistem de tracțiune integrală a fost disponibil doar pentru vârful de gamă, T5. Actualizarea exterioară a inclus o nouă grilă cu un Volvo Iron Mark mai atrăgător. Farurile au fost reproiectate și au prezentat noul stil „Thor’s Hammer” al Volvo. Cinci noi culori de vopsea pentru exterior au fost adăugate în gamă: Amazon Blue, Denim Blue, Bursting Blue, Blue Midie și Luminous Sand.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4">
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/v60polestar.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">V60 POLESTAR<small class="text-muted"> (2014 - PREZENT)</small></h5>
                <p class="card-text">În timp ce se afla încă în proprietatea Ford, Volvo a trebuit să facă vehicule sigure, mame de fotbal, ecologice. Nu li s-a permis să se laude cu trecutul lor de curse victorios. Volvo ar putea arăta doar sistemele lor de frânare automată, airbagurile gazillion și superioritatea sa din oțel suedeză. Ei bine, Geely a schimbat toată acea filozofie după ce Volvo a trecut prin câteva mâini și a aterizat pe portofoliul gigant chinezesc. Noul proprietar a încercat să îi facă pe fanii Volvo să zâmbească din nou, iar versiunile Polestar au fost doar o modalitate de a face acest lucru.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/s60polestar.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">S60 POLESTAR<small class="text-muted"> (2017 - PREZENT)</small></h5>
                <p class="card-text">Când auziți expresia „aduceți tot ce aveți”, s-ar putea să vă gândiți la o dramă sau un film de acțiune. Pentru Volvo, asta a spus noua conducere departamentului de motorsport. Și inginerii de acolo au adus tot ce au primit și l-au pus într-o singură mașină: S60 Polestar. Mașina pe care Volvo a putut să o facă cu mult timp în urmă, a fost însărcinată să rămână cu insigna de siguranță, nu cu cea sportivă. Dar Polestar era altceva. A fost o mică echipă de curse achiziționată de Volvo în 2015, iar S60 Polestar a fost primul lor produs sub acoperișul producătorului auto suedez.</p>
              </div>
            </div>
          </div>
          <div class="col margin-card">
            <div class="card h-100">
              <img src="img/v602nd.png" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">V60<small class="text-muted"> (2018 - PREZENT)</small></h5>
                <p class="card-text">Acest lucru permite creșterea spațiului interior, conectivitate avansată și cele mai noi sisteme de asistență pentru șoferi și tehnologie de siguranță Volvo. Sistemul de infotainment Sensus Volvo Cars este pe deplin compatibil cu Apple CarPlay, Android Auto și 4G și păstrează șoferii conectați în orice moment. Sistemul este controlat printr-un ecran tactil intuitiv în stil tabletă care combină funcțiile mașinii, navigația, serviciile conectate și aplicațiile de divertisment.</p>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      <nav>
        <ul class="pagination">
          <li class="page-item <?php if(!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] == 1)) echo 'disabled'; ?>"><a class="page-link" href="gallery.php?page=<?php if(isset($_GET['page']) && $_GET['page'] > 1) { echo $_GET['page'] - 1; } ?>">Previous</a></li>
          <li class="page-item <?php if(!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] == 1)) echo 'active'; ?>"><a class="page-link" href="gallery.php?page=1">1</a></li>
          <li class="page-item <?php if(isset($_GET['page']) && $_GET['page'] == 2) echo 'active'; ?>"><a class="page-link" href="gallery.php?page=2">2</a></li>
          <li class="page-item <?php if(isset($_GET['page']) && $_GET['page'] == 3) echo 'active'; ?>"><a class="page-link" href="gallery.php?page=3">3</a></li>
          <li class="page-item <?php if(isset($_GET['page']) && $_GET['page'] == 4) echo 'active'; ?>"><a class="page-link" href="gallery.php?page=4">4</a></li>
          <li class="page-item <?php if(isset($_GET['page']) && $_GET['page'] == 4) echo 'disabled'; ?>"><a class="page-link" href="gallery.php?page=<?php if(isset($_GET['page']) && $_GET['page'] <= 4) { echo $_GET['page'] + 1; } elseif(!isset($_GET['page'])) { echo '2'; } ?>">Next</a></li>
        </ul>
      </nav>
        <hr><br>


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