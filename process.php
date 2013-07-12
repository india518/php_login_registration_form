<?php
	require("connection.php");
	session_start();

	function email_validation()
	{
		$message = NULL;
		if ( empty($_POST["email"]) )
			$message = "Email address cannot be blank.";
		else if (! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) )
			$message = "Email should be in valid format.";
		//return the string that we will store in $errors[email]
		return $message;
	}

	if( $_POST )
	{
		$errors = array();

		//Validations for Login form:
		if( $_POST["action"] == "login" )
		{
			//email validation
			$email_message = email_validation();
			if ( $email_message )
				$errors["email"] = $email_message;

			//password validation
			if( empty($_POST["password"]) )
				$errors["password"] = "Password cannot be blank.";
			else if ( strlen($_POST["password"]) < 6 )
				$errors["password"] = "Password should be at least 6 characters long";

			if( count($errors) > 0 )
			{
				$_SESSION["login_error_messages"] = $errors;
				header("location: index.php");
			}
			else
			{
				// Check that user exists
				$query = "SELECT users.* FROM users WHERE users.email = '{$_POST['email']}'";
				$user = fetch_record($query);
				if ( $user )
				{
					//check that password is valid!
					if ( $_POST["password"] != $user["password"] )
					{
						$_SESSION["login_error_messages"]["password"] = "Incorrect password.";
						header("location: index.php");
					}
					else
					{
						// everything checks out, log in user!
						$_SESSION["login_success_message"] = "Logged in sucessfully!";
						header("location: wall.php");
					}
				}
				else
				{
					$_SESSION["login_error_messages"]["user"] = "There is no account with this email address. Try registering for a new account!";
						header("location: index.php");
				}
			}
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
			else if ( is_numeric($_POST["last_name"]) )
				$errors["last_name"] = "Last Name cannot contain numbers.";

			//Email validation
			$message = email_validation();
			if ( $message )
				$errors["email"] = $message;

			//Birthdate validation
			// The form uses a datepicker, but let's leave this for reference.
			// if(! empty($_POST["birth_date"]) AND ! preg_match(" '\b(0?[1-9]|1[012])[- /.](0?[1-9]|[12][0-9]|3[01])[- /.](19|20)?[0-9]{2}\b' ", $_POST["birth_date"]) )
			// 	$errors["birth_date"] = "Birth Date should be in valid format.";

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
			{
				$_SESSION["registration_error_messages"] = $errors;
				header("location: index.php");
			}
			else
			{
				//FIRST - check to see if user already exists
				$query = "SELECT users.* FROM users WHERE users.email = '{$_POST['email']}'";
				$user = fetch_record($query);

				if ( $user )
					$_SESSION["registration_error_messages"]["user"] = "A user with this email already exists. Try logging in!";
				else
				//SECOND - INSERT INTO database
				{
					$first_name = $_POST["first_name"];
					$last_name = $_POST["last_name"];
					$email = $_POST["email"];
					$password = $_POST["password"];
					$query = "INSERT INTO users (first_name, last_name, email, password, created_at) VALUES ('{$first_name}', '{$last_name}', '{$email}', '{$password}', NOW())";
					mysql_query($query);

					//echo $query;
					//die();
					$_SESSION["registration_success_message"] = "Thank you for submitting your information. Your new account has been created!";
					header("location: index.php");
				}
			}
		} //end $_POST["action"] == "register"

	}

?>