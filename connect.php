<?php
// Change this to your connection info.
$DATABASE_HOST = "localhost";
$DATABASE_USER = "solomonh_niculai";
$DATABASE_PASS = "niculai";
$DATABASE_NAME = "solomonh_niculai";
$HOST_TYPE = "WEBHOST"; // Set host type (LOCALHOST / WEBHOST).
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	die ('Nu s-a reusit conectarea la Baza de Date. Motivul: ' . mysqli_connect_error());
}

?>