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
		return $message;
	}

	if ( isset($_POST['action']) AND $_POST["action"] == "login" )
		do_login();
	else if ( isset($_POST['action']) AND $_POST["action"] == "register" )
		do_registration();
	else
	{
		//We are assuming the user wants to log out
		session_destroy();
		header("location: index.php");
	}

	function do_login()
	{
		$errors = array();

		//First, we validate the email address format!
		$email_message = email_validation();
		if ( $email_message )
			$errors["email"] = $email_message;
		//I've removed the password format since it would have been
		// validated when the user registered. If the password field
		// is left blank, or is too short, it will not match the password
		// in the database anyway.

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
			if (! $user )
			{
				$_SESSION["login_error_messages"]["user"] = "There is no account with this email address. Try registering for a new account!";
					header("location: index.php");
			}
			else // we found a user!
			{
				// but is their password valid?
				if ( $_POST["password"] != $user["password"] )
				{
					$_SESSION["login_error_messages"]["password"] = "Incorrect password.";
					header("location: index.php");
				}
				else
				{
					// The password *is* valid!
					// Now, we create a user object (of sorts) and log them in!
					$_SESSION["user"]["first_name"] = $user["first_name"];
					$_SESSION["user"]["last_name"] = $user["last_name"];
					$_SESSION["user"]["email"] = $user["email"];
					$_SESSION["logged_in"] = true;
					header("location: wall.php");
					//yay!
				}
			}
		}
	} //end do_login()

	function do_registration()
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
		// The form uses a datepicker, but let's keep this for reference.
		// if(! empty($_POST["birth_date"]) AND ! preg_match(" '\b(0?[1-9]|1[012])[- /.](0?[1-9]|[12][0-9]|3[01])[- /.](19|20)?[0-9]{2}\b' ", $_POST["birth_date"]) )
		// 	$errors["birth_date"] = "Birth Date should be in valid format.";
		// Password format validation
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
			{
				$_SESSION["registration_error_messages"]["user"] = "A user with this email already exists. Try logging in!";
				header("location: index.php");
			}
			else
			{
				//NEXT: we have a new, unique user. Stick 'em in the database!
				$first_name = $_POST["first_name"];
				$last_name = $_POST["last_name"];
				$email = $_POST["email"];
				$password = $_POST["password"];
				$query = "INSERT INTO users (first_name, last_name, email, password, created_at) VALUES ('{$first_name}', '{$last_name}', '{$email}', '{$password}', NOW())";
				mysql_query($query);

				//Quick thought to look up later: is there a true/false value
				// associated with a mysql_query() command?
				//Would it be better practice to only product the following
				// message if the mysql_query() command returned true?
				$_SESSION["registration_success_message"] = "Thank you for submitting your information. Your new account has been created!";
				header("location: index.php");
			}
		}
	} //end do_registration()

?>