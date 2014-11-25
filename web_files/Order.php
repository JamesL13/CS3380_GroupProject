<?php
session_start();

if(($_SERVER['HTTPS']!=="on"))
{
        $redir = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header("Location: $redir");
}
if(empty($_SESSION['username'])){
        header("Location: login.php");
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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

    <title>Ordering</title>
</head>
<body>
    <div class="TonysBanner">
        <img id="TonysImg" src="images/TonysPizza.png" alt="Tonys" height="82px" width="644px">
    </div>
    <div class="col-md-12">
        <nav class="navbar navbar-inverse" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href='index.php'>Tony's Pizza</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id=".navbar-collapse">
                    <ul class="nav navbar-nav navbar-center">
                        <li><a href="#">Order Now</a></li>

                        <li><a href="AboutUs.html">About Us</a></li>
			<li><a href="logout.php">Logout</a></li>
                    </ul>
                    <!--</ul>-->
                </div> <!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
    </div><!--col-md-12-->
    </nav>
    <div id="OrderBox">
    <div>
        <form method="POST" action="Order.php">

            <input type="radio" name="Small" values="Small">Small<br />
            <input type="radio" name="Medium" values="Medium">Medium<br />
            <input type="radio" name="Large" values="Large">Large<br />

            <hr ><!--Dividing Line-->

            <input type="checkbox" name="Onions" value="Onions">Onions<br />
            <input type="checkbox" name="Mushrooms" value="Mushrooms">Mushrooms<br />
            <input type="checkbox" name="Canadian_Bacon" value="Canadian_Bacon">Canadian Bacon<br />
            <input type="checkbox" name="Sausage" value="Sausage">Sausage<br />
            <input type="checkbox" name="Beef" value="Beef">Beef<br />
            <input type="checkbox" name="Anchovies" value="Anchovies">Anchovies<br />
            <input type="checkbox" name="Pepperoni" value="Pepperoni">Pepperoni<br />
            <input type="checkbox" name="Bacon" value="Bacon">Bacon<br />
            <input type="checkbox" name="Pepperjack Cheese" value="Pepperjack Cheese">Pepperjack Cheese<br />
            <input type="checkbox" name="Chicken" value="Chicken">Chicken<br />
            <input type="checkbox" name="Black Olive" value="Black Olive">Black Olive<br />
            <input type="checkbox" name="Jalapeno" value="Jalapeno">Jalapeno<br />
            <input type="checkbox" name="Shrimp" value="Shrimp">Shrimp<br />
            <input type="checkbox" name="Salami" value="Salami">Salami<br />
            <input type="checkbox" name="Green_Peppers" value="Green_Peppers">Green Peppers<br />
            <input type="checkbox" name="Pineapple" value="Pineapple">Pineapple<br />
            <input type="checkbox" name="Green_Olive" value="Green_Olive">Green Olive<br />
            <input type="checkbox" name="Gyros_Meat" value="Gyros_Meat">Gyros Meat<br />

            <hr ><!--Dividing Line-->

            <input type="radio" name="Veggie" value="Veggie">Veggie<br />
            <input type="radio" name="Meat_Lovers" value="Meat_Lovers">Meat_Lovers<br />
            <input type="radio" name="Tonys_Special" value="Tonys_Special">Tony's Special<br />
            <input type="radio" name="House_Special" value="House_Special">House Special<br />
            <input type="radio" name="The_Zeus" value="The_Zeus">The Zeus<br />

            <hr><!--Dividing Line-->

            <input type="checkbox" name="Fountain_Drinks" value="Fountain_Drinks">Fountain Drinks<br />
            <input type="checkbox" name="Soda_Pitcher" value="Soda_Pitcher">Soda Pitcher<br />
            <input type="checkbox" name="Bottle_Drinks" value="Bottle_Drinks">Bottle Drinks<br />

            <br />
            <input type="submit" name="submit" value="Execute" />
        </form>
    </div>
    </div><!--Order Box-->

</body>
</html>

<?php
include "../secure/database.php";

//Connect to Database using my credentials
$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD);
//$conn = pg_connect("host= dbhost-pgsql.cs.missouri.edu user=cs3380f14grp2 password= 82rLygpv dbname= cs3380f14grp2");

if (!$conn)
{
    die('Fail');
}
else
{
    echo "Success";
}

if(isset($_POST['submit']))
{
    echo "This works";
    $result = pg_query('SELECT name FROM TonysPizza.specialtypizza WHERE id = 1') or die ('Could not find pizza' . pg_last_error());

    $line = pg_fetch_array($result, null, PGSQL_ASSOC);
    
    echo '<i> $line <\i> Is what was returned';
}
?>
