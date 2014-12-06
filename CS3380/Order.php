<?php
session_start();

if(($_SERVER['HTTPS']!=="on"))
{
        $redir = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header("Location: $redir");
}
if(empty($_SESSION['username'])){
        header("Location: index.php");
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
    <title>Order</title>
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
</head>
    <!--END HEAD SECTION -->
<body>   
    <!-- NAV SECTION -->
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Tony's Pizza</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="AboutUs.html">ABOUT US</a></li>
                    <li><a href="Order.php">ORDER</a></li>
		    		<li><a href="admin.php">ADMINISTRATION</a></li>
                    <li><a href="logout.php">LOG OUT</a></li>
              <!--       <li><a href="pricing.html">PRICING</a></li>
                    <li><a href="founders.html">FOUNDERS</a></li>
                    <li><a href="contact.html">CONTACT</a></li>
                --></ul>
            </div>
           
        </div>
    </div>
     <!--END NAV SECTION -->
     
    <!--SERVICES SECTION -->
     <div id="service-section">
     <div class="container" >
    <div class="row  text-center">
              <div class="row main-top-margin text-center">
                <div class="col-md-8 col-md-offset-2 " >
                    <h1>Order Here!</h1>
                    
                

<?php
include "../secure/database.php";

//Connect to Database using my credentials
$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD);
//$conn = pg_connect("host= dbhost-pgsql.cs.missouri.edu user=cs3380f14grp2 password= 82rLygpv dbname= cs3380f14grp2");
/*
if (!$conn)
{
    die('Fail');
}
else
{
    echo "Success" .'<br>';
}
*/

if(isset($_POST['clear'])){

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

        if ($csize == 10)
            $cs='Small';
        if ($csize == 12)
            $cs='Medium';
        if ($csize == 14)
            $cs='Large';
        
    //inserts the current order into the order table
        $query = 'INSERT INTO tonyspizza.orders (phone_number, crust_size, price, description) VALUES ($1, $2, $3, $4)';
                $stmt = pg_prepare($conn, "insert_order1", $query);
                //sends query to database
                $result = pg_execute($conn, "insert_order1", array($phone_number, $csize, $result["cheese_only_price"], $cs . ' Cheese Pizza'));
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

        if ($csize == 10)
            $cs='Small';
        if ($csize == 12)
            $cs='Medium';
        if ($csize == 14)
            $cs='Large';
        
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
                $result = pg_execute($conn, "insert_order2", array($phone_number, $csize, $result["single_topping_price"], $cs . ' Single Topping' . " " . $_POST['SToppingDROP']));
                //if database doesnt return results print this
                        if(!$result) {
                                echo "execute failed" . pg_last_error($conn);
            }
    }
    //Checks which radio bullton is selected based on which radio button is selected
    if(isset($_POST['CustomSmall']) || ($_POST['CustomMedium']) || ($_POST['CustomLarge'])) {
	//echo " here here here";
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

        if ($csize == 10)
            $cs='Small';
        if ($csize == 12)
            $cs='Medium';
        if ($csize == 14)
            $cs='Large';
        
        $desc = "";
        for($i = 0; $i < $count; $i++)
            if ($i == $count-1)
                $desc = $desc . $_POST['val'][$i];
            else
                $desc = $desc . $_POST['val'][$i] . ", ";
            
    //inserts the order into the database
        $query = 'INSERT INTO tonyspizza.orders (phone_number, crust_size, price, description) VALUES ($1, $2, $3, $4)';
                $stmt = pg_prepare($conn, "insert_order3", $query);
                //sends query to database
                $result = pg_execute($conn, "insert_order3", array($phone_number, $csize, $custom_pizza_price, $cs ." " . $desc));
                //if database doesnt return results print this
                        if(!$result) {
                                echo "execute failed" . pg_last_error($conn);
            }
    }   
            //Checks which radio bullton is selected based on which radio button is selected
    $count = sizeof($_POST['special']);
        if(isset($_POST['special'])){
                if (isset($_POST['SpecialtySmall']))
                        $csize = 10;
                if (isset($_POST['SpecialtyMedium']))
                        $csize = 12;
                if (isset($_POST['SpecialtyLarge']))
                        $csize = 14;

        if ($csize == 10)
            $cs='Small';
        if ($csize == 12)
            $cs='Medium';
        if ($csize == 14)
            $cs='Large';
        
      for($i = 0; $i < $count; $i++){
        //selects the correct price for custom pizza section
                $query = 'SELECT price FROM tonyspizza.specialtypizza WHERE pizzasize = $1 AND name = $2';
                $stmt = pg_prepare($conn, "get_specialty_price", $query);
                        if(!$result) {
                                echo "execute failed" . pg_last_error($conn);
                        }
                //sends query to database
                $result = pg_execute($conn, "get_specialty_price", array($csize, $_POST['special'][$i]));
                //if database doesnt return results print this
                        if(!$result) {
                                echo "execute failed" . pg_last_error($conn);
                        }
                $result = pg_fetch_array($result,0,PGSQL_BOTH) or die("Query failed: " . pg_last_error());
        //calculates the total price of order
                $tp = $tp + $result["price"];
        //inserts the order into the database
                $query = 'INSERT INTO tonyspizza.orders(phone_number, crust_size, price, description) VALUES ($1, $2, $3, $4)';
                $stmt = pg_prepare($conn, "insert_order4", $query);
                //sends query to database
        $result = pg_execute($conn, "insert_order4", array($phone_number, $csize, $result["price"], $cs . " " . $_POST['special'][$i]));
                //if database doesnt return results print this
                        if(!$result) {
                                echo "execute failed" . pg_last_error($conn);
            }
      }
    }
    $count = sizeof($_POST['appetizer']);
        if(isset($_POST['appetizer'])){
      for($i = 0; $i < $count; $i++){

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
    if(isset($_POST['dinner'])){
      for($i = 0; $i < $count; $i++){

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
                $result = pg_fetch_array($result,0,PGSQL_BOTH) or die("Query failed: !! " . pg_last_error());

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

//echo "display";

echo "Customer: " . $_SESSION['username'] . '<br>';
echo "Phone #: " . $phone_number . '<br>';
echo "<br>";

$query = "SELECT description as ORDER ,price as PRICE  FROM tonyspizza.orders WHERE phone_number = '$phone_number' ORDER BY phone_number;";
        //function call to print results of query

        $result = pg_query($query) or die("Query failed: !" . pg_last_error());
        //prints amount of rows returned
        //echo "There were <em>" . pg_num_rows($result) . "</em> rows returned\n";
        //echo "<br /><br />\n";
        echo "<table border=\"1\"\n>";

        //variables for columns and rows
        $num_fields = pg_num_fields($result);
        $num_rows = pg_num_rows($result);

        echo "<tr>\n";
        for($i=0;$i<$num_fields;$i++)
        {
                //prints column headings
                $fieldname = pg_field_name($result,$i);
                echo "<th><center>$fieldname<center></th>\n";

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
$result = pg_query("SELECT SUM(price) FROM tonyspizza.orders WHERE phone_number ='$phone_number'");
$result = pg_fetch_array($result, 0, PGSQL_BOTH);
$total = $result[0];
echo pg_last_error();
echo "Your total price is " . money_format('%.2n',$total) . '<br>';
//Free result
pg_free_result($result);

}   
?>
</div>
            </div>
            <!-- ./ Main Heading-->
<form method="POST" action="Order.php">


                 <div class="row main-low-margin text-center"> 
                <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 ">
                    <div class="col-md-4 col-sm-6" >
                        <div class="text-center">
                            
                            <h4>Cheese Pizza</h4>
                            <p>
            <input class="rbuttons" type="radio" name="CSmall" values="CSmall">Small<br />
            <input class="rbuttons" type="radio" name="CMedium" values="CMedium">Medium<br />
            <input class="rbuttons" type="radio" name="CLarge" values="CLarge">Large<br />
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6"  >
                        <div class="text-center">
                            
                            <h4>Single Topping Pizza</h4>
                            <p>
            <input class="rbuttons" type="radio" name="OneTopSmall" values="OneTopSmall">Small<br />
            <input class="rbuttons" type="radio" name="OneTopMedium" values="OneTopMedium">Medium<br />
            <input class="rbuttons" type="radio" name="OneTopLarge" values="OneTopLarge">Large<br />
    <select name="SToppingDROP">
	    <option value="">Select...</option>
            <option value="Onions">Onions</option>
            <option value="Mushrooms">Mushrooms</option>
            <option value="Canadian Bacon">Canadian Bacon</option>
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
            <option value="Green Peppers">Green Peppers</option>>
            <option value="Pineapple">Pineapple</option>>
            <option value="Green Olive">Green Olive</option>>
            <option value="Gyros Meat">Gyros Meat</option>>
    </select>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6" >
                        <div class="text-center">
                           
                            <h4>Customize Your Pizza.</h4>
                            <p>
            <input class="rbuttons" type="radio" name="CustomSmall" values="CustomSmall">Small<br />
            <input class="rbuttons" type="radio" name="CustomMedium" values="CustomMedium">Medium<br />
            <input class="rbuttons" type="radio" name="CustomLarge" values="CustomLarge">Large<br /><br />
    <h5>Toppings</h5>
            <input type="checkbox" name="val[]" value="Onions">Onions<br />
            <input type="checkbox" name="val[]" value="Mushrooms">Mushrooms<br />
            <input type="checkbox" name="val[]" value="Canadian Bacon">Canadian Bacon<br />
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
            <input type="checkbox" name="val[]" value="Green Peppers">Green Peppers<br />
            <input type="checkbox" name="val[]" value="Pineapple">Pineapple<br />
            <input type="checkbox" name="val[]" value="Green Olive">Green Olive<br />
            <input type="checkbox" name="val[]" value="Gyros Meat">Gyros Meat<br />
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6" >
                        <div class="text-center">
                           
                            <h4>Specialty Pizzas</h4>
                            <p>
            <input class="rbuttons" type="radio" name="SpecialtySmall" values="SpecialtySmall">Small<br />
            <input class="rbuttons" type="radio" name="SpecialtyMedium" values="SpecialtyMedium">Medium<br />
            <input class="rbuttons" type="radio" name="SpeciatlyLarge" values="SpecialtyLarge">Large<br /><br />

            <input type="checkbox" name="special[]" value="Veggie">Veggie<br />
            <input type="checkbox" name="special[]" value="Meat Lovers">Meat_Lovers<br />
            <input type="checkbox" name="special[]" value="Tonys Special">Tony's Special<br />
            <input type="checkbox" name="special[]" value="House Special">House Special<br />
            <input type="checkbox" name="special[]" value="The Zeus">The Zeus<br />
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6" >
                        <div class="text-center">
                            
                            <h4>Appetizers</h4>
                            <p>
        <input type="checkbox" name="appetizer[]" value="Onion Rings">Onion Rings<br />
        <input type="checkbox" name="appetizer[]" value="Fried Mushrooms">Fried Mushrooms<br />
        <input type="checkbox" name="appetizer[]" value="Mozzarella Cheese Sticks">Mozzarella Cheese Sticks<br />
        <input type="checkbox" name="appetizer[]" value="Spicy Buffalo Wings">Spicy Buffalo Wings<br />
        <input type="checkbox" name="appetizer[]" value="Toasted Beef Ravioli">Toasted Beef Ravioli<br />
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6" >
                        <div class="text-center">
                            
                            <h4>Dinners</h4>
                            <p>
            <input type="checkbox" name="dinner[]" value="Gyros Dinner">Gyros Dinner<br />
            <input type="checkbox" name="dinner[]" value="Souvlaki Dinner">Souvlaki Dinner<br />
            <input type="checkbox" name="dinner[]" value="Shrimp Dinner">Shrimp dinner<br />
            <input type="checkbox" name="dinner[]" value="Chicken Strip Dinner">Chicken Strip Dinner<br />
            <input type="checkbox" name="dinner[]" value="Spaghetti Dinner">Spaghetti Dinner<br />
                            </p>
                        </div>
                    </div>
                </div>
                     </div>
                <!-- ./ Content div-->
               <br />
            <input type="submit" name="submit" value="Add to Order" />
            <input type="submit" name="clear" value="Clear Order" />
            <br />
   </form>
            </div>
         </div>
          </div>
    <!-- END SERVICES SECTION -->
   
 
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
