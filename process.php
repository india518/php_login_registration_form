<?php
session_start();

	function email_validation()
	{
		$message = NULL;

		if ( empty($_POST["email"]) )
		{
			$message = "Email address cannot be blank.";
		}
		else if (! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL )
		{
			$message = "Email should be in valid format.";
		}
		//return the string that we will store in $errors[email]
		return $message;
	}


	if( $_POST )
	{
		$errors = array();
		// $errors = NULL;

		//Validations for Login form:
		if( $_POST["action"] == "login" )
		{
			//email validation
			$message = email_validation();
			if (! $message )
				$errors["email"] = $message;

			// NOTE: I assume at some point there will
			// be a validation that the email address is in the database,
			// but there's no way to put that in right now!

			//password validation
			if( empty($_POST["password"]) )
				$errors["password"] = "Password cannot be blank.";
			else if ( strlen($_POST["password"]) < 6 )
				$errors["password"] = "Password should be at least 6 characters long";

			if( count($errors) > 0 )
				$_SESSION["login_error_messages"] = $errors;
			else
				$_SESSION["login_success_message"] = "Logged in sucessfully!";
		} //end $_POST["action"] == "login"

		//Validations for Registration form:
		if($_POST["action"] == "register")
		{
			//First name validation
			if ( empty($_POST["first_name"]) )
				$errors["first_name"] = "First Name cannot be blank.";
			else if ( is_numeric($_POST["first_name"]) )
				$errors["first_name"] = "First Name cannot contain numbers.";

			//Last name validation
			if ( empty($_POST["last_name"]) )
				$errors["last_name"] = "Last Name cannot be blank.";
			}
			else if ( is_numeric($_POST["last_name"]) )
				$errors["last_name"] = "Last Name cannot contain numbers.";

			//Email validation
			$message = email_validation();
			if (! $message )
				$errors["email"] = $message;

			//Birthdate validation
			// more useful if this is text field and not a datepicker,
			// but I'll leave this in for reference.
			if(! empty($_POST["birth_date"]) AND ! preg_match(" '\b(0?[1-9]|1[012])[- /.](0?[1-9]|[12][0-9]|3[01])[- /.](19|20)?[0-9]{2}\b' ", $_POST["birth_date"]) )
				$errors["birth_date"] = "Birth Date should be in valid format.";

			// Password
			if( empty($_POST["password"]) )
				$errors["password"] = "Password cannot be blank.";
			else if ( strlen($_POST["password"]) < 6 )
				$errors["password"] = "Password should be at least 6 characters long";

			//Confirm password validation
			if ( empty($_POST["confirm_password"]) )
				$errors["confirm_password"] = "The Confirm Password field cannot be blank.";
			else if ( $_POST["confirm_password"] != $_POST["password"] )
				$errors["confirm_password"] = "Passwords do not match.";

			if( count($errors) > 0 )
				$_SESSION["registration_error_messages"] = $errors;
			else
				$_SESSION["registration_success_message"] = "Thank you for submitting your form!";
		} //end $_POST["action"] == "register"

	}
	
	header("location: index.php");

?>