<?php
session_start();

    //if submit button is pressed
    if(isset($_POST['submit']))
    {
        //connects to database
        include("../secure/database.php");
        $conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD);
         
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

	    if($_POST['username'] == 'admin' && $localhash == $row['password_hash']){
		$_SESSION['username'] = $_POST['username'];
		header("Location: admin.php");

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
                            if(!$result) {
                                    echo "execute failed" . pg_last_error($conn);
                            }

            } 
            //if pw entered and pw stored in db match
            else if($localhash == $row['password_hash']){
                //navigate to Order.php
                $_SESSION['username'] = $_POST['username'];
                header("Location: Order.php");

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
                            if(!$result) {
                                    echo "execute failed" . pg_last_error($conn);
                            }

            }
            else{
                //if username/pw is invalid, echo alert box
                echo "<script type='text/javascript'>window.alert('Invalid login credentials! Try again.')</script>";

            
            }
  //      }   
    }

    //if submit button is pressed
    if(isset($_POST['register']))
    {
        //connects to database
        include("../secure/database.php");
        $conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD);
    
        //if two entered passwords match up
        if($_POST['pass'] == $_POST['verifyPass'])
        {
            
            mt_srand(); // Seed number generator
            $salt = sha1(rand());//random salted number
            $pwhash = sha1($salt . $_POST['pass']);//concatenate random number and the password. salt the result
            
            //insert the username into user_info first
            $query = "INSERT INTO tonyspizza.user_info (username, phone_number) VALUES ($1, $2)";
            $stmt = pg_prepare($conn, "user_info", $query);
            //sends query to database
            $result = pg_execute($conn, "user_info", array($_POST['username'], $_POST['phone_number']));
            //if database doesnt return results print this
            if(!$result) {
                 echo "<script type='text/javascript'>window.alert('User Name already exists! Please try again.')</script>";
                break;
            }
            
            //insert everything into authentication second due to key constraints
            $query = "INSERT INTO tonyspizza.authentication(username, password_hash, salt) VALUES ($1, $2, $3)";
            $stmt = pg_prepare($conn, "authentication", $query);
            //sends query to database
            $result = pg_execute($conn, "authentication", array($_POST['username'], $pwhash, $salt));
            //if database doesnt return results print this
            if(!$result) {
                echo "<script type='text/javascript'>window.alert('Unable to add credenials')</script>";
                break;
            }
            
            //log users actions in log table
            $query = "INSERT INTO tonyspizza.log (username, ip_address, action) VALUES ($1, $2, $3)";
            $stmt = pg_prepare($conn, "log", $query);
            //sends query to database
            $result = pg_execute($conn, "log", array($_POST['username'], $_SERVER['REMOTE_ADDR'], "register"));
            //if database doesnt return results print this
            if(!$result) {
                echo "<script type='text/javascript'>window.alert('Unable to add credenials')</script>";
                break;
            }
            /*echo "<script type='text/javascript'>window.alert('Congrats! You registered! Please sign in now so you can order!')</script>";
            */header("Location: Order.php");
        }
        else
        {
            echo "<script type='text/javascript'>window.alert('Passwords Do Not Match')</script>";
        }
    }
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
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
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
    <script type="text/javascript">
    	$(function(){
    		$('#slider').panelGallery({
    			boxSize:50,
    			boxFadeDuration:1000,
    			boxTransitionDuration:100,
    			FX: new Array('fade')
    			//boxSouthEast','fade','boxRandom','panelZipperDown,true','panelZipperRight,true','panelTeethDown,true','panelTeethRightReveal')
    		});
    	});
    </script>
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.panelgallery-2.0.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/ajax.js"></script>
    <script src="assets/custom.js"></script>
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
  <div id = "header-section">
  		
       <!-- <div class="container">
            <div class="row text-center">
                <div class="col-md-10 col-md-offset-1 col-sm-12">
                   <h1>
			<strong> Welcome to Tony's Pizza Palace!</strong>          
                   </h1>
                     <br /> <br /> <br />
                   <h2>THE GREEK PIZZA YOU NEED TO TRY! </h2>
                     <br />
                   <h3>  NOW YOU CAN ORDER ONLINE! CLICK ABOVE! </h3>
                     <br /><br />
                </div>
            </div>     
        </div>-->
        
   </div> 
      <!--END HEADER SECTION -->
     <!-- BASIC INFO SECTION -->
   <div id="basic-info">
   		<div class="container-fluid">
<div class="row-fluid">
<div class="span12">
    <div class="carousel slide" id="myCarousel">
        <div class="carousel-inner">
            <div class="item active">
                <div class="bannerImage">
                    <img src="assets/img/food/hot_pizza.jpg" alt="Hot Pizza" style="width: 70%; position: relative; left: 15%;">
                </div>                                      
            </div><!-- /Slide1 --> 
            <div class="item">
                <div class="bannerImage">
                    <img src="assets/img/food/gyro_sandwich.jpg" alt="Gyro Sandwich" style="width: 63.5%; position: relative; left: 18%;">
                </div>                                       
            </div><!-- /Slide2 -->             
            <div class="item">
                <div class="bannerImage">
                    <img src="assets/img/food/baklava.jpg" alt="Baklava" style="width: 70.3%; position: relative; left: 15%;">
                </div>                                 
            </div><!-- /Slide3 --> 
            <div class="item">
                <div class="bannerImage">
                    <img src="assets/img/food/onion_rings.jpg" alt="Onion Rings" style="width: 62.3%; position: relative; left: 19%;">
                </div>                                 
            </div><!-- /Slide4 -->                     
        </div>
        <div class="control-box">                            
            <a data-slide="prev" href="#myCarousel" class="carousel-control left">‹</a>
            <a data-slide="next" href="#myCarousel" class="carousel-control right">›</a>
        </div><!-- /.control-box -->                         
    </div><!-- /#myCarousel -->    
</div><!-- /.span12 -->          
</div><!-- /.row --> 
</div><!-- /.container -->
   
		<div class="login-container">
			<form method="POST">
                		<div class="col-md-8 col-md-offset-2 " >
                    		<h1>Login</h1>
        					<div class="textbox">
            					<label for="username">Enter User Name:</label>
            					<input type="text" id="username" name="username">
        					</div>
        					<!-- Password -->
        					<div class = "textbox">
            					<label for="pass">Enter Password:</label>
            					<input type="password" name="pass">
        					</div>
        					<!-- Submit -->
        					<div>
            					<input type="submit" name="submit" value="Submit"/>
        					</div>
        					<a href="AboutUs.html">Click here for more information about Tony's Pizza</a>
        				</div>
     		</form>
        </div>
	
		<div class="registration-container">
     		<form method="POST">
         			<div class="col-md-8 col-md-offset-2 " >
         				<h1>Register</h1>
         				<div>
         					<label for="username">User Name:</label>
         					<input type="text" id="username" name="username"/>
         				</div>
         				<div>
                			<label for="phoneNumber">Phone Number:</label>
                			<input type="text" id="phone_number" name="phone_number"/>
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
        				<!-- Submit -->
        				<div>
            				<input type="submit" name="register" value="Register"/>
        				</div>
        			</div>
    		</form>
		</div>        
   </div>
    <!--END BASIC INFO SECTION -->
    <!--FOOTER SECTION -->
    <div class="navbar navbar-inverse navbar-fixed-bottom">
    	<div id="footer">
        	<div class="row ">
             	CS3380 group 2 | Tony's Pizza Online Ordering
        	</div>
    	</div>  
    </div>
     <!--END FOOTER SECTION -->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY LIBRARY -->
    <script src="assets/js/jquery.js"></script>
    <!-- CORE BOOTSTRAP LIBRARY -->
    <script src="assets/js/bootstrap.min.js"></script>
           <!-- CUSTOM SCRIPT-->
    <script src="assets/js/custom.js"></script>
    
</body>
</html>
