<?php
session_start();

/*
 EDIT.PHP
Allows user to edit specific entry in database
*/
 
// creates the edit record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
 
function renderForm($id, $num_fields, $row, $result, $error, $tn)
{
?>
<!DOCTYPE html>
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
     <!-- HEADER SECTION -->
<br /><br /><br />
<body>
<div class="container">
<div class="row text-center">
<div>
	<h2><strong>Edit The Table Below!</strong></h2><hr/>

	<form class="form-horizontal" action="" method="post">

	<?php
 	// if there are any errors, display them
		if ($error != '')
		{
			echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
		}
	?>
	<div class="form-group">
	<input type="hidden" name="id" value="<?php echo $id; ?>"/>
	<input type="hidden" name="tn" value="<?php echo $tn; ?>"/>
	</div>
	<div>
		<h3><strong>ID:</strong> <?php echo $id; ?></h3>
		<?php get_rows($num_fields, $row, $result); ?><br/>
	<div>
	<div>	
		<button class="btn btn-primary" type="submit" name="submit" value="Submit">Submit Changes</button>
		<button class="btn" type="submit" name="cancel" value="Cancel">Cancel</button>
	</div>
	</form>
</div>
</div>
</div>
</body>
</html>
<?php
}
 
// connect to the database
$conn = pg_connect("host= dbhost-pgsql.cs.missouri.edu user=cs3380f14grp2 password= 82rLygpv dbname= cs3380f14grp2");

// cancel add feature and redirect back to calling php
 if (isset($_POST['cancel']))
{
        header("Location: view.php");
}
 // check if the form has been submitted. If it has, process the form and save it to the database
if (isset($_POST['submit']))
{
 // confirm that the 'id' value is a valid integer before getting the form data
	if (is_numeric($_POST['id']))
	{
		$id = $_POST['id'];
		$tn = $_POST['tn'];
		 // query db
		$query = "SELECT * FROM tonyspizza." . $tn . " WHERE id=$1";

                $stmt = pg_prepare($conn, "s1", $query);
                $result = pg_execute($conn, "s1", array($id));

                if (!$result) die ("Query failed: " . pg_last_error());

                $row = pg_fetch_array($result, null, PGSQL_BOTH);
                 // check that the 'id' matches up with a row in the databse
                if($row)
                {
                         //variables for columns and rows
                        $num_fields = pg_num_fields ($result);
                        $num_rows = pg_num_rows ($result);
                }
                else
                // if no match, display result
                {
                        echo "No results!";
                }

		// get form data, making sure it is valid
		for ($i=1; $i<$num_fields; $i++)
        	{
			$ft=pg_field_type($result, $i);
        		$fn=pg_field_name($result, $i);

			if ($ft=='varchar')
			{
        			$fv=pg_escape_string(htmlspecialchars($_POST[$fn]));
				pg_query("UPDATE tonyspizza." . $tn . " SET $fn = '$fv' WHERE id='$id'")
					or die(pg_last_error());
			}
			else
			{
        			$fv=($_POST[$fn]);
				pg_query("UPDATE tonyspizza." . $tn . " SET $fn = $fv WHERE id='$id'")
					or die(pg_last_error());
			}
        	}

		header("Location: view.php");
	}
	else
	{
		// if the 'id' isn't valid, display an error
		echo "Error!";
	}
}
else
// if the form hasn't been submitted, get the data from the db and display the form
{
	 // get the 'id' value from the URL (if it exists), making sure that it is valid (checing that it is numeric/larger than 0)
	if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
	{
		// query db
		$id = $_GET['id'];
		$tn = $_SESSION['tn'];

		$query = "SELECT * FROM tonyspizza." . $tn . " WHERE id=$1";

                $stmt = pg_prepare($conn, "s2", $query);
                $result = pg_execute($conn, "s2", array($id));

                if (!$result) die ("Query failed: " . pg_last_error());

		$row = pg_fetch_array($result, null, PGSQL_BOTH);
		 // check that the 'id' matches up with a row in the databse
		if($row)
		{
			 //variables for columns and rows
			$num_fields = pg_num_fields ($result);
			$num_rows = pg_num_rows ($result);
 
			renderForm($id, $num_fields, $row, $result, '', $tn);
 
		}
		else
		// if no match, display result
		{
			echo "No results!";
		}
	}	
	else
	// if the 'id' in the URL isn't valid, or if there is no 'id' value, display an error
	{
		echo 'Error!';
	}
}
function get_rows($num_fields, $row, $result) 
{
	// get data from db
	for ($i=1; $i<$num_fields; $i++)
	{
	$fn=pg_field_name($result, $i);
	?>
		<div class="col-sm-6"><strong><?php echo $fn ?></strong> <input class="form-control" type="text" name="<?php echo $fn ?>" value="<?php echo $row[$i]; ?>"/><br/><br/></div>
	<?php
	}
}
?>
