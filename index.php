<?php 
// Detect the current session
session_start();
$MainContent = "<img src='Images/Home_Page.jpg'  
                     class='home-img img-fluid' 
                     style='display:block;'/>";

// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php"); 

// form SQL to retrieve list of products associated to the category ID
$qry = "SELECT * FROM Product";
$result = $conn->query($qry);
$MainContent .= "<h2 style='text-align:center; margin-bottom:40px; color:#e63232'>Products On Offer</h2>";
$MainContent .= "<div class='card-deck flex-wrap justify-content-center'>";

// display each product in a row 
while ($row = $result->fetch_array())
{
    // Product details
    $product = "productDetails.php?pid=$row[ProductID]";
    $formattedPrice = number_format($row["Price"], 2);
    $offeredPrice = number_format($row["OfferedPrice"], 2);
    $img="./Images/products/$row[ProductImage]";
    $offer="productDetails.php?";
    // Content
    if($row["Offered"]==1){
        // start card
    $MainContent .= "<div class='card flex-wrap' style='min-width:280px; max-width:280px; margin-bottom:10px;'>";
        $MainContent .= "<img class='card-img-top' src='$img' alt='Product Image'>"; 
        $MainContent .= "<div class='card-body'>"; //67% of row width
        $MainContent .= "<h5 class='cart-title'>$row[ProductTitle]</h5>";
        $MainContent .= "<p class='card-text text-primary' style='font-size:1.2em;'><del style='opacity:0.5;'>$formattedPrice</del>$ $offeredPrice</p>";
        $MainContent .= "<a href='$product' class='btn btn-danger'>Product Details</a>";
        $MainContent .= "</div>"; //end of card body 
        $MainContent .= "</div>"; //end of card
    }
}
$conn->close();
$MainContent .= "</div>"; 
$MainContent .= "</div>"; // End of container
include("MasterTemplate.php"); 
?>
