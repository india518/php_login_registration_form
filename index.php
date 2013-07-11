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

			<div id="display_messages"
			<?php
				if ( isset( $_SESSION["success_message"]) )
				{	?>
					class="success_border" </h3>
			<?php	echo "<h3>{$_SESSION['success_message']}</h3>";

				}
				else if ( isset( $_SESSION["error_messages"]) )
				{	?>
					class="error_border" </h3>
			<?php	foreach( $_SESSION["error_messages"] as $message )
					{
						echo "<h3>{$message}</h3>";
					}
				}	?>
			</div>

			<form id="registration" action="process.php" method="post">
				<div>
					<label for="first_name">* First Name: </label>
					<input type="text" name="first_name" id="first_name" placeholder="First Name" 
					<?= ( isset($_SESSION["error_messages"]["first_name"]) ) ?
							" class='highlight'" : ""	?> />
				</div>
				<div>
					<label for="last_name">* Last Name: </label>
					<input type="text" name="last_name" id="last_name" placeholder="Last Name" 
					<?= ( isset($_SESSION["error_messages"]["last_name"]) ) ?
							" class='highlight'" : ""	?> />
				</div>
				<div>
					<label for="email">* Email: </label>
					<input type="text" name="email" id="email" placeholder="Email Address" 
					<?= ( isset($_SESSION["error_messages"]["email"]) ) ?
							" class='highlight'" : ""	?> />
				</div>
				<div>		
					<label for="birth_date">Birth Date: </label>
					<input type="date" name="birth_date" id="birth_date" 
					<?= ( isset($_SESSION["error_messages"]["birth_date"]) ) ?
							" class='highlight'" : ""	?> />
				</div>
				<div>
					<label for="password">* Password: </label>
					<input type="password" name="password" id="password" placeholder="password" 
					<?= ( isset($_SESSION["error_messages"]["password"]) ) ?
							" class='highlight'" : ""	?> />
				</div>
				<div>
					<label for="confirm_password">* Confirm Password: </label>
					<input type="password" name="confirm_password" id="confirm_password" placeholder="confirm password" 
					<?= ( isset($_SESSION["error_messages"]["confirm_password"]) ) ?
							" class='highlight'" : ""	?> />
				</div>
				<input type="submit" value="Register" />
			</form>
		</div>
	</body>
</html>
<?php
	unset($_SESSION["success_message"]);
	unset($_SESSION["error_messages"]);
?>