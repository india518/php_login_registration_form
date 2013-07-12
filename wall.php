<?php
	session_start();

	//if we're not logged in, redirect us to the login/registration page
	if ( !isset($_SESSION["logged_in"]) )
		header("location: index.php");
?>

<p>Hello <?= $_SESSION["user"]["first_name"] ?>, and welcome to the wall!</p>

<a href="process.php">Log Out</a>