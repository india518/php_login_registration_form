<?php
session_start();

	$min_password_length = 6;

	if ( empty($_POST["first_name"]) )
	{
		$_SESSION["errors"]["first_name"] = "The First Name field is empty!";
	}
	if ( empty($_POST["last_name"]) )
	{
		$_SESSION["errors"]["last_name"] = "The Last Name field is empty!";
	}
	if ( empty($_POST["email"]) )
	{
		$_SESSION["errors"]["email"] = "The Email field is empty!";
	}
	
	if ( empty($_POST["password"]) )
	{
		$_SESSION["errors"]["password"] = "The password field is empty!";
	}
	else if ( strlen($_POST["password"]) <= $min_password_length )
	{	
		if ( strlen($_POST["password"]) <= $min_password_length )
		//we have a password, check the length
		$_SESSION["errors"]["password"] = "The password should be more than 6 characters!";
	}

	//Maybe this should be refactored into one function,
	//called twice?
	if ( preg_match("#[\d]#", $_POST["first_name"]) )
	{
		$_SESSION["errors"]["first_name"] = "First name is invalid!";
		// Remember that you can't have a digit in an empty field!
	}
	if ( preg_match("#[\d]#", $_POST["last_name"]) )
	{
		$_SESSION["errors"]["last_name"] = "Last name is invalid!";
	}

	//validate email
	if(! (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) )
	{
		$_SESSION["errors"]["email"] =  "Invalid email!";
	}

	//validate birth_date
	// May come back to this - if we use the date picker,
	// this seems to validate itself before submission!
	// otherwise - use regex to check?
	if ( isset($_POST["birth_date"]) )
	{
		$birth_date = $_POST["birth_date"]; //for display purposes
	}

	//validate password = confirm_password
	if (! ($_POST["password"] == $_POST["confirm_password"]) )
	{
		$_SESSION["errors"]["confirm_password"] =  "The password fields do not match!";
	}

	if (! isset($_SESSION["errors"]) )
	{
		$_SESSION["success"] = "Thanks for submitting your information.";
	}

	//$_SESSION["birth_date"] = $birth_date;
	header("location: index.php");

?>