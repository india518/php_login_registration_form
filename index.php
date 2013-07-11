<?php
	session_start();
?>
<!DOCTYPE HTML>
<html lang="en-US">
	<head>
		<meta charset="UTF-8">
		<title>User Login</title>
		<link rel="stylesheet" type="text/css" href="css/registration.css">
	</head>
	<body>
		<div id="wrapper">

			<div id="testing" class="hidden">
				<!-- hide this for now; may need it for debugging later -->
				<?php
					echo "<p>" . $_SESSION["birth_date"] . "</p>";
				?>
			</div>

	<?php
			if ( isset($_SESSION["errors"]) )
			{
				//display all error messages in "errors" array
				foreach($_SESSION["errors"] as $error)
				{	?>
		 			<h3 id="error_display">
	<?php		 		echo $error;	?>
					</h3>	
	<?php		}	
			}	?>

	<?php
			if ( isset($_SESSION["success"]) )
			{	?>
		 		<h3 id="registration_success">
	<?php			echo $_SESSION["success"];	?>
				</h3>		
	<?php	}	?>

			<form id="registration" action="process.php" method="post">
				<div>
					<label for="first_name">* First Name: </label>
					<input type="text" name="first_name" id="first_name"
					<?= ( isset($_SESSION["errors"]["first_name"]) ) ?
							" class='error_highlight'" : ""	?> />
				</div>
				<div>
					<label for="last_name">* Last Name: </label>
					<input type="text" name="last_name" id="last_name"
					<?= ( isset($_SESSION["errors"]["last_name"]) ) ?
							" class='error_highlight'" : ""	?> />
				</div>
				<div>
					<label for="email">* Email: </label>
					<input type="text" name="email" id="email"
					<?= ( isset($_SESSION["errors"]["email"]) ) ?
							" class='error_highlight'" : ""	?> />
				</div>
				<div>		
					<label for="birth_date">Birth Date: </label>
					<input type="date" name="birth_date" id="birth_date"
					<?= ( isset($_SESSION["errors"]["birth_date"]) ) ?
							" class='error_highlight'" : ""	?> />
				</div>
				<div>
					<label for="password">* Password: </label>
					<input type="password" name="password" id="password"
					<?= ( isset($_SESSION["errors"]["password"]) ) ?
							" class='error_highlight'" : ""	?> />
				</div>
				<div>
					<label for="confirm_password">* Confirm Password: </label>
					<input type="password" name="confirm_password" id="confirm_password"
					<?= ( isset($_SESSION["errors"]["confirm_password"]) ) ?
							" class='error_highlight'" : ""	?> />
				</div>
				<input type="submit" value="Login" />
			</form>
		</div>
	</body>
</html>
<?php
	unset($_SESSION["errors"]);
	unset($_SESSION["success"]);
?>