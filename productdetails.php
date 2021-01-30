<?php 
session_start(); // Detect the current session
// Create a container, 90% width of viewport
$MainContent = "<div style='width:90%; margin:auto;'>";

$pid=$_GET["pid"]; // Read Product ID from query string

// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php"); 
$qry = "SELECT * from product where ProductID=?";
$stmt = $conn->prepare($qry);
$stmt->bind_param("i", $pid); 	// "i" - integer 
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$cartBtn= "<button type='submit' class='btn btn-danger'> Add to Cart</button>";
$MainContent .= "<div class='card product-card'>";

// To Do 1:  Display Product information. Starting ....
while($row = $result->fetch_array())
{
    $MainContent .= "<div class='card-header'>";
    $MainContent .= "<span class='page-title'>$row[ProductTitle]</span>";
    $MainContent .= "</div>";
    
    // Display the product's description 
    $MainContent .= "<div class='card-body' style='margin:1.45rem;'>";
    // Display the product's image
    $MainContent .= "<div class='row'>";
    $MainContent .= "<div class='col'>";
    // get image
    $img = "./Images/products/$row[ProductImage]";
    $MainContent .= "<p><img src='$img'/></p>";
    $MainContent .= "</div>";
    $MainContent .= "<div class='col'>";

    
    
    // Product's if on offer
    if($row["Offered"]==1){
        $MainContent .= "<h5 class='card-title' style='font-weight:bold; color:red;'>On Offer</h5>";    
    }
    $MainContent .= "<p>$row[ProductDesc]</p>";

    if($row["Quantity"]<1){
        $MainContent .="<h3>Out of Stock !</h3>";
        $cartBtn ="<button type='submit' class='btn btn-danger' disabled>Add to Cart</button>";
    }

    // Display the product's Specification 
    $qry = "SELECT s.SpecName, ps.SpecVal from productspec ps
            INNER JOIN specification s ON ps.SpecID=s.SpecID
            WHERE ps.ProductID=?
            ORDER BY ps.priority";
    $stmt = $conn->prepare($qry);
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $result2 = $stmt->get_result();
    $stmt->close();
    while($row2=$result2->fetch_array()){
        $MainContent .=$row2["SpecName"].":".$row2["SpecVal"]."<br />";
    }
    


    // display the product's price
    $formattedPrice = number_format($row["Price"], 2);
    $offeredPrice = number_format($row["OfferedPrice"], 2);
    if($row["Offered"]==1){
        $MainContent .="Price:<span style='font-size:1.2em; font-weight:bold; color:red;'>
        <del style='font-size:0.8em; opacity:0.5;'>$formattedPrice</del>S$ $offeredPrice</span>" ;
    }
    else{
        $MainContent .="Price:<span style='font-size:1.2em; font-weight:bold; color:red;'>
        S$ $formattedPrice</span>" ;
    }
    
    
    
}

// To Do 1:  Ending ....

// To Do 2:  Create a Form for adding the product to shopping cart. Starting ....
$MainContent .="<form action='cartFunctions.php'method='post' style='margin:40px 0;'>";
$MainContent .="<input type='hidden' name='action' value='add'/>";
$MainContent .="<input type='hidden' name='product_id' value='$pid'/>";
$MainContent .="Quantity: <input type='number' name='quantity' value='1' 
                min='1' max='10' style='width:40px' required />";
$MainContent .="<br>";
$MainContent .="<br>";
$MainContent .=$cartBtn;
$MainContent .="</form>";
$MainContent .= "</div>";
$MainContent .= "</div>";
$MainContent .="</div>";
$MainContent .= "</div>";

$MainContent .="</div>"; // end of card



// To Do 2:  Ending ....

$conn->close(); // Close database connnection
$MainContent .= "</div>"; // End of container
include("MasterTemplate.php");  
?>
