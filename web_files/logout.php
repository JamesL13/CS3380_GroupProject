<?php
	//carries session data
	session_start();
	
	//connect to db
	include("../../secure/database.php");
	$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD);
	
	$name = $_SESSION['username'];
	
	//log users actions in log table
	$query = "INSERT INTO TonysPizza.log(username, ip_address, action) VALUES ($1, $2, $3)";
	$stmt = pg_prepare($conn, "log", $query);
	//sends query to database
	$result = pg_execute($conn, "log", array($name, $_SERVER['REMOTE_ADDR'], "logged out"));
	//if database doesnt return results print this
	if(!$result) {
		die("Unable to execute: " . pg_last_error($conn));
	}
	
	//destroys session
	session_destroy();
	//navigates to login.php
	header('Location: login.php');
	
?>
