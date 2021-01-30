<?php 
// Include the code that contains shopping cart's functions
include_once("cartFunctions.php");

// Check if user logged in 
if (! isset($_SESSION["ShopperID"])) {
	// redirect to login page if the session variable shopperid is not set
	header ("Location: login.php");
	exit;
}

$MainContent = "<div id='myShopCart' style='margin:auto'>";
if (isset($_SESSION["Cart"])) {
	include_once("mysql_conn.php");
	// To Do 1 (Practical 4): 
	// Retrieve from database and display shopping cart in a table
	$qry="SELECT *,(Price*Quantity) AS Total From ShopCartItem WHERE ShopCartID=?";
	$stmt =$conn->prepare($qry);
	$stmt->bind_param("i",$_SESSION["Cart"]);
	$stmt->execute();
	$result=$stmt->get_result();
	$stmt->close();
	
	if ($result->num_rows > 0) {
		// To Do 2 (Practical 4): Format and display 
		// the page header and header row of shopping cart page
		$MainContent .= "<p class='page-title' style='text-align:center'>Shopping Cart</p>"; 
		$MainContent .= "<div class='table-responsive' >";
		$MainContent .= "<table class='table table-hover'>"; 
		$MainContent.= "<thead class= 'cart-header'>";
		$MainContent.= "<tr>";
		$MainContent.="<th width='250px'> Item</th>";
		$MainContent.="<th width='90px'> Price</th>";
		$MainContent.="<th width='60px'> Quantity</th>";
		$MainContent.="<th width='120px'> Total (S$)</th>";
		$MainContent.="<th>&nbsp;</th>";$MainContent.="</tr>";
		$MainContent.="</thead>";		
		// To Do 5 (Practical 5):
		// Declare an array to store the shopping cart items in session variable 
		$_SESSION["Items"]=array();
		// To Do 3 (Practical 4): 
		// Display the shopping cart content
		$subTotal = 0; // Declare a variable to compute subtotal before tax
		$totalQuantity = 0;
		$MainContent .= "<tbody>";
		while ($row = $result->fetch_array()) {
			$MainContent.="<tr>";
			$MainContent.= "<td style='width:50%'>$row[Name]<br />";
			$MainContent.= "Product ID: $row[ProductID]</td>";
			$formattedPrice= number_format($row["Price"],2);
			$MainContent.="<td>$formattedPrice</td>";

			$MainContent.="<td>";
			$MainContent.="<form action='cartFunctions.php' method='post'>";
			$MainContent.="<select name='quantity' onChange='this.form.submit()'>";
			for ($i=1;$i<=10;$i++){
				//check for the quanity that is in the db and set it to selected value
				if($i==$row["Quantity"])
					$selected="selected";
				else
					$selected="";

				$MainContent.="<option value='$i' $selected>$i</option>";
			}
			$MainContent.="<input type='hidden' name='action' value='update'/>";
			$MainContent.= "<input type='hidden' name='product_id' value='$row[ProductID]' />";
			$MainContent.= "</form>";
			$MainContent.="</td>";
			$formattedTotal= number_format($row["Total"],2);
			$MainContent.="<td>$formattedTotal</td>";

			//Remove Item
			$MainContent.="<td>";
			$MainContent.="<form action='cartFunctions.php' method='post'>";
			$MainContent.="<input type='hidden' name='action' value='remove' />";
			$MainContent.= "<input type='hidden' name='product_id' value='$row[ProductID]' />";
			$MainContent.="<input type='image' src='images/trash-can.png' title='Remove Item' />";
			$MainContent.= "</form>";
			$MainContent.= "</td>";
			$MainContent.="</tr>";
			
			// To Do 6 (Practical 5):
		    // Store the shopping cart items in session variable as an associate array
			$_SESSION["Items"][]=array("productId"=>$row["ProductID"],
			"name"=>$row["Name"],
			"price"=>$row["Price"],
			"quantity"=>$row["Quantity"]
		);
			
			// Accumulate the running sub-total
			$subTotal += $row["Total"];
			$totalQuantity += $row["Quantity"];
		}
		$MainContent .= "</tbody>";
		$MainContent .= "</table>";
		$MainContent .= "</div>";
				
		//Delivery Type
		$MainContent .= "<form onchange='this.submit()' action='cartFunctions.php' method='post'>";
		$MainContent .= "<input type='hidden' name='action' value='deliveryOption' />";
		if (isset($_SESSION["ShipCharge"])) {
			if (($_SESSION["ShipCharge"]) == 5){
				$MainContent .= "<input type='radio' name ='delivery' value ='Normal' checked>Normal";
				$MainContent .= "<input type='radio' name ='delivery' value ='Express' >Express";
			}
			else {
				$MainContent .= "<input type='radio' name ='delivery' value ='Normal' >Normal";
				$MainContent .= "<input type='radio' name ='delivery' value ='Express' checked>Express";
			}
		}
		else {
			$_SESSION["ShipCharge"] = 5;
			$MainContent .= "<input type='radio' name ='delivery' value ='Normal' checked>Normal";
			$MainContent .= "<input type='radio' name ='delivery' value ='Express' >Express";
		}
		$MainContent .= "</form>";

		// To Do 4 (Practical 4): 
		// Display the subtotal at the end of the shopping cart
		$MainContent.= "<p style='text-align:right; font-size:20px'> Total item: ".number_format($totalQuantity);
		$MainContent.= "<p style='text-align:right; font-size:20px'> SubTotal= S$".number_format($subTotal,2);
		$MainContent.= "<p style='text-align:right; font-size:20px'> Shipping Charge= S$".number_format($_SESSION["ShipCharge"],2);
		$Total = $subTotal + $_SESSION["ShipCharge"];
		$_SESSION["SubTotal"]=round($subTotal,2);
		$MainContent.= "<p style='text-align:right; font-size:20px'> Total= S$".number_format($Total,2);

		
		// To Do 7 (Practical 5):
		// Add PayPal Checkout button on the shopping cart page
		$MainContent.="<form method='post' action='checkoutProcess.php'>";
		$MainContent.="<input type='image' style='float:right;' src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif'>";
		$MainContent.="</form></p>";
		
		
	}
	else {
		$MainContent .= "<h3 style='text-align:center; color:red;'>Empty shopping cart!</h3>";
	}
	$conn->close(); // Close database connection
}
else {
	$MainContent .= "<h3 style='text-align:center; color:red;'>Empty shopping cart!</h3>";
}
$MainContent .= "</div>";

include("MasterTemplate.php"); 
?>
