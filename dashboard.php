<?php  
	session_start();
    unset($_SESSION["pagename"]);
    $_SESSION['pagename'] = basename($_SERVER['PHP_SELF']);

    unset($_SESSION['sortdates']);

     if (isset($_SESSION['loggedtime']) && (time() - $_SESSION['loggedtime'] > 1800)) {
      session_destroy();
      session_unset();
      header('location: index.php?status=loggedout');
      } else {
        $_SESSION['loggedtime'] = time();
      }

      if(!isset($_SESSION['username'])) {
        header('location: index.php?status=loggedout');
      }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="refresh" content="1800;url=includes/php/logout.inc.php" />
    <link rel="icon" href="img/dashboardicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="includes/dashboard/css/bootadmin.css">
    <link href="includes/style.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">    
    <script src="https://kit.fontawesome.com/0c4d35ef60.js" crossorigin="anonymous"></script>

        <!-- Boostrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.2.7/purify.min.js" integrity="sha512-srKA/HGYuusMcB2uqsvHKmqqE39vHU74WIuPBaKS5+wtfI6NquGXQtby+eM7o139a7Gt3szcHS09wou8GK4IJQ==" crossorigin="anonymous"></script>

    <title>DashBoard VolvoFAN.ro</title>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand navbar-dark bg-primary">
        <a class="sidebar-toggle mr-3" href="#"><i class="fa fa-bars"></i></a>
        <div class="logo">
            <a class="navbar-brand" href="index.php">VolvoFAN.ro DashBoard</a>
        </div>

        <div class="navbar-collapse dropdown show">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown active">
                    <a href="#" class="nav-link dropdown-toggle" role="button" id="dropdownmenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 16px; font-weight: bold;">Welcome <i class="fa fa-user"></i><?php echo ' '.$_SESSION['username'] ?></a>
                    <div class="dropdown-menu" aria-labelledby="dropdownmenu" id="dropdownmenu" style="width: 200px;">
                        <a href="index.php" class="dropdown-item"><i class="fa fa-home" aria-hidden="true"></i> Acasa</a>
                        <a href=profile.php?profil=<?php echo $_SESSION['username']; ?> class="dropdown-item"><i class="fa fa-user" aria-hidden="true"></i> Profilul tau</a>
                        <a class="dropdown-item active" href="dashboard.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a>
                        <div class="dropdown-divider"></div>
                        <a href="includes/php/logout.inc.php" class="dropdown-item"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="d-flex">
        <div class="sidebar sidebar-dark bg-dark">
            <ul class="list-unstyled">
                <li <?php if(!isset($_GET['action'])) {echo 'class="active"';} ?>><a href="dashboard.php"><i class="fa fa-fw fa-tachometer-alt"></i> Dashboard</a></li>
                <li <?php if(isset($_GET['action']) && $_GET['action'] == 'staff') {echo 'class="active"';} ?>><a href="dashboard.php?action=staff"><i class="fas fa-users-cog"></i> Staff</a></li>
                <li <?php if(isset($_GET['action']) && $_GET['action'] == 'users') {echo 'class="active"';} ?>><a href="dashboard.php?action=users"><i class="fa fa-users" aria-hidden="true"></i> Utilizatori</a></li>
                <li <?php if(isset($_GET['action']) && $_GET['action'] == 'bugreports') {echo 'class="active"';} ?>><a href="dashboard.php?action=bugreports"><i class="fa fa-bug" aria-hidden="true"></i> Bug Reports <span class="badge badge-danger">
                	<?php 
                		require 'includes/php/connect.php';

                        $sql = "SELECT id FROM bugreport WHERE status = 0";
                        $result = mysqli_query($con, $sql);
                        echo mysqli_num_rows($result);
                	?></span></a></li>

                <li <?php if(isset($_GET['action']) && $_GET['action'] == 'postreports') {echo 'class="active"';} ?> ><a href="dashboard.php?action=postreports"><i class="fa fa-flag" aria-hidden="true"></i> Reclamatii <span class="badge badge-danger">
                    <?php 
                        require 'includes/php/connect.php';

                        $sql = "SELECT id FROM postreports WHERE status = 0";
                        $result = mysqli_query($con, $sql);
                        echo mysqli_num_rows($result);
                    ?></span></a></li>

                <li <?php if(isset($_GET['action']) && $_GET['action'] == 'banlist') {echo 'class="active"';} ?> ><a href="dashboard.php?action=banlist"><i class="fa fa-list" aria-hidden="true"></i> Ban List <span class="badge badge-danger">
                    <?php 
                        require 'includes/php/connect.php';
                        $now = date('Y-m-d', time());
                        $sql = "SELECT * FROM banlist WHERE unbandate > '$now' OR permanentbanned = 1";
                        $result = mysqli_query($con, $sql);
                        echo mysqli_num_rows($result);
                    ?></span></a></li>


                <li <?php if(isset($_GET['action']) && $_GET['action'] == 'unbanrequests') {echo 'class="active"';} ?> ><a href="dashboard.php?action=unbanrequests"><i class="fa fa-ban" aria-hidden="true"></i> Cereri de Debanare <span class="badge badge-danger">
                    <?php 
                        require 'includes/php/connect.php';

                        $sql = "SELECT id FROM unbanrequests WHERE status = 0";
                        $result = mysqli_query($con, $sql);
                        echo mysqli_num_rows($result);
                    ?></span></a></li>
            </ul>
        </div>
        <script type="text/javascript">
            $('.sidebar-toggle').on('click', function (e) {
                e.preventDefault();
                $('.sidebar').toggleClass('toggled');
            });
        </script>
 <?php
 	if(!isset($_GET['action'])) {
        unset($_SESSION['sorttext']);
        unset($_SESSION['searchusername']);
 ?>
        <div class="content p-4">
        	
                <h2 class="mb-4">Dashboard</h2>

    <div class="row mb-4">
        <div class="col-md">
            <div class="d-flex border">
                <div class="bg-danger text-light p-4">
                    <div class="d-flex align-items-center h-100">
                        <i class="fas fa-3x fa-fw  fa-ban"></i>
                    </div>
                </div>
                <div class="flex-grow-1 bg-white p-4">
                    <p class="text-uppercase text-secondary mb-0">Conturi Banate</p>
                    <?php 
                    	require 'includes/php/connect.php';
                        $now = date('Y-m-d', time());
                    	$sql = "SELECT * FROM banlist WHERE unbandate > '$now' OR permanentbanned = 1";
                        $results = mysqli_query($con, $sql);
                    ?>
                    <h3 class="font-weight-bold mb-0"><?php echo mysqli_num_rows($results); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="d-flex border">
                <div class="bg-secondary text-light p-4">
                    <div class="d-flex align-items-center h-100">
                        <i class="fa fa-3x fa-fw fa-flag-checkered" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="flex-grow-1 bg-white p-4">
                    <p class="text-uppercase text-secondary mb-0">Reclamatii</p>
                    <h3 class="font-weight-bold mb-0">
                        <?php 
                            require 'includes/php/connect.php';

                            $sql = "SELECT id FROM postreports";
                            $result = mysqli_query($con, $sql);
                            echo mysqli_num_rows($result);
                        ?>
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="d-flex border">
                <div class="bg-info text-light p-4">
                    <div class="d-flex align-items-center h-100">
                        <i class="fa fa-3x fa-fw fa-users"></i>
                    </div>
                </div>
                <div class="flex-grow-1 bg-white p-4">
                    <p class="text-uppercase text-secondary mb-0">Conturi inregistrate</p>
                    <?php 
                    	require 'includes/php/connect.php';

                    	$sql = "SELECT count(id) AS totalacc FROM users";
                    	$result = mysqli_query($con, $sql);
                    	$values = mysqli_fetch_assoc($result);
                    	$accounts = $values['totalacc'];

                    ?>
                    <h3 class="font-weight-bold mb-0"><?php echo $accounts ?></h3>
                </div>
            </div>
        </div>
    </div>

   <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                 <div class="card-header bg-white font-weight-bold">
                    Top 20 cele mai populare topicuri
                </div>
                <div class="card-body">
                     <div class="row">
            <div class="col-sm-12">
                <table " class="table table-hover no-footer dtr-inline" width="100%" style="width: 100%;">
                <thead>
                <tr>
                    <th style="width: 298.5px;">ID</th>
                    <th style="width: 446.5px;">Nume Pagina</th>
                    <th style="width: 223.5px;">Views</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    require 'includes/php/connect.php';
                    $query = mysqli_query($con, "SELECT * FROM views ORDER BY visits DESC");
                    while($row = mysqli_fetch_array($query)){
                        echo '<tr>';
                            echo '<td>'.$row['id'].'</td>';
                            echo "<td><a href='forum.php?action=viewpost&idpost=".$row['idpost']."' style='font-weight: bold; text-decoration: none;'>".$row['pagename']."</a></td>";
                            echo "<td>".$row['visits']."</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" style="margin-top: 20px;">
                <div class="card-header bg-white font-weight-bold">
                    Ultimele 10 conturi intregistrate
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Nume</th>
                                <th>Prenume</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        require 'includes/php/connect.php';
                        $query = mysqli_query($con, "SELECT * FROM users ORDER by id DESC LIMIT 10");
                        while($row = mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td><a href="profile.php?profil=<?php echo $row['username']; ?>" style="font-weight: bold; text-decoration: none;"><?php echo $row['username']; ?></a></td>
                            <td><?php echo $row['firstname']; ?></td>
                            <td><?php echo $row['lastname']; ?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            <div class="card" style="margin-top: 20px;">
                <div class="card-header bg-white font-weight-bold">
                    Ultimele 10 actiunii pe site
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody>
                        <?php
                        require 'includes/php/connect.php';
                        $query = mysqli_query($con, "SELECT * FROM logs ORDER by id DESC LIMIT 10");
                        while($row = mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td style="font-size: 13px;"><?php echo $row['logtext']; ?></td>
                        <tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php 
		}
    ?>

 <?php
    if(isset($_GET['action']) && $_GET['action'] == 'staff') {
        unset($_SESSION['sorttext']);
        unset($_SESSION['searchusername']);
 ?>
<div class="container-fluid">
    <div class="card-body">
        <div class="breadcrumb">
            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                <a href="dashboard.php" class="btn btn-primary">Dashboard</a>
                <a href="dashboard.php?action=staff" class="btn btn-success">Staff</a>
            </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover table-striped">
            <thead class="thead-dark">
                <tr style="text-align: center;">
                    <th>ID</th>
                    <th>Username</th>
                    <th>Rol</th>
                    <th>Status Update Editate</th>
                    <th>Topicuri Suspendate</th>
                    <th>Topicuri Sterse</th>
                    <th>Reclamatii inchise</th>
                    <th>Cereri de Debanare inchise</th>
                    <th>Conturi Sterse</th>
                    <th>Bug Report-uri marcate</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    require 'includes/php/connect.php';
                    
                    $query = mysqli_query($con, "SELECT * FROM staff ORDER by function DESC, id ASC");
                    while($row = mysqli_fetch_assoc($query)){
                        echo '<tr style="text-align: center;">';
                        echo '<td>'.$row['adminid'].'</td>';
                        echo '<td style="text-align: left;"><a href="profile.php?profil='.$row['username'].'" style="font-weight: bold; text-decoration: none;">'.$row['username'].'</a></td>';
                        // Determina Functia -->
                        if($row['function'] == 0)
                          echo "<td><span class='badge badge-secondary'>Utilizator Normal</span></td>";
                        elseif($row['function'] == 1)
                          echo '<td><span class="badge badge-primary">Moderator</span></td>';
                        elseif($row['function'] == 2)
                          echo '<td><span class="badge badge-success">Administrator</span></td>';
                        elseif($row['function'] == 3)
                          echo '<td><span class="badge badge-danger">Owner</span></td>';
                        // ================ -->
                        echo "<td>".$row['editedstatusupdates']."</td>";
                        echo "<td>".$row['suspendedtopics']."</td>";
                        if($row['function'] > 1)
                            echo "<td>".$row['deletedtopics']."</td>";
                        else
                           echo '<td><span class="badge badge-secondary">None</span></td>'; 

                        if($row['function'] > 1)
                            echo "<td>".$row['closedcomplaints']."</td>";
                        else
                           echo '<td><span class="badge badge-secondary">None</span></td>'; 

                        if($row['function'] > 1)
                            echo "<td>".$row['closedunbanrequests']."</td>";
                        else
                           echo '<td><span class="badge badge-secondary">None</span></td>'; 

                        if($row['function'] > 2)
                            echo "<td>".$row['accountsdeleted']."</td>";
                        else
                           echo '<td><span class="badge badge-secondary">None</span></td>';

                       if($row['function'] > 2)
                            echo "<td>".$row['bugreportmarked']."</td>";
                        else
                           echo '<td><span class="badge badge-secondary">None</span></td>'; 

                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <hr>
    </div>
</div>
        <?php 
        }
        ?>

 <?php
 	if(isset($_GET['action']) && $_GET['action'] == 'users') {
 ?>
<?php if(isset($_SESSION['function']) && $_SESSION['function'] == 3) { ?>
  <!-- DELETE CONFIRMATION MODAL -->

<!-- Modal -->
<div id="deletemodal" class="modal fade" data-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Confirma stergerea!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="includes/php/delete.inc.php" method="POST">
      <div class="modal-body">
        <input type="hidden" name="delete_id" id="delete_id">
        <input type="hidden" name="delete_username" id="delete_username">
        <p>Esti sigur ca doresti sa stergi acest cont?</p>
        <p class="text-secondary"><small>Acest proces este ireversivil. Odata sters, contul nu mai poate fi recuperat!</small></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Inchide</button>
        <button type="submit" class="btn btn-danger btn-sm" name="deletedashboard">Sterge</button>
      </div>
    </form>
    </div>
  </div>
</div>
  <!-- DELETE CONFIRMATION MODAL END -->
<?php } ?>
<!-- FILTER USER MODAL -->
  <div class="modal fade" id="filterusermodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Filtreaza Utilizatori</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="includes/php/sort.inc.php" method="POST" class="form-group">
          <div class="modal-body">
            <label><small><b>Ordoneaza:</b></small></label>
            <div class="form-check">
                <input type="radio" name="sort-ord" id="DESC" value="sort-desc" checked> <label for="DESC"><span class="badge badge-dark">Descrescator</span></label>
            </div>
            <div class="form-check">
                <input type="radio" name="sort-ord" id="ASC" value="sort-asc"> <label for="ASC"><span class="badge badge-dark">Crescator</span></label>
            </div>
            <label><small><b>Afiseaza pe cei ce detin rolul:</b></small></label>
            <div class="form-check">
                <input type="checkbox" name="sort-function[]" value="0" id="normal-user"> <label for="normal-user"><span class="badge badge-secondary">Utilizator Normal</span>
            </div>
            <div class="form-check">
                <input type="checkbox" name="sort-function[]" value="1" id="moderator"> <label for="moderator"><span class="badge badge-primary">Moderator</span>
            </div>
            <div class="form-check">
                <input type="checkbox" name="sort-function[]" value="2" id="admin"> <label for="admin"><span class="badge badge-success">Administrator</span>
            </div>
            <div class="form-check">
                <input type="checkbox" name="sort-function[]" value="3" id="owner"> <label for="owner"><span class="badge badge-danger">Owner</span>
            </div>
            <label><small><b>Afiseaza doar pe cei inregistrati in data de:</b></small></label>
            <select class="form-control form-control-sm" name="sort-joindate">
                <option disabled selected>Alege o data</option>
                <?php
                    require 'includes/php/connect.php';
                    $sqldateregister = "SELECT DATE(joindate) AS joindate FROM users GROUP by DATE(joindate) ORDER by id DESC";
                    $queryregister = mysqli_query($con, $sqldateregister);
                    while($rowregister = mysqli_fetch_assoc($queryregister)) {
                ?>
                <option value="<?php echo $rowregister['joindate'];?>"><?php echo date('d.M.Y', strtotime($rowregister['joindate'])); ?></option>
                <?php } ?>
            </select>
            <label><small><b>Afiseaza doar pe cei ce sunt din judetul:</b></small></label>
            <select class="form-control form-control-sm" name="sort-countries">
                <option disabled selected>Alege un judet</option>
                <?php 
                $countries = array('Alege Judet', 'Alba', 'Arad', 'Arges','Bacau','Bihor','Bistrita-Nasaud','Botosani','Brasov','Braila','Buzau','Caras-Severin','Calarasi','Cluj','Constanta','Covasna','Dambovita','Dolj','Galati','Giurgiu','Gorj','Harghita','Hunedoara','Ialomita','Iasi','Ilfov','Maramures','Mehedinti','Mures','Neamt','Olt','Prahova','Satu Mare','Salaj','Sibiu','Suceava','Teleorman','Timis','Tulcea','Vaslui','Valcea','Vrancea');
                for($i = 1; $i <= 41; $i++) {
                ?>
                <option value="<?php echo $countries[$i]; ?>"><?php echo $countries[$i];?></option>
                <?php } ?>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success btn-sm" name="sort-dashboard-users">Aplica</button>
          </div>
      </form>
    </div>
  </div>
</div>
<!-- END FILTER USER MODAL -->
<div class="container-fluid">
          <div class="card-body">
            <div class="breadcrumb">
                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                    <a href="dashboard.php" class="btn btn-primary">Dashboard</a>
                    <a href="dashboard.php?action=users" class="btn btn-success">Utilizatori</a>
                </div>
            </div>
            <form action="includes/php/sort.inc.php" method="POST" class="form-inline">
                <div class="form-group mb-2">
                    <input type="text" name="search-username" class="form-control form-control-sm" placeholder="Scrie utilizatorul cautat...">
                </div>
                <div class="form-group mb-2 mx-sm-3">
                    <button type="submit" class="btn btn-outline-success btn-sm form-control-sm" name="search-dashboard-user"><i class="fas fa-search"></i> Cauta</button>
                </div>
                <div class="form-group mb-2">
                    <button type="button" class="btn btn-outline-warning btn-sm form-control-sm" data-toggle="modal" data-target="#filterusermodal"><i class="fas fa-sliders-h"></i> Filtreaza Utilizatorii</button>
                </div>
                <div class="form-group mb-2 mx-sm-3">
                    <button type="submit" class="btn btn-secondary btn-sm form-control-sm" name="reset-dashboard-users"><i class="fas fa-cog"></i> Reseteaza Filtre</button>
                </div>
            </form>
            <?php if(isset($_GET['msg']) && $_GET['msg'] == 'error') {
            echo '<div class="alert alert-danger alert-dismissible" id="alert">
                        A aparut o eroare la stergere!
                </div>';
          }
          ?>
          <?php if(isset($_GET['msg']) && $_GET['msg'] == 'succes') {
                echo ' <div class="alert alert-success alert-dismissible" id="alert">
                            Contul a fost sters cu succes!
                      </div>';
          }
          ?>
          <?php if(isset($_GET['msg']) && $_GET['msg'] == 'cantdeleteyouraccount') {
                echo '<div class="alert alert-danger alert-dismissible" id="alert">
                            Nu iti poti sterge singur contul!                     
                    </div>';
          }
          ?>
          <?php if(isset($_GET['msg']) && $_GET['msg'] == 'lowlevel') {
                echo '<div class="alert alert-warning alert-dismissible" id="alert">
                            Nivelul de administrator este prea mic pentru a executa aceasta comanda!                    
                    </div>';
          }
          ?>
        <?php if(isset($_GET['error']) && $_GET['error'] == 'emptyfield') {
                echo '<div class="alert alert-danger alert-dismissible" id="alert">
                            <b>Pentru a cauta un utilizator trebuie sa introduci numele in casuta.</b>                    
                    </div>';
          }
          ?>
        <?php if(isset($_GET['error']) && $_GET['error'] == 'toofewchars') {
                echo '<div class="alert alert-danger alert-dismissible" id="alert">
                            <b>Pentru a cauta un utilizator trebuie sa introduci minim 3 caractere!</b>                     
                    </div>';
          }
          ?>
        <div class="table-responsive">
          <table class="table">
            <thead class="thead-dark">
                <tr>
                	<th>ID</th>
                	<th>Username</th>
                	<th>Email</th>
                	<th>Nume</th>
                	<th>Prenume</th>
                	<th>Rol</th>
                	<th>Inregistrat din</th>
                	<th>Judet</th>
                	<th>ADMIN TOOLS</th>
                </tr>
                </thead>
                <tbody>
                	<?php
                    require 'includes/php/connect.php';

                    if(!isset($_GET['page']))
                        $page = 1;
                    else
                        $page = $_GET['page'];

                    if(!isset($_SESSION['sorttext']))
                        $pagenumber = "SELECT * FROM users";
                    else
                        $pagenumber = $_SESSION['sorttext'];

                    $pagenumber = mysqli_query($con, $pagenumber);
                    $numberofresults = mysqli_num_rows($pagenumber);
                    $resultsperpage = 10;
                    $numberofpage = ceil($numberofresults / $resultsperpage);
                    $thispageresults = ($page - 1) * $resultsperpage;

                    if(!isset($_SESSION['sorttext']) && !isset($_SESSION['searchusername']))
                        $query = mysqli_query($con, "SELECT * FROM users ORDER by function DESC, id DESC LIMIT ".$thispageresults.', '.$resultsperpage);
                    if(isset($_SESSION['sorttext']) && !isset($_SESSION['searchusername']))
                        $query = mysqli_query($con, $_SESSION['sorttext']." LIMIT ".$thispageresults.', '.$resultsperpage);
                    if(!isset($_SESSION['sorttext']) && isset($_SESSION['searchusername']))
                        $query = mysqli_query($con, "SELECT * FROM users WHERE username LIKE '%".$_SESSION['searchusername']."%' LIMIT ".$thispageresults.', '.$resultsperpage);
                    if(mysqli_num_rows($query) > 0) {
                        while($row = mysqli_fetch_assoc($query)){
                            $joindate = $row['joindate'];
                            $joindate = strtotime($joindate);
                            $joindate = date('d.M.Y', $joindate);
                            echo '<tr>';
                            echo '<td>'.$row['id'].'</td>';
                            echo "<td>".$row['username']."</td>";
                            echo "<td>".$row['email']."</td>";
                            echo "<td>".$row['firstname']."</td>";
                            echo "<td>".$row['lastname']."</td>";

                            // Determina Functia -->
                            if($row['function'] == 0)
                              echo "<td><span class='badge badge-secondary'>Utilizator Normal</span></td>";
                            elseif($row['function'] == 1)
                              echo '<td><span class="badge badge-primary">Moderator</span></td>';
                            elseif($row['function'] == 2)
                              echo '<td><span class="badge badge-success">Administrator</span></td>';
                            elseif($row['function'] == 3)
                              echo '<td><span class="badge badge-danger">Owner</span></td>';
                            // ================ -->

                            echo "<td>".$joindate."</td>";
                            echo "<td>".$row['country']."</td>";
                            echo '<td class=" actions">';
                            echo '<a href=profile.php?profil='.$row['username'].'><button class="btn btn-icon btn-pill btn-success title="Go to profile"><i class="fas fa-external-link-alt"></i></button></a>';
                            echo '<button class="btn btn-icon btn-pill btn-danger deletebtn'; if($_SESSION['function'] != 3) echo " disabled"; echo '" title="Delete"><i class="fa fa-fw fa-trash"></i></button>';
                            echo "</tr>";
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="9">Nu a fost gasit nici un utilizator care sa corespunda cerintelor.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
                <hr>
                    <nav>
                      <ul class="pagination justify-content-end">
                        <li class="page-item <?php if(!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] == 1 )) echo 'disabled'; ?>">
                          <a class="page-link" href="dashboard.php?action=users&page=<?php echo $page - 1; ?>"><i class="fa fa-fast-backward" aria-hidden="true"></i></a>
                        </li>
                        <?php for($i = 1; $i <= $numberofpage; $i++) { ?>
                            <li class="page-item <?php if($i == $page) echo 'active' ?>"><a class="page-link" href="dashboard.php?action=users&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                        <?php } ?>
                        <?php if($numberofpage == 0) { ?>
                            <li class="page-item active"><a class="page-link" href="dashboard.php?action=users&page=1">1</a></li>
                        <?php } ?>
                        <li class="page-item <?php if((!isset($_GET['page']) && $page == $numberofpage) || (isset($_GET['page']) && $_GET['page'] == $numberofpage) || $numberofpage == 0) echo 'disabled'; ?>">
                          <a class="page-link" href="dashboard.php?action=users&page=<?php echo $page + 1; ?>"><i class="fa fa-fast-forward" aria-hidden="true"></i></a>
                        </li>
                      </ul>
                    </nav>
        </div>
    </div>
    <?php
        }
    ?>

     <!-- SCRIPT FOR DELETE MODAL -->
  <script type="text/javascript">
    $(document).ready(function () {
      $(".deletebtn").on('click', function() {
        $("#deletemodal").modal('show');
          $tr = $(this).closest('tr');
          var data = $tr.children("td").map(function () {
            return $(this).text();
          }).get();
          console.log(data);
          $('#delete_id').val(data[0]);
          $('#delete_username').val(data[1]);
      });
    });
  </script>

<?php
 	if(isset($_GET['action']) && $_GET['action'] == 'bugreports') {
        unset($_SESSION['sorttext']);
        unset($_SESSION['searchusername']);
        if(!isset($_GET['bugreportview'])) {
?>
<div class="container-fluid">
    <div class="card-body">
        <div class="breadcrumb">
            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                <a href="dashboard.php" class="btn btn-primary">Dashboard</a>
                <a href="dashboard.php?action=bugreports" class="btn btn-success">Bug Reports</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th>Nr</th>
                        <th>Titlul</th>
                        <th>Creatorul</th>
                        <th>Creata la data de</th>
                        <th>Status</th>
                        <th>Vezi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        require 'includes/php/connect.php';

                         if(!isset($_GET['page']))
                                $page = 1;
                            else
                                $page = $_GET['page'];

                            $pagenumber = "SELECT * FROM bugreport";
                            $pagenumber = mysqli_query($con, $pagenumber);
                            $numberofresults = mysqli_num_rows($pagenumber);
                            $resultsperpage = 10;
                            $numberofpage = ceil($numberofresults/$resultsperpage);
                            $thispageresults = ($page - 1) * $resultsperpage;

                            $sqlbugreport = "SELECT * FROM bugreport ORDER by status ASC, id DESC LIMIT ".$thispageresults.', '.$resultsperpage;
                            $resultsbugreport = mysqli_query($con, $sqlbugreport);
                            if(mysqli_num_rows($resultsbugreport) > 0) {
                                while ($rowbugreport = mysqli_fetch_assoc($resultsbugreport)) {

                    ?>
                    <tr>
                        <td><?php echo $rowbugreport['id']; ?></td>
                        <td><?php echo $rowbugreport['title']; ?></td>
                        <td><a style="text-decoration: none; font-weight: bold;" href="profile.php?profil=<?php echo $rowbugreport['usernamecreator']; ?>"><?php echo $rowbugreport['usernamecreator']; ?></a></td>
                        <td><?php echo date("d.M.Y H:i", strtotime($rowbugreport['createdate'])); ?></td>
                        <?php if($rowbugreport['status'] == 0 ) { ?>
                                <td><div class="badge badge-danger">Nerezolvat</div></td>
                        <?php } else { ?>
                                <td><div class="badge badge-success">Rezolvat</div></td>
                        <?php } ?>
                        <td><a class="btn btn-success btn-sm" href="dashboard.php?action=bugreports&bugreportview=<?php echo $rowbugreport['id']; ?>"><i class="fa fa-external-link" aria-hidden="true"></i></a></td>
                    </tr>
                    <?php } } ?>
                </tbody>
            </table>
    </div>
    <hr>
            <nav>
              <ul class="pagination justify-content-end">
                <li class="page-item <?php if(!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] == 1 )) echo 'disabled'; ?>">
                  <a class="page-link" href="dashboard.php?action=bugreports&page=<?php echo $page - 1; ?>"><i class="fa fa-fast-backward" aria-hidden="true"></i></a>
                </li>
                <?php for($i = 1; $i <= $numberofpage; $i++) { ?>
                    <li class="page-item <?php if($i == $page) echo 'active' ?>"><a class="page-link" href="dashboard.php?action=bugreports&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php } ?>
                <li class="page-item <?php if((!isset($_GET['page']) && $page == $numberofpage) || (isset($_GET['page']) && $_GET['page'] == $numberofpage)) echo 'disabled'; ?>">
                  <a class="page-link" href="dashboard.php?action=bugreports&page=<?php echo $page + 1; ?>"><i class="fa fa-fast-forward" aria-hidden="true"></i></a>
                </li>
              </ul>
            </nav>
    </div>
</div>
<?php } else { ?>

    <?php if(isset($_GET['msg']) && $_GET['msg'] == 'marksolved') { ?>
  <script>
      $(document).ready(function(){
          $("#markmodal").modal('show');
      });
  </script>
<?php } ?>

<?php if(isset($_GET['msg']) && $_GET['msg'] == 'markunsolved') { ?>
  <script>
      $(document).ready(function(){
          $("#unmarkmodal").modal('show');
      });
  </script>
<?php } ?>

    <!-- <! OPEN MODAL !> -->
<div class="modal fade" id="markmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <center>
          <i class="text-success fas fa-fw fa-9x fa-check-square"></i>
          <p style="font-weight: 900; font-size: 25px; margin-top: 10px;">Aceasta problema a fost marcata ca si rezolvata!</p>
        </center>
      </div>
    </div>
  </div>
</div>
<!-- <! OPEN MODAL !> -->

<!-- <! CLOSE MODAL !> -->
<div class="modal fade" id="unmarkmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <center>
          <i class="text-danger fas fa-fw fa-9x fa-times-circle"></i>
          <p style="font-weight: 900; font-size: 30px; margin-top: 10px;">Aceasta problema a fost marcata ca si nerezolvata.</p>
        </center>
      </div>
    </div>
  </div>
</div>
<!-- <! CLOSE MODAL !> -->

    <div class="card-body">
        <?php 
            require 'includes/php/connect.php';
            $idbugreport = $_GET['bugreportview'];
            $sqlbugrep = "SELECT * FROM bugreport WHERE id = '$idbugreport'";
            $rowreport = mysqli_fetch_assoc(mysqli_query($con, $sqlbugrep));
        ?>
        <div class="breadcrumb">
        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
            <a href="dashboard.php" class="btn btn-primary">Dashboard</a>
            <a href="dashboard.php?action=bugreports" class="btn btn-primary">Bug Reports</a>
            <a href="dashboard.php?action=bugreports&bugreportview=<?php echo $idbugreport; ?>" class="btn btn-success">Bug Report "<?php echo $rowreport['title']; ?>"</a>
        </div>
    </div>
    <hr>
        <div class="row">
            <div class="col">
                <label><small><b>Nr Bug Report: </b></small></label>
                <p style="margin-left: 10px;"><?php echo $rowreport['id']; ?></p>
                <label><small><b>Titlul: </b></small></label>
                <p style="margin-left: 10px;"><?php echo $rowreport['title']; ?></p>
                <label><small><b>Raportat de: </b></small></label>
                <p style="margin-left: 10px;"><a style="text-decoration: none; font-weight: bold;" href="profile.php?profil=<?php echo $rowreport['usernamecreator']; ?>" ><?php echo $rowreport['usernamecreator']; ?></a></p>
                <label><small><b>Data raportari: </b></small></label>
                <p style="margin-left: 10px;"><?php echo date("d.M.Y H:i", strtotime($rowreport['createdate'])); ?></p>
                <label><small><b>Status: </b></small></label>
                <?php if($rowreport['status'] == 0 ) { ?>
                        <p style="margin-left: 10px;"><div class="badge badge-danger">Nerezolvat</div></p>
                <?php } else { ?>
                        <p style="margin-left: 10px;"><div class="badge badge-success">Rezolvat</div></p>
                <?php } ?>
                <label><small><b>Marcat ca rezolvat de: </b></small></label>
                <?php if(!empty($rowreport['usernameresponser'])) { ?>
                    <p style="margin-left: 10px;"><?php echo $rowreport['usernameresponser']; ?></p>
                <?php } else { ?>
                    <p style="margin-left: 10px;">-</p>
                <?php } ?>
            </div>
            <div class="col-10">
                <label><small><b>Detalii: </b></small></label>
                <div style="margin-left: 10px;"><?php echo $rowreport['details']; ?></div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-2">
                <form action="includes/php/bugreport.inc.php" method="POST">
                    <input type="hidden" name="id-bug-report" value="<?php echo $_GET['bugreportview']; ?>">
                <table style="justify-content: center; width: 100%;">
                    <thead>
                        <tr>
                            <th><center><h5><i class="fa fa-sliders" aria-hidden="true"></i> ADMIN TOOLS</h5></center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($rowreport['status'] == 1) { ?>
                        <tr>
                            <td><button class="btn btn-danger btn-block <?php if($_SESSION['function'] != 3) echo 'disabled'; ?>" name="mark-unsolved">Marcheaza ca Nerezolvat</button></td>
                        </tr>
                        <?php } else { ?>
                        <tr>
                            <td><button class="btn btn-success btn-block <?php if($_SESSION['function'] != 3) echo 'disabled'; ?>" name="mark-solved">Marcheaza ca Rezolvat</button></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                </form>
            </div>
            <div class="col-md-10">
               <div class="card">
                        <h5 class="card-header">Notite:</h5>
                        <div class="card-body">
                        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'emptyfields') { ?>
                            <div class="alert alert-danger">Casuta in care se introduci notita e goala.</div>
                        <?php } ?>
                        <?php if($rowreport['status'] == 0 && $_SESSION['function'] == 3) { ?>
                            <?php if(!empty($rowreport['usernote']) && !empty($rowreport['notes'])) { ?>
                                <a style="text-decoration: none; font-weight: bold;" href="profile.php?profil=<?php echo $rowreport['usernote']; ?>"><?php echo $rowreport['usernote']; ?></a>
                                <p style="margin-left: 10px;"><?php echo $rowreport['notes']; ?></p>
                                <hr>
                            <?php } ?>
                        <form action="includes/php/bugreport.inc.php" method="POST">
                            <input type="hidden" name="id-bug-report-note" value="<?php echo $_GET['bugreportview']; ?>">
                            <textarea type="text" class="form-control card-text" name="notes" placeholder="Scrie raspunsul aici..." rows="3"><?php if(!empty($rowreport['usernote'])) echo $rowreport['notes']; ?></textarea><br>
                            <button type="submit" class="btn btn-sm btn-info" name="submit-notes" style="float:right;"><i class="fa fa-sticky-note" aria-hidden="true"></i> Adauga Notita</button>
                        </form>
                        <?php } else { ?>
                            <?php if(!empty($rowreport['usernote']) && !empty($rowreport['notes'])) { ?>
                            <a style="text-decoration: none; font-weight: bold;" href="profile.php?profil=<?php echo $rowreport['usernote']; ?>"><?php echo $rowreport['usernote']; ?></a>
                            <p style="margin-left: 10px;"><?php echo $rowreport['notes']; ?></p>
                            <?php } else { ?>
                                <p style="margin-left: 10px;">Nu s-a lasat nici o notita la aceasta problema.</p>
                            <?php } ?>
                        <?php } ?>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <script src="includes/ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('notes');
    </script>
<?php 
	} }
?>
  
    <?php 
    if(isset($_GET['action']) && $_GET['action'] == 'postreports') {
        unset($_SESSION['sorttext']);
        unset($_SESSION['searchusername']);
        if(!isset($_GET['postreportview'])) {
    ?>
<div class="container-fluid">
    <div class="card-body">
        <div class="breadcrumb">
            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
              <a href="dashboard.php" class="btn btn-primary">Dashboard</a>
              <a href="dashboard.php?action=postreports" class="btn btn-success">Reclamatii</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th>Nr</th>
                        <th>Creator</th>
                        <th>Numele Topicului</th>
                        <th>Creatorul topicului</th>
                        <th>Status</th>
                        <th>Vezi</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    require 'includes/php/connect.php';

                    if(!isset($_GET['page']))
                        $page = 1;
                    else
                        $page = $_GET['page'];

                    $pagenumber = "SELECT * FROM postreports";
                    $pagenumber = mysqli_query($con, $pagenumber);
                    $numberofresults = mysqli_num_rows($pagenumber);
                    $resultsperpage = 3;
                    $numberofpage = ceil($numberofresults/$resultsperpage);
                    $thispageresults = ($page - 1) * $resultsperpage;

                    $sqlpostreport = "SELECT * FROM postreports ORDER by status ASC, id ASC LIMIT ".$thispageresults.', '.$resultsperpage;
                    $resultspostreport = mysqli_query($con, $sqlpostreport);
                    if(mysqli_num_rows($resultspostreport) > 0) {
                        while ($rowpostreport = mysqli_fetch_assoc($resultspostreport)) {
                    ?>
                    <tr>
                        <td><?php echo $rowpostreport['id']; ?></td>
                        <td><a style="font-weight: bold; text-decoration: none;" href="profile.php?profil=<?php echo $rowpostreport['userreporter']; ?>"><?php echo $rowpostreport['userreporter']; ?></a></td>
                        <td><?php echo $rowpostreport['topictitle']; ?></td>
                        <td><a style="font-weight: bold; text-decoration: none;" href="profile.php?profil=<?php echo $rowpostreport['topiccreator']; ?>"><?php echo $rowpostreport['topiccreator']; ?></a></td>
                        <?php if($rowpostreport['status'] == 0 ) { ?>
                            <td><div class="badge badge-info">In asteptare</div></td>
                        <?php } else { ?>
                            <td><div class="badge badge-danger">Inchisa</div></td>
                        <?php } ?>
                        <td><a class="btn btn-sm btn-success" href="dashboard.php?action=postreports&postreportview=<?php echo $rowpostreport['id']; ?>"><i class="fa fa-external-link" aria-hidden="true"></i></a></td>
                    </tr>
                <?php }
                } ?>
                </tbody>
            </table>
        </div>
    <hr>
            <nav>
              <ul class="pagination justify-content-end">
                <li class="page-item <?php if(!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] == 1 )) echo 'disabled'; ?>">
                  <a class="page-link" href="dashboard.php?action=postreports&page=<?php echo $page - 1; ?>"><i class="fa fa-fast-backward" aria-hidden="true"></i></a>
                </li>
                <?php for($i = 1; $i <= $numberofpage; $i++) { ?>
                    <li class="page-item <?php if($i == $page) echo 'active' ?>"><a class="page-link" href="dashboard.php?action=postreports&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php } ?>
                <li class="page-item <?php if((!isset($_GET['page']) && $page == $numberofpage) || (isset($_GET['page']) && $_GET['page'] == $numberofpage)) echo 'disabled'; ?>">
                  <a class="page-link" href="dashboard.php?action=postreports&page=<?php echo $page + 1; ?>"><i class="fa fa-fast-forward" aria-hidden="true"></i></a>
                </li>
              </ul>
            </nav>
    </div>
</div>
        <?php } else { ?>
                <?php if(isset($_GET['msg']) && $_GET['msg'] == 'opened') { ?>
                  <script>
                      $(document).ready(function(){
                          $("#openedmodal").modal('show');
                      });
                  </script>
                <?php } ?>

                <?php if(isset($_GET['msg']) && $_GET['msg'] == 'closed') { ?>
                  <script>
                      $(document).ready(function(){
                          $("#closedmodal").modal('show');
                      });
                  </script>
                <?php } ?>

                    <!-- <! OPEN MODAL !> -->
                <div class="modal fade" id="openedmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <center>
                          <i class="text-success fas fa-fw fa-9x fa-check-square"></i>
                          <p style="font-weight: 900; font-size: 25px; margin-top: 10px;">Reclamatia a fost deschisa cu succes!</p>
                        </center>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- <! OPEN MODAL !> -->

                <!-- <! CLOSE MODAL !> -->
                <div class="modal fade" id="closedmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <center>
                          <i class="text-danger fas fa-fw fa-9x fa-check-square"></i>
                          <p style="font-weight: 900; font-size: 30px; margin-top: 10px;">Reclamatia a fost inchisa cu succes!</p>
                        </center>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- <! CLOSE MODAL !> -->

        <div class="card-body">
            <?php 
                require 'includes/php/connect.php';
                $idreport = $_GET['postreportview'];
                $query = mysqli_query($con, "SELECT * FROM postreports WHERE id = '$idreport'");
                $rowpost = mysqli_fetch_assoc($query);
            ?>
            <div class="breadcrumb">
                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                  <a href="dashboard.php" class="btn btn-primary">Dashboard</a>
                  <a href="dashboard.php?action=postreports" class="btn btn-primary">Reclamatii</a>
                  <a href="dashboard.php?action=postreports&postreportview=<?php echo $idreport;?>" class="btn btn-success">Reclamatia lui <?php echo $rowpost['userreporter'];?></a>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <label><small><b>Titlu topic: </b></small></label>
                    <p style="padding-left: 10px;"><?php echo $rowpost['topictitle']; ?></p>
                    <label><small><b>Creator topic: </b></small></label>
                    <p style="padding-left: 10px;"><?php echo $rowpost['topiccreator']; ?></p>
                    <label><small><b>Creator reclamatie: </b></small></label>
                    <p style="padding-left: 10px;"><?php echo $rowpost['userreporter']; ?></p>
                     <label><small><b>Status: </b></small></label>
                        <?php 
                            if($rowpost['status'] == 0)
                                echo '<p style="padding-left: 15px;"><span class="badge badge-danger">In asteptare</span></p>';
                            if($rowpost['status'] == 1)
                                echo '<p style="padding-left: 15px;"><span class="badge badge-success">Inchisa</span></p>';
                        ?>
                </div>
                <div class="col">
                    <?php 
                        require 'includes/php/connect.php';
                        $creator = $rowpost['topiccreator'];
                        $querycreator = mysqli_query($con, "SELECT * FROM users WHERE username = '$creator'");
                        $rowcreator = mysqli_fetch_assoc($querycreator);
                    ?>
                    <label><small><b>Detalii creator topic <?php echo $rowpost['topiccreator']; ?>: </b></small></label><br>
                    <ul>
                        <label><small><b>Email: </b></small></label>
                        <p style="padding-left: 10px;"><?php echo $rowcreator['email']; ?></p>
                        <label><small><b>Rol: </b></small></label>
                        <?php 
                            if($rowcreator['function'] == 0)
                                echo '<p style="padding-left: 15px;"><span class="badge badge-secondary">Utilizator Normal</span></p>';
                            if($rowcreator['function'] == 1)
                                echo '<p style="padding-left: 15px;"><span class="badge badge-primary">Moderator</span></p>';
                            if($rowcreator['function'] == 2)
                                echo '<p style="padding-left: 15px;"><span class="badge badge-success">Administrator</span></p>';
                            if($rowcreator['function'] == 3)
                                echo '<p style="padding-left: 15px;"><span class="badge badge-danger">Owner</span></p>';
                        ?>
                        <label><small><b>Statusul Contului: </b></small></label>
                        <?php 
                            if($rowcreator['verified'] == 0)
                                echo '<p style="padding-left: 15px;"><span class="badge badge-danger">Cont Neverificat</span></p>';
                            if($rowcreator['verified'] == 1)
                                echo '<p style="padding-left: 15px;"><span class="badge badge-success">Cont Verificat</span></p>';
                        ?>
                        <label><small><b>Inregistrat la data de: </b></small></label>
                        <p style="padding-left: 10px;"><?php echo date("d.M.Y H:i", strtotime($rowcreator['joindate'])); ?></p>
                    </ul>
                </div>
                <div class="col">
                    <?php 
                        require 'includes/php/connect.php';
                        $reporter = $rowpost['userreporter'];
                        $queryreporter = mysqli_query($con, "SELECT * FROM users WHERE username = '$reporter'");
                        $rowreporter = mysqli_fetch_assoc($queryreporter);
                    ?>
                    <label><small><b>Detalii creator reclamatie <?php echo $rowpost['userreporter']; ?>: </b></small></label><br>
                    <ul>
                        <label><small><b>Email: </b></small></label>
                        <p style="padding-left: 10px;"><?php echo $rowreporter['email']; ?></p>
                        <label><small><b>Rol: </b></small></label>
                        <?php 
                            if($rowreporter['function'] == 0)
                                echo '<p style="padding-left: 15px;"><span class="badge badge-secondary">Utilizator Normal</span></p>';
                            if($rowreporter['function'] == 1)
                                echo '<p style="padding-left: 15px;"><span class="badge badge-primary">Moderator</span></p>';
                            if($rowreporter['function'] == 2)
                                echo '<p style="padding-left: 15px;"><span class="badge badge-success">Administrator</span></p>';
                            if($rowreporter['function'] == 3)
                                echo '<p style="padding-left: 15px;"><span class="badge badge-danger">Owner</span></p>';
                        ?>
                        <label><small><b>Statusul Contului: </b></small></label>
                        <?php 
                            if($rowreporter['verified'] == 0)
                                echo '<p style="padding-left: 15px;"><span class="badge badge-danger">Cont Neverificat</span></p>';
                            if($rowreporter['verified'] == 1)
                                echo '<p style="padding-left: 15px;"><span class="badge badge-success">Cont Verificat</span></p>';
                        ?>
                        <label><small><b>Inregistrat la data de: </b></small></label>
                        <p style="padding-left: 10px;"><?php echo date("d.M.Y H:i", strtotime($rowreporter['joindate'])); ?></p>
                    </ul>
                </div>
        </div>
        <hr>
            <label><small><b>Detalii: </b></small></label>
            <div style="padding-left: 10px;"><?php echo $rowpost['details']; ?></div>
        <hr>
        <div class="row">
            <div class="col-md-2">
                <form action="includes/php/addpost.inc.php" method="POST">
                    <input type="hidden" name="id-report" value="<?php echo $_GET['postreportview']; ?>">
                <table style="justify-content: center; width: 100%;">
                <thead>
                    <tr>
                        <th><center><h5><i class="fa fa-sliders" aria-hidden="true"></i> ADMIN TOOLS</h5></center></th>
                    </tr>
                </thead>
                <tbody>
                <?php if($rowpost['status'] == 0) { ?>
                    <tr>
                        <td><button type="submit" name="close-post-report" class="btn btn-danger btn-block <?php if($_SESSION['function'] < 2) echo "disabled"; ?>"><i class="fa fa-window-close" aria-hidden="true"></i> Inchide Cererea</button></td>
                    </tr>
                <?php } ?>
                <?php if($rowpost['status'] == 1) { ?>
                    <tr>
                        <td><button type="submit" name="open-post-report" class="btn btn-success btn-block"><i class="fas fa-unlock"></i> Deschide Reclamatia</button></td>
                <?php } ?>
                    <tr>
                        <td><a href="forum.php?action=viewpost&idpost=<?php echo $rowpost['topicid']?>" class="btn btn-warning btn-block" style="color: #fff;"><i class="fa fa-external-link" aria-hidden="true"></i> Inspre Topic</a></td>
                    </tr>
                    <tr>
                        <td><a href="profile.php?profil=<?php echo $rowpost['topiccreator']?>" class="btn btn-warning btn-block" style="color: #fff;"><i class="fa fa-external-link" aria-hidden="true"></i> Profilul Creatorului</a></td>
                    </tr>
                    <tr>
                        <td><a href="profile.php?profil=<?php echo $rowpost['userreporter']?>" class="btn btn-warning btn-block" style="color: #fff;"><i class="fa fa-external-link" aria-hidden="true"></i> Profilul Reclamantului</a></td>
                    </tr>
                </tbody>
            </table>
            </form><br>
            </div>
            <div class="col">
                <div class="col-md">
                    <div class="card">
                        <h5 class="card-header">Raspuns:</h5>
                        <div class="card-body">
                            <h5 class="card-title"><a style="text-decoration: none; font-weight: bold;" href="profile.php?profil=<?php echo $rowpost['usersolver']; ?>"><?php echo $rowpost['usersolver']; ?></a></h5>
                            <p class="card-text" style="padding-left: 10px;"><?php echo $rowpost['response']; ?></p>
                        <?php if($rowpost['status'] == 0) { ?>
                        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'emptyfields') { ?>
                            <div class="alert alert-danger">Casuta in care se introduce comentariul este goala.</div>
                        <?php } ?>
                        <form action="includes/php/addpost.inc.php" method="POST">
                            <input type="hidden" name="id-report" value="<?php echo $_GET['postreportview']; ?>">
                            <textarea type="text" class="form-control card-text" name="anwsear" placeholder="Scrie raspunsul aici..." rows="3"></textarea><br>
                            <button type="submit" class="btn btn-sm btn-success" name="submit-answear-report" style="float:right;" <?php if($_SESSION['function'] < 2) echo "disabled"; ?>><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Trimite raspuns</button>
                        </form>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        <?php } } ?>

    <?php 
        if(isset($_GET['action']) && $_GET['action'] == 'banlist') {
            unset($_SESSION['sorttext']);
            unset($_SESSION['searchusername']);
    ?>
<div class="container-fluid">
    <div class="card-body">
        <div class="breadcrumb">
            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
              <a href="dashboard.php" class="btn btn-primary">Dashboard</a>
              <a href="dashboard.php?action=banlist" class="btn btn-success">Ban List</a>
            </div>
        </div>
        <div class="table-responsive">
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th>Username</th>
              <th>Data Banului</th>
              <th>Motivul Banului</th>
              <th>Banat de</th>
              <th>Banul expira la</th>
              <th>IP Ban</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            include 'includes/php/connect.php';

            if(!isset($_GET['page']))
                        $page = 1;
                    else
                        $page = $_GET['page'];

                    $pagenumber = "SELECT * FROM banlist";
                    $pagenumber = mysqli_query($con, $pagenumber);
                    $numberofresults = mysqli_num_rows($pagenumber);
                    $resultsperpage = 10;
                    $numberofpage = ceil($numberofresults/$resultsperpage);
                    $thispageresults = ($page - 1) * $resultsperpage;

                    $now = date('Y-m-d', time());
            $sqlbanlist = "SELECT * FROM banlist WHERE unbandate > '$now' OR permanentbanned = 1 LIMIT ".$thispageresults.', '.$resultsperpage;
            $min1 = 0;
            $resultbanlist = mysqli_query($con, $sqlbanlist);
            if(mysqli_num_rows($resultbanlist) > 0) {
                while($rowbanlist = mysqli_fetch_assoc($resultbanlist)) {
                    echo '<tr>';
                    echo '<td><a href="profile.php?profil='.$rowbanlist['bannedusername'].'" style="text-decoration: none; font-weight: bold;">'.$rowbanlist['bannedusername'].'</a></td>';
                    echo '<td>'.$rowbanlist['banneddate'].'</td>';
                    echo '<td>'.$rowbanlist['reason'].'</td>';
                    echo '<td>'.$rowbanlist['bannedby'].'</td>';
                    if($rowbanlist['unbandate'] != '0000-00-00') {
                        echo '<td>'.$rowbanlist['unbandate'].'</td>';
                    } else {
                        echo '<td>Permanent</td>';
                    }
                    if($rowbanlist['permanentbanned'] == 0) {
                        echo '<td><span class="badge badge-success">No</span></td>';
                    } else {
                        echo '<td><span class="badge badge-danger">Yes</span></td>';
                    }
                    echo '</tr>';
                }
            } else {
                    echo '<tr>';
                    echo '<td colspan="6">Nu exista conturi banate</td>';
                    echo '</tr>';
                }
            ?>
          </tbody>
        </table>
    </div>
      <hr>
            <nav>
              <ul class="pagination justify-content-end">
                <li class="page-item <?php if(!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] == 1 )) echo 'disabled'; ?>">
                  <a class="page-link" href="dashboard.php?action=banlist&page=<?php echo $page - 1; ?>"><i class="fa fa-fast-backward" aria-hidden="true"></i></a>
                </li>
                <?php for($i = 1; $i <= $numberofpage; $i++) { ?>
                    <li class="page-item <?php if($i == $page) echo 'active' ?>"><a class="page-link" href="dashboard.php?action=banlist&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php } ?>
                <li class="page-item <?php if((!isset($_GET['page']) && $page == $numberofpage) || (isset($_GET['page']) && $_GET['page'] == $numberofpage)) echo 'disabled'; ?>">
                  <a class="page-link" href="dashboard.php?action=banlist&page=<?php echo $page + 1; ?>"><i class="fa fa-fast-forward" aria-hidden="true"></i></a>
                </li>
              </ul>
            </nav>
    </div>
</div>
    <?php 
        }
    ?>

    <?php 
        if(isset($_GET['action']) && $_GET['action'] == 'unbanrequests' && !isset($_GET['unbanrequestview'])) {
            unset($_SESSION['sorttext']);
            unset($_SESSION['searchusername']);
    ?>
<div class="container-fluid">
    <div class="card-body">
        <div class="breadcrumb">
            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
              <a href="dashboard.php" class="btn btn-primary">Dashboard</a>
              <a href="dashboard.php?action=unbanrequests" class="btn btn-success">Cereri de debanare</a>
            </div>
        </div>
        <div class="table-responsive">
        <table class="table">
        <thead class="table-dark">
          <tr>
            <th>Nr.</th>
            <th>Deschisa de</th>
            <th>Banat de</th>
            <th>Motiv</th>
            <th>Status</th>
            <th>Vezi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          require 'includes/php/connect.php';
          $id = $_SESSION['id'];

          if(!isset($_GET['page']))
                        $page = 1;
                    else
                        $page = $_GET['page'];
                    $pagenumber = "SELECT * FROM unbanrequests";
                    $pagenumber = mysqli_query($con, $pagenumber);
                    $numberofresults = mysqli_num_rows($pagenumber);
                    $resultsperpage = 4;
                    $numberofpage = ceil($numberofresults/$resultsperpage);
                    $thispageresults = ($page - 1) * $resultsperpage;

          $sqlrequests = "SELECT * FROM unbanrequests ORDER by status, id DESC LIMIT ".$thispageresults.', '.$resultsperpage;
          $requsts = mysqli_query($con, $sqlrequests);
          if(mysqli_num_rows($requsts) > 0) {
            while($rowrequests = mysqli_fetch_assoc($requsts)) { 
            ?>
                <tr>
                  <th><?php echo $rowrequests['id'];?></th>
                  <th><a href="<?php echo 'profile.php?profil='.$rowrequests['bannedusername'] ?>" style="text-decoration: none;"><?php echo $rowrequests['bannedusername']; ?></a></th>
                  <td><?php echo $rowrequests['bannedby']; ?></td>
                  <td><?php echo $rowrequests['reason']; ?></td>
                  <?php if($rowrequests['status'] == 0) { ?>
                    <td><span class="badge badge-info">Pending</span></td>
                  <?php } else { ?>
                    <td><span class="badge badge-danger">Closed</span></td>
                  <?php } ?>
                  <td><a href="<?php echo 'dashboard.php?action=unbanrequests&unbanrequestview='.$rowrequests['id']; ?>" class="btn btn-success btn-sm"><i class="fa fa-external-link" aria-hidden="true"></i></a></td>
                </tr>
            <?php 
            }
          }
          ?>
        </tbody>
      </table>
  </div>
      <hr>
            <nav>
              <ul class="pagination justify-content-end">
                <li class="page-item <?php if(!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] == 1 )) echo 'disabled'; ?>">
                  <a class="page-link" href="dashboard.php?action=unbanrequests&page=<?php echo $page - 1; ?>"><i class="fa fa-fast-backward" aria-hidden="true"></i></a>
                </li>
                <?php for($i = 1; $i <= $numberofpage; $i++) { ?>
                    <li class="page-item <?php if($i == $page) echo 'active' ?>"><a class="page-link" href="dashboard.php?action=unbanrequests&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php } ?>
                <li class="page-item <?php if((!isset($_GET['page']) && $page == $numberofpage) || (isset($_GET['page']) && $_GET['page'] == $numberofpage)) echo 'disabled'; ?>">
                  <a class="page-link" href="dashboard.php?action=unbanrequests&page=<?php echo $page + 1; ?>"><i class="fa fa-fast-forward" aria-hidden="true"></i></a>
                </li>
              </ul>
            </nav>
  </div>
</div>
    <?php 
        } elseif(isset($_GET['unbanrequestview'])) { ?>
    <?php
            require 'includes/php/connect.php';
            $id = $_GET['unbanrequestview'];
            $sqlbanned = "SELECT * FROM unbanrequests WHERE id = '$id'";
            $resultbanned = mysqli_query($con, $sqlbanned);
            $rowbanned = mysqli_fetch_assoc($resultbanned);
                $banlistid = $rowbanned['banlistid'];
                $bannedip = $rowbanned['bannedip'];
                $bannedid= $rowbanned['banneduserid'];
                $bannedby = $rowbanned['bannedby'];
                $bannedusername = $rowbanned['bannedusername'];
                $reason = $rowbanned['reason'];
                $permanent = $rowbanned['permanentbanned'];
                $banduration = $rowbanned['banduration'];
                $banneddate = $rowbanned['banneddate'];
                $banneddate = strtotime($banneddate);
                $banneddate = date('d.m.Y H:i', $banneddate);
                $unbandate = $rowbanned['unbandate'];
                $unbandate = strtotime($unbandate);
                $unbandate = date('d.m.Y', $unbandate);
                $status = $rowbanned['status'];
                        
    ?>

<?php if(isset($_GET['msg']) && $_GET['msg'] == 'opened') { ?>
  <script>
      $(document).ready(function(){
          $("#openmodal").modal('show');
      });
  </script>
<?php } ?>

<?php if(isset($_GET['msg']) && $_GET['msg'] == 'closed') { ?>
  <script>
      $(document).ready(function(){
          $("#closedmodal").modal('show');
      });
  </script>
<?php } ?>

    <!-- <! OPEN MODAL !> -->
<div class="modal fade" id="openmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <center>
          <i class="text-success fas fa-fw fa-9x fa-lock-open"></i>
          <p style="font-weight: 900; font-size: 25px; margin-top: 10px;">Cererea de debanare a fost deschisa cu succes!</p>
        </center>
      </div>
    </div>
  </div>
</div>
<!-- <! OPEN MODAL !> -->

<!-- <! CLOSE MODAL !> -->
<div class="modal fade" id="closedmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <center>
          <i class="text-danger fas fa-fw fa-9x fa-lock"></i>
          <p style="font-weight: 900; font-size: 30px; margin-top: 10px;">Cererea de debanare a fost inchisa cu succes!</p>
        </center>
      </div>
    </div>
  </div>
</div>
<!-- <! CLOSE MODAL !> -->

<?php if($_SESSION['function'] >= 2) { ?>
<!-- BAN  MODAL -->

<div id="editbanmodal" class="modal fade" data-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Editeaza ban <b><?php echo $bannedusername; ?></b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="includes/php/ban.inc.php" method="POST">
      <div class="modal-body">
        <input type="hidden" name="banned-id"  value="<?php echo $bannedid; ?>">
        <input type="hidden" name="banned-username"  value="<?php echo $bannedusername; ?>">
        <input type="hidden" name="banned-ip"  value="<?php echo $bannedip; ?>">
        <input type="hidden" name="ban-list-id"  value="<?php echo $banlistid; ?>">
        <input type="hidden" name="unbanlist-id"  value="<?php echo $id; ?>">
        <p>Doresti sa editezi banul utilizatorului <?php echo $bannedusername; ?>?</p>
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
                            <option value="0">Permanent - Nu va expira niciodata(IP)</option> 
                            </optgroup> 
                            </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger" name="edit-ban-user">Editeaza Ban!</button>
      </div>
    </form>
    </div>
  </div>
</div>
    <!-- BAN  MODAL END -->

    <?php 
        require 'includes/php/connect.php';
        $sql1 = "SELECT * FROM users WHERE id = '$bannedid' LIMIT 1";
        $row1 = mysqli_fetch_assoc(mysqli_query($con, $sql1));
        if($row1['banned'] == 1) {
    ?>

<!-- UNBAN CONFIRMATION MODAL -->

            <!-- Modal -->
    <div id="unbanmodal" class="modal fade" data-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Debaneaza contul <?php echo $bannedusername; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="includes/php/ban.inc.php" method="POST">
                  <div class="modal-body">
                    <?php 
                        require 'includes/php/connect.php';
                        $sqlbanned = "SELECT * FROM banlist WHERE banneduserid = '$bannedid'";
                        $resultbanned = mysqli_query($con, $sqlbanned);
                        $rowban = mysqli_fetch_assoc($resultbanned);
                        $idban = $rowban['id'];
                        $banneduserid= $rowban['banneduserid'];
                        $bannedby1 = $rowban['bannedby'];
                        $reason1 = $rowban['reason'];
                        $permanent1 = $rowban['permanentbanned'];
                        $banduration1 = $rowban['banduration'];
                        $banneddate1 = $rowban['banneddate'];
                        $banneddate1 = strtotime($banneddate1);
                        $banneddate1 = date('d.m.Y H:i', $banneddate1);
                        $unbandate1 = $rowban['unbandate'];
                    ?>
                    <input type="hidden" name="ban-id" value="<?php echo $idban; ?>">
                    <input type="hidden" name="banned-username" value="<?php echo $bannedusername; ?>">
                    <input type="hidden" name="banned-id" value="<?php echo $banneduserid; ?>">
                    <input type="hidden" name="unbanrequest-id" value="<?php echo $id; ?>">
                    <p>Esti pe cale sa debanezi acest utilizator, esti sigur?</p>
                    <p><small><b>Detalii:</b></small></p>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item">Utilizatorul: <b><?php echo $bannedusername; ?></b></li>
                      <li class="list-group-item">Banat de: <b><?php echo $bannedby1; ?></b></li>
                      <li class="list-group-item">Data banari: <b><?php echo $banneddate1; ?></b></li>
                      <li class="list-group-item">Motivul banari: <b><?php echo $reason1; ?></b></li>
                      <li class="list-group-item">Tipul banului: <b><?php if($permanent1 == 1) {echo 'Permanent';} else { echo 'Temporar('.$banduration1.' zile)'; } ?></b></li>
                    </ul>
                    <p><small><b>Motivul debanari:</b></small></p>
                    <input type="text" class="form-control" name="unban-reason" placeholder="Introdu motivul (Obligatoriu)" required>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" name="unban-request-btn">Debaneaza Utilizator</button>
                  </div>
                </form>
                </div>
              </div>
            </div>
  <!-- UNBAN CONFIRMATION MODAL END -->
    <?php } ?>

<!-- CLOSE REQUEST MODAL -->

            <!-- Modal -->
            <div id="closerequestmodal" class="modal fade" data-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="dialog">
              <div class="modal-dialog" rolpe="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Confirmare inchidere!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="includes/php/ban.inc.php" method="POST">
                  <div class="modal-body">
                    <input type="hidden" name="close-request-id" value="<?php echo $id; ?>">
                    <input type="hidden" name="close-request-userid" value="<?php echo $bannedid; ?>">
                    <p>Esti sigur ca vrei sa inchizi cererea de debanare a utilizatorului "<b><?php echo $bannedusername; ?></b>"?</p>
                    <p class="text-secondary"><small>Daca apesi butonul <span class="badge badge-success">Inchide</span>, cererea va fi inchisa. Acesta poate fi deschisa in orice moment.</small></p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-sm" name="close-request">Inchide cererea</button>
                  </div>
                </form>
                </div>
              </div>
            </div>
  <!-- CLOSE REQUEST MODAL END -->

  <!-- OPEN REQUEST MODAL -->

            <!-- Modal -->
            <div id="openrequestmodal" class="modal fade" data-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Confirmare deschidere!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="includes/php/ban.inc.php" method="POST">
                  <div class="modal-body">
                    <input type="hidden" name="open-request-id" value="<?php echo $id; ?>">
                    <input type="hidden" name="open-request-userid" value="<?php echo $bannedid; ?>">
                    <p>Esti sigur ca vrei sa deschizi cererea de debanare a utilizatorului "<b><?php echo $bannedusername; ?></b>"?</p>
                    <p class="text-secondary"><small>Daca apesi butonul <span class="badge badge-danger">Deschide</span>, cererea va fi deschisa. Acesta poate fi inchisa in orice moment.</small></p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger btn-sm" name="open-request">Deschide cererea</button>
                  </div>
                </form>
                </div>
              </div>
            </div>
  <!-- OPEN REQUEST MODAL END -->
<?php } ?>

  <!-- EDIT COMMENT MODAL -->

            <!-- Modal -->
    <div id="editcommmodal" class="modal fade" data-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Editeaza comentariul tau.</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="includes/php/ban.inc.php" method="POST">
                  <div class="modal-body">
                    <?php 
                      require 'includes/php/connect.php';
                      $sql = "SELECT * FROM unbanrequestscomments WHERE unbanrequestid = '$id'";
                      $query = mysqli_query($con, $sql);
                        $row = mysqli_fetch_assoc($query);
                          $idcomm = $row['id'];
                          $usernamecom = $row['usernamecomm'];
                          $textcomm = $row['commtext'];
                    ?>
                    <input type="hidden" name="ban-id" value="<?php echo $idcomm; ?>">
                    <input type="hidden" name="banned-username" value="<?php echo $usernamecom; ?>">
                    <p><small><b>Comentariul:</b></small></p>
                    <textarea type="text" class="form-control" name="unban-reason" rows="5" required><?php echo $textcomm; ?></textarea>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-sm" name="edit-commrequest-btn">Editeaza comentariu.</button>
                  </div>
                </form>
                </div>
              </div>
            </div>
  <!-- EDIT COMMENT MODAL END -->

<div class="card-body" style="background-color: #fff;">
    <div class="breadcrumb">
            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
              <a href="dashboard.php" class="btn btn-primary">Dashboard</a>
              <a href="dashboard.php?action=unbanrequests" class="btn btn-primary">Cereri de debanare</a>
              <a href="dashboard.php?action=unbanrequests&unbanrequestview=<?php echo $id; ?>" class="btn btn-success">Cererea lui <?php echo $bannedusername; ?></a>
            </div>
        </div>
        <hr>
    <div class="row">
        <div class="col">
            <?php 
                require 'includes/php/connect.php';
                $sqlusers = "SELECT * FROM users WHERE id = '$bannedid'";
                $resultsusers = mysqli_query($con, $sqlusers);
                $rowusers = mysqli_fetch_assoc($resultsusers);
                    $usernameban = $rowusers['username'];
                    $firstnameban = $rowusers['firstname'];
                    $lastnameban = $rowusers['lastname'];
                    $emailban = $rowusers['email'];
                    $verifiedban = $rowusers['verified'];
                    $ipban = $rowusers['ip'];
                    $functionban = $rowusers['function'];
                    $banstatus = $rowusers['banned'];
            ?>
            <small><b><label class="mr-sm-2" for="username">Username: </label></b></small>
                <p style="padding-left: 15px;"><?php echo $usernameban; ?></p>
            <small><b><label class="mr-sm-2" for="username">IP: </label></b></small>
                <p style="padding-left: 15px;"><?php echo $ipban; ?></p>
            <small><b><label for="password">Rol: </label></b></small>
            <?php 
                if($functionban == 0)
                    echo '<p style="padding-left: 15px;"><span class="badge badge-secondary">Utilizator Normal</span></p>';
                if($functionban == 1)
                    echo '<p style="padding-left: 15px;"><span class="badge badge-primary">Moderator</span></p>';
                if($functionban == 2)
                    echo '<p style="padding-left: 15px;"><span class="badge badge-success">Administrator</span></p>';
                if($functionban == 3)
                    echo '<p style="padding-left: 15px;"><span class="badge badge-danger">Owner</span></p>';
            ?>
            <small><b><label class="mr-sm-2" for="username">Nume complet: </label></b></small>
                <p style="padding-left: 15px;"><?php echo $firstnameban.' '.$lastnameban; ?></p>
            <small><b><label class="mr-sm-2" for="email">Email: </label></b></small>
                <p style="padding-left: 15px;"><?php echo $emailban; ?></p>
            <small><b><label for="password">Statusul Contului: </label></b></small>
            <?php 
                if($verifiedban == 0)
                    echo '<p style="padding-left: 15px;"><span class="badge badge-danger">Cont Neverificat</span></p>';
                else
                    echo '<p style="padding-left: 15px;"><span class="badge badge-success">Cont Verificat</span></p>';
                if($banstatus == 0)
                    echo '<p style="padding-left: 15px;"><span class="badge badge-success">Cont Debanat</span></p>';
                else
                    echo '<p style="padding-left: 15px;"><span class="badge badge-danger">Cont Banat</span></p>';
            ?>
        </div>
        <div class="col">
                    <p><small><b>Detalii:</b></small></p>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item">Nume Utilizator: <b><a style="text-decoration: none;" href="profile.php?profil=<?php echo $bannedusername; ?>"><?php echo $bannedusername; ?></a></b></li>
                      <li class="list-group-item">Banat de: <b><a style="text-decoration: none;" href="profile.php?profil=<?php echo $bannedby; ?>"><?php echo $bannedby; ?></a></b></li>
                      <li class="list-group-item">Data banari: <b><?php echo $banneddate; ?></b></li>
                      <li class="list-group-item">Motivul banari: <b><?php echo $reason; ?></b></li>
                      <li class="list-group-item">Tipul banului: <b><?php if($permanent == 1) {echo 'Permanent';} else { echo 'Temporar('.$banduration.' zile)'; } ?></b></li>
                      <li class="list-group-item">Data debanari: <b><?php if($permanent == 1) {echo 'Niciodata';} else { echo $unbandate;  } ?></b></li>
                    </ul>
        </div>
                </div>
                <hr>
                    <small><b><label class="mr-sm-2" for="age">De ce consideri ca meriti sa fi debanat?: </label></b></small>
                    <p style="padding-left: 15px;"><?php echo $rowbanned['unbanrequesttext']; ?></p><br>
                <hr>
    <div class="row">
        <div class="col-md">
            <table style="justify-content: center; width: 100%;">
                <thead>
                    <tr>
                        <th><center><h5><i class="fa fa-sliders" aria-hidden="true"></i> ADMIN TOOLS</h5></center></th>
                    </tr>
                </thead>
                <tbody>
                <?php if($status == 0) { ?>
                    <tr>
                         <td><a href=#unbanmodal data-toggle="modal" type="button" class="btn btn-success btn-block <?php if($banstatus == 0) echo "disabled"; ?><?php if($_SESSION['function'] < 2) echo "disabled"; ?>" style="color: #fff;"><i class="fa fa-unlock" aria-hidden="true"></i> Debaneaza Cont</a></td>
                    </tr>
                    <tr>
                        <td><a href=#editbanmodal data-toggle="modal" type="button" class="btn btn-warning btn-block <?php if($_SESSION['function'] < 2) echo "disabled"; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true" ></i> Editeaza Banul</a></td>
                    </tr>
                    <tr>
                        <td><a href=#closerequestmodal data-toggle="modal" type="button" class="btn btn-danger btn-block <?php if($_SESSION['function'] < 2) echo "disabled"; ?>"><i class="fa fa-window-close" aria-hidden="true"></i> Inchide Cererea</a></td>
                    </tr>
                <?php } ?>
                <?php if($status == 1) { ?>
                    <tr>
                        <td><a href=#openrequestmodal data-toggle="modal" type="button" class="btn btn-success btn-block <?php if($_SESSION['function'] < 2) echo "disabled"; ?>"><i class="fa fa-external-link-square" aria-hidden="true"></i> Dechide Cererea</a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table><br>
        </div>
        <div class="col-md-10">
            <div class="card">
                <h5 class="card-header">Sectiunea de comentarii:</h5>
                <div class="card-body">
                    <?php if($status == 0) { ?>
                    <?php if(isset($_GET['msg']) && $_GET['msg'] == 'emptyfields') { ?>
                        <div class="alert alert-danger">Casuta in care se introduce comentariul este goala.</div>
                    <?php } ?>
                  <form action="includes/php/unbanrequest.inc.php" method="POST">
                      <input type="hidden" name="unbanrequest-id" value="<?php echo $id; ?>">
                      <textarea type="text" class="form-control card-text" name="unbanrequest-comm-text" placeholder="Scrie un comentariu..." rows="3"></textarea><br>
                      <button type="submit" class="btn btn-primary" name="unbanrequest-comm-btn" style="float:right;" <?php if($_SESSION['function'] < 2) echo "disabled"; ?>>Posteaza</button>
                  </form>
                </div>
                <hr>
            <?php } ?>
            <?php 
              require 'includes/php/connect.php';
              $sql = "SELECT * FROM unbanrequestscomments WHERE unbanrequestid = '$id' ORDER BY id DESC";
              $query = mysqli_query($con, $sql);
              if(mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_assoc($query)){
                  $usernamecom = $row['usernamecomm'];
                  $textcomm = $row['commtext'];
                $sqlimg = "SELECT profileimgname, profileimgstatus, function FROM users WHERE username = '$usernamecom'";
                $queryimg = mysqli_query($con, $sqlimg);
                $rowimg = mysqli_fetch_assoc($queryimg); 
                  $profileimgstatus = $rowimg['profileimgstatus'];
                  $profileimgname = $rowimg['profileimgname'];
                  $functionimg = $rowimg['function'];
            ?>

          <div class="card" style="margin: 20px;">
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
                        <p>
                            <a class="float-left" href="<?php echo 'profile.php?profil='.$usernamecom; ?>"><strong><?php echo $usernamecom; ?></strong></a>
            <?php 
                if($functionimg == 0)
                    echo '<span class="float-right badge badge-secondary">Utilizator Normal</span>';
                if($functionimg == 1)
                    echo '<span class="float-right badge badge-primary">Moderator</span>';
                if($functionimg == 2)
                    echo '<span class="float-right badge badge-success">Administrator</span>';
                if($functionimg == 3)
                    echo '<span class="float-right badge badge-danger">Owner</span>';
            ?>
                       </p>
                       <div class="clearfix"></div>
                        <p><?php echo $textcomm; ?></p>
                        <?php if($status == 0 && $_SESSION['username'] == $usernamecom) { ?>
                        <p><a href="#editcommmodal" data-toggle="modal" class="float-right btn btn-info ml-2 btn-sm"><i class="fa fa-edit"></i> Editeaza</a></p>
                        <?php } else { ?>
                            <br>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div><br>
        <?php 
            }
          } else {
        ?>
        <div class="card">
          <div class="card-body">
            <center><h5 class="card-text">Momentan nu este nici un comentariu.</h5></center>
          </div>
            </div>
        <?php } ?>
        </div>
    </div>
<?php } ?>
</body>
</html>