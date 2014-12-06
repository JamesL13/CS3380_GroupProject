<?php
session_start();

/* 
 DELETE.PHP
 Deletes a specific entry from the passed table
*/

 // connect to the database
$conn = pg_connect("host= dbhost-pgsql.cs.missouri.edu user=cs3380f14grp2 password= 82rLygpv dbname= cs3380f14grp2");

 // check if the 'id' variable is set in URL, and check that it is valid
 if (isset($_GET['id']) && is_numeric($_GET['id']))
 {
 	// get id value
 	$id = $_GET['id'];
 	$tn = $_SESSION['tn'];
	print "alert('Are you sure you want to delete that item?')";
	// delete the entry
 	$query = "DELETE FROM tonyspizza." . $tn ."  WHERE id=$1";

        $stmt = pg_prepare($conn, "d1", $query);
        $result = pg_execute($conn, "d1", array($id));

        if (!$result) die ("Delete failed: " . pg_last_error());

	// redirect back to the view page
 	header("Location: view.php");
 }
 else
 	// if id isn't set, or isn't valid, redirect back to view page
 {
	 header("Location: view.php");
 }
 
?>
