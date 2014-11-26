<?php
/*
if(isset($_SESSION['username'])) {
	header("Location: Order.php");
        $_SESSION['username'] = $_POST['username'];
}
else*/
//starts session to carry data
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
	<title>Lab 8</title>
</head>
<body>
	<form method="POST">
		<!--Tonys Banner-->
		<div class="TonysBanner">
           	     <img id="TonysImg" src="images/TonysPizza.png" alt="Tonys" height="82px" width="644px">
	        </div>

		<!-- Text Input -->
		<div>
			<label for="username">Enter User Name:</label>
			<input type="text" id="username" name="username">
		</div>
		
		<!-- Password -->
		<div>
			<label for="pass">Enter Password:    </label>
			<input type="password" name="pass">
		</div>
		
		<!-- Submit -->
		<div>
			<input type="submit" name="submit" value="Submit"/>
			<input type="submit" name="submit" value="Register"/>
		</div>
	</form>
	<a href="AboutUs.html">Click here for more information about Tony's Pizza</a>

<?php
	//if submit button is pressed
	if(isset($_POST['submit']))
	{
		//connects to database
		include("../secure/database.php");
		$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD);
		
		//if button pressed is register
		if($_POST['submit'] == "Register")
		{
			//navigate to registration.php
			header("Location: registration.php");
		}
		//if button pressed is submit
		elseif($_POST['submit'] == "Submit")
		{
			$query = "SELECT salt, password_hash FROM tonyspizza.authentication WHERE username = $1";
			$stmt = pg_prepare($conn, "find_username", $query);
			//sends query to database
			$result = pg_execute($conn, "find_username", array($_POST['username']));
			//if database doesnt return results print this
			if(!$result) {
				die("Unable to execute: " . pg_last_error($conn));
			}
			
			//gets array from query
			$row = pg_fetch_assoc($result);
			//re hashes pw user entered with salt stored in db
			$localhash = sha1($row['salt'] . $_POST['pass']);
			
			//if pw entered and pw stored in db match
			if($localhash == $row['password_hash']){
				//navigate to Order.php
				header("Location: Order.php");
				$_SESSION['username'] = $_POST['username'];
				
				$query = "INSERT INTO tonyspizza.log(username, ip_address, action) VALUES ($1, $2, $3)";
				$stmt = pg_prepare($conn, "log", $query);
				//sends query to database
				$result = pg_execute($conn, "log", array($_POST['username'], $_SERVER['REMOTE_ADDR'], "logged in"));
				//if database doesnt return results print this
				if(!$result) {
					die("Unable to execute: " . pg_last_error($conn));
				}
			}
			else{
				//if username/pw is invalid, echo alert box
				echo "<script type='text/javascript'>window.alert('Invalid login credentials! Try again.')</script>";
			
			}
		}	
	}
?>

</body>
</html>
