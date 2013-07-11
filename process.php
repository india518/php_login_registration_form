<?php
session_start();

	if($_POST)
	{
		// $errors = array();
		$errors = NULL;

		//First name validation
		if ( empty($_POST["first_name"]) )
		{
			$errors["first_name"] = "First Name cannot be blank.";
		}
		else if ( is_numeric($_POST["first_name"]) )
		{
			$errors["first_name"] = "First Name cannot contain numbers.";
		}

		//Last name validation
		if ( empty($_POST["last_name"]) )
		{
			$errors["last_name"] = "Last Name cannot be blank.";
		}
		else if ( is_numeric($_POST["last_name"]) )
		{
			$errors["last_name"] = "Last Name cannot contain numbers.";
		}

		//Email validation
		if ( empty($_POST["email"]) )
		{
			$errors["email"] = "Email address cannot be blank.";
		}
		else if ( filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == FALSE )
		{
			$errors["email"] = "Email should be in valid format.";
		}

		//Birthdate validation
		// more useful if this is text field and not a datepicker,
		// but I'll leave this in for reference.
		if( !empty($_POST["birth_date"]) and !preg_match(" '\b(0?[1-9]|1[012])[- /.](0?[1-9]|[12][0-9]|3[01])[- /.](19|20)?[0-9]{2}\b' ", $_POST["birth_date"]) )
		{
			$errors["birth_date"] = "Birth Date should be in valid format.";
		}

		// Password
		if( empty($_POST["password"]) )
		{
			$errors["password"] = "Password cannot be blank.";
		}
		else if ( strlen($_POST["password"]) < 6 )
		{
			$errors["password"] = "Password should be at least 6 characters long";
		}

		//Confirm password validation
		if ( empty($_POST["confirm_password"]) )
		{
			$errors["confirm_password"] = "The Confirm Password field cannot be blank.";
		}
		else if ( $_POST["confirm_password"] != $_POST["password"] )
		{
			$errors["confirm_password"] = "Passwords do not match.";
		}

		if($errors == NULL)
		{
			$_SESSION["success_message"] = "Thank you for submitting your form!";
		}
		else
		{
			$_SESSION["error_messages"] = $errors;
		}
	}
	
	header("location: index.php");

?>