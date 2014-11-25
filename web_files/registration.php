<?php
session_start();

if(($_SERVER['HTTPS']!=="on"))
{
        $redir = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header("Location: $redir");
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Forms</title>
</head>
<body>
	<form method="POST">
		<!-- input for username -->
		<div>
			<label for="username">Admin Email:</label>
			<input type="text" id="username" name="username"/>
		</div>
		
		<!-- two inputs for pw, used to verify pw is correct when registering -->
		<div>
			<label for="pass">Enter Password:    </label>
			<input type="password" name="pass" required/>
		</div>
		<div>
			<label for="verifyPass">ReEnter Password:    </label>
			<input type="password" name="verifyPass" required/>
		</div>
		
		<!-- button to submit data -->
		<div>
			<input type="submit" name="submit" value="Submit"/>
		</div>	
	</form>

<?php

	//if submit button is pressed
	if(isset($_POST['submit']))
	{
		//connects to database
		include("../../secure/database.php");
		$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD);
	
		//if two entered passwords match up
		if($_POST['pass'] == $_POST['verifyPass'])
		{
			
			mt_srand(); // Seed number generator
			$salt = sha1(rand());//random salted number
			$pwhash = sha1($salt . $_POST['pass']);//concatenate random number and the password. salt the result
			
			//insert the username into user_info first
			$query = "INSERT INTO tonyspizza.user_info (username) VALUES ($1)";
			$stmt = pg_prepare($conn, "user_info", $query);
			echo 'Unable to execute:' . pg_last_error($conn);
			//sends query to database
			$result = pg_execute($conn, "user_info", array($_POST['username']));
			//if database doesnt return results print this
			if(!$result) {
				echo 'Unable to execute: ' . pg_last_error($conn);
				echo '<br /><br />Unable to add credenials<br />';
				echo 'Return to <a href="registration.php">Registration page</a>';
				break;
			}
			
			//insert everything into authentication second due to key constraints
			$query = "INSERT INTO tonyspizza.authentication(username, password_hash, salt) VALUES ($1, $2, $3)";
			$stmt = pg_prepare($conn, "authentication", $query);
			//sends query to database
			$result = pg_execute($conn, "authentication", array($_POST['username'], $pwhash, $salt));
			//if database doesnt return results print this
			if(!$result) {
				echo 'Unable to execute: ' . pg_last_error($conn);
				echo '<br /><br />Unable to add credenials<br />';
				echo 'Return to <a href="registration.php">Registration page</a>';
				break;
			}
			
			//log users actions in log table
			$query = "INSERT INTO tonyspizza.log (username, ip_address, action) VALUES ($1, $2, $3)";
			$stmt = pg_prepare($conn, "log", $query);
			//sends query to database
			$result = pg_execute($conn, "log", array($_POST['username'], $_SERVER['REMOTE_ADDR'], "register"));
			//if database doesnt return results print this
			if(!$result) {
				echo 'Unable to execute: ' . pg_last_error($conn);
				echo '<br /><br />Unable to add credenials<br />';
				echo 'Return to <a href="registration.php">Registration page</a>';
				break;
			}
			
			header("Location: login.php");
		}
		else
		{
			echo 'Passwords do not match';
		}
	}
	
?>
	
</body>
</html>
