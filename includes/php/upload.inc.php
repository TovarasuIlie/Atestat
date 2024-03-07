<?php
  session_start();
  require 'connect.php';

  $id = $_SESSION['id'];
  $username = $_SESSION['username'];

  // If upload button is clicked ... 
  if (isset($_POST['profilepicture'])) { 

      $sqlimg = "SELECT profileimgname FROM users WHERE id ='$id'";
      $result = mysqli_query($con, $sqlimg);
      $row = mysqli_fetch_assoc($result);
      if($row['profileimgname'] != NULL)
        unlink('profilepictures/'.$row['profileimgname']);

    $file = $_FILES['profile-picture'];

    $filename = $file["name"]; 
    $tempname = $file["tmp_name"];  
    $filesize = $file["size"];    
    $fileerror = $file["error"];
    $filetipe = $file["type"];  

    $fileext = explode('.', $filename);
    $fileactualext = strtolower(end($fileext));

    $allowed = array('jpg', 'jpeg', 'png', 'gif');

    if(in_array($fileactualext, $allowed)) {
      if($fileerror == 0) {
        if($filesize < 3000000) {
          $filenewname = "profileimg".$id.".".$username.".".mt_rand().".".$fileactualext;
          $filedestination = 'profilepictures/'.$filenewname;
          move_uploaded_file($tempname, $filedestination);
          $sql = "UPDATE users SET profileimgstatus = 1, profileimgname = '$filenewname' WHERE id = '$id'"; 
          mysqli_query($con, $sql); 
          header("location: ../../profile.php?profil=".$_SESSION['username']."&msg=succesupload"); 
          } else {
          header("location: ../../profile.php?profil=".$_SESSION['username']."&msg=toobig");
        }
      } else {
         header("location: ../../profile.php?profil=".$_SESSION['username']."&msg=errortoupload");
      }
    } else {
     header("location: ../../profile.php?profil=".$_SESSION['username']."&msg=isntimg");
    }
  } 

?>