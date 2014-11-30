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

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.panelgallery-2.0.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/ajax.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Exo+2:400,800' rel='stylesheet' type='text/css'>

	
</head>
<body>
	<form method="POST">
		<div class="imgbackground">
		<!--Tonys Banner-->
		<div class="TonysBanner">
           	     <img id="TonysImg" src="images/TonysPizza.png" alt="Tonys">
	        </div>
	    </div><!--img background-->
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

        			//retrieves the appropriate info from user_info table
         			$query = 'SELECT phone_number FROM tonyspizza.user_info WHERE username = $1';
                		$stmt = pg_prepare($conn, "retrieve_user_info", $query);
                		//sends query to database
                		$result = pg_execute($conn, "retrieve_user_info", array($_SESSION['username']));
                		//if database doesnt return results print this
                        	if(!$result) {
                                	echo "execute failed" . pg_last_error($conn);
                        	}
                		$result = pg_fetch_array($result,0,PGSQL_ASSOC) or die("Query failed: " . pg_last_error());
                		$phone_number = $result["phone_number"];

        			//Deletes all rows from the order table
           			$query = 'DELETE FROM tonyspizza.orders WHERE phone_number = $1';
                		$stmt = pg_prepare($conn, "delete_user_order_table", $query);
                		//sends query to database
                		$result = pg_execute($conn, "delete_user_order_table", array($phone_number));
                		//if database doesnt return results print this
				echo "return = " . $return;
                        	if(!$result) {
                               	 	echo "execute failed" . pg_last_error($conn);
                        	}
				echo $phone_number;
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
