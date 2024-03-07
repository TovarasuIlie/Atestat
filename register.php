<?php
  if(isset($_GET['error'])) {
        if($_GET['username'] !=  NULL)
          $username = $_GET['username'];
        else
          $username = '';

        if($_GET['email'] != NULL)
          $email = $_GET['email'];
        else
          $email = '';

        if($_GET['day'] != 0)
          $day = $_GET['day'];
        else
          $day = '';

                if($_GET['month'] != 0)
          $month = $_GET['month'];
        else
          $month = '';

                if($_GET['year'] != 0)
          $year= $_GET['year'];
        else
          $year = '';

        if($_GET['firstname'] != NULL)
          $firstname = $_GET['firstname'];
        else
          $firstname = '';

        if($_GET['lastname'] != NULL)
          $lastname = $_GET['lastname'];
        else
          $lastname = '';

        if($_GET['age'] != NULL)
          $age = $_GET['age'];
        else
          $age = '';

        if($_GET['country'] != NULL)
          $country = $_GET['country'];
        else
          $country = '';
  } else {
        $username = '';
        $email = '';
        $day = 0;
        $year = 0;
        $month = 0;
        $firstname = '';
        $lastname = '';
        $age = '';
        $country = '';
  }

  $luni = array('Alege Luna','Ianuarie', 'Februarie', 'Martie', 'Aprilie', 'Mai', 'Iunie', 'Iulie', 'August', 'Septembrie','Octombre', 'Noiembrie', 'Decembrie');

  $countries = array('Alege Judet', 'Alba', 'Arad', 'Arges','Bacau','Bihor','Bistrita-Nasaud','Botosani','Brasov','Braila','Buzau','Caras-Severin','Calarasi','Cluj','Constanta','Covasna','Dambovita','Dolj','Galati','Giurgiu','Gorj','Harghita','Hunedoara','Ialomita','Iasi','Ilfov','Maramures','Mehedinti','Mures','Neamt','Olt','Prahova','Satu Mare','Salaj','Sibiu','Suceava','Teleorman','Timis','Tulcea','Vaslui','Valcea','Vrancea');
  
  ?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Inregistreaza-ti un cont - VolvoFAN.ro</title>
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
  <div class="container-sm" style="background-color: #4d4d4d; height: 80px; width: 500px; border-top-left-radius: 6px; border-top-right-radius: 6px;"><center><img src="img/logo.png" height="30px" width="140px" title="VolvoFAN.ro" style="margin-top: 15px;"><p><small style="color: white;">Formular de Inregistrare</small></p></center></div>
  <div class="container-sm" style="width: 500px; background-color: #fff; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px;"><br>
                  <?php if(isset($_GET['error']) && $_GET['error'] == 'emptyfields') {
               echo '<div class="alert alert-danger alert-dismissible" id="alert">
                        Toate campurile trebuie completate!
                    </div>';
              }
              ?>
              <?php if(isset($_GET['error']) && $_GET['error'] == 'invalidmail') {
               echo '<div class="alert alert-warning alert-dismissible" id="alert">
                        Email-ul nu este unul valid!
                    </div>';
              }
              ?>
              <?php if(isset($_GET['error']) && $_GET['error'] == 'pwdnotmatch') {
               echo '<div class="alert alert-danger alert-dismissible" id="alert">
                        Parolele nu se potrivesc!
                    </div>';
              }
              ?>
              <?php if(isset($_GET['error']) && $_GET['error'] == 'stmtfail') {
               echo '<div class="alert alert-danger alert-dismissible" id="alert">
                        A aparut o eroare la STMT!
                     </div>';
              }
              ?>
              <?php if(isset($_GET['error']) && $_GET['error'] == 'usernameormailtaken') {
               echo '<div class="alert alert-warning alert-dismissible" id="alert">
                        Username-ul sau Email-ul sunt deja luate!
                    </div>';
              }
              ?>
              <?php if(isset($_GET['error']) && $_GET['error'] == 'findipbannedpermanent') {
               echo '<div class="alert alert-danger alert-dismissible" id="alert">
                        Nu va puteti crea cont, deoarece exista 2 conturi pe acelasi IP care este banat <b>Permanent</b>
                    </div>';
              }
              ?>
    <form class="form-group" method="POST" action="includes/php/register.inc.php">
      <small><b><label class="mr-sm-2" for="username">Username: </label></b></small>
      <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $username; ?>"><br>
      <small><b><label class="mr-sm-2" for="email">Email: </label></b></small>
      <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>"><br>
   <div class="row">
    <div class="col">
          <small><b><label for="password">Parola: </label></b></small>
          <input type="password" name="password" class="form-control" placeholder="Parola">
    </div>
        <div class="col">
          <small><b><label class="mr-sm-2" for="pwdrepeat">Confirma parola: </label></b></small>
          <input type="password" name="pwdrepeat" class="form-control" placeholder="Confirma parola">
    </div>
  </div><br>
  <div class="row">
     <div class="col">
          <small><b><label class="mr-sm-2" for="firstname">Nume: </label></b></small>
          <input type="text" name="firstname" class="form-control" placeholder="Nume" value="<?php echo $firstname; ?>">
    </div>
        <div class="col">
          <small><b><label class="mr-sm-2" for="latname">Prenume: </label></b></small>
          <input type="text" name="lastname" class="form-control" placeholder="Prenume" value="<?php echo $lastname; ?>">
    </div>
  </div><br>
   <div class="row">
     <div class="col">
          <small><b><label class="mr-sm-2" for="day">Zi: </label></b></small>
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
          <small><b><label class="mr-sm-2" for="month">Luna: </label></b></small>
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
          <small><b><label class="mr-sm-2" for="year">An: </label></b></small>
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
  </div><br>
      <small><b><label class="mr-sm-2" for="age">Ani: </label></b></small>
      <input type="text" name="age" class="form-control" placeholder="Ani" value="<?php echo $age; ?>"><br>
      <small><b><label class="mr-sm-2" for="country">Judet: </label></b></small>
      <select name="country" class="custom-select">
        <option value="0">Alege Judetul</option>
              <?php
                  for ($i=1; $i<=41; $i++)
                  {
                      ?>
                          <option value="<?php echo $i;?>" <?php if($i !=0) {if($country == $i ) echo 'selected';}?> ><?php echo $countries[$i];?></option>
                      <?php
                  }
              ?>
      </select>
     <div class="row">
                    <div class="col">
                    <div class="checkbox mb-3"><br>
                      <small>
                      <label>
                           <input type="checkbox" value="remember-me"> Tine-ma minte!
                      </label>
                    </small>
                         </div>
                       </div>
                         <div class="col"><br>
                          <small class="float-right">Ai deja un cont creat? <a href="index.php">Apasa aici</a></small>
                        </div>
                      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit" name="register-submit">Creaza-ti un cont!</button><br>
    </form>      
  </div>
  </body>
     <div class="footer fixed-bottom" style="background-color: rgb(0, 0, 0, 0.6);">
      <footer class="container">
            <div class="col">
                <p style="color: white; font-weight: bold; font-size: 13px;">&copy; 2020-<?php echo date('Y'); ?> Copyright. All Rights Reseved | by Niculai Ilie-Traian &copy;</p>
            </div>
      </footer>
    </div>
</html>