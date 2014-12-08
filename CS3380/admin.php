<?php
//starts session to carry data
session_start();

if(!isset($_SESSION['username']) || $_SESSION['username']!='admin')
{
	header("Location: index.php");
	echo "<script type='text/javascript'>window.alert('Sorry, you must have special priviledges to view this page.')</script>";

	exit;
}
//starts session to carry data
session_start();
/*
if(($_SERVER['HTTPS']!=="on"))
{
    $redir = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: Order.php");
}*/
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
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
 
       
    <div class="row text-center">
    	<div class="col-md-10 col-md-offset-1 col-sm-12">
        	<h1>
                <strong> Welcome Tony's Pizza Employee's!</strong>
            </h1>
                <br />
                <h2>Click Below To Easily Make Menu Changes!</h2>
	</div>
    </div>
        
<br/><br/>
<div class="row text-center">
	<div class="col-md-10 col-md-offset-1 col-sm-12">
		<form action="" method="post">
			<button type="submit" name="tn" value="size_pizza">Modify Cheese, Single, and Additional Topping Prices</button><br /><br />
			<button type="submit" name="tn" value="dinners">Modify Dinners</button><br /><br />
			<button type="submit" name="tn" value="appetizers">Modify Appetizers</button><br /><br />
			<button type="submit" name="tn" value="specialtypizza">Modify Specialty Pizzas</button><br /><br />
		</form>
	</div>
</div>
<!--FOOTER SECTION -->
    <div class="navbar navbar-inverse navbar-fixed-bottom">
    	<div id="footer">
        	<div class="row ">
             	CS3380 group 2 | Tony's Pizza Online Ordering
        	</div>
    	</div>  
    </div> 
     <!--END FOOTER SECTION -->
</body>
</html> 

<?php
if(isset($_POST['tn']))
{
	$_SESSION['tn']=$_POST['tn'];
	header("Location: view.php");
}
?>
