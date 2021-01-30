<?php 

// TO DO: Haven't touched this page

// Detect the current session
session_start();

// HTML Form to collect search keyword and submit it to the same page 
// in server
$MainContent = "<div style='width:80%; margin:auto;'>"; // Container
$MainContent .= "<form name='frmSearch' method='get' action=''>";
$MainContent .= "<div class='form-group row'>"; // 1st row
$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent .= "<span class='page-title'>Product Search</span>";
$MainContent .= "</div>";
$MainContent .= "</div>"; // End of 1st row

$MainContent .= "<div class='form-group row'>"; // 2nd row
$MainContent .= "<label for='keywords' 
                  class='col-sm-3 col-form-label'>Product Title:</label>";
$MainContent .= "<div class='col-sm-6'>";
$MainContent .= "<input class='form-control' name='keywords' id='keywords' 
                  type='search'/>";
$MainContent .= "</div>";

$MainContent .= "<div class='col-sm-3'>";
$MainContent .= "<button type='submit' class='btn btn-danger'>Search</button>";
$MainContent .= "</div>";

$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent .= "<br><label for='myCheck'>On Offer</label>";
$MainContent .= "&nbsp<input type='checkbox' id='check' name='check' value='yes'>";
$MainContent .= "</div>";

$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent .= "<div class='price-slider'><span>Price Range:</br>";
$MainContent .= "<input type='number' label for='num1' name='num1' placeholder='1' min='0' max='200' />     to  ";
$MainContent .= "<input type='number' label for='num2' name='num2' placeholder='160' min='0' max='200' /></span></br>";
$MainContent .= "</div>";
$MainContent .= "</div>";


$MainContent .= "</div>";  // End of 2nd row
$MainContent .= "</form>";

// The search keyword is sent to server
if (isset($_GET['keywords']) && (isset($_GET['num1']) || isset($_GET['num2']) || isset($_GET['check']))) {

    // To Do (DIY): Retrieve list of product records with "ProductTitle" 
    // contains the keyword entered by shopper, and display them in a table.
    include_once("mysql_conn.php");

    // get all products
    $qry = "SELECT p.*, ps.SpecVal FROM `product` AS p
            INNER JOIN ProductSpec as ps ON p.ProductID = ps.ProductID";
    
    $result = $conn->query($qry);

    $filtered_products = array();
    $filtered_prod_titles = array();

    while($row = $result->fetch_array()) {
        if (in_array($row["ProductTitle"], $filtered_prod_titles)) {
            continue;
        }

        if (isset($_GET["check"]) && $_GET["check"] == "yes") {
            if ($row["Offered"] != 1) {
                continue;
            }
        }

        if ($_GET['keywords'] != '') {
            if (stripos($row["ProductTitle"], $_GET["keywords"]) == FALSE &&
                stripos($row["ProductDesc"], $_GET["keywords"]) == FALSE &&
                stripos($row["SpecVal"], $_GET["keywords"]) == FALSE) {

                continue;
            }
        }

        // get offered price if there is
        $price = 0;

        if ($row["Offered"] == 1) {
            $price = $row["OfferedPrice"];
        }

        else {
            $price = $row["Price"];
        }
        
        if ($_GET['num1'] != '') {
            if ($price < $_GET['num1']) {
                continue;
            }
        }
    
        if ($_GET['num2'] != '') {
            if ($price > $_GET['num2']) {
                continue;
            }
        }

        $filtered_prod_titles[] = $row["ProductTitle"];
        $filtered_products[] = $row;
    }


    // Close connection
    $conn->close();
    
    $MainContent .= "<p style='font-size: 15px; font-weight: bold;'>Search Results for $_GET[keywords]: </p>";

    $MainContent .= "<div class='card-deck flex-wrap justify-content-center'>";

    if (count($filtered_products) > 0) {
    foreach ($filtered_products as $row)
    {
         // start card
         $MainContent .= "<div class='card' style='min-width:280px; max-width:280px; margin-bottom:10px;'>";
         $product =  "productDetails.php?pid=$row[ProductID]";
         $formattedPrice = number_format($row["Price"], 2);
         $offeredPrice = number_format($row["OfferedPrice"], 2);
         
         $img="./Images/products/$row[ProductImage]";

         // Content
         $MainContent .= "<img class='card-img-top' src='$img' alt='Product Image'>"; 
         $MainContent .= "<div class='card-body' style='text-align: center;'>"; //67% of row width
         $MainContent .= "<h5 class='cart-title'>$row[ProductTitle]</h5>";
         if ($row["Offered"]==1){
            $MainContent .= "<p class='card-text text-primary' style='font-size:1.2em;'><del style='opacity:0.5;'>$formattedPrice</del>$ $offeredPrice</p>";
         }
         else{
            $MainContent .= "<p class='card-text text-primary' style='font-size:1.2em'>Price: $ $formattedPrice</p>";
         }
         $MainContent .= "<a href='$product' class='btn btn-danger'>Product Details</a>";
         $MainContent .= "</div>"; //end of body card
         $MainContent .= "</div>"; //end of card  
         
    }

    }
     else {
         $MainContent .= "<h3 style='color:#f774bc'>No results found, please try again.</h3>";
     }
     $MainContent .= "</div>"; //end of card wrap  

}


$MainContent .= "</div>"; // End of Container
include("MasterTemplate.php");
?>

<script>  
$(document).ready(function(){  
    
	$( "#price_range" ).slider({
		range: true,
		min: 1000,
		max: 20000,
		values: [ <?php echo $minimum_range; ?>, <?php echo $maximum_range; ?> ],
		slide:function(event, ui){
			$("#minimum_range").val(ui.values[0]);
			$("#maximum_range").val(ui.values[1]);
			load_product(ui.values[0], ui.values[1]);
		}
	});
	
});  
</script>