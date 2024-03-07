<?php
  session_start();
  $user = $_SESSION['resetusername'];
  $email = $_SESSION['resetemail'];
  unset($_SESSION['resetusername']);
  unset($_SESSION['resetemail']);
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Recupereaza-ti Parola - VolvoFAN.ro</title>
	    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">

        <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">    
    <link href="includes/style.css" rel="stylesheet">

   		<!-- Boostrap JavaScript -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
	<link href="includes/signin.css" rel="stylesheet">

  <style type="text/css">
body {
     background-image: url("https://i.imgur.com/T7bmQzL.jpg");
     background-repeat: no-repeat;
     height: 100%;
     background-position: center;
     background-attachment: fixed;
     background-size: cover;
 }
  </style>

  </head>
 <body><br>
  <?php if(!isset($_GET['action'])) {
      $user = NULL;
      $email = NULL;

   ?>
  <div class="container-sm" style="background-color: #4d4d4d; height: 80px; width: 500px; border-top-left-radius: 6px; border-top-right-radius: 6px;"><center><img src="img/logo.png" height="30px" width="140px" title="VolvoFAN.ro" style="margin-top: 15px;"><p><small style="color: white;">Recover your Password</small></p></center></div>
  <div class="container-sm" style="width: 500px; background-color: #fff; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px;"><br>
    <form class="form-group" method="POST" action="includes/php/recoverpassword.inc.php">
      <div class="alert alert-danger">
        Pentru ati recupera parola, te rugam sa introduci mai jos <b>email-ul</b> sau <b>username-ul</b> asociat contului, pentru ati putea trimite un <b>link de recuperare</b>.
      </div>
      <small><b><label class="mr-sm-2" for="username">Email sau Username: </label></b></small>
      <input type="text" name="recover-dates" class="form-control" placeholder="Email sau Username"><br>
    <?php if(isset($_GET['error']) && $_GET['error'] == 'emptyfields') {
               echo '<div class="alert alert-danger alert-dismissible" id="alert">
                        Toate campurile trebuie completate!
                </div>';
              }
              ?>
              <?php if(isset($_GET['error']) && $_GET['error'] == 'pwdnotmatch') {
               echo '<div class="alert alert-danger alert-dismissible" id="alert">
                        Parolele nu se potrivesc!
                </div>';
              }
              ?>
              <?php if(isset($_GET['error']) && $_GET['error'] == 'invalidmailorusername') {
               echo '<div class="alert alert-danger alert-dismissible" id="alert">
                        Username-ul sau email-ul introdus nu este asociat niciunui cont.
                </div>';
              }
              ?>
      <button class="btn btn-lg btn-primary btn-block btn-sm" type="submit" name="recoverpwd-btn">Trimite email!</button><br>
    </form>      
  </div>
<?php } ?>

  <?php if(isset($_GET['action']) && $_GET['action'] == 'emailsend')
          if(isset($user) && isset($email)) {
   ?>
  <div class="container-sm" style="background-color: #4d4d4d; height: 80px; width: 500px; border-top-left-radius: 6px; border-top-right-radius: 6px;"><center><img src="img/logo.png" height="30px" width="140px" title="VolvoFAN.ro" style="margin-top: 15px;"><p><small style="color: white;">Recover your Password</small></p></center></div>
  <div class="container-sm" style="width: 500px; background-color: #fff; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px;"><br>
      <div class="alert alert-success">
        Un email a fost trimis pe adresa de email <b><?php echo $email; ?></b> pentru a reseta parola de la contul <b><?php echo $user;?></b>. Va rugam sa va accesati email-ul.
      </div><br>
  </div>
<?php } else { ?>
  <div class="container-sm" style="background-color: #4d4d4d; height: 80px; width: 500px; border-top-left-radius: 6px; border-top-right-radius: 6px;"><center><img src="img/logo.png" height="30px" width="140px" title="VolvoFAN.ro" style="margin-top: 15px;"><p><small style="color: white;">Recover your Password</small></p></center></div>
  <div class="container-sm" style="width: 500px; background-color: #fff; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px;"><br>
      <div class="alert alert-danger">
        Email-ul sau Username-ul nu ai fost gasite in baza de date. Te rugam sa verifici datele inainte de a continua.
      </div><br>
  </div>
<?php } ?>

<?php if(isset($_GET['action']) && $_GET['action'] == 'resetpwd') 
        if(isset($_SESSION['idreset']) && isset($_SESSION['usernamereset']) && isset($_SESSION['tokenreset'])) {
?>
<div class="container-sm" style="background-color: #4d4d4d; height: 80px; width: 500px; border-top-left-radius: 6px; border-top-right-radius: 6px;"><center><img src="img/logo.png" height="30px" width="140px" title="VolvoFAN.ro" style="margin-top: 15px;"><p><small style="color: white;">Recover your Password</small></p></center></div>
  <div class="container-sm" style="width: 500px; background-color: #fff; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px;"><br>
    <form class="form-group" method="POST" action="includes/php/recoverpassword.inc.php">
      <div class="alert alert-success">
        Pentru ati reseta parola, te rugam sa introduci noua parola in casutele de mai jos.
      </div>
      <input type="hidden" name="id-reset" value="<?php echo $_SESSION['idreset']; ?>">
      <input type="hidden" name="username-reset" value="<?php echo $_SESSION['usernamereset']; ?>">
      <input type="hidden" name="token-reset" value="<?php echo $_SESSION['tokenreset']; ?>">
      <small><b><label class="mr-sm-2">Introduce-ti noua parola: </label></b></small>
      <input type="password" name="pwd" class="form-control" placeholder="Noua parola.."><br>
      <small><b><label class="mr-sm-2">Confirmati noua parola: </label></b></small>
      <input type="password" name="repeat-pwd" class="form-control" placeholder="Confirmati noua parola.."><br>
    <?php if(isset($_GET['error']) && $_GET['error'] == 'emptyfields') {
               echo '<div class="alert alert-danger alert-dismissible" id="alert">
                        Toate campurile trebuie completate!
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                      </button>
                </div>';
              }
              ?>
              <?php if(isset($_GET['error']) && $_GET['error'] == 'pwdnotmatch') {
               echo '<div class="alert alert-danger alert-dismissible" id="alert">
                        Parolele nu se potrivesc!
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                      </button>
                </div>';
              }
              ?>
              <?php if(isset($_GET['error']) && $_GET['error'] == 'notreset') {
               echo '<div class="alert alert-danger alert-dismissible" id="alert">
                        A aparut o eroare. Te rugam sa incerci din nou.
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                      </button>
                </div>';
              }
              ?>
      <button class="btn btn-lg btn-primary btn-block btn-sm" type="submit" name="resetpwd-btn">Reseteaza parola!</button><br>
    </form>      
  </div>
<?php } else { ?>
 <div class="container-sm" style="background-color: #4d4d4d; height: 80px; width: 500px; border-top-left-radius: 6px; border-top-right-radius: 6px;"><center><img src="img/logo.png" height="30px" width="140px" title="VolvoFAN.ro" style="margin-top: 15px;"><p><small style="color: white;">Recover your Password</small></p></center></div>
  <div class="container-sm" style="width: 500px; background-color: #fff; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px;"><br>
      <div class="alert alert-danger">
        Parola a fost resetata recent!.
      </div><br>
  </div>
<?php } ?>
  </body>
   <div class="footer fixed-bottom" style="background-color: rgb(0, 0, 0, 0.6);">
      <footer class="container">
        <div class="row">
            <div class="col">
                <p style="color: white; font-weight: bold; font-size: 13px;">&copy; 2020-<?php echo date('Y'); ?> Copyright. All Rights Reseved | by Niculai Ilie-Traian &copy;</p>
            </div>
            <div class="col">
                <p class="float-right"><button class="btn btn-sm btn-outline-primary" style="font-weight: bold; margin-top: 9px; margin-bottom: -9px;" id="gotop" onclick="goTop()"> <i class="fas fa-chevron-up"></i> Back to Top</button></p>>
            </div>
        </div>
      </footer>
    </div>
</html>