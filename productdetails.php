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

// To Do 1:  Display Product information. Starting ....
while($row = $result->fetch_array())
{
    // Display Page Header
    // Product's name is read from teh "ProductTitle" solumn of "Product" table
    if($row["Offered"]==1){
        $MainContent .= "<h2 style='color:#e63232;'>On offer</h2>";
        $MainContent .= "<div class='row'>";
        $MainContent .= "<div class='col-sm-12' style='padding:5px'>";
        $MainContent .= "<span class='page-title'>$row[ProductTitle]</span>";
        $MainContent .= "</div>";
        $MainContent .= "</div>";
    }
    else{
        $MainContent .= "<div class='row'>";
        $MainContent .= "<div class='col-sm-12' style='padding:5px'>";
        $MainContent .= "<span class='page-title'>$row[ProductTitle]</span>";
        $MainContent .= "</div>";
        $MainContent .= "</div>";
    }
    // start a new row 
    $MainContent .= "<div class='row'>";
    // left column - display the product's description 
    $MainContent .= "<div class='col-sm-9' style='padding:5px'>";
    $MainContent .= "<p>$row[ProductDesc]</p>";

    if($row["Quantity"]<1){
        $MainContent .="<h3>Out of Stock !</h3>";
        $cartBtn ="<button type='submit' class='btn btn-danger' disabled>Add to Cart</p>";
    }

    // Left column - display the product's Specification 
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
    $MainContent .= "</div>";

    // right column - display the product's image
    $img = "./Images/products/$row[ProductImage]";
    $MainContent .="<div class='col-sm-3' style='vertical-align:top; padding:5px'>";
    $MainContent .= "<p><img src='$img'/></p>";
    // right column - display the product's price
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
$MainContent .="<form action='cartFunctions.php'method='post'>";
$MainContent .="<input type='hidden' name='action' value='add'/>";
$MainContent .="<input type='hidden' name='product_id' value='$pid'/>";
$MainContent .="Quantity: <input type='number' name='quantity' value='1' 
                min='1' max='10' style='width:40px' required />";
$MainContent .=$cartBtn;
$MainContent .="</form>";
$MainContent .="</div>";
$MainContent .="</div>";



// To Do 2:  Ending ....

$conn->close(); // Close database connnection
$MainContent .= "</div>"; // End of container
include("MasterTemplate.php");  
?>
