<?php
session_start();
?>
<html lang="en">
<!--<![endif]-->
<!-- HEAD SECTION -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>Tony's Pizza</title>
    <!--GOOGLE FONT -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <!--BOOTSTRAP MAIN STYLES -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!--FONTAWESOME MAIN STYLE -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" />

    <!--CUSTOM STYLE -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
    <!--END HEAD SECTION -->
<body>
     <div class="loader"></div>

     <!-- NAV SECTION -->
    <div class="navbar navbar-inverse navbar-fixed-top">


        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div id="logo">
                	<a id="logo" href="index.php"><img src="assets/img/TonysPizzaBanner.jpg" alt="Tonys Pizza" style="width: 44%; position: relative;"></a>
            	</div>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="AboutUs.html">ABOUT US</a></li>
                    <li><a href="Order.php">ORDER</a></li>
                    <li><a href="admin.php">ADMINISTRATION</a></li>
                    <li><a href="logout.php">LOG OUT</a></li>
                <!--     <li><a href="pricing.html">PRICING</a></li>
                    <li><a href="founders.html">FOUNDERS</a></li>
                    <li><a href="contact.html">CONTACT</a></li>
                --></ul>
            </div>
        </div>
    </div>
     <!--END NAV SECTION -->
    <br/><br /><br />
 
<?php
/*
                VIEW.PHP
                Displays all data from 'players' table
*/
if (!isset($_SESSION['tn']))
{
	echo "Session Info not set ... Check your browser security settings" . '<br>';
	header("Location: view.php");
}

                // connect to the database
//		$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD);
$conn = pg_connect("host= dbhost-pgsql.cs.missouri.edu user=cs3380f14grp2 password= 82rLygpv dbname= cs3380f14grp2");

if (!$conn)
{
    die('Fail');
}
else
{
    echo "Success" .'<br>';
}
                // get results from database
		$query = "SELECT * FROM tonyspizza." . $_SESSION['tn'] . " order by 1";
                               
		$stmt = pg_prepare($conn, "s1", $query);
		$result = pg_execute($conn, "s1", array());

		if (!$result) die ("Query failed: " . pg_last_error());
 
                //variables for columns and rows
                $num_fields = pg_num_fields ($result);
                $num_rows = pg_num_rows ($result); 
 
                // display data in table
               
                echo "<table class='table table-striped'>";
 
                echo "</tr>";
                //loop displays column name headings
                for ($i=0; $i<$num_fields; $i++)
                {
				$fieldname = pg_field_name($result,$i);
                                echo "<th>$fieldname</th>\n";
                }
                echo "</tr>";
 
                // loop through results of database query, displaying them in the table
                while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                               
                                // echo out the contents of each row into a table
                                echo "<tr>\n";
                                foreach ($row as $col_value) {
                                echo "<td>$col_value</td>\n";
                                }
				echo '<td><strong><a href="edit.php?id=' . $row['id'] . '">Edit</a></strong></td>';
                                echo '<td><strong><a href="delete.php?id=' . $row['id'] .'">Delete</a></strong></td>';
                                echo "</tr>";
                }
 
                // close table>
                echo "</table>";


/*
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
 }*/

?>
<h3><strong><a href="add.php" class="btn">Add an item</a></strong></h3>
<h3><strong><a href="admin.php" class="btn">Administration Page</a></strong></h3>
</body>
</html>               
