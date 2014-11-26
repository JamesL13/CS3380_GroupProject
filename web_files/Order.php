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
    <div>
    <iframe src="CurrentOrder.php">

    </iframe>
    </div>
    <div id="OrderBox">
    <div>
        <form method="POST" action="Order.php">
	<h3>Cheese Pizza</h3>
            <input class="rbuttons" type="radio" name="CSmall" values="CSmall">Small<br />
            <input class="rbuttons" type="radio" name="CMedium" values="CMedium">Medium<br />
            <input class="rbuttons" type="radio" name="CLarge" values="CLarge">Large<br />

            <hr ><!--Dividing Line-->
	<h3>Single Topping Pizza</br>
	    <input class="rbuttons" type="radio" name="OneTopSmall" values="OneTopSmall">Small<br />
            <input class="rbuttons" type="radio" name="OneTopMedium" values="OneTopMedium">Medium<br />
            <input class="rbuttons" type="radio" name="OneTopLarge" values="OneTopLarge">Large<br />
	<select>
            <option value="Onions">Onions</option>
            <option value="Mushrooms">Mushrooms</option>
            <option value="Canadian_Bacon">Canadian Bacon</option>
            <option value="Sausage">Sausage</option>
            <option value="Beef">Beef</option>>
            <option value="Anchovies">Anchovies</option>>
            <option value="Pepperoni">Pepperoni</option>>
            <option value="Bacon">Bacon</option>>
            <option value="Pepperjack Cheese">Pepperjack Cheese</option>>
            <option value="Chicken">Chicken</option>>
            <option value="Black Olive">Black Olive</option>>
            <option value="Jalapeno">Jalapeno</option>>
            <option value="Shrimp">Shrimp</option>>
            <option value="Salami">Salami</option>>
            <option value="Green_Peppers">Green Peppers</option>>
            <option value="Pineapple">Pineapple</option>>
            <option value="Green_Olive">Green Olive</option>>
            <option value="Gyros_Meat">Gyros Meat</option>>
	</select>
            <hr ><!--Dividing Line-->

	<h3>Customize Your Pizza.</h3>
	    <input class="rbuttons" type="radio" name="CustomSmall" values="CustomSmall">Small<br />
            <input class="rbuttons" type="radio" name="CustomMedium" values="CustomMedium">Medium<br />
            <input class="rbuttons" type="radio" name="CustomLarge" values="CustomLarge">Large<br /><br />
    
            <input type="checkbox" name="val[]" value="Onions">Onions<br />
            <input type="checkbox" name="val[]" value="Mushrooms">Mushrooms<br />
            <input type="checkbox" name="val[]" value="Canadian_Bacon">Canadian Bacon<br />
            <input type="checkbox" name="val[]" value="Sausage">Sausage<br />
            <input type="checkbox" name="val[]" value="Beef">Beef<br />
            <input type="checkbox" name="val[]" value="Anchovies">Anchovies<br />
            <input type="checkbox" name="val[]" value="Pepperoni">Pepperoni<br />
            <input type="checkbox" name="val[]" value="Bacon">Bacon<br />
            <input type="checkbox" name="val[]" value="Pepperjack Cheese">Pepperjack Cheese<br />
            <input type="checkbox" name="val[]" value="Chicken">Chicken<br />
            <input type="checkbox" name="val[]" value="Black Olive">Black Olive<br />
            <input type="checkbox" name="val[]" value="Jalapeno">Jalapeno<br />
            <input type="checkbox" name="val[]" value="Shrimp">Shrimp<br />
            <input type="checkbox" name="val[]" value="Salami">Salami<br />
            <input type="checkbox" name="val[]" value="Green_Peppers">Green Peppers<br />
            <input type="checkbox" name="val[]" value="Pineapple">Pineapple<br />
            <input type="checkbox" name="val[]" value="Green_Olive">Green Olive<br />
            <input type="checkbox" name="val[]" value="Gyros_Meat">Gyros Meat<br />
	<hr ><!--Dividing Line-->
        <h3>Specialty Pizzas</h3>
	    <input class="rbuttons" type="radio" name="SpecialtySmall" values="SpecialtySmall">Small<br />
            <input class="rbuttons" type="radio" name="SpecialtyMedium" values="SpecialtyMedium">Medium<br />
            <input class="rbuttons" type="radio" name="SpeciatlyLarge" values="SpecialtyLarge">Large<br /><br />

            <input type="checkbox" name="Veggie" value="Veggie">Veggie<br />
            <input type="checkbox" name="Meat_Lovers" value="Meat_Lovers">Meat_Lovers<br />
            <input type="checkbox" name="Tonys_Special" value="Tonys_Special">Tony's Special<br />
            <input type="checkbox" name="House_Special" value="House_Special">House Special<br />
            <input type="checkbox" name="The_Zeus" value="The_Zeus">The Zeus<br />

            <hr><!--Dividing Line-->
	<h3>Appetizers</h3>
	    <input type="checkbox" name="appetizer[]" value="Onion Rings">Onion Rings<br />
	    <input type="checkbox" name="appetizer[]" value="Fried Mushrooms">Fried Mushrooms<br />
	    <input type="checkbox" name="appetizer[]" value="Mozzarella Cheese Sticks">Mozzarella Cheese Sticks<br />
	    <input type="checkbox" name="appetizer[]" value="Spicy Buffalo Wings">Spicy Buffalo Wings<br />
	    <input type="checkbox" name="appetizer[]" value="Toasted Beef Ravioli">Toasted Beef Ravioli<br />
	
        <h3>Dinners</h3>
            <input type="checkbox" name="dinner[]" value="Gyros Dinner">Gyros Dinner<br />
            <input type="checkbox" name="dinner[]" value="Souvlaki Dinner">Souvlaki Dinner<br />
            <input type="checkbox" name="dinner[]" value="Shrimp Dinner">Shrimp dinner<br />
            <input type="checkbox" name="dinner[]" value="Chicken Strip Dinner">Chicken Strip Dinner<br />
            <input type="checkbox" name="dinner[]" value="Spaghetti Dinner">Spaghetti Dinner<br />

<!--
            <input type="checkbox" name="Fountain_Drinks" value="Fountain_Drinks">Fountain Drinks<br />
            <input type="checkbox" name="Soda_Pitcher" value="Soda_Pitcher">Soda Pitcher<br />
            <input type="checkbox" name="Bottle_Drinks" value="Bottle_Drinks">Bottle Drinks<br />

            <br />-->
            <input type="submit" name="submit" value="Add to Order" />
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
    echo "Success" .'<br>';
}

if(isset($_POST['submit']))
{
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

	//checks whether radio buttons under cheese pizza section is checked
	if(isset($_POST['CSmall']) || ($_POST['CMedium']) || ($_POST['CLarge'])) {
		if (isset($_POST['CSmall']))
			$csize = 10;
		if (isset($_POST['CMedium']))
			$csize = 12;
		if (isset($_POST['CLarge']))
			$csize = 14;
	//pulls the correct price from the database based on the size of the crust chosen
		$query = 'SELECT cheese_only_price FROM tonyspizza.size_pizza WHERE crust_size = $1';
                $stmt = pg_prepare($conn, "get_cheese_price", $query);
               	//sends query to database
                $result = pg_execute($conn, "get_cheese_price", array($csize));
                //if database doesnt return results print this
                	if(!$result) {
				echo "execute failed" . pg_last_error($conn);
                        }
		$result = pg_fetch_array($result,0,PGSQL_ASSOC) or die("Query failed: " . pg_last_error());
	//Calculates the total price of order
		$tp = $tp +  $result["cheese_only_price"];
		
	//inserts the current order into the order table
		$query = 'INSERT INTO tonyspizza.orders (phone_number, crust_size, price, description) VALUES ($1, $2, $3, $4)';
                $stmt = pg_prepare($conn, "insert_order1", $query);
                //sends query to database
                $result = pg_execute($conn, "insert_order1", array($phone_number, $csize, $result["cheese_only_price"], 'Cheese Pizza'));
                //if database doesnt return results print this
                        if(!$result) {
                                echo "execute failed" . pg_last_error($conn);
                        }

	}
	
	//checks what radio button is selected in the single topping pizza section
	if(isset($_POST['OneTopSmall']) || ($_POST['OneTopMedium']) || ($_POST['OneTopLarge'])) {
		if (isset($_POST['OneTopSmall']))
			$csize = 10;
		if (isset($_POST['OneTopMedium']))
			$csize = 12;
		if (isset($_POST['OneTopLarge']))
			$csize = 14;
	//selects the correct price from the database based on size chosen
		$query = 'SELECT single_topping_price FROM tonyspizza.size_pizza WHERE crust_size = $1';
                $stmt = pg_prepare($conn, "get_single_price", $query);
                	if(!$result) {
				echo "execute failed" . pg_last_error($conn);
                        }
               	//sends query to database
                $result = pg_execute($conn, "get_single_price", array($csize));
                //if database doesnt return results print this
                	if(!$result) {
				echo "execute failed" . pg_last_error($conn);
                        }
		$result = pg_fetch_array($result,0,PGSQL_ASSOC) or die("Query failed: " . pg_last_error());
		
	//calculates the total price of order
		$tp = $tp + $result["single_topping_price"];

                $query = 'INSERT INTO tonyspizza.orders (phone_number, crust_size, price, description) VALUES ($1, $2, $3, $4)';
                $stmt = pg_prepare($conn, "insert_order2", $query);
                //sends query to database
                $result = pg_execute($conn, "insert_order2", array($phone_number, $csize, $result["single_topping_price"], 'Single Topping'));
                //if database doesnt return results print this
                        if(!$result) {
                                echo "execute failed" . pg_last_error($conn);
			}
	}
	//Checks which radio bullton is selected based on which radio button is selected
	if(isset($_POST['CustomSmall']) || ($_POST['CustomMedium']) || ($_POST['CustomLarge'])) {
		if (isset($_POST['CustomSmall']))
			$csize = 10;
		if (isset($_POST['CustomMedium']))
			$csize = 12;
		if (isset($_POST['CustomLarge']))
			$csize = 14;
	//selects the correct price for custom pizza section
		$query = 'SELECT single_topping_price, additional_topping_price FROM tonyspizza.size_pizza WHERE crust_size = $1';
                $stmt = pg_prepare($conn, "get_custom_price", $query);
                	if(!$result) {
				echo "execute failed" . pg_last_error($conn);
                        }
               	//sends query to database
                $result = pg_execute($conn, "get_custom_price", array($csize));
                //if database doesnt return results print this
                	if(!$result) {
				echo "execute failed" . pg_last_error($conn);
                        }
		$result = pg_fetch_array($result,0,PGSQL_BOTH) or die("Query failed: " . pg_last_error());
	// counts the total number of checkboxes that are checked
                $count = sizeof($_POST['val']);
	//calculates the price of pizza with additional toppings
		$custom_pizza_price = ($result["single_topping_price"]+($result["additional_topping_price"]*($count-1)));
	//calculates the total price of order
                $tp = $tp + $custom_pizza_price;
			
	//inserts the order into the database
		$query = 'INSERT INTO tonyspizza.orders (phone_number, crust_size, price, description) VALUES ($1, $2, $3, $4)';
                $stmt = pg_prepare($conn, "insert_order3", $query);
                //sends query to database
                $result = pg_execute($conn, "insert_order3", array($phone_number, $csize, $custom_pizza_price, 'Custom Pizza'));
                //if database doesnt return results print this
                        if(!$result) {
                                echo "execute failed" . pg_last_error($conn);
			}
	}	
	        //Checks which radio bullton is selected based on which radio button is selected
        if(isset($_POST['SpecialtySmall']) || ($_POST['SpecialtyMedium']) || ($_POST['SpecialtyLarge'])){
                if (isset($_POST['SpecialtySmall']))
                        $csize = 10;
                if (isset($_POST['SpecialtyMedium']))
                        $csize = 12;
                if (isset($_POST['SpecialtyLarge']))
                        $csize = 14;

		if(isset($_POST['Veggie']) || ($_POST['Meat_Lovers']) || ($_POST['Tonys_Special']) || ($_POST['House_Special']) || ($_POST['The_Zeus'])){
			if(isset($_POST['Veggie']))
				$name = 'Veggie';
			if(isset($_POST['Meat_Lovers']))
                        	$name = 'Meat Lovers';
			if(isset($_POST['Tonys_Special']))
                        	$name = 'Tonys Special';
			if(isset($_POST['House_Special']))
                        	$name = 'House Special';
			if(isset($_POST['The_Zeus']))
                        	$name = 'The Zeus';
	}
        //selects the correct price for custom pizza section
                $query = 'SELECT price FROM tonyspizza.specialtypizza WHERE pizzasize = $1 AND name = $2';
                $stmt = pg_prepare($conn, "get_specialty_price", $query);
                        if(!$result) {
                                echo "execute failed" . pg_last_error($conn);
                        }
                //sends query to database
                $result = pg_execute($conn, "get_specialty_price", array($csize, $name));
                //if database doesnt return results print this
                        if(!$result) {
                                echo "execute failed" . pg_last_error($conn);
                        }
                $result = pg_fetch_array($result,0,PGSQL_BOTH) or die("Query failed: " . pg_last_error());
        //calculates the total price of order
                $tp = $tp + $result["price"];
		echo $tp . '<br>';
        //inserts the order into the database
                $query = 'INSERT INTO tonyspizza.orders(phone_number, crust_size, price, description) VALUES ($1, $2, $3, $4)';
                $stmt = pg_prepare($conn, "insert_order4", $query);
                //sends query to database
                $result = pg_execute($conn, "insert_order4", array($phone_number, $csize, $result["price"], 'Specialty Pizza'));
                //if database doesnt return results print this
                        if(!$result) {
                                echo "execute failed" . pg_last_error($conn);
			}
}
	$count = sizeof($_POST['appetizer']);
	for($i = 0; $i < $count; $i++){
                if(isset($_POST['appetizer'])){

                $query = 'SELECT price FROM tonyspizza.appetizers WHERE name = $1';
                $stmt = pg_prepare($conn, "get_app_price", $query);
                        if(!$result) {
                                echo "execute failed" . pg_last_error($conn);
                        }
                //sends query to database
                $result = pg_execute($conn, "get_app_price", array($_POST['appetizer'][$i]));
                //if database doesnt return results print this
                        if(!$result) {
                                echo "execute failed" . pg_last_error($conn);
                        }
                $result = pg_fetch_array($result,0,PGSQL_BOTH) or die("Query failed: " . pg_last_error());

	        //calculates the total price of order
                $tp = $tp + $result["price"];
        	//inserts the order into the database
                $query = 'INSERT INTO tonyspizza.orders(phone_number, price, description) VALUES ($1, $2, $3)';
                $stmt = pg_prepare($conn, "insert_order5", $query);
                //sends query to database
                $result = pg_execute($conn, "insert_order5", array($phone_number, $result["price"], $_POST['appetizer'][$i]));
                //if database doesnt return results print this
                        if(!$result) {
                                echo "execute failed" . pg_last_error($conn);
                        }
		}
	}
	$count = sizeof($_POST['dinner']);
	for($i = 0; $i < $count; $i++){
		if(isset($_POST['dinner'])){

                $query = 'SELECT price FROM tonyspizza.dinners WHERE name = $1';
                $stmt = pg_prepare($conn, "get_dinner_price", $query);
                        if(!$result) {
                                echo "execute failed" . pg_last_error($conn);
                        }

                //sends query to database
                $result = pg_execute($conn, "get_dinner_price", array($_POST['dinner'][$i]));
                //if database doesnt return results print this
                        if(!$result) {
                                echo "execute failed" . pg_last_error($conn);
                        }
                $result = pg_fetch_array($result,0,PGSQL_BOTH) or die("Query failed: " . pg_last_error());

                //calculates the total price of order
                $tp = $tp + $result["price"];
	        //inserts the order into the database
                $query = 'INSERT INTO tonyspizza.orders(phone_number, price, description) VALUES ($1, $2, $3)';
                $stmt = pg_prepare($conn, "insert_order6", $query);
                //sends query to database
                $result = pg_execute($conn, "insert_order6", array($phone_number, $result["price"], $_POST['dinner'][$i]));
                //if database doesnt return results print this
                        if(!$result) {
                                echo "execute failed" . pg_last_error($conn);
			}
		}
}

echo "display";
$query = "SELECT * FROM tonyspizza.orders ORDER BY phone_number;";
        //function call to print results of query

        $result = pg_query($query) or die("Query failed: " . pg_last_error());
        //prints amount of rows returned
        echo "There were <em>" . pg_num_rows($result) . "</em> rows returned\n";
        echo "<br /><br />\n";
        echo "<table border=\"1\"\n>";

        //variables for columns and rows
        $num_fields = pg_num_fields($result);
        $num_rows = pg_num_rows($result);

        echo "<tr>\n";
        for($i=0;$i<$num_fields;$i++)
        {
                //prints column headings
                $fieldname = pg_field_name($result,$i);
                echo "<th>$fieldname</th>\n";

        }
        echo "</tr>";
        //loop gathers query data and stores it in result
        while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                echo "<tr>\n";
                //prints data by the line
                foreach ($line as $col_value) {
                        echo "<td>$col_value</td>\n";
                }
                echo "</tr>\n";
        }
echo "</table>\n";
//Free result
pg_free_result($result);

}	
?>
