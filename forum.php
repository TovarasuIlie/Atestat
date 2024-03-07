<?php
	session_start();
  require 'includes/php/connect.php';

  if(isset($_SESSION['username'])) {
      $userto = $_SESSION['username'];
      $sqlinbox = "SELECT id FROM inbox WHERE touser = '$userto' AND status = 0";
      $queryinbox = mysqli_query($con, $sqlinbox);
      $nrnotifications = mysqli_num_rows($queryinbox);
    }
  unset($_SESSION["pagename"]);
  $_SESSION['pagename'] = basename($_SERVER['PHP_SELF']);
  unset($_SESSION['sortdates']);

if(isset($_SESSION['id'])) {
  $userid = $_SESSION['id'];
  $username = $_SESSION['username'];
  $sqlupdatesession = "SELECT * FROM users WHERE id = '$userid' AND username = '$username'";
  $rowupdatesession = mysqli_fetch_assoc(mysqli_query($con, $sqlupdatesession));
  $_SESSION['verified'] = $rowupdatesession['verified'];
  $_SESSION['banned'] = $rowupdatesession['banned'];
  $_SESSION['function'] = $rowupdatesession['function'];
}

  if (isset($_SESSION['loggedtime']) && (time() - $_SESSION['loggedtime'] > 1800)) {
      session_destroy();
      session_unset();
      header('location: forum.php');
      } else {
        $_SESSION['loggedtime'] = time();
      }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php if(!isset($_GET['action']) && !isset($_GET['view'])) { ?>
	<title>Forum - VolvoFAN.ro</title>
<?php }elseif(isset($_GET['action']) && $_GET['action'] == 'addpost') { ?>
  <title>Adauga topic - VolvoFAN.ro</title>
<?php }elseif(isset($_GET['view']) && $_GET['view'] == 'suspended') { ?>
  <title>Topicuri Suspendate - VolvoFAN.ro</title>
<?php }elseif(isset($_GET['action']) && $_GET['action'] == 'viewpost') {
  require 'includes/php/connect.php';
  $idtitle = $_GET['idpost'];
  $sqltitle = "SELECT title FROM posts WHERE id = '$idtitle'";
  $post = mysqli_fetch_assoc(mysqli_query($con, $sqltitle));
  ?>
  <title><?php echo $post['title']; ?> - VolvoFAN.ro</title>
<?php } ?>

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

  <?php if(isset($_GET['msg']) && $_GET['msg'] == 'success') { ?>
  <script>
      $(document).ready(function(){
          $("#successmodal").modal('show');
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
              <a class="nav-link" href="index.php">Acasa<span class="sr-only">(current)</span></a>
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
            <li class="nav-item active">
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
                          if($_SESSION['function'] !=0 && $_SESSION['banned'] == 0) { 
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

<!-- <! SUCCESS MODAL !> -->
<div class="modal fade" id="successmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success">
        <center>
          <i class="fas fa-fw fa-9x fa-check-square"></i>
          <p style="font-weight: 900; font-size: 30px; margin-top: 10px;">Actiunea a fost executata cu succes!</p>
        </center>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- <! SUCCESS MODAL !> -->

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

<!--           INBOX MODAL -->

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
      <?php 
        if(!isset($_GET['action']))
        {
      ?>
     <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/slide1.1.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block opacity-background">
        <h5>Bun Venit pe Forumul VolvoFAN.ro</h5>
        <p>Aici este locul unde poti gasii raspuns la orice intrebare.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/slide3.3.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block opacity-background">
        <h5>Doresti sa afli mai multe despre "Volvo"?</h5>
        <p>Poti accesa sectiunea "Istoria Volvo" <a href="history.php" style="font-weight: bold;" class="btn btn-outline-primary btn-sm">Apasand Aici</a> in care este prezentata istoria marcii.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/slide2.2.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block opacity-background">
        <h5>Vrei sa vezi masinile care i-au consacrat pe cei de la Volvo?</h5>
        <p>La sectiunea <a href="gallery.php" class="btn btn-outline-primary btn-sm" style="font-weight: bold;">Galerie</a> poti admira niste modele remarcabile a celor de la Volvo.</p>
      </div>
    </div>
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
      <div class="container-fluid">
      <div class="row">
        <div class="col-lg topics">
          <?php if(isset($_GET['msg']) && $_GET['msg'] == 'succes') {
            echo ' <div class="alert alert-success alert-dismissible" id="alert">
                        Topicul a fost adaugat cu succes!
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                          </button>
                  </div>';
                }
          ?>
        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'successstatusdeleted') {
            echo ' <div class="alert alert-success alert-dismissible" id="alert">
                        <i class="fas fa-check-square"></i> Status update-ul a fost sters cu succes!
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                          </button>
                  </div>';
                }
          ?>
        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'deletefailed') {
            echo ' <div class="alert alert-success alert-dismissible" id="alert">
                        <i class="fas fa-exclamation-triangle"></i> A aparut o eroare la stergere. Va rugam sa incercati mai tarziu.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                          </button>
                  </div>';
                }
          ?>
          <div class="card">
            <div class="card-body" style="background-color: #4d4d4d; border-radius: 2px;">
              <div class="row">
                <div class="col">
                  <div class="input-group">
                    <form class="form-inline input-group-sm" action="includes/php/search.inc.php" method="POST">
                      <input class="form-control" type="text" name="topic-search" placeholder="Titlul topicului...">
                      <div class="input-group-append">
                        <button class="btn btn-success btn-sm radius-left-bottom-top" type="submit" name="search-topic"><i class="fas fa-search"></i> Cauta!</button>
                      </div>
                    </form>
                  </div>
                </div>
        <div class="col">
         <?php if(!isset($_GET['view']) && (isset($_SESSION['function']) && $_SESSION['function'] >= 1) && (isset($_SESSION['banned']) && $_SESSION['banned'] == 0)) { ?>
           <a href="forum.php?view=suspended" class="float-right btn btn-danger btn-sm"><i class="fa fa-window-close" aria-hidden="true"></i> Topicuri Suspendate</a>
         <?php } ?>
         <?php if(isset($_GET['view']) && $_GET['view'] == 'suspended') { ?>
           <a href="forum.php" class="float-right btn btn-success btn-sm"><i class="fa fa-check-square" aria-hidden="true"></i> Topicuri Nesuspendate</a>
         <?php } ?>

          <?php if((isset($_SESSION['verified']) && $_SESSION['verified'] == 1) && (isset($_SESSION['banned']) && $_SESSION['banned'] == 0)) { ?>
            <a href="forum.php?action=addpost" class="float-right btn btn-primary btn-sm" style="margin-right: 10px;"><i class="fa fa-plus" aria-hidden="true"></i> Adauga un Topic</a>
          <?php } elseif(isset($_SESSION['verified']) && $_SESSION['verified'] == 0) { ?>
            <span class="d-inline-block float-right" tabindex="0" data-toggle="tooltip" data-html="true" title='Contul nu este <b><u>ACTIVAT</u></b>. Verifica-ti email-ul pentru al activa.'>
              <a href="forum.php?action=addpost" class="btn btn-primary disabled btn-sm" style="pointer-events: none;"><i class="fa fa-plus" aria-hidden="true"></i> Adauga un Topic</a>
            </span>
          <?php } ?>
        </div>
      </div>
            </div>
          </div><br>
          <?php
            if(!isset($_GET['view']) && !isset($_GET['search'])) {
              require 'includes/php/connect.php';
              if(!isset($_GET['page']))
                        $page = 1;
                    else
                        $page = $_GET['page'];
                    $pagenumber = "SELECT * FROM posts WHERE suspended = 0";
                    $pagenumber = mysqli_query($con, $pagenumber);
                    $numberofresults = mysqli_num_rows($pagenumber);
                    $resultsperpage = 10;
                    $numberofpage = ceil($numberofresults/$resultsperpage);
                    if($numberofpage == 0)
                        $numberofpage ++;
                    $thispageresults = ($page - 1) * $resultsperpage;

            $sql = "SELECT * FROM posts WHERE suspended = 0 ORDER BY id DESC LIMIT ".$thispageresults.', '.$resultsperpage;;
            $query = mysqli_query($con, $sql);
            if(mysqli_num_rows($query) > 0) {
              while($row = mysqli_fetch_assoc($query)){
                $idpost = $row['id'];
                $usernamepost = $row['username'];
                $titlepost = $row['title'];
                $descriptionpost = $row['description'];
                $textpost = $row['textpost'];
                $publicdate = $row['publicdate'];
                $publicdate = strtotime($publicdate);
                $publicdate = date("d.m.Y", $publicdate);
                $likespost = $row['likes'];
                $commentspost = $row['comments'];

                    $sqlvisits = "SELECT visits FROM views WHERE idpost = '$idpost'";
                    $queryvisits = mysqli_query($con, $sqlvisits);
                    $row = mysqli_fetch_assoc($queryvisits);
                    $viewspost = $row['visits'];
          ?>
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col">
                    <h5><?php echo $titlepost; ?></h5>
                </div>
                <div class="col">
                  <small class="float-right">Publicat pe <?php echo $publicdate; ?></small>
                </div>
              </div>
            </div>
            <div class="card-body">
              <h5 class="card-title">Descriere: <?php echo $descriptionpost; ?></h5>
              <p class="card-text">Publicat de <b><u><?php echo $usernamepost; ?></u></b></p>
              <a href="forum.php?action=viewpost&idpost=<?php echo $idpost; ?>" class="btn btn-primary btn-sm"><b>Citeste mai mult</b></a>
              <div class="float-right">
              <i class="fa fa-heart" aria-hidden="true"></i> <?php echo $likespost;?> likes |
              <i class="fa fa-eye" aria-hidden="true"></i> <?php echo $viewspost;?> views |
              <i class="fa fa-comment" aria-hidden="true"></i> <?php echo $commentspost;?> comments
            </div>
            </div>
          </div><br>
          <?php 
            }
          }
        }
          ?>
          <?php
            if(!isset($_GET['view']) && isset($_GET['search'])) {
              require 'includes/php/connect.php';
              $search = $_GET['search'];
              $search = preg_replace('/[^a-z0-9]+/i', '', $search);
              $slqnumberpage = "SELECT * FROM posts WHERE suspended = 0";
              $numberofresults = 0;
              $results = mysqli_query($con, $slqnumberpage);
              while($rownumberpage = mysqli_fetch_assoc($results)) {
                if(preg_match("/{$search}/i", strtolower(preg_replace('/[^a-z0-9]+/i', '', $rownumberpage['title']))))
                  $numberofresults = $numberofresults + 1;
              }
              if(!isset($_GET['page']))
                        $page = 1;
                    else
                        $page = $_GET['page'];

                    $resultsperpage = 10;
                    $numberofpage = ceil($numberofresults / $resultsperpage);
                    if($numberofpage == 0)
                        $numberofpage ++;
                    $thispageresults = ($page - 1) * $resultsperpage;
          if($numberofresults != 0) {
            ?>
          <div class="alert alert-info">
            <h6>S-au gasit <?php echo $numberofresults; ?> rezultate pentru "<?php echo $search; ?>".</h6>
          </div>
            <?php } else { ?>
          <div class="alert alert-danger">
            <div class="row">
                <div class="col">
                  <i class="fas fa-frown"></i>  Din pacate nu a fost gasit nici un topic cu acest nume.
                </div>
                <div class="col">
                    <a href="forum.php" class="float-right" style="font-weight: 900;">Inapoi pe pagina principala</a>
                </div>
            </div>
        </div>
         <?php }
            $sql = "SELECT * FROM posts WHERE suspended = 0 ORDER BY id DESC LIMIT ".$thispageresults.', '.$resultsperpage;
            $query = mysqli_query($con, $sql);
            if(mysqli_num_rows($query) > 0) {
              while($row = mysqli_fetch_assoc($query)) {
                if(preg_match("/{$search}/i", strtolower(preg_replace('/[^a-z0-9]+/i', '', $row['title'])))) {
                      $idpost = $row['id'];
                      $usernamepost = $row['username'];
                      $titlepost = $row['title'];
                      $descriptionpost = $row['description'];
                      $textpost = $row['textpost'];
                      $publicdate = $row['publicdate'];
                      $publicdate = strtotime($publicdate);
                      $publicdate = date("d.m.Y", $publicdate);
                      $likespost = $row['likes'];
                      $commentspost = $row['comments'];

                    $sqlvisits = "SELECT visits FROM views WHERE idpost = '$idpost'";
                    $queryvisits = mysqli_query($con, $sqlvisits);
                    $row = mysqli_fetch_assoc($queryvisits);
                    $viewspost = $row['visits'];
          ?>
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col">
                    <h5><?php echo $titlepost; ?></h5>
                </div>
                <div class="col">
                  <small class="float-right">Publicat pe <?php echo $publicdate; ?></small>
                </div>
              </div>
            </div>
            <div class="card-body">
              <h5 class="card-title">Descriere: <?php echo $descriptionpost; ?></h5>
              <p class="card-text">Publicat de <b><u><?php echo $usernamepost; ?></u></b></p>
              <a href="forum.php?action=viewpost&idpost=<?php echo $idpost; ?>" class="btn btn-primary btn-sm"><b>Citeste mai mult</b></a>
              <div class="float-right">
              <i class="fa fa-heart" aria-hidden="true"></i> <?php echo $likespost;?> likes |
              <i class="fa fa-eye" aria-hidden="true"></i> <?php echo $viewspost;?> views |
              <i class="fa fa-comment" aria-hidden="true"></i> <?php echo $commentspost;?> comments
            </div>
            </div>
          </div><br>
          <?php 
              }
            }
          }
        } 
        ?>
          <?php

            if(isset($_GET['view']) && $_GET['view'] == 'suspended') {
              if(isset($_SESSION['username'])) {
              echo '<div class="alert alert-danger" role="alert">
                      <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Topicuri suspendate din diverse motive!
                    </div>';
            require 'includes/php/connect.php';

             if(!isset($_GET['page']))
                $page = 1;
            else
                $page = $_GET['page'];
                $pagenumber = "SELECT * FROM unbanrequests";
                $pagenumber = mysqli_query($con, $pagenumber);
                $numberofresults = mysqli_num_rows($pagenumber);
                $resultsperpage = 10;
                $numberofpage = ceil($numberofresults/$resultsperpage);
                $thispageresults = ($page - 1) * $resultsperpage;

            $sql = "SELECT * FROM posts WHERE suspended = 1 ORDER BY id DESC LIMIT ".$thispageresults.', '.$resultsperpage;
            $query = mysqli_query($con, $sql);
            if(mysqli_num_rows($query) > 0) {
              while($row = mysqli_fetch_assoc($query)){
                $idpost = $row['id'];
                $usernamepost = $row['username'];
                $titlepost = $row['title'];
                $descriptionpost = $row['description'];
                $textpost = $row['textpost'];
                $publicdate = $row['publicdate'];
                $publicdate = strtotime($publicdate);
                $publicdate = date("d.m.Y", $publicdate);
                $likespost = $row['likes'];
                $commentspost = $row['comments'];

                    $sqlvisits = "SELECT visits FROM views WHERE idpost = '$idpost'";
                    $queryvisits = mysqli_query($con, $sqlvisits);
                    $row = mysqli_fetch_assoc($queryvisits);
                    $viewspost = $row['visits'];
          ?>
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col">
                    <h5><?php echo $titlepost; ?></h5>
                </div>
                <div class="col">
                  <small class="float-right">Publicat pe <?php echo $publicdate; ?></small>
                </div>
              </div>
            </div>
            <div class="card-body">
              <h5 class="card-title">Descriere: <?php echo $descriptionpost; ?></h5>
              <p class="card-text">Publicat de <b><u><?php echo $usernamepost; ?></u></b></p>
              <a href="forum.php?action=viewpost&idpost=<?php echo $idpost; ?>" class="btn btn-primary btn-sm"><b>Citeste mai mult</b></a>
              <div class="float-right">
              <i class="fa fa-heart" aria-hidden="true"></i> <?php echo $likespost;?> likes |
              <i class="fa fa-eye" aria-hidden="true"></i> <?php echo $viewspost;?> views |
              <i class="fa fa-comment" aria-hidden="true"></i> <?php echo $commentspost;?> comments
            </div>
            </div>
          </div><br>
          <?php 
            }
          }
        } else {
          header('location: forum.php');
        }
      }
          ?>
          
      </div>
      <div class="col-lg-4 status-update">
        <div class="card">
          <h5 class="card-header" style="background-color: #4d4d4d; color: #ffffff;">Recent Status Updates</h5>
          <div class="card-body">
            <form action="includes/php/statusupdates.inc.php" method="POST">
            <textarea type="text" class="form-control card-text" name="status-update-text" placeholder="Ce este in mintea ta?" <?php if(!isset($_SESSION['username']) || $_SESSION['verified'] == 0 || $_SESSION['banned'] == 1) echo 'disabled'; ?> rows="2"></textarea><br>
            <button type="submit" class="btn btn-primary btn-sm" name="status-update-btn" style="float:right;" <?php if(!isset($_SESSION['username']) || $_SESSION['verified'] == 0 || $_SESSION['banned'] == 1) echo 'disabled'; ?> ><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Posteaza</button>
          </form>
       </div>
</div><br>
        <?php 
            require 'includes/php/connect.php';
            $sql =  "SELECT * FROM statusupdates ORDER BY id DESC LIMIT 5";
            $query = mysqli_query($con, $sql);
            while($row = mysqli_fetch_assoc($query)) {
              $usernameposter = $row['usernameposter'];
              $text = $row['textstatus'];
              $likes = $row['likes'];
              $idstatus = $row['id'];
              $nrofcomms = $row['nrcomms'];
              $sqlimg = "SELECT profileimgname , profileimgstatus FROM users WHERE username = '$usernameposter'";
              $queryimg = mysqli_query($con, $sqlimg);
              while($rowimg = mysqli_fetch_assoc($queryimg)) {
                  $profileimgname = $rowimg['profileimgname'];
                  $profileimgstatus = $rowimg['profileimgstatus'];
                 }
                $sqllikes = "SELECT * FROM likelogs WHERE idstatuslike = '$idstatus'";
                $querylikes = mysqli_query($con, $sqllikes);
                if(mysqli_num_rows($querylikes) > 0) {
                  while($rowlikes = mysqli_fetch_assoc($querylikes)) {
                    $userlike = $rowlikes['username'];
                     }
               } else {
                $userlike = NULL;
               }
        ?>
     <div class="card" style="margin-top: 10px;">
      <div class="card-body">
          <div class="row">
              <div class="col-md-2">
                <?php 
                   if($profileimgstatus == 0) {
                 ?>
                  <div class="profilestatusborderhome">
                    <img  src="includes/php/profilepictures/default.png" class="profilestatusimg">
                  </div>
                <?php 
                    } elseif($profileimgstatus == 1) {
                ?>
                  <div class="profilestatusborderhome">
                    <img  <?php echo "src=includes/php/profilepictures/".$profileimgname; ?> class="profilestatusimg">
                  </div>
                <?php 
                    }
                ?>
              </div>
              <div class="col-md-10">
                  <form action="includes/php/delete.inc.php" method="POST">
                      <a class="float-left" href="<?php echo 'profile.php?profil='.$usernameposter; ?>" ><strong><?php echo $usernameposter; ?></strong></a>
                      <?php if(isset($_SESSION['username']) && ($usernameposter == $_SESSION['username'] || $_SESSION['function'] > 0)) { ?>
                      <button type="button" class="float-right btn text-white btn-primary btn-sm" style="margin-left: 10px;" data-toggle="collapse" data-target="<?php echo '#editstatusform'.$idstatus; ?>" <?php if(isset($_SESSION['username']) && $_SESSION['username'] != $usernameposter && $_SESSION['function'] < 1) echo 'disabled'; ?> ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></i></button>
                       <button type="submit" class="float-right btn text-white btn-danger btn-sm" name="delete-status-update" <?php if(isset($_SESSION['username']) && $_SESSION['username'] != $usernameposter && $_SESSION['function'] < 2) echo 'disabled';?> value="<?php echo $idstatus; ?>"><i class="fas fa-trash-alt"></i></button>
                      <?php } ?>
                 </form>
                 <div class="clearfix"></div>
                  <p><?php echo $text; ?></p>
                  <p>
                    <form action="includes/php/statusupdates.inc.php" method="POST">
                      <input type="hidden" name="status-id-like" value="<?php echo $idstatus; ?>">
                      <button type="submit" class="float-right btn text-white btn-danger btn-sm" style="margin-left: 10px;" name="like-btn-status" 
                      <?php 
                      if(!isset($_SESSION['username'])) { 
                          echo 'disabled'; 
                        } else
                        if(isset($userlike)) { 
                            if($_SESSION['username'] == $userlike) { 
                                echo 'disabled';
                            }
                          }
                       ?> > <i class="fa fa-heart"></i> Like <?php echo $likes; ?></button>
                    </form>
                    <button class="float-right btn btn-outline-primary ml-2 btn-sm" data-toggle="collapse" data-target="<?php echo '#replyform'.$idstatus; ?>"><i class="fa fa-reply"></i> Reply</button>
                    <a href="<?php echo '#replys'.$idstatus; ?>" data-toggle="collapse" style="text-decoration: none;"><small><b>Arata raspunsuri <i class="fa fa-arrow-down" aria-hidden="true"></i></b></small></a>

                    <div id="<?php echo 'replyform'.$idstatus; ?>" class="collapse" style="margin-top: 15px;">
                         <div class="card">
                            <div class="card-body">
                              <form action="includes/php/statusupdates.inc.php" method="POST">
                                <input type="hidden" name="id-reply-status" value="<?php echo $idstatus; ?>">
                                <textarea type="text" class="form-control card-text" name="reply-text" rows="5" placeholder="Raspunde la <?php echo $usernameposter; ?>" <?php if(!isset($_SESSION['username']) || $_SESSION['verified'] == 0  || $_SESSION['banned'] == 1) echo 'disabled'; ?> rows="2"></textarea><br>
                                <button type="submit" class="btn btn-outline-warning btn-sm" name="reply-update-btn" style="float:right;" <?php if(!isset($_SESSION['username']) || $_SESSION['verified'] == 0  || $_SESSION['banned'] == 1) echo 'disabled'; ?> ><i class="fas fa-paper-plane"></i> Raspunde</button>
                            </form>
                            </div>
                          </div>
                      </div>
                      <div id="<?php echo 'editstatusform'.$idstatus; ?>" class="collapse" style="margin-top: 15px;">
                         <div class="card">
                            <h5 class="card-header">Editeaza-ti statusul</h5>
                            <div class="card-body">
                              <form action="includes/php/statusupdates.inc.php" method="POST">
                                <input type="hidden" name="status-id" value="<?php echo $idstatus; ?>">
                                <textarea type="text" class="form-control card-text"  name="edit-status-text" rows="5" placeholder="Editeaza-ti Status Update" <?php if(!isset($_SESSION['username'])) echo 'disabled'; ?> ><?php echo $row['textstatus']; ?></textarea><br>
                                <button type="submit" class="btn btn-outline-warning btn-sm" name="edit-status-btn" style="float:right;" <?php if(!isset($_SESSION['username'])) echo 'disabled'; ?> ><i class="fas fa-edit"></i> Editeaza</button>
                            </form>
                            </div>
                          </div>
                      </div>
            <div id="<?php echo 'replys'.$idstatus; ?>" class="collapse" style="margin-top: 15px;">

                            <?php 
                            require 'includes/php/connect.php';
                            $sql1 =  "SELECT * FROM replystatusupdates WHERE idstatusreply = '$idstatus' ORDER BY id DESC LIMIT 5";
                            $query1 = mysqli_query($con, $sql1);
                            if(mysqli_num_rows($query1)) {
                                while($row1 = mysqli_fetch_assoc($query1)) {
                                  $idreply = $row1['id'];
                                  $usernamereply = $row1['usernamereply'];
                                  $textreply = $row1['textreply'];
                                  $likes = $row1['likes'];

                                  $sqlimg = "SELECT profileimgname , profileimgstatus FROM users WHERE username = '$usernamereply'";
                                  $queryimg = mysqli_query($con, $sqlimg);
                                  while($rowimg = mysqli_fetch_assoc($queryimg)) {
                                      $profileimgname = $rowimg['profileimgname'];
                                      $profileimgstatus = $rowimg['profileimgstatus'];
                                    }
                                  $sqllikes = "SELECT username FROM likelogs WHERE idreplylike = '$idreply'";
                                  $querylikes = mysqli_query($con, $sqllikes);
                                  if(mysqli_num_rows($querylikes) > 0) {
                                    while($rowlikes = mysqli_fetch_assoc($querylikes)) {
                                      $userlike = $rowlikes['username'];
                                  }
                                  } else {
                                    $userlike = NULL;
                                  }
                            ?>
                               <div class="card">
                                      <div class="card-body">
                                          <div class="row">
                                              <div class="col-md-2">
                                                  <?php 
                                                     if($profileimgstatus == 0) {
                                                   ?>
                                                    <div class="profilestatusborderhomereply">
                                                      <img  src="includes/php/profilepictures/default.png" class="profilestatusimg">
                                                    </div>
                                                  <?php 
                                                      } elseif($profileimgstatus == 1) {
                                                  ?> 
                                                    <div class="profilestatusborderhomereply">
                                                      <img  <?php echo "src=includes/php/profilepictures/".$profileimgname; ?> class="profilestatusimg">
                                                    </div>
                                                  <?php 
                                                      }
                                                  ?>
                                              </div>
                                              <div class="col-md-10">
                                                  <form action="includes/php/delete.inc.php" method="POST">
                                                      <a class="float-left" href="<?php echo 'profile.php?profil='.$usernamereply; ?>"><strong><?php echo $usernamereply; ?></strong></a>
                                                      <?php if(isset($_SESSION['username']) && ($usernameposter == $_SESSION['username'] || $_SESSION['function'] > 0)) { ?>
                                                      <button type="button" class="float-right btn text-white btn-primary btn-sm" style="margin-left: 10px;" data-toggle="collapse" data-target="<?php echo '#editreplyform'.$idreply; ?>" <?php if(isset($_SESSION['username']) && $_SESSION['username'] != $usernameposter && $_SESSION['function'] < 1) echo 'disabled'; ?> ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></i></button>
                                                      <button type="submit" class="float-right btn text-white btn-danger btn-sm" name="delete-reply" <?php if(isset($_SESSION['username']) && $_SESSION['username'] != $usernameposter && $_SESSION['function'] < 2) echo 'disabled';?> value="<?php echo $idreply; ?>"><i class="fas fa-trash-alt"></i></button>
                                                    <?php } ?>
                                                 </form>
                                                 <div class="clearfix"></div>
                                                  <p><?php echo $textreply; ?></p>
                                                  <p> 
                                                      <form action="includes/php/statusupdates.inc.php" method="POST">
                                                          <input type="hidden" name="reply-id" value="<?php echo $idreply; ?>">
                                                          <button class="float-right btn text-white btn-danger btn-sm" name="like-btn-reply"
                                                          <?php if(!isset($_SESSION['username'])) { 
                                                            echo 'disabled'; 
                                                          } elseif(isset($userlike)) { 
                                                            if($_SESSION['username'] == $userlike) { 
                                                              echo 'disabled';
                                                            }
                                                            } ?> > <i class="fa fa-heart"></i> Like <?php echo $likes; ?></button>
                                                      </form>
                                                 </p>
                                              </div>
                                          </div>
                                      </div>
                                      </div>
                                      <div id="<?php echo 'editreplyform'.$idreply; ?>" class="collapse" style="margin-top: 10px;">
                                       <div class="card">
                                          <h5 class="card-header">Editeaza raspuns</h5>
                                          <div class="card-body">
                                            <form action="includes/php/statusupdates.inc.php" method="POST">
                                              <input type="hidden" name="reply-status-id" value="<?php echo $idreply; ?>">
                                              <textarea type="text" class="form-control card-text"  name="reply-edit-text" rows="5" placeholder="Edit Status Update" <?php if(!isset($_SESSION['username'])) echo 'disabled'; ?> ><?php echo $row1['textreply']; ?></textarea><br>
                                              <button type="submit" class="btn btn-primary btn-sm" name="reply-edit-btn" style="float:right;" <?php if(!isset($_SESSION['username'])) echo 'disabled'; ?> >Editeaza</button>
                                          </form>
                                          </div>
                                        </div>
                                    </div>
                                <?php 
                                }
                            } else {
                                ?>
                                <div class="card">
                                  <div class="card-body">
                                    Momentan nu are nici un raspuns.
                                  </div>
                                </div>
                           <?php } ?>
                            </div>
                         </p>
                      </div>
                  </div>
              </div>
            </div>
            <?php 
              }
              ?>
            </div>
          </div>
          <hr>
            <nav>
              <ul class="pagination justify-content-start">
                <li class="page-item <?php if(!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] == 1 )) echo 'disabled'; ?>">
                  <a class="page-link" href="forum.php?<?php if(isset($_GET['search'])) echo 'search='.$_GET['search'].'&'; ?><?php if(isset($_GET['view'])) echo 'view=suspended&'; ?>page=<?php echo $page - 1; ?>"><i class="fa fa-fast-backward" aria-hidden="true"></i></a>
                </li>
                <?php for($i = 1; $i <= $numberofpage; $i++) { ?>
                    <li class="page-item <?php if($i == $page) echo 'active' ?>"><a class="page-link" href="forum.php?<?php if(isset($_GET['search'])) echo 'search='.$_GET['search'].'&'; ?><?php if(isset($_GET['view'])) echo 'view=suspended&'; ?>page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php } ?>
                <li class="page-item <?php if((isset($_GET['page']) && $_GET['page'] == $numberofpage) || (!isset($_GET['page']) && $numberofpage == 1)) echo 'disabled'; ?>">
                  <a class="page-link" href="forum.php?<?php if(isset($_GET['search'])) echo 'search='.$_GET['search'].'&'; ?><?php if(isset($_GET['view'])) echo 'view=suspended&'; ?>page=<?php echo $page + 1; ?>"><i class="fa fa-fast-forward" aria-hidden="true"></i></a>
                </li>
              </ul>
            </nav><br><br>
       </div> <!-- /.container -->
       <?php 
        }
      ?>
      <script type="text/javascript">
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
      </script>

      <?php 
        if(isset($_GET['action']) && $_GET['action'] == 'addpost')
        {
      ?>
        <div class="container marketing">
          <br><br>
          <?php if(isset($_GET['msg']) && $_GET['msg'] == 'emptyfields') {
               echo '<div class="alert alert-danger alert-dismissible" id="alert">
                        Toate campurile trebuie completate!
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                      </button>
                </div>';
              }
              ?>
              <?php if(isset($_GET['msg']) && $_GET['msg'] == 'stmtfail') {
               echo '<div class="alert alert-danger alert-dismissible" id="alert">
                        A aparut o eroare! Incercati din nou.
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                      </button>
                </div>';
              }
              ?>
          <div class="card">
            <h5 class="card-header">Adauga un nou topic</h5>
            <div class="card-body">
              <form class="form-group" action="includes/php/addpost.inc.php" method="POST">
                <label for="title">Titlu*: </label>
                <input type="text" class="form-control" id="title" name="title"><br>
                <label for="description">O mica descriere*: </label>
                <input type="text" class="form-control" id="description" name="description"><br>
                <label for="textpost">Topicul*: </label>
                <textarea name="textpost" id="textpost"></textarea>
            </div>
            <div class="card-footer text-muted">
              <button type="submit" name="addpost-btn" class="btn btn-primary float-right"><i class="far fa-paper-plane"></i> Posteaza</button>
              </form>
            </div>
          </div>
        </div><br><br>
        <script src="includes/ckeditor/ckeditor.js"></script>
          <script>
              CKEDITOR.replace('textpost');
          </script>
      <?php 
        }
      ?>


      <?php 
        if(isset($_GET['action']) && $_GET['action'] == 'viewpost') {
          $idpost = $_GET['idpost'];
          require 'includes/php/connect.php';
        ?>
        <?php
          require 'includes/php/connect.php';
          $sql = "SELECT * FROM posts WHERE id = '$idpost'";
          $query = mysqli_query($con, $sql);
          while($row = mysqli_fetch_assoc($query)) {
            $titlepost = $row['title'];
            $textpost = $row['textpost'];
            $descriptionpost = $row['description'];
          }
         ?>

           <?php if(isset($_GET['msg']) && $_GET['msg'] == 'success') { ?>
            <script>
                $(document).ready(function(){
                    $("#successmodal").modal('show');
                });
            </script>
          <?php } ?>
          <?php if(isset($_GET['msg']) && $_GET['msg'] == 'reported') { ?>
            <script>
                $(document).ready(function(){
                    $("#reportedmodal").modal('show');
                });
            </script>
          <?php } ?>
        <!-- <! SUCCESS MODAL !> -->
        <div class="modal fade" id="successmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="alert alert-success">
                <center>
                  <i class="fas fa-fw fa-9x fa-check-square"></i>
                  <p style="font-weight: 900; font-size: 30px; margin-top: 10px;">Actiunea a fost executata cu succes!</p>
                </center>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- <! SUCCESS MODAL !> -->

        <!-- <! REPORTED MODAL !> -->
        <div class="modal fade" id="reportedmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="alert alert-warning">
                <center>
                  <i class="fas fw fa-9x fa-flag-checkered"></i>
                  <p style="font-weight: 900; font-size: 30px; margin-top: 10px;">Acest topic a fost raportat deja de tine!</p>
                </center>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- <! REPORTED MODAL !> -->

         <div class="modal fade" id="editpostmodal" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <div class="modal-content" style="background-color: #FFFFFF;">
                <div class="modal-header" style="background-color: #4d4d4d; color: #ffffff;">
                  <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editeaza Topic "<?php echo $titlepost; ?>"</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form class="form-group" method="POST" action="includes/php/addpost.inc.php">
                  <div class="modal-body">
                    <input type="hidden" name="id_edit_post" value="<?php echo $idpost; ?>">
                    <label><small><b>Titlu: </b></small></label>
                    <input type="text" class="form-control" name="edit-title" value="<?php echo $titlepost; ?>"><br>
                    <label><small><b>Descriere: </b></small></label>
                    <input type="text" class="form-control" name="description" value="<?php echo $descriptionpost; ?>"><br>
                    <label><small><b>Text: </b></small></label>
                    <textarea class="form-control" name="edittext" id="edittext"><?php echo $textpost; ?></textarea><br>
                  </div>
                  <div class="modal-footer">
                      <button class="btn btn-danger btn-sm" type="button" data-dismiss="modal">Close</button>
                      <button class="btn btn-primary btn-sm" type="submit" name="edit-post-btn">Editeaza Topic!</button>
                      </form>
                    </div>
                  </div>
              </div>
            </div>
            <script src="includes/ckeditor/ckeditor.js"></script>
            <script>
              CKEDITOR.replace('edittext');
          </script>
          </div>


          <?php
          require 'includes/php/connect.php';
          $sql = "SELECT * FROM posts WHERE id = '$idpost'";
          $query = mysqli_query($con, $sql);
          while($row = mysqli_fetch_assoc($query)) {
            $titlepost = $row['title'];
            $userpost = $row['username'];
          }
         ?>

          <div class="modal fade" id="reporttopicmodal" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <div class="modal-content" style="background-color: #ECF0F1;">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Raporteaza Topic</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form class="form-group" method="POST" action="includes/php/addpost.inc.php">
                  <div class="modal-body">
                    <p>Esti pe cale sa raportezi topicul <strong><?php echo $titlepost; ?></strong> creat de <strong><?php echo $userpost ?></strong>. Orice report aiurea se sanctioneaza cu <strong>BAN</strong>!</p>
                    <input type="hidden" name="id-reported-post" id="id-reported-post" value="<?php echo $idpost; ?>">
                    <input type="hidden" name="title-report-post" id="title-report-post" value="<?php echo $titlepost; ?>">
                    <input type="hidden" name="user-report-post" id="user-report-post" value="<?php echo $userpost; ?>">
                    <label>De ce vrei sa raportezi acest topic? : </label>
                    <textarea class="form-control" name="report-details" id="report-details" placeholder="Detaliaza aici..." required></textarea><br>
                    <center>
                        <button class="btn btn-primary" type="submit" name="report-post-btn">Send Report</button>
                    </center>
                  </div>
                </form>
              </div>
            </div>
            <script src="includes/ckeditor/ckeditor.js"></script>
            <script>
              CKEDITOR.replace( 'report-details' );
          </script>
          </div>

              <!-- DELETE CONFIRMATION TOPIC MODAL -->

            <!-- Modal -->
            <div id="deletetopicmodal" class="modal fade" data-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Confirmare stergere topic "<?php echo $titlepost; ?>"!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="includes/php/delete.inc.php" method="POST">
                  <div class="modal-body">
                    <input type="hidden" name="deletetopicid" value="<?php echo $idpost; ?>">
                    <input type="hidden" name="deletetopicuser" value="<?php echo $userpost; ?>">
                    <input type="hidden" name="deletetopictitle" value="<?php echo $titlepost; ?>">
                    <p>Esti sigur ca vrei sa stergi topicul "<b><?php echo $titlepost; ?></b>"?</p>
                    <p class="text-secondary"><small>Daca apesi butonul <span class="badge badge-danger">Delete</span>, procesul va fi ireversibil.</small></p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger btn-sm" name="deletetopic">Delete</button>
                  </div>
                </form>
                </div>
              </div>
            </div>
  <!-- DELETE CONFIRMATION TOPIC MODAL END -->

                <!-- SUSPEND TOPIC MODAL -->

            <!-- Modal -->
            <div id="suspendtopicmodal" class="modal fade" data-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Confirmare suspendare topic "<?php echo $titlepost; ?>"!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="includes/php/delete.inc.php" method="POST">
                  <div class="modal-body">
                    <input type="hidden" name="suspendtopicid" value=<?php echo $idpost; ?>>
                    <input type="hidden" name="suspendtopicuser" value=<?php echo $userpost; ?>>
                    <input type="hidden" name="suspendtopictitle" value=<?php echo $titlepost; ?>>
                    <p>Esti sigur ca vrei sa ascunzi topicul "<b><?php echo $titlepost; ?></b>"?</p>
                    <p class="text-secondary"><small>Daca apesi butonul <span class="badge badge-warning">Suspend</span> topicul va putea fi vazut doar de administratori. Acesta poate fi oricand reafisat.</small></p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning btn-sm" name="suspend-topic">Suspend</button>
                  </div>
                </form>
                </div>
              </div>
            </div>
  <!-- SUSPEND TOPIC MODAL END -->

                  <!-- SUSPEND TOPIC MODAL -->

            <!-- Modal -->
            <div id="unsuspendtopicmodal" class="modal fade" data-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Confirmare reafisare topic "<?php echo $titlepost; ?>"!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="includes/php/delete.inc.php" method="POST">
                  <div class="modal-body">
                    <input type="hidden" name="unsuspendtopicid" value=<?php echo $idpost; ?>>
                    <input type="hidden" name="unsuspendtopicuser" value=<?php echo $userpost; ?>>
                    <input type="hidden" name="unsuspendtopictitle" value=<?php echo $titlepost; ?>>
                    <p>Esti sigur ca vrei sa reafisezi topicul "<b><?php echo $titlepost; ?></b>"?</p>
                    <p class="text-secondary"><small>Daca apesi butonul <span class="badge badge-warning">Unsuspend</span> topicul va putea fi vazut de toti utilizatori.</small></p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning btn-sm" name="unsuspended-topic">Unsuspend</button>
                  </div>
                </form>
                </div>
              </div>
            </div>
  <!-- SUSPEND TOPIC MODAL END -->



         <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
          </ol>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="img/slide1.1.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block opacity-background">
                  <h5>Bun Venit pe Forumul VolvoFAN.ro</h5>
                  <p>Aici este locul unde poti gasii raspuns la orice intrebare.</p>
                </div>
              </div>
              <div class="carousel-item">
                <img src="img/slide3.3.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block opacity-background">
                  <h5>Doresti sa afli mai multe despre "Volvo"?</h5>
                  <p>Poti accesa sectiunea "Istoria Volvo" <a href="history.php" style="font-weight: bold;" class="btn btn-outline-primary btn-sm">Apasand Aici</a> in care este prezentata istoria marcii.</p>
                </div>
              </div>
              <div class="carousel-item">
                <img src="img/slide2.2.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block opacity-background">
                  <h5>Vrei sa vezi masinile care i-au consacrat pe cei de la Volvo?</h5>
                  <p>La sectiunea <a href="gallery.php" class="btn btn-outline-primary btn-sm" style="font-weight: bold;">Galerie</a> poti admira niste modele remarcabile a celor de la Volvo.</p>
                </div>
              </div>
            </div>
          <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div><br><br>
        <?php
          require 'includes/php/connect.php';

          $sqlvisits = "SELECT visits FROM views WHERE idpost = '$idpost'";
          $queryvisits = mysqli_query($con, $sqlvisits);
          if(mysqli_num_rows($queryvisits) > 0) {
            $row = mysqli_fetch_assoc($queryvisits);
            $views = $row['visits'];
          }

          if(isset($_SESSION['username'])) {
            $usernamelike = $_SESSION['username'];
            $sqllikes = "SELECT * FROM likelogs WHERE idpostlike = '$idpost' AND username = '$usernamelike'";
            $querylikes = mysqli_query($con, $sqllikes);
            if(mysqli_num_rows($querylikes) > 0) {
              $row = mysqli_fetch_assoc($querylikes);
              $userlike = $row['username'];
            } else {
              $userlike = NULL;
            }
          }

          $sql = "SELECT * FROM posts WHERE id = '$idpost'";
          $query = mysqli_query($con, $sql);
          if(mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            $usernamepost = $row['username'];
            $titlepost = $row['title'];
            $textpost = $row['textpost'];
            $likes = $row['likes'];
            $comments = $row['comments'];
            $publicdate = $row['publicdate'];
            $publicdate = strtotime($publicdate);
            $publicdate = date("d.m.Y", $publicdate);
            $suspended = $row['suspended'];
            $usernamesuspender = $row['usersuspender'];
            if($suspended == 0) {
              $sql = "UPDATE views SET visits = visits + 1 WHERE idpost = '$idpost'";
              mysqli_query($con, $sql);
            }

      ?>
      <div class="container marketing">
        <?php  if($suspended == 1) { ?>
        <div class="alert alert-danger alert-dismissible" id="alert">
           <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Acest topic a fost ascuns de catre administratorul <b><a style="text-decoration: none; color: #000;" href="<?php echo 'profile.php?profil='.$usernamesuspender; ?>"><?php echo $usernamesuspender; ?></a></b> deoarece nu respecta politicile VolvoFAN.ro.
        </div>
      <?php } ?>
    <div class="card">
        <div class="card-header">
            <div class="row">
              <div class="col">
                <h4><?php echo $titlepost; ?></h4>
                <small class="card-title">Postat de <?php echo $usernamepost; ?> pe data de <?php echo $publicdate; ?></small>
              </div>
              <div class="col">
                <div class="float-right">
                  <small class="text-black-50">
                    <i class="fa fa-heart" aria-hidden="true"></i> <?php echo $likes;?> likes |
                    <i class="fa fa-eye" aria-hidden="true"></i> <?php echo $views;?> views |
                    <i class="fa fa-comment" aria-hidden="true"></i> <?php echo $comments;?> comments
                  </small>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="card-text resizeposimg"><?php echo $textpost; ?></div>
          </div>
          <div class="card-footer">
            <form action="includes/php/addpost.inc.php" method="POST">
              <input type="hidden" name="id-post-liked" value=<?php echo $idpost; ?>>
              <button class="float-right btn btn-danger btn-sm" name="like-post-btn" <?php if(!isset($_SESSION['username'])) {  echo 'disabled'; } elseif(isset($userlike)) {  if($_SESSION['username'] == $userlike) { echo 'disabled';}} ?>><i class="fa fa-heart" aria-hidden="true"></i> Like</button>
            </form>
            <?php if((isset($_SESSION['username']) && $usernamepost == $_SESSION['username']) || (isset($_SESSION['function']) && $_SESSION['function'] >= 1)) {?>
            <a href="#editpostmodal" class="btn btn-primary btn-sm" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editeaza</a>
          <?php } ?>
          <?php if((isset($_SESSION['username']) && $_SESSION['username'] != $usernamepost) && (isset($_SESSION['function']) && $_SESSION['function'] == 0)) { ?>
            <a href="#reporttopicmodal" class="btn btn-secondary btn-sm <?php if(isset($_SESSION['banned']) && $_SESSION['banned'] == 1) echo 'disabled' ?>" data-toggle="modal"><i class="fa fa-flag" aria-hidden="true"></i> Raporteaza acest Topic</a>
          <?php } ?>
          <?php if(isset($_SESSION['function']) && $_SESSION['function'] > 0 && $suspended == 0  && $_SESSION['banned'] == 0) { ?>
            <a href="#suspendtopicmodal" class="btn btn-warning btn-sm" data-toggle="modal"><i class="fa fa-eye-slash" aria-hidden="true"></i> Ascunde acest Topic</a>
          <?php } ?>
          <?php if(isset($_SESSION['function']) && $_SESSION['function'] > 0 && $suspended == 1  && $_SESSION['banned'] == 0) { ?>
              <a href="#unsuspendtopicmodal" class="btn btn-warning btn-sm" data-toggle="modal"><i class="fa fa-eye" aria-hidden="true"></i> Pune la vedere acest Topic</a>
            </form>
          <?php } ?>
          <?php if(isset($_SESSION['function']) && $_SESSION['function'] == 3 && $_SESSION['banned'] == 0) { ?>
            <a href="#deletetopicmodal" class="btn btn-danger btn-sm" data-toggle="modal"><i class="fa fa-trash-o" aria-hidden="true"></i> Sterge acest Topic</a>
          <?php } ?>
          </div>
        </div><br>
    <div class="card" style="margin-bottom: 80px;">
        <h6 class="card-header"><i class="fas fa-comments"></i> Comentarii</h6>
        <div class="card-body">
            <div class="card-text">
            <?php if(isset($_SESSION['username']) && $_SESSION['banned'] == 0 && $suspended == 0) { ?>
              <div class="card">
                <div class="card-header">Comenteaza ca si <?php echo $_SESSION['username']; ?></div>
                <div class="card-body">
                  <div class="card-text">
                    <form action="includes/php/postcomments.inc.php" method="POST">
                      <input type="hidden" name="id_post_comment" id="id_post_comment" value="<?php echo $idpost; ?>">
                    <textarea class="form-control" name="postcomment" id="postcomment"></textarea>
                  </div><br>
                  <button type="submit" name="post-comment-btn" class="btn btn-primary float-right btn-sm"><i class="fas fa-paper-plane"></i> Pozteaza</button>
                </form>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>

            <?php 
              require 'includes/php/connect.php';
              $sql = "SELECT * FROM postcomments WHERE idpost = '$idpost' ORDER BY id DESC";
              $query = mysqli_query($con, $sql);
              if(mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_assoc($query)){
                  $idcomm = $row['id'];
                  $usernamecom = $row['usernamecommpost'];
                  $textcomm = $row['postcomment'];
                $sqlimg = "SELECT profileimgname, profileimgstatus FROM users WHERE username = '$usernamecom'";
                $queryimg = mysqli_query($con, $sqlimg);
                while($rowimg = mysqli_fetch_assoc($queryimg)) {
                  $profileimgstatus = $rowimg['profileimgstatus'];
                  $profileimgname = $rowimg['profileimgname'];
                }
            ?>

          <div class="card" style="margin-left: 20px; margin-right: 20px; margin-bottom: 10px;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <?php 
                           if(!isset($profileimgstatus) || $profileimgstatus == 0) {
                         ?>
                          <div class="profilestatusborder">
                            <img src="includes/php/profilepictures/default.png" class="profilestatusimg">
                          </div>
                        <?php 
                            } elseif($profileimgstatus == 1) {
                        ?>
                          <div class="profilestatusborder">
                            <img  class="profilestatusimg" <?php echo "src=includes/php/profilepictures/".$profileimgname; ?> class="img img-rounded img-fluid">
                          </div>
                        <?php 
                            }
                        ?>
                    </div>
                    <div class="col-md-10">
                      <form action="includes/php/delete.inc.php" method="POST">
                        <input type="hidden" name="delete-id-post-comm" value="<?php echo $idpost; ?>">
                        <input type="hidden" name="delete-name-post-comm" value="<?php echo $titlepost; ?>">
                            <a class="float-left" href="<?php echo 'profile.php?profil='.$usernamecom; ?>"><strong><?php echo $usernamecom; ?></strong></a>
                            <?php if((isset($_SESSION['username']) && $usernamecom == $_SESSION['username']) || (isset($_SESSION['function']) && $_SESSION['function'] >= 1)) { ?>
                            <a class="btn btn-sm btn-primary float-right" style="margin-left: 10px;" data-toggle="collapse" role="button" href="#editform<?php echo $idcomm; ?>" aria-expanded="false" aria-controls="collapseExample" <?php if(isset($_SESSION['username']) && $_SESSION['username'] != $usernamecom && $_SESSION['function'] <= 1) echo 'disabled'; ?> ><i class="fas fa-edit"></i></a>
                            <button class="btn btn-sm btn-danger float-right" type="submit" name="delete-comm-post" value="<?php echo $idcomm; ?>" <?php if(isset($_SESSION['username']) && $_SESSION['username'] != $usernamecom && $_SESSION['function'] <= 1) echo 'disabled'; ?>><i class="fas fa-trash-alt"></i></button>
                            <?php } ?>
                     </form>
                       <div class="clearfix"></div>
                        <p><?php echo $textcomm; ?></p>
                        <div class="collapse" id="editform<?php echo $idcomm; ?>">
                          <div class="card card-body">
                            <form class="form-group" action="includes/php/postcomments.inc.php" method="POST">
                              <input type="hidden" name="id-edit-post-comm" value="<?php echo $idcomm; ?>">
                              <textarea class="form-control" name="edit-text-comm" rows="5"><?php echo $textcomm; ?></textarea><br>
                              <button class="btn btn-sm btn-outline-warning float-right" name="submit-edit-text-comm"><i class="fas fa-edit"></i> Editeaza</button>
                            </form>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            }
          } else {
        ?>
    <div class="card">
      <div class="card-body">
        <center><h5 class="card-text">Momentan nu este nici un comentariu. Fi tu primu care comenteaza!</h5></center>
      </div>
</div>
</div>
<?php 
  }
?>
    <?php } else { ?>
      <div class="container">
          <div class="alert alert-danger">
            <b>Din pacate atest topic nu mai exista, deoarece a fost sters de catre administratorii VolvoFAN.ro</b>
          </div>
        </div>
    <?php } 
      }
      ?>

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